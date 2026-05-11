<?php

namespace App\Services;

use Google\Cloud\Firestore\FirestoreClient;

class FirestoreService
{
    private static ?FirestoreClient $client = null;

    private static function client(): FirestoreClient
    {
        if (self::$client === null) {
            $credentials = env('FIREBASE_CREDENTIALS');
            if ($credentials) {
                // Vercel: JSON inline en variable de entorno
                $tmpFile = sys_get_temp_dir() . '/firebase_credentials.json';
                file_put_contents($tmpFile, $credentials);
                putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $tmpFile);
            }
            // Local: GOOGLE_APPLICATION_CREDENTIALS apunta al archivo .json directamente

            self::$client = new FirestoreClient([
                'projectId' => env('FIREBASE_PROJECT_ID'),
            ]);
        }
        return self::$client;
    }

    public static function collection(string $name)
    {
        return self::client()->collection($name);
    }
}
