<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'total',
        'status',
        'paid_at',
    ];
    protected $table="invoices";

    public function scopeGetPaid($query) {
        return $query->where('status','=','paid');
    }
}
