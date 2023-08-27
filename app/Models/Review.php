<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'comment'
    ];

    protected $casts = [
        'created' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
