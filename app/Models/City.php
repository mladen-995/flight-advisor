<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function getLatestNthComments(int $numberOfComments)
    {
        return $this->comments->take($numberOfComments);
    }
}
