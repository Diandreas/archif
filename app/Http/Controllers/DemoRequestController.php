<?php

namespace App\Http\Controllers;

use App\Models\DemoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DemoRequestController extends Controller
{
    /**
     * Enregistre une nouvelle demande de démo
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Log la requête pour le débogage
        Log::info('Demo request received', [
            'email' => $request->email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:demo_requests,email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first('email')
            ]);
        }

        try {
            // Récupère les informations de localisation basées sur l'IP
            $ipData = $this->getIpInfo($request->ip());
            
            // Extrait les informations du navigateur/appareil
            $deviceInfo = $this->parseUserAgent($request->userAgent());
            
            // Prépare les données à sauvegarder
            $demoData = [
                'email' => $request->email,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'country' => $ipData['country'] ?? null,
                'city' => $ipData['city'] ?? null,
                'browser' => $deviceInfo['browser'] ?? null,
                'device' => $deviceInfo['device'] ?? null,
                'os' => $deviceInfo['os'] ?? null,
                'referrer' => $request->header('referer'),
                'utm_source' => $request->query('utm_source'),
                'utm_medium' => $request->query('utm_medium'),
                'utm_campaign' => $request->query('utm_campaign'),
                'landing_page' => $request->session()->get('landing_page', url()->previous()),
            ];

            // Enregistre la demande de démo
            DemoRequest::create($demoData);

            return response()->json([
                'success' => true,
                'message' => 'Merci ! Vous recevrez bientôt un email avec votre démo.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error saving demo request', [
                'error' => $e->getMessage(),
                'email' => $request->email
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Une erreur s\'est produite. Veuillez réessayer plus tard.'
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
                    'city' => 'Yaoundé'
                ];
            }

            // Utilise l'API ipinfo.io pour obtenir la géolocalisation
            // Note: on peut utiliser la version gratuite sans token avec des limites de requêtes
            $response = Http::get("https://ipinfo.io/{$ip}/json");
            
            if ($response->successful()) {
                $data = $response->json();
                return [
                    'country' => $data['country'] ?? null,
                    'city' => $data['city'] ?? null
                ];
            }
        } catch (\Exception $e) {
            // En cas d'erreur, on retourne un tableau vide
            report($e);
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
        if (strpos($userAgent, 'Chrome') && !strpos($userAgent, 'Edg')) {
            $browser = 'Chrome';
        } elseif (strpos($userAgent, 'Firefox')) {
            $browser = 'Firefox';
        } elseif (strpos($userAgent, 'Safari') && !strpos($userAgent, 'Chrome')) {
            $browser = 'Safari';
        } elseif (strpos($userAgent, 'Edg')) {
            $browser = 'Edge';
        } elseif (strpos($userAgent, 'MSIE') || strpos($userAgent, 'Trident')) {
            $browser = 'Internet Explorer';
        }

        // Détecter le système d'exploitation
        if (strpos($userAgent, 'Windows')) {
            $os = 'Windows';
        } elseif (strpos($userAgent, 'Mac')) {
            $os = 'MacOS';
        } elseif (strpos($userAgent, 'Linux')) {
            $os = 'Linux';
        } elseif (strpos($userAgent, 'Android')) {
            $os = 'Android';
        } elseif (strpos($userAgent, 'iOS') || strpos($userAgent, 'iPhone') || strpos($userAgent, 'iPad')) {
            $os = 'iOS';
        }

        // Détecter le type d'appareil
        if (strpos($userAgent, 'Mobile') || strpos($userAgent, 'Android') || strpos($userAgent, 'iPhone')) {
            $device = 'Mobile';
        } elseif (strpos($userAgent, 'iPad') || strpos($userAgent, 'Tablet')) {
            $device = 'Tablet';
        }

        return [
            'browser' => $browser,
            'device' => $device,
            'os' => $os
        ];
    }
} 