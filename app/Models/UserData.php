<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    use HasFactory;
    
    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'url',
        'referrer',
        'ip_address',
        'country',
        'city',
        'region',
        'latitude',
        'longitude',
        'user_agent',
        'language',
        'screen_resolution',
        'window_size',
        'timezone',
        'cookies_enabled',
        'do_not_track',
        'platform',
        'connection_type',
        'additional_data',
        'search_history',
        'page_views',
        'visit_count',
        'last_visit',
        'time_spent',
    ];
    
    /**
     * Les attributs qui doivent être convertis.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'cookies_enabled' => 'boolean',
        'additional_data' => 'array',
        'search_history' => 'array',
        'page_views' => 'array',
        'latitude' => 'float',
        'longitude' => 'float',
        'visit_count' => 'integer',
        'time_spent' => 'integer',
        'last_visit' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    /**
     * Obtenir le navigateur de l'utilisateur à partir de l'user-agent
     */
    public function getBrowserAttribute()
    {
        $userAgent = $this->user_agent;
        
        if (strpos($userAgent, 'Firefox') !== false) {
            return 'Firefox';
        } elseif (strpos($userAgent, 'Chrome') !== false && strpos($userAgent, 'Edg') === false) {
            return 'Chrome';
        } elseif (strpos($userAgent, 'Safari') !== false && strpos($userAgent, 'Chrome') === false) {
            return 'Safari';
        } elseif (strpos($userAgent, 'Edg') !== false) {
            return 'Edge';
        } elseif (strpos($userAgent, 'MSIE') !== false || strpos($userAgent, 'Trident/') !== false) {
            return 'Internet Explorer';
        } elseif (strpos($userAgent, 'Opera') !== false || strpos($userAgent, 'OPR') !== false) {
            return 'Opera';
        }
        
        return 'Autre';
    }
    
    /**
     * Déterminer si l'utilisateur est sur mobile
     */
    public function getIsMobileAttribute()
    {
        $userAgent = $this->user_agent;
        
        return (
            strpos($userAgent, 'iPhone') !== false || 
            strpos($userAgent, 'iPad') !== false || 
            strpos($userAgent, 'Android') !== false || 
            strpos($userAgent, 'Mobile') !== false
        );
    }
    
    /**
     * Obtenir le système d'exploitation de l'utilisateur
     */
    public function getOsAttribute()
    {
        $userAgent = $this->user_agent;
        
        if (strpos($userAgent, 'Windows') !== false) {
            return 'Windows';
        } elseif (strpos($userAgent, 'Mac OS') !== false) {
            return 'macOS';
        } elseif (strpos($userAgent, 'Linux') !== false) {
            return 'Linux';
        } elseif (strpos($userAgent, 'iPhone') !== false || strpos($userAgent, 'iPad') !== false) {
            return 'iOS';
        } elseif (strpos($userAgent, 'Android') !== false) {
            return 'Android';
        }
        
        return 'Autre';
    }
}
