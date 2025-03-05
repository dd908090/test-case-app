<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;


    protected $fillable = [
        "original_url",
        "short_url",
        "expired_at",
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
