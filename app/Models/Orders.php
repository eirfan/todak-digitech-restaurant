<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orders extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'restaurant_id',
        'type_of_deliveries',
        'status'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function restaurant() {
        return $this->belongsTo(Restaurants::class,'restaurant_id','id');
    }

}
