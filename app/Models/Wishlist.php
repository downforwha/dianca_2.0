<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable = ['product_id', 'session_id', 'ip_address'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }}
