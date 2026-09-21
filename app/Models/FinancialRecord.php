<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinancialRecord extends Model
{
    protected $fillable = [
        'order_id', 'reference_number', 'type', 'category',
        'amount', 'description', 'date', 'recorded_by'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'date'   => 'date',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    public function scopeIncome($query)
    {
        return $query->where('type', 'income');
    }

    public function scopeExpense($query)
    {
        return $query->where('type', 'expense');
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('date', now()->month)->whereYear('date', now()->year);
    }

    public function scopeThisYear($query)
    {
        return $query->whereYear('date', now()->year);
    }
}
