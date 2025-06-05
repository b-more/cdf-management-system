<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommunityProject;
use App\Models\Ward;

class PublicApplicationController extends Controller
{
    public function showForm()
    {
        $wards = Ward::all();
        return view('public.apply', compact('wards'));
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'fullName' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email',
            'nationalId' => 'required|string|max:50',
            'address' => 'required|string',
            'projectType' => 'required|in:community,disaster',
            'projectTitle' => 'required|string|max:255',
            'category' => 'required|string',
            'ward' => 'required|exists:wards,name',
            'description' => 'required|string',
            'requestedAmount' => 'required|numeric|min:1000|max:500000',
            'beneficiaries' => 'required|integer|min:1',
            'priority' => 'required|in:Low,Medium,High,Critical',
            'location' => 'required|string',
        ]);

        // Generate application ID
        $applicationId = 'CDF-' . date('Y') . '-' . strtoupper(uniqid());

        // Get ward ID
        $ward = Ward::where('name', $validated['ward'])->first();

        // Create application
        $project = CommunityProject::create([
            'project_code' => $applicationId,
            'title' => $validated['projectTitle'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'priority' => $validated['priority'],
            'status' => 'Submitted',
            'ward_id' => $ward->id,
            'location' => $validated['location'],
            'beneficiaries_count' => $validated['beneficiaries'],
            'requested_amount' => $validated['requestedAmount'],
            'applicant_name' => $validated['fullName'],
            'applicant_phone' => $validated['phone'],
            'applicant_email' => $validated['email'],
            'applicant_id_number' => $validated['nationalId'],
            'applicant_address' => $validated['address'],
        ]);

        // Send SMS notification
        $this->sendSMSNotification($validated['phone'], $applicationId, $validated['projectTitle']);

        return response()->json([
            'success' => true,
            'application_id' => $applicationId,
            'message' => 'Application submitted successfully!'
        ]);
    }

    private function sendSMSNotification($phone, $applicationId, $projectTitle)
    {
        $message = "CDF APPLICATION: Your application '{$projectTitle}' has been submitted successfully. Application ID: {$applicationId}. You will receive updates on this number.";

        $encodedMessage = urlencode($message);
        $url = "https://www.cloudservicezm.com/smsservice/httpapi?username=Blessmore&password=Blessmore&msg={$encodedMessage}&shortcode=2343&sender_id=BLESSMORE&phone={$phone}&api_key=121231313213123123";

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Cookie: MUTUMIKI=us0kovmvlpga3vpdf5dl1uclih'
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            curl_close($ch);

            return $response;
        } catch (\Exception $e) {
            \Log::error('SMS Error: ' . $e->getMessage());
            return false;
        }
    }
}
