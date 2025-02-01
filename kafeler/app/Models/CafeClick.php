<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CafeClick extends Model
{
    protected $fillable = [
        'user_id',
        'slug',
        'year',
        'month',
        'click_count',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
