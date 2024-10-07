<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed image
 */
class Information extends Model
{
    protected $table = 'footer_information';
    public $timestamps = false;
    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'skype1' => 'array',
        'skype2' => 'array',
        'phone1' => 'array',
        'phone2' => 'array',
        'whatsapp1' => 'array',
        'whatsapp2' => 'array',
        'email' => 'array',
        'dynamic_footer_items' => 'array',
    ];

    public function delete(){
        Information::delete();
    }
}
