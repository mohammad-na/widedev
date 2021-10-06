<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    public $timestamps = false;

    /**
     * Get the order that this payment belongs to.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
