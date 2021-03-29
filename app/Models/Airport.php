<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Airport extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function sourceRoutes(): HasMany
    {
        return $this->hasMany(Route::class, 'source_airport_id');
    }
}
