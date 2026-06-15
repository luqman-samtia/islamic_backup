<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class AdmissionForm extends Model
{
    protected $fillable = [
        'user_id',
        'roll_no',
        'pic',
        'student_name',
        'father_name',
        'course',
        'age',
        'fee',
        'phone_no',
        'admission_date',
        'address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
