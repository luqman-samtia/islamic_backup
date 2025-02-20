<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class Feedback extends Model
{
    // protected $guarded = [];
    protected $fillable = [
        'title', 'image', 'feedback','user_id'
    ];


    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return ($this->image) ? asset('storage/' . $this->image) : null;
    }

    public function delete(){
        Storage::delete($this->image);
        parent::delete();
    }

    public function del(){
        @unlink(public_path("/storage/".$this->image));
        parent::delete();
    }
}
