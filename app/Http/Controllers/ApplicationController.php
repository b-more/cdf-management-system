<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Ward;
use App\Models\CommunityProject;
use App\Models\AuditTrail;

class ApplicationController extends Controller
{
    /**
     * Submit a new project application
     */
    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'applicant_name' => 'required|string|max:255',
            'applicant_phone' => 'required|string|max:20',
            'applicant_email' => 'nullable|email|max:255',
            'applicant_id_number' => 'required|string|max:50',
            'applicant_address' => 'required|string|max:500',
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'ward_id' => 'required|exists:wards,id',
            'location' => 'required|string|max:255',
            'description' => 'required|string|min:100',
            'requested_amount' => 'required|numeric|min:1000|max:500000',
            'beneficiaries_count' => 'required|integer|min:1',
            'justification' => 'required|string|min:50',
            'priority' => 'required|string|in:High,Medium,Low',
            'terms' => 'required|accepted',
            'sms_consent' => 'required|accepted',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please check your input and try again.');
        }

        try {
            // Generate unique application ID
            $applicationId = 'CDF-' . date('Y') . '-' . sprintf('%06d', rand(100000, 999999));

            // Create the project application
            $project = CommunityProject::create([
                'project_code' => $applicationId,
                'title' => $request->title,
                'description' => $request->description,
                'category' => $request->category,
                'priority' => $request->priority,
                'ward_id' => $request->ward_id,
                'location' => $request->location,
                'requested_amount' => $request->requested_amount,
                'beneficiaries_count' => $request->beneficiaries_count,
                'justification' => $request->justification,
                'status' => 'Submitted',
                'applicant_name' => $request->applicant_name,
                'applicant_phone' => $request->applicant_phone,
                'applicant_email' => $request->applicant_email,
                'applicant_id_number' => $request->applicant_id_number,
                'applicant_address' => $request->applicant_address,
                'submission_date' => now(),
            ]);

            // Log the submission in audit trail
            AuditTrail::create([
                'user_id' => null, // Public submission
                'action' => 'create',
                'model_type' => 'CommunityProject',
                'model_id' => $project->id,
                'description' => "Public application submitted: {$project->title}",
                'old_values' => null,
                'new_values' => json_encode($project->toArray()),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Send SMS confirmation
            $this->sendApplicationConfirmationSMS($request->applicant_phone, $applicationId, $request->title);

            // Clear saved form data
            session()->flash('clear_form', true);

            return redirect()->route('apply')->with('success',
                "Your application has been submitted successfully! " .
                "Application ID: {$applicationId}. " .
                "You will receive SMS updates on your application status."
            );

        } catch (\Exception $e) {
            \Log::error('Application submission error: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Sorry, there was an error submitting your application. Please try again or contact us for assistance.');
        }
    }

    /**
     * Show status check page
     */
    public function checkStatus()
    {
        return view('public.status');
    }

    /**
     * Search for application status
     */
    public function searchStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'search_term' => 'required|string',
            'search_type' => 'required|in:application_id,phone',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->with('error', 'Please provide valid search information.');
        }

        try {
            $query = CommunityProject::whereNotNull('applicant_name');

            if ($request->search_type === 'application_id') {
                $query->where('project_code', $request->search_term);
            } else {
                $query->where('applicant_phone', $request->search_term);
            }

            $applications = $query->with('ward')->get();

            if ($applications->isEmpty()) {
                return back()->with('error', 'No applications found with the provided information.');
            }

            return view('public.status', compact('applications'));

        } catch (\Exception $e) {
            return back()->with('error', 'Sorry, there was an error searching for your application. Please try again.');
        }
    }

    /**
     * Get wards for AJAX requests
     */
    public function getWards()
    {
        try {
            $wards = Ward::select('id', 'name')->orderBy('name')->get();
            return response()->json($wards);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to load wards'], 500);
        }
    }

    /**
     * Send SMS via API
     */
    public function sendSMS(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
            'message' => 'required|string|max:160',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Invalid request data']);
        }

        try {
            $result = $this->sendSMSMessage($request->phone, $request->message);

            if ($result) {
                return response()->json(['success' => true, 'message' => 'SMS sent successfully']);
            } else {
                return response()->json(['success' => false, 'message' => 'Failed to send SMS']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'SMS service error']);
        }
    }

    /**
     * Send application confirmation SMS
     */
    private function sendApplicationConfirmationSMS($phone, $applicationId, $projectTitle)
    {
        $message = "CDF APPLICATION RECEIVED: Your application '{$projectTitle}' has been submitted successfully. Application ID: {$applicationId}. You will receive updates on this number. Thank you!";

        return $this->sendSMSMessage($phone, $message);
    }

    /**
     * Send SMS using the provided API
     */
    private function sendSMSMessage($phone, $message)
    {
        try {
            // Clean phone number (remove spaces, special characters)
            $cleanPhone = preg_replace('/[^0-9+]/', '', $phone);

            // Ensure phone starts with country code
            if (!str_starts_with($cleanPhone, '260') && !str_starts_with($cleanPhone, '+260')) {
                if (str_starts_with($cleanPhone, '0')) {
                    $cleanPhone = '260' . substr($cleanPhone, 1);
                } else {
                    $cleanPhone = '260' . $cleanPhone;
                }
            }

            $encodedMessage = urlencode($message);
            $url = "https://www.cloudservicezm.com/smsservice/httpapi?" . http_build_query([
                'username' => 'Blessmore',
                'password' => 'Blessmore',
                'msg' => $message,
                'shortcode' => '2343',
                'sender_id' => 'BLESSMORE',
                'phone' => $cleanPhone,
                'api_key' => '121231313213123123'
            ]);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Cookie: MUTUMIKI=us0kovmvlpga3vpdf5dl1uclih'
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            // Log SMS attempt
            \Log::info('SMS sent', [
                'phone' => $cleanPhone,
                'message' => $message,
                'response' => $response,
                'http_code' => $httpCode
            ]);

            return $httpCode === 200;

        } catch (\Exception $e) {
            \Log::error('SMS Error: ' . $e->getMessage());
            return false;
        }
    }
}
