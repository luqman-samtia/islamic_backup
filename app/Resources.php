<?php
//
//namespace App;
//
//use Illuminate\Database\Eloquent\Model;
//
///**
// * @property mixed image
// */
//class Resources extends Model
//{
//    protected $fillable = [
//        'title','image',
//    ];
//
//    protected $appends = ['image_url'];
//
//    public function getImageUrlAttribute(){
//        return ($this->image) ? asset('storage/'.$this->image) : null;
//    }
//}


namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

/**
 * @property mixed image
 */
class Resources extends Model
{
    protected $fillable = [
        'title', 'image', 'parent_id'
    ];

    protected $appends = ['image_url'];

    public function scopeParent($query, $parent)
    {
        return $query->where('parent_id', $parent);
    }

    public function getImageUrlAttribute()
    {
        return ($this->image) ? asset('storage/' . $this->image) : null;
    }

    public function children()
    {
        return $this->hasMany(Resources::class, 'parent_id', 'id');
    }

    public function delete(){
        @unlink(public_path("/storage/".$this->image));
        $path = public_path('/storage/resources/'.$this->id);
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
