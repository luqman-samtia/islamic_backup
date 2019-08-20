<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quran extends Model
{
    protected $table = "quran";
    protected $fillable = [
        'title', 'image', 'parent_id'
    ];
}
