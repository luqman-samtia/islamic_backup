<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

/**
 * @property mixed video_id
 */
class Media extends Model
{
    protected $fillable = [
        'title', 'description', 'video_id', 'parent_id', 'slug',
    ];

    protected $appends = ['image_url'];
    /**
     * @var mixed
     */

    public function scopeParent($query, $parent)
    {
        return $query->where('parent_id', $parent);
    }

    public function scopeFindBySlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }

    public function getImageUrlAttribute()
    {
        return ($this->video_id) ? asset('storage/' . $this->video_id) : null;
    }

    public function children()
    {
        return $this->hasMany(Media::class, 'parent_id', 'id');
    }

    public function getYoutubeIdAttribute()
    {
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $this->video_id, $match);
        return @$match[1];
    }

    public function delete(){
        @unlink(public_path("/storage/".$this->video_id));
        $path = public_path('/storage/media/'.$this->id);
        if(File::isDirectory($path)){
            File::deleteDirectory($path);
        }
        foreach($this->children as $child){
            $child->del();
        }
        parent::delete();
    }

    public function del(){
        @unlink(public_path("/storage/".$this->video_id));
        parent::delete();
    }
}
