<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\EducationalBursary;
use App\Models\Ward;
use App\Models\Document;

class BursaryController extends Controller
{
    /**
     * Upload Document via AJAX
     */
    public function uploadDocument(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
            'document_category' => 'required|string',
            'bursary_id' => 'nullable|exists:educational_bursaries,id',
            'title' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $file = $request->file('file');
            $category = $request->document_category;

            // Generate filename
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('bursary_documents/' . $category, $filename);

            // Create document record
            $documentData = [
                'title' => $request->title ?? $file->getClientOriginalName(),
                'document_type' => 'bursary_application',
                'document_category' => $category,
                'file_path' => $path,
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'uploaded_by_id' => auth()->id(),
                'is_public' => false,
                'priority' => 'high',
            ];

            // If bursary_id provided, link to specific bursary
            if ($request->bursary_id) {
                $documentData['documentable_type'] = EducationalBursary::class;
                $documentData['documentable_id'] = $request->bursary_id;
            }

            $document = Document::create($documentData);

            return response()->json([
                'success' => true,
                'message' => 'Document uploaded successfully',
                'document' => [
                    'id' => $document->id,
                    'title' => $document->title,
                    'category' => $document->document_category,
                    'file_size' => $this->formatFileSize($document->file_size),
                    'upload_date' => $document->created_at->format('M d, Y')
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error uploading document',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Application Progress
     */
    public function getApplicationProgress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bursary_code' => 'nullable|string',
            'phone' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $query = EducationalBursary::query();

            if ($request->bursary_code) {
                $query->where('bursary_code', $request->bursary_code);
            } elseif ($request->phone) {
                $query->where('mobile_phone', $request->phone);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Either bursary code or phone number is required'
                ], 422);
            }

            $bursary = $query->with(['ward', 'vulnerabilityAssessment'])->first();

            if (!$bursary) {
                return response()->json([
                    'success' => false,
                    'message' => 'No bursary application found'
                ], 404);
            }

            $progress = $this->calculateApplicationProgress($bursary);

            return response()->json([
                'success' => true,
                'bursary' => [
                    'code' => $bursary->bursary_code,
                    'type' => $bursary->bursary_type,
                    'status' => $bursary->status,
                    'applicant_name' => $bursary->full_name,
                    'submission_date' => $bursary->submission_date->format('M d, Y'),
                    'ward' => $bursary->ward->name,
                    'vulnerability_level' => $bursary->vulnerabilityAssessment->vulnerability_level ?? 'pending'
                ],
                'progress' => $progress
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching application progress',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Validate Ward Eligibility
     */
    public function validateWardEligibility(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ward_id' => 'required|exists:wards,id',
            'bursary_type' => 'required|in:skills_development,secondary_boarding'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $ward = Ward::findOrFail($request->ward_id);

            // Check if ward has active CDF allocation
            $hasActiveFunding = true; // You can implement actual funding check logic

            // Check application limits per ward
            $currentApplications = EducationalBursary::where('ward_id', $request->ward_id)
                ->where('bursary_type', $request->bursary_type)
                ->whereIn('status', ['submitted', 'wdc_review', 'wdc_approved', 'cdfc_review'])
                ->count();

            $maxApplicationsPerWard = $request->bursary_type === 'skills_development' ? 50 : 30;
            $hasSpaceForApplication = $currentApplications < $maxApplicationsPerWard;

            return response()->json([
                'success' => true,
                'eligible' => $hasActiveFunding && $hasSpaceForApplication,
                'ward_info' => [
                    'name' => $ward->name,
                    'current_applications' => $currentApplications,
                    'max_applications' => $maxApplicationsPerWard,
                    'remaining_slots' => max(0, $maxApplicationsPerWard - $currentApplications)
                ],
                'messages' => [
                    'funding_status' => $hasActiveFunding ? 'Ward has active CDF funding' : 'Ward funding not available',
                    'capacity_status' => $hasSpaceForApplication ? 'Application slots available' : 'Application limit reached for this ward'
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error validating ward eligibility',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Wards with Availability
     */
    public function getWardsWithAvailability(Request $request)
    {
        try {
            $bursaryType = $request->get('bursary_type', 'skills_development');
            $maxApplicationsPerWard = $bursaryType === 'skills_development' ? 50 : 30;

            $wards = Ward::withCount([
                'educationalBursaries as current_applications_count' => function ($query) use ($bursaryType) {
                    $query->where('bursary_type', $bursaryType)
                          ->whereIn('status', ['submitted', 'wdc_review', 'wdc_approved', 'cdfc_review']);
                }
            ])->get()->map(function ($ward) use ($maxApplicationsPerWard) {
                $remainingSlots = max(0, $maxApplicationsPerWard - $ward->current_applications_count);
                return [
                    'id' => $ward->id,
                    'name' => $ward->name,
                    'current_applications' => $ward->current_applications_count,
                    'remaining_slots' => $remainingSlots,
                    'is_available' => $remainingSlots > 0
                ];
            });

            return response()->json([
                'success' => true,
                'wards' => $wards
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching ward availability',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Calculate Application Progress
     */
    private function calculateApplicationProgress(EducationalBursary $bursary): array
    {
        $steps = [
            'submitted' => ['completed' => true, 'date' => $bursary->submission_date],
            'wdc_review' => ['completed' => false, 'date' => null],
            'wdc_approved' => ['completed' => false, 'date' => null],
            'cdfc_review' => ['completed' => false, 'date' => null],
            'cdfc_approved' => ['completed' => false, 'date' => null],
        ];

        switch ($bursary->status) {
            case 'wdc_review':
                $steps['wdc_review']['completed'] = true;
                break;
            case 'wdc_approved':
                $steps['wdc_review']['completed'] = true;
                $steps['wdc_approved']['completed'] = true;
                $steps['wdc_approved']['date'] = $bursary->wdc_review_date;
                break;
            case 'cdfc_review':
                $steps['wdc_review']['completed'] = true;
                $steps['wdc_approved']['completed'] = true;
                $steps['cdfc_review']['completed'] = true;
                $steps['wdc_approved']['date'] = $bursary->wdc_review_date;
                break;
            case 'cdfc_approved':
                $steps['wdc_review']['completed'] = true;
                $steps['wdc_approved']['completed'] = true;
                $steps['cdfc_review']['completed'] = true;
                $steps['cdfc_approved']['completed'] = true;
                $steps['wdc_approved']['date'] = $bursary->wdc_review_date;
                $steps['cdfc_approved']['date'] = $bursary->cdfc_approval_date;
                break;
            case 'rejected':
                // Keep only completed steps
                break;
        }

        return $steps;
    }

    /**
     * Format File Size
     */
    private function formatFileSize(int $bytes): string
    {
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
}
