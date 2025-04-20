<?php

namespace App\Http\Controllers;

use App\Models\DemoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class DemoAdminController extends Controller
{
    /**
     * Affiche la liste des demandes de démo
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Récupère toutes les demandes de démo, triées par date (plus récentes d'abord)
        $demoRequests = DemoRequest::orderBy('created_at', 'desc')->get();
        
        // Récupère des statistiques
        $stats = [
            'total' => DemoRequest::count(),
            'today' => DemoRequest::whereDate('created_at', today())->count(),
            'week' => DemoRequest::where('created_at', '>=', now()->subDays(7))->count(),
            'month' => DemoRequest::where('created_at', '>=', now()->subDays(30))->count(),
            'countries' => DemoRequest::whereNotNull('country')->distinct('country')->count('country'),
            'browsers' => DemoRequest::whereNotNull('browser')
                ->selectRaw('browser, count(*) as count')
                ->groupBy('browser')
                ->orderByDesc('count')
                ->get(),
            'devices' => DemoRequest::whereNotNull('device')
                ->selectRaw('device, count(*) as count')
                ->groupBy('device')
                ->orderByDesc('count')
                ->get(),
        ];
        
        return view('admin.demo-requests', compact('demoRequests', 'stats'));
    }
    
    /**
     * Exporte les demandes de démo au format CSV
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function export()
    {
        $demoRequests = DemoRequest::orderBy('created_at', 'desc')->get();
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="demo-requests-' . date('Y-m-d') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        $callback = function() use ($demoRequests) {
            $file = fopen('php://output', 'w');
            
            // En-têtes CSV
            fputcsv($file, [
                'ID', 'Email', 'Date', 'IP', 'Pays', 'Ville', 
                'Navigateur', 'Système', 'Appareil', 'Référent',
                'Page Atterrissage', 'UTM Source', 'UTM Medium', 
                'UTM Campaign', 'Envoyé le'
            ]);
            
            // Lignes de données
            foreach ($demoRequests as $request) {
                fputcsv($file, [
                    $request->id,
                    $request->email,
                    $request->created_at->format('Y-m-d H:i:s'),
                    $request->ip_address,
                    $request->country,
                    $request->city,
                    $request->browser,
                    $request->os,
                    $request->device,
                    $request->referrer,
                    $request->landing_page,
                    $request->utm_source,
                    $request->utm_medium,
                    $request->utm_campaign,
                    $request->sent_at ? $request->sent_at->format('Y-m-d H:i:s') : 'Non envoyé'
                ]);
            }
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }
    
    /**
     * Marque une demande comme envoyée
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsSent(Request $request, $id)
    {
        $demoRequest = DemoRequest::findOrFail($id);
        $demoRequest->sent_at = now();
        $demoRequest->save();
        
        return redirect()->back()->with('success', 'Demande marquée comme envoyée');
    }
    
    /**
     * Supprime une demande
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $demoRequest = DemoRequest::findOrFail($id);
        $demoRequest->delete();
        
        return redirect()->back()->with('success', 'Demande supprimée avec succès');
    }
} 