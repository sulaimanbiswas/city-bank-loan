<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gateway extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'method',
        'account_number',
        'logo_path',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'type' => 'string',
            'method' => 'string',
            'account_number' => 'string',
            'logo_path' => 'string',
            'status' => 'string',
        ];
    }

    public function getLogoUrlAttribute(): ?string
    {
        if (!$this->logo_path) {
            return null;
        }
        if (str_starts_with($this->logo_path, 'http')) {
            return $this->logo_path;
        }
        // Assuming files are stored on 'public' disk, which maps to storage/app/public
        // and is symlinked to public/storage
        return asset('storage/' . ltrim($this->logo_path, '/'));
    }
}
