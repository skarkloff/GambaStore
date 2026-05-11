<?php

namespace App\Services;

use Google\Cloud\Firestore\FirestoreClient;

class FirestoreService
{
    private static ?FirestoreClient $client = null;

    private static function client(): FirestoreClient
    {
        if (self::$client === null) {
            $credentials = json_decode(env('FIREBASE_CREDENTIALS', '{}'), true);
            self::$client = new FirestoreClient([
                'projectId' => env('FIREBASE_PROJECT_ID'),
                'keyFile'   => $credentials,
                'transportConfig' => [
                    'rest' => [],
                ],
            ]);
        }
        return self::$client;
    }

    public static function collection(string $name)
    {
        return self::client()->collection($name);
    }
}
