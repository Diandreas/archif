<?php

namespace App\Http\Controllers;

use App\Models\UserData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class UserDataController extends Controller
{
    /**
     * Enregistre les données utilisateur collectées automatiquement
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function collectUserData(Request $request)
    {
        Log::info('Requête reçue', ['ip' => $request->ip(), 'content_type' => $request->header('Content-Type')]);
        
        try {
            // Log des données brutes reçues
            Log::info('Données reçues', ['data' => $request->all()]);
            
            // Récupère les informations de localisation basées sur l'IP
            $ipData = $this->getIpInfo($request->ip());
            
            // Extrait les informations du navigateur/appareil
            $deviceInfo = $this->parseUserAgent($request->userAgent());
            
            // Valider uniquement les données minimales requises
            $validated = $request->validate([
                'userId' => 'required|string',
                'url' => 'required|string',
            ]);
            
            // Vérifier si un enregistrement existe déjà pour cet utilisateur aujourd'hui
            $existingRecord = UserData::where('user_id', $validated['userId'])
                ->whereDate('created_at', today())
                ->first();

            if ($existingRecord) {
                // Mettre à jour l'enregistrement existant
                $existingRecord->update([
                    'url' => $validated['url'],
                    'search_history' => $request->search_history ?? $existingRecord->search_history,
                    'page_views' => $request->page_views ?? $existingRecord->page_views,
                    'visit_count' => ($existingRecord->visit_count ?? 0) + 1,
                    'time_spent' => $request->time_spent ?? $existingRecord->time_spent,
                    'last_visit' => now(),
                ]);

                Log::info('Enregistrement existant mis à jour', ['id' => $existingRecord->id]);
                
                return response()->json([
                    'success' => true, 
                    'message' => 'Données utilisateur mises à jour avec succès',
                    'id' => $existingRecord->id
                ]);
            }

            // Préparer les données pour le modèle
            $userData = [
                'user_id' => $validated['userId'],
                'url' => $validated['url'],
                'referrer' => $request->header('referer') ?? '',
                'ip_address' => $request->ip(),
                'country' => $ipData['country'] ?? null,
                'city' => $ipData['city'] ?? null,
                'region' => $ipData['region'] ?? null,
                'user_agent' => $request->userAgent(),
                'language' => $request->getPreferredLanguage() ?? 'fr',
                'screen_resolution' => $request->input('screenResolution', null),
                'window_size' => $request->input('windowSize', null),
                'timezone' => $request->input('timezone', null),
                'cookies_enabled' => $request->input('cookiesEnabled', true),
                'do_not_track' => $request->input('doNotTrack', null),
                'platform' => $deviceInfo['os'] ?? null,
                'connection_type' => $request->input('connectionType', 'unknown'),
                'search_history' => $request->input('search_history', null),
                'page_views' => $request->input('page_views', null),
                'visit_count' => 1,
                'time_spent' => $request->input('time_spent', 0),
                'last_visit' => now(),
                'additional_data' => [
                    'utm_source' => $request->query('utm_source'),
                    'utm_medium' => $request->query('utm_medium'),
                    'utm_campaign' => $request->query('utm_campaign'),
                    'timestamp_client' => $request->input('timestamp', now()->toIso8601String()),
                ],
            ];
            
            // Enregistrer les données dans la base de données
            $record = UserData::create($userData);
            
            Log::info('Nouvel enregistrement créé avec succès', ['id' => $record->id]);
            
            return response()->json([
                'success' => true, 
                'message' => 'Données utilisateur enregistrées avec succès',
                'id' => $record->id
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Erreur de validation', [
                'errors' => $e->errors(),
            ]);
            
            return response()->json([
                'success' => false, 
                'message' => 'Erreur de validation des données', 
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'enregistrement des données utilisateur', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return response()->json([
                'success' => false, 
                'message' => 'Erreur lors de l\'enregistrement des données: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Récupère les informations de géolocalisation basées sur l'IP
     *
     * @param  string  $ip
     * @return array
     */
    private function getIpInfo($ip)
    {
        try {
            // Si on est en local, on utilise une IP de test
            if ($ip == '127.0.0.1' || $ip == '::1') {
                return [
                    'country' => 'Cameroun',
                    'city' => 'Yaoundé',
                    'region' => 'Centre'
                ];
            }

            // Utilise l'API ipinfo.io pour obtenir la géolocalisation
            $response = Http::get("https://ipinfo.io/{$ip}/json");
            
            if ($response->successful()) {
                $data = $response->json();
                
                return [
                    'country' => $data['country'] ?? null,
                    'city' => $data['city'] ?? null,
                    'region' => $data['region'] ?? null
                ];
            }
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des données IP', [
                'error' => $e->getMessage(),
                'ip' => $ip
            ]);
        }

        return [];
    }

    /**
     * Extrait les informations du navigateur et de l'appareil depuis l'User-Agent
     *
     * @param  string  $userAgent
     * @return array
     */
    private function parseUserAgent($userAgent)
    {
        $browser = 'Inconnu';
        $device = 'Desktop';
        $os = 'Inconnu';

        // Détecter le navigateur
        if (strpos($userAgent, 'Chrome') !== false && strpos($userAgent, 'Edg') === false) {
            $browser = 'Chrome';
        } elseif (strpos($userAgent, 'Firefox') !== false) {
            $browser = 'Firefox';
        } elseif (strpos($userAgent, 'Safari') !== false && strpos($userAgent, 'Chrome') === false) {
            $browser = 'Safari';
        } elseif (strpos($userAgent, 'Edg') !== false) {
            $browser = 'Edge';
        } elseif (strpos($userAgent, 'MSIE') !== false || strpos($userAgent, 'Trident') !== false) {
            $browser = 'Internet Explorer';
        } elseif (strpos($userAgent, 'Opera') !== false || strpos($userAgent, 'OPR') !== false) {
            $browser = 'Opera';
        }

        // Détecter le système d'exploitation
        if (strpos($userAgent, 'Windows') !== false) {
            $os = 'Windows';
        } elseif (strpos($userAgent, 'Mac') !== false) {
            $os = 'MacOS';
        } elseif (strpos($userAgent, 'Linux') !== false) {
            $os = 'Linux';
        } elseif (strpos($userAgent, 'Android') !== false) {
            $os = 'Android';
        } elseif (strpos($userAgent, 'iOS') !== false || strpos($userAgent, 'iPhone') !== false || strpos($userAgent, 'iPad') !== false) {
            $os = 'iOS';
        }

        // Détecter le type d'appareil
        if (strpos($userAgent, 'Mobile') !== false || strpos($userAgent, 'Android') !== false || strpos($userAgent, 'iPhone') !== false) {
            $device = 'Mobile';
        } elseif (strpos($userAgent, 'iPad') !== false || strpos($userAgent, 'Tablet') !== false) {
            $device = 'Tablet';
        }

        return [
            'browser' => $browser,
            'device' => $device,
            'os' => $os
        ];
    }
} 