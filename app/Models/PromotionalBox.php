<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionalBox extends Model
{
    /**
     * La table associée au modèle.
     *
     * @var string
     */
    protected $table = 'promotional_boxes';

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'category',
        'category_color',
        'image',
        'link_url',
        'link_text',
        'position',
        'is_active',
        'display_on',
    ];

    /**
     * Les attributs qui doivent être cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'display_on' => 'json',
    ];
}
