<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'label',
        'types',
        'value',
        'interest_rate',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'types' => 'string',
            'value' => 'string',
            'interest_rate' => 'decimal:2',
        ];
    }
}
