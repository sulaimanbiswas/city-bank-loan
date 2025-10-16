<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Limit extends Model
{
    use HasFactory;

    protected $fillable = [
        'min_deposit',
        'max_deposit',
        'min_withdraw',
        'max_withdraw',
    ];

    protected function casts(): array
    {
        return [
            'min_deposit' => 'decimal:2',
            'max_deposit' => 'decimal:2',
            'min_withdraw' => 'decimal:2',
            'max_withdraw' => 'decimal:2',
        ];
    }
}
