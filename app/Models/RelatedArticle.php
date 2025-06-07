<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RelatedArticle extends Model
{
    /**
     * La table associée au modèle.
     *
     * @var string
     */
    protected $table = 'related_articles';

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'article_id',
        'related_article_id',
        'relationship_type',
        'score',
    ];

    /**
     * Les attributs qui doivent être cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'score' => 'float',
    ];

    /**
     * Obtient l'article principal associé à cette relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class, 'article_id');
    }

    /**
     * Obtient l'article relié.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function relatedArticle(): BelongsTo
    {
        return $this->belongsTo(Article::class, 'related_article_id');
    }
}
