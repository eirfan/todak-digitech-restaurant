<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Restaurants extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'address',
        'categories',
        'operation_status',
        'approval_status',
        'manager_id'
    ];
    public function staffs() {
        return $this->hasMany(Staffs::class,'restaurant_id','id');
    }
    public function manager() {
        return $this->hasOne(User::class,'manager_id','id');
    }
}
