<?php

namespace App\Services;

use Google\Cloud\Firestore\FirestoreClient;

class FirestoreService
{
    private static ?FirestoreClient $client = null;

    private static function client(): FirestoreClient
    {
        if (self::$client === null) {
            $credentialsJson = env('FIREBASE_CREDENTIALS', '{}');
            $tmpFile = sys_get_temp_dir() . '/firebase_credentials.json';
            file_put_contents($tmpFile, $credentialsJson);

            self::$client = new FirestoreClient([
                'projectId'   => env('FIREBASE_PROJECT_ID'),
                'keyFilePath' => $tmpFile,
            ]);
        }
        return self::$client;
    }

    public static function collection(string $name)
    {
        return self::client()->collection($name);
    }
}
