<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Quran extends Model
{
    protected $table = "quran";
    protected $fillable = [
        'title', 'image', 'parent_id', 'slug', 'number','ayat_from','ayat_to'
    ];

    protected $appends = ['image_url'];

    public function scopeParent($query, $parent)
    {
        return $query->where('parent_id', $parent);
    }

    public function scopeOrderAsc($query, $column)
    {
        return $query->orderBy($column, 'asc');
    }

    public function scopeFindBySlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }

    public function getImageUrlAttribute()
    {
        return ($this->image) ? asset('storage/' . $this->image) : null;
    }

    public function children()
    {
        return $this->hasMany(Quran::class, 'parent_id', 'id');
    }

    public function getParent()
    {
        return $this->hasOne(Quran::class, 'id', 'parent_id');
    }
    public function SearchgetParent()
    {
        return $this->belongsTo(Quran::class, 'parent_id');
    }

    public function delete(){
        @unlink(public_path("/storage/".$this->image));
        $path = public_path('/storage/quran/'.$this->id);
        if(File::isDirectory($path)){
            File::deleteDirectory($path);
        }
        foreach($this->children as $child){
            $child->del();
        }
        parent::delete();
    }

    public function del(){
        @unlink(public_path("/storage/".$this->image));
        parent::delete();
    }
}
