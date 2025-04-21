<?php

namespace App\Helpers;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class JsonHelper
{
    /**
     * Compte le nombre d'éléments dans un champ JSON pour une collection d'enregistrements.
     * Alternative à JSON_LENGTH pour SQLite.
     *
     * @param Collection $collection
     * @param string $jsonField
     * @return int
     */
    public static function countJsonElements(Collection $collection, string $jsonField): int
    {
        return $collection->reduce(function ($total, $item) use ($jsonField) {
            $data = $item->{$jsonField} ?? [];
            return $total + (is_array($data) ? count($data) : 0);
        }, 0);
    }

    /**
     * Filtre une collection pour ne garder que les éléments avec un champ JSON non-vide.
     *
     * @param Collection $collection
     * @param string $jsonField
     * @return Collection
     */
    public static function filterNonEmptyJson(Collection $collection, string $jsonField): Collection
    {
        return $collection->filter(function ($item) use ($jsonField) {
            $data = $item->{$jsonField} ?? [];
            return is_array($data) && count($data) > 0;
        });
    }

    /**
     * Extrait les éléments uniques d'un champ JSON spécifique pour toute une collection.
     *
     * @param Collection $collection
     * @param string $jsonField
     * @param string $subField Champ spécifique à extraire (optionnel)
     * @return array
     */
    public static function extractUniqueFromJson(Collection $collection, string $jsonField, ?string $subField = null): array
    {
        $allItems = [];
        
        foreach ($collection as $item) {
            $jsonData = $item->{$jsonField} ?? [];
            if (!is_array($jsonData)) {
                continue;
            }
            
            if ($subField) {
                foreach ($jsonData as $entry) {
                    if (isset($entry[$subField])) {
                        $allItems[] = $entry[$subField];
                    }
                }
            } else {
                $allItems = array_merge($allItems, $jsonData);
            }
        }
        
        return array_unique($allItems);
    }
} 