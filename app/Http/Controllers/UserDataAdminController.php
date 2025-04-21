<?php

namespace App\Http\Controllers;

use App\Models\UserData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Helpers\JsonHelper;

class UserDataAdminController extends Controller
{
    /**
     * Affiche la page d'administration des données utilisateur
     */
    public function index()
    {
        // Récupération de tous les enregistrements pour les calculs basés sur JSON
        $allUserData = UserData::all();
        
        // Utilisateurs avec historique de recherche
        $usersWithSearchHistory = JsonHelper::filterNonEmptyJson($allUserData, 'search_history')->count();
        
        // Total des pages consultées
        $totalPagesViewed = JsonHelper::countJsonElements($allUserData, 'page_views');
        
        // Statistiques générales
        $stats = [
            'total' => UserData::count(),
            'today' => UserData::whereDate('created_at', today())->count(),
            'browsers' => UserData::select(DB::raw('COUNT(*) as count'))
                ->selectRaw("CASE 
                    WHEN user_agent LIKE '%Firefox%' THEN 'Firefox'
                    WHEN user_agent LIKE '%Chrome%' AND user_agent NOT LIKE '%Edg%' THEN 'Chrome'
                    WHEN user_agent LIKE '%Safari%' AND user_agent NOT LIKE '%Chrome%' THEN 'Safari'
                    WHEN user_agent LIKE '%Edg%' THEN 'Edge'
                    WHEN user_agent LIKE '%MSIE%' OR user_agent LIKE '%Trident/%' THEN 'Internet Explorer'
                    WHEN user_agent LIKE '%Opera%' OR user_agent LIKE '%OPR%' THEN 'Opera'
                    ELSE 'Autre'
                END as browser")
                ->groupBy('browser')
                ->orderBy('count', 'desc')
                ->get(),
            'os' => UserData::select(DB::raw('COUNT(*) as count'))
                ->selectRaw("CASE 
                    WHEN user_agent LIKE '%Windows%' THEN 'Windows'
                    WHEN user_agent LIKE '%Mac OS%' THEN 'macOS'
                    WHEN user_agent LIKE '%Linux%' THEN 'Linux'
                    WHEN user_agent LIKE '%iPhone%' OR user_agent LIKE '%iPad%' THEN 'iOS'
                    WHEN user_agent LIKE '%Android%' THEN 'Android'
                    ELSE 'Autre'
                END as os")
                ->groupBy('os')
                ->orderBy('count', 'desc')
                ->get(),
            'mobile' => UserData::where(function($query) {
                $query->where('user_agent', 'like', '%Mobile%')
                    ->orWhere('user_agent', 'like', '%Android%')
                    ->orWhere('user_agent', 'like', '%iPhone%')
                    ->orWhere('user_agent', 'like', '%iPad%');
            })->count(),
            'desktop' => UserData::where(function($query) {
                $query->where('user_agent', 'not like', '%Mobile%')
                    ->where('user_agent', 'not like', '%Android%')
                    ->where('user_agent', 'not like', '%iPhone%')
                    ->where('user_agent', 'not like', '%iPad%');
            })->count(),
            'countries' => UserData::whereNotNull('country')
                ->select('country', DB::raw('count(*) as count'))
                ->groupBy('country')
                ->orderBy('count', 'desc')
                ->limit(10)
                ->get(),
            'cities' => UserData::whereNotNull('city')
                ->select('city', 'country', DB::raw('count(*) as count'))
                ->groupBy('city', 'country')
                ->orderBy('count', 'desc')
                ->limit(10)
                ->get(),
            'searches' => UserData::whereNotNull('search_history')
                ->count(),
            'total_pages_viewed' => UserData::count() // Approximation pour SQLite
        ];
        
        // Récupérer les données utilisateur avec pagination
        $userData = UserData::latest()->paginate(15);
        
        return view('admin.user-data.index', [
            'userData' => $userData,
            'stats' => $stats,
            'allUserData' => $allUserData,
            'totalUsers' => $stats['total'],
            'todayUsers' => $stats['today'],
            'browsers' => $stats['browsers'],
            'operatingSystems' => $stats['os'],
            'mobileUsers' => $stats['mobile'],
            'desktopUsers' => $stats['desktop'],
            'countries' => $stats['countries'],
            'cities' => $stats['cities'],
            'usersWithSearchHistory' => $usersWithSearchHistory,
            'totalPagesViewed' => $totalPagesViewed
        ]);
    }
    
    /**
     * Affiche le détail d'un enregistrement
     */
    public function show($id)
    {
        $userData = UserData::findOrFail($id);
        
        return view('admin.user-data.show', [
            'userData' => $userData
        ]);
    }
    
    /**
     * Exporte les données utilisateur en CSV
     */
    public function export(Request $request)
    {
        $fileName = 'user_data_export_' . date('Y-m-d') . '.csv';
        
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];
        
        $columns = [
            'ID', 'User ID', 'URL', 'Référent', 'Adresse IP', 
            'Navigateur', 'Système', 'Mobile', 'Langue', 
            'Résolution', 'Cookies', 'Date'
        ];
        
        $callback = function() use($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            
            UserData::orderBy('id')->chunk(100, function($users) use($file) {
                foreach ($users as $user) {
                    fputcsv($file, [
                        $user->id,
                        $user->user_id,
                        $user->url,
                        $user->referrer,
                        $user->ip_address,
                        $user->browser,
                        $user->os,
                        $user->is_mobile ? 'Oui' : 'Non',
                        $user->language,
                        $user->screen_resolution,
                        $user->cookies_enabled ? 'Oui' : 'Non',
                        $user->created_at->format('d/m/Y H:i:s'),
                    ]);
                }
            });
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }
    
    /**
     * Supprime un enregistrement
     */
    public function destroy($id)
    {
        $userData = UserData::findOrFail($id);
        $userData->delete();
        
        return redirect()->route('user-data-admin.index')
            ->with('success', 'Enregistrement supprimé avec succès');
    }
    
    /**
     * Supprime tous les enregistrements
     */
    public function destroyAll()
    {
        UserData::truncate();
        
        return redirect()->route('user-data-admin.index')
            ->with('success', 'Toutes les données utilisateur ont été supprimées');
    }
} 