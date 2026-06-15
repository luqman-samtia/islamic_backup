<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class FeeRecord extends Model
{
    protected $fillable = [
        'user_id',
        'year',
        'month',
        'monthly_fee',
        'received',
        'outstanding',
        'paid_date',
        'proof',
        'status',
    ];

    public static $months = [
        1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
        5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug',
        9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec',
    ];

    // Verification statuses
    public static $statuses = [
        'pending'  => 'Pending',
        'received' => 'Received',
        'rejected' => 'Rejected',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
