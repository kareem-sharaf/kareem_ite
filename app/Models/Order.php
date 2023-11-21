<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected   $fillable=[
        'status',
        'pay_status',
        'user_id',
        'user_id',
        'content',


    ];
    public function warehouse()
    {
        return $this->belongsTo('App/Models/User');
    }

    public function pharmacy()
    {
        return $this->belongsTo('App/Models/User');
    }
}
