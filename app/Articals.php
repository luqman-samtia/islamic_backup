<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Articals extends Model
{

    protected $fillable = [
        'title', 'slug' , 'content'
    ];

    public function scopeFindBySlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }

}
