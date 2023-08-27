<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'order_number',
        'recipient_address',
        'shipping_address',
        'shipping_date',
        'expected_delivery_date',
        'status'
    ];

    protected $casts = [
        'shipping_date' => 'datetime',
        'expected_delivery_date' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
