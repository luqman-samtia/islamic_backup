<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    protected $fillable = ['user_id', 'type', 'message', 'is_read'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}