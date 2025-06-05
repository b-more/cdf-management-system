<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\FamilyMember;
use App\Models\EducationalBursary;

class FamilyMemberController extends Controller
{
    /**
     * Add Family Member via AJAX
     */
    public function addFamilyMember(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'educational_bursary_id' => 'required|exists:educational_bursaries,id',
            'relationship' => 'required|in:father,mother,guardian',
            'vital_status' => 'required|in:alive,deceased',
            'surname' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'other_names' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female',
            'date_of_birth' => 'nullable|date',
            'nrc_number' => 'nullable|string|max:50',
            'occupation' => 'nullable|string|max:255',
            'employer_name' => 'nullable|string|max:255',
            'mobile_phone' => 'nullable|string|max:20',
            'has_disability' => 'boolean',
            'disability_nature' => 'nullable|string|max:500',
            'has_medical_condition' => 'boolean',
            'medical_condition_details' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $familyMember = FamilyMember::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Family member added successfully',
                'family_member' => $familyMember
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding family member',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update Family Member
     */
    public function updateFamilyMember(Request $request, FamilyMember $familyMember)
    {
        $validator = Validator::make($request->all(), [
            'relationship' => 'required|in:father,mother,guardian',
            'vital_status' => 'required|in:alive,deceased',
            'surname' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'other_names' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female',
            'date_of_birth' => 'nullable|date',
            'occupation' => 'nullable|string|max:255',
            'employer_name' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $familyMember->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Family member updated successfully',
                'family_member' => $familyMember
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating family member',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete Family Member
     */
    public function deleteFamilyMember(FamilyMember $familyMember)
    {
        try {
            $familyMember->delete();

            return response()->json([
                'success' => true,
                'message' => 'Family member deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting family member',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Family Members for a Bursary Application
     */
    public function getFamilyMembers(EducationalBursary $bursary)
    {
        try {
            $familyMembers = $bursary->familyMembers()->orderBy('relationship')->get();

            return response()->json([
                'success' => true,
                'family_members' => $familyMembers
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching family members',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Validate Family Member Employment Details
     */
    public function validateEmployment(Request $request)
    {
        $rules = [
            'occupation' => 'nullable|string|max:255',
            'employer_name' => 'nullable|string|max:255',
            'position_rank' => 'nullable|string|max:255',
            'employer_address' => 'nullable|string|max:500',
        ];

        // If occupation is provided, require employer details
        if ($request->filled('occupation') && $request->occupation !== 'unemployed') {
            $rules['employer_name'] = 'required|string|max:255';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Employment details are valid'
        ]);
    }
}
