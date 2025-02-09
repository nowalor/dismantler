<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'published_at', 'tags'];
    protected $dates = ['published_at'];

    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', Carbon::now());
    }
}