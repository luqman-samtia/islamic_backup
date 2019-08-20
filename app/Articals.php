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

//
//    public function children()
//    {
//        return $this->hasMany(Articals::class, 'parent_id', 'id');
//    }
//
//    public function delete(){
//        @unlink(public_path("/storage/".$this->image));
//        $path = public_path('/storage/articals/'.$this->id);
//        if(File::isDirectory($path)){
//            File::deleteDirectory($path);
//        }
//        foreach($this->children as $child){
//            $child->del();
//        }
//        parent::delete();
//    }
//
//    public function del(){
//        @unlink(public_path("/storage/".$this->image));
//        parent::delete();
//    }
}
