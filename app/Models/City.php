<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class City extends Model
{
    use HasFactory;
    use Searchable;

    protected $table = 'cities';

    protected $fillable = [
        'destino_turistico',
        'aeroporto',
        'distancia'
    ];

    public function toSearchableArray()
    {
        $array = $this->toArray();

        return [
            'destino_turistico' => $array['destino_turistico']
        ];
    }
}
