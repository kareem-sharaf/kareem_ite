<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    use HasFactory;
    protected   $fillable=[
        'status',
        'pay_status',
        'user_id',
        'warehouse_id',
        'content',


    ];
    public function warehouse()
    {
        return $this->belongsToMany('App/Models/User','warehouse_id');
    }

    public function pharmacy()
    {
        return $this->hasMany('App/Models/Product');
    }
}
