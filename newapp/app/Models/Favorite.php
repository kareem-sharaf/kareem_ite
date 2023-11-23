<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{ protected   $fillable=[
    
    
    'pharmacies_id',
    'warehouse_id',
    'product_id',
];
    use HasFactory;


    public function pharmacie()
    {
        return $this->belongsTo('App/Models/User','pharmacie_id');
    }
    public function warehouse()
    {
        return $this->belongsTo('App/Models/User','warehouse_id');
    }
    public function product()
    {
        return $this->belongsTo('App/Models/Proudct','product_id');
    }
}
