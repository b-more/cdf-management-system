<?php

namespace App\Services;

use App\Models\SmsNotification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class SmsService
{
    private $username;
    private $password;
    private $sender_id;
    private $short_code;
    private $api_key;
    private $http_endpoint;
    private $json_endpoint;

    public function __construct()
    {
        $this->username = config('sms.username');
        $this->password = config('sms.password');
        $this->sender_id = config('sms.sender_id');
        $this->short_code = config('sms.short_code');
        $this->api_key = config('sms.api_key', 'use_preshared');
        $this->http_endpoint = config('sms.http_endpoint');
        $this->json_endpoint = config('sms.json_endpoint');
    }

    /**
     * Send single SMS using HTTP API
     */
    public function sendSingleSms(string $phone, string $message, ?int $userId = null): array
    {
        try {
            // Clean phone number
            $phone = $this->cleanPhoneNumber($phone);

            // Create SMS notification record
            $smsNotification = SmsNotification::create([
                'user_id' => $userId,
                'phone' => $phone,
                'message' => $message,
                'message_type' => 'general',
                'status' => 'pending',
                'sent_by' => auth()->id(),
            ]);

            // Prepare URL with parameters
            $url = $this->http_endpoint . '?' . http_build_query([
                'username' => $this->username,
                'password' => $this->password,
                'msg' => $message,
                'shortcode' => $this->short_code,
                'sender_id' => $this->sender_id,
                'phone' => $phone,
                'api_key' => $this->api_key,
            ]);

            // Send HTTP request
            $response = Http::timeout(30)
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])
                ->post($url);

            $responseData = $response->body();

            // Update SMS notification status based on response
            if ($response->successful()) {
                $smsNotification->update([
                    'status' => 'sent',
                    'response_data' => $responseData,
                    'sms_reference' => $this->generateReference(),
                    'sent_at' => now(),
                ]);

                return [
                    'success' => true,
                    'message' => 'SMS sent successfully',
                    'response' => $responseData,
                    'sms_id' => $smsNotification->id,
                ];
            } else {
                $smsNotification->update([
                    'status' => 'failed',
                    'response_data' => $responseData,
                ]);

                return [
                    'success' => false,
                    'message' => 'Failed to send SMS',
                    'response' => $responseData,
                    'sms_id' => $smsNotification->id,
                ];
            }

        } catch (Exception $e) {
            Log::error('SMS Service Error: ' . $e->getMessage());

            if (isset($smsNotification)) {
                $smsNotification->update([
                    'status' => 'failed',
                    'response_data' => $e->getMessage(),
                ]);
            }

            return [
                'success' => false,
                'message' => 'SMS service error: ' . $e->getMessage(),
                'sms_id' => $smsNotification->id ?? null,
            ];
        }
    }

    /**
     * Send bulk SMS using JSON API
     */
    public function sendBulkSms(array $recipients, string $messageType = 'bulk'): array
    {
        try {
            $messages = [];
            $smsNotifications = [];

            // Prepare messages array and create notification records
            foreach ($recipients as $recipient) {
                $phone = $this->cleanPhoneNumber($recipient['phone']);
                $message = $recipient['message'];
                $userId = $recipient['user_id'] ?? null;

                $messages[] = [
                    'phone' => $phone,
                    'message' => $message,
                ];

                // Create SMS notification record
                $smsNotifications[] = SmsNotification::create([
                    'user_id' => $userId,
                    'phone' => $phone,
                    'message' => $message,
                    'message_type' => $messageType,
                    'status' => 'pending',
                    'sent_by' => auth()->id(),
                ]);
            }

            // Prepare JSON payload
            $jsonData = [
                'auth' => [
                    'username' => $this->username,
                    'password' => $this->password,
                    'sender_id' => $this->sender_id,
                    'short_code' => $this->short_code,
                ],
                'messages' => $messages,
            ];

            // Send JSON request
            $response = Http::timeout(60)
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])
                ->post($this->json_endpoint, $jsonData);

            $responseData = $response->body();

            // Update all SMS notification statuses
            $status = $response->successful() ? 'sent' : 'failed';
            foreach ($smsNotifications as $notification) {
                $notification->update([
                    'status' => $status,
                    'response_data' => $responseData,
                    'sms_reference' => $this->generateReference(),
                    'sent_at' => $response->successful() ? now() : null,
                ]);
            }

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message' => 'Bulk SMS sent successfully',
                    'count' => count($recipients),
                    'response' => $responseData,
                    'sms_ids' => collect($smsNotifications)->pluck('id')->toArray(),
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Failed to send bulk SMS',
                    'response' => $responseData,
                    'sms_ids' => collect($smsNotifications)->pluck('id')->toArray(),
                ];
            }

        } catch (Exception $e) {
            Log::error('Bulk SMS Service Error: ' . $e->getMessage());

            // Update failed notifications
            if (isset($smsNotifications)) {
                foreach ($smsNotifications as $notification) {
                    $notification->update([
                        'status' => 'failed',
                        'response_data' => $e->getMessage(),
                    ]);
                }
            }

            return [
                'success' => false,
                'message' => 'Bulk SMS service error: ' . $e->getMessage(),
                'sms_ids' => isset($smsNotifications) ? collect($smsNotifications)->pluck('id')->toArray() : [],
            ];
        }
    }

    /**
     * Send project approval notification
     */
    public function sendProjectApprovalSms(string $phone, string $projectTitle, string $status, ?int $userId = null): array
    {
        $message = match($status) {
            'wdc_recommended' => "Your project '{$projectTitle}' has been recommended by WDC and forwarded to CDFC for final approval.",
            'cdfc_approved' => "Congratulations! Your project '{$projectTitle}' has been approved by CDFC. Funds will be allocated soon.",
            'rejected' => "Your project '{$projectTitle}' has been rejected. Please contact your Ward Development Committee for more details.",
            default => "Your project '{$projectTitle}' status has been updated to: {$status}."
        };

        return $this->sendSingleSms($phone, $message, $userId);
    }

    /**
     * Send fund allocation notification
     */
    public function sendFundAllocationSms(string $phone, string $projectTitle, int $amount, ?int $userId = null): array
    {
        $formattedAmount = 'K' . number_format($amount, 2);
        $message = "Fund allocation approved! Your project '{$projectTitle}' has been allocated {$formattedAmount}. Implementation can begin as per approved plan.";

        return $this->sendSingleSms($phone, $message, $userId);
    }

    /**
     * Send grant repayment reminder
     */
    public function sendRepaymentReminderSms(string $phone, string $grantReference, int $amount, string $dueDate, ?int $userId = null): array
    {
        $formattedAmount = 'K' . number_format($amount, 2);
        $message = "Payment reminder: Your grant {$grantReference} has an outstanding balance of {$formattedAmount}. Due date: {$dueDate}. Please make payment to avoid penalties.";

        return $this->sendSingleSms($phone, $message, $userId);
    }

    /**
     * Send monitoring report reminder
     */
    public function sendMonitoringReminderSms(string $phone, string $projectTitle, string $period, ?int $userId = null): array
    {
        $message = "Monitoring report reminder: Please submit your {$period} progress report for project '{$projectTitle}'. Reports are essential for continued funding.";

        return $this->sendSingleSms($phone, $message, $userId);
    }

    /**
     * Clean and format phone number
     */
    private function cleanPhoneNumber(string $phone): string
    {
        // Remove any non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Handle different formats and convert to 260XXXXXXXXX
        if (substr($phone, 0, 3) === '260') {
            return $phone;
        } elseif (substr($phone, 0, 1) === '0') {
            return '260' . substr($phone, 1);
        } elseif (strlen($phone) === 9) {
            return '260' . $phone;
        }

        return $phone;
    }

    /**
     * Generate unique SMS reference
     */
    private function generateReference(): string
    {
        return 'SMS-' . date('Ymd-His') . '-' . rand(1000, 9999);
    }

    /**
     * Get SMS sending statistics
     */
    public function getSmsStatistics(int $days = 30): array
    {
        $fromDate = now()->subDays($days);

        return [
            'total_sent' => SmsNotification::where('created_at', '>=', $fromDate)->count(),
            'successful' => SmsNotification::where('created_at', '>=', $fromDate)->where('status', 'sent')->count(),
            'failed' => SmsNotification::where('created_at', '>=', $fromDate)->where('status', 'failed')->count(),
            'pending' => SmsNotification::where('created_at', '>=', $fromDate)->where('status', 'pending')->count(),
            'by_type' => SmsNotification::where('created_at', '>=', $fromDate)
                ->selectRaw('message_type, count(*) as count')
                ->groupBy('message_type')
                ->pluck('count', 'message_type')
                ->toArray(),
        ];
    }

    /**
     * Retry failed SMS
     */
    public function retrySms(int $smsId): array
    {
        $sms = SmsNotification::findOrFail($smsId);

        if ($sms->status !== 'failed') {
            return [
                'success' => false,
                'message' => 'SMS is not in failed status',
            ];
        }

        return $this->sendSingleSms($sms->phone, $sms->message, $sms->user_id);
    }
}

// Config file: config/sms.php
return [
    'username' => env('SMS_USERNAME'),
    'password' => env('SMS_PASSWORD'),
    'sender_id' => env('SMS_SENDER_ID'),
    'short_code' => env('SMS_SHORTCODE', '388'),
    'api_key' => env('SMS_API_KEY', 'use_preshared'),
    'http_endpoint' => env('SMS_HTTP_ENDPOINT', 'https://www.cloudservicezm.com/smsservice/httpapi'),
    'json_endpoint' => env('SMS_JSON_ENDPOINT', 'https://www.cloudservicezm.com/smsservice/jsonapi'),
];

// .env additions
/*
SMS_USERNAME=your_username
SMS_PASSWORD=your_password
SMS_SENDER_ID=your_sender_id
SMS_SHORTCODE=388
SMS_API_KEY=use_preshared
SMS_HTTP_ENDPOINT=https://www.cloudservicezm.com/smsservice/httpapi
SMS_JSON_ENDPOINT=https://www.cloudservicezm.com/smsservice/jsonapi
*/
