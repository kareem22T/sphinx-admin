<?php

namespace App\Traits;

use Google\Client as Google_Client;  // Ensure the correct namespace
use Illuminate\Support\Facades\Http;
use App\Models\Notification;

trait PushNotificationTrait
{
    public function pushNotification($title, $body, $user_id = null, $topic = 'all_users', $data = null)
    {
        // Initialize the Google Client
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/sphinx-travel-d17f5-firebase-adminsdk-vxcus-773161a904.json'));  // Load the service account JSON file
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');

        // Fetch the access token
        $accessToken = $client->fetchAccessTokenWithAssertion()['access_token'];

        // Determine if we are using a token or a topic
        if ($user_id) {
            $deviceToken = $this->getUserDeviceToken($user_id);  // Create a method to fetch this if needed
            $messageTarget = ['token' => $deviceToken];  // Use 'token' for device-specific push
        } else {
            $messageTarget = ['topic' => $topic ?? 'all_users'];  // Use 'topic' for broadcast
        }

        // Send the push notification
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
        ])
            ->post('https://fcm.googleapis.com/v1/projects/sphinx-travel-d17f5/messages:send', [
                'message' => array_merge($messageTarget, [
                    'notification' => [
                        'title' => $title,
                        'body' => $body,
                    ],
                    'data' => array_merge($data ?? [], [
                        'icon_url' => "https://sphinx-travel.ykdev.online/11Sphinx.png"
                    ])
                ]),
            ]);

        // Handle the response
        if ($response->successful()) {
            return $response->json();
        } else {
            return $response->json();
        }
    }

    // Example function to get the user's device token
    private function getUserDeviceToken($user_id)
    {
        // Fetch from your database or relevant storage
        return "the_user_device_token";  // Replace with actual logic to fetch the token
    }
}
