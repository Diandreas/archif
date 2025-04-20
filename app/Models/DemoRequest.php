<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemoRequest extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'ip_address',
        'user_agent',
        'country',
        'city',
        'browser',
        'device',
        'os',
        'referrer',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'landing_page',
    ];
} 