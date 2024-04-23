<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenusOrders extends Model
{
    use HasFactory;
    protected $fillable=[
        'menu_id',
        'order_id'
    ];
    protected $table = "menus_orders";
}
