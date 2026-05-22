<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class TajweedQuran extends Model
{
    protected $table = "tajweed_quran";
    protected $guarded = ['id'];

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
        return $this->hasMany(TajweedQuran::class, 'parent_id', 'id');
    }
    public function getParaNameAttribute($value)
    {
        if (!empty($this->para_no)) {
            $arabicName = \App\Constants\QuranParas::getParaName($this->para_no);
            if ($arabicName) {
                return $arabicName;
            }
        }
        
        return $value;
    }
    public function getParent()
    {
        return $this->belongsTo(TajweedQuran::class,'parent_id');
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
