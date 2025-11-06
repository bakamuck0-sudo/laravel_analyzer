<?php

namespace App\Models;

use illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Analysis extends Model
{
    protected $fillable = [
        'user_id',
        'url',
        'status',
        'results',
        'h1_tags',
        'meta_description'
    ];
    protected function user()
    {
        return $this->belongsTo(User::class);
    }

}
