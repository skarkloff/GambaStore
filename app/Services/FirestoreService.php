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
                // Flujo de tu compañero para Vercel
                $tmpFile = sys_get_temp_dir() . '/firebase_credentials.json';
                file_put_contents($tmpFile, $credentials);
                putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $tmpFile);

                self::$client = new FirestoreClient([
                    'projectId' => env('FIREBASE_PROJECT_ID'),
                ]);
            } else {
                // TU FLUJO EN DOCKER (Lee el archivo mapeado en Linux)
                self::$client = new FirestoreClient([
                    'projectId' => env('FIREBASE_PROJECT_ID'),
                    'keyFilePath' => env('GOOGLE_APPLICATION_CREDENTIALS'), // <-- Forzamos la ruta interna
                ]);
            }
        }
        return self::$client;
    }

    public static function collection(string $name)
    {
        return self::client()->collection($name);
    }
}
