<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'product_id', 'product_name',
        'customer_name', 'customer_phone', 'customer_email', 'customer_address',
        'size', 'quantity', 'unit_price', 'total_price',
        'notes', 'status', 'admin_notes', 'confirmed_at', 'done_at', 'fitting_date'
    ];

    protected $casts = [
        'unit_price'   => 'decimal:2',
        'total_price'  => 'decimal:2',
        'confirmed_at' => 'datetime',
        'done_at'      => 'datetime',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function financialRecord(): HasOne
    {
        return $this->hasOne(FinancialRecord::class);
    }

    public static function generateOrderNumber(): string
    {
        $prefix = 'ORD-' . date('Ymd') . '-';
        $last = static::where('order_number', 'like', $prefix . '%')->orderByDesc('id')->first();
        $seq = $last ? (intval(substr($last->order_number, -4)) + 1) : 1;
        return $prefix . str_pad($seq, 4, '0', STR_PAD_LEFT);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending'    => '<span class="badge badge-warning">Menunggu</span>',
            'confirmed'  => '<span class="badge badge-info">Dikonfirmasi</span>',
            'processing' => '<span class="badge badge-primary">Diproses</span>',
            'done'       => '<span class="badge badge-success">Selesai</span>',
            'cancelled'  => '<span class="badge badge-danger">Dibatalkan</span>',
            default      => '<span class="badge badge-secondary">-</span>',
        };
    }

    public function getWhatsappLinkAttribute(): string
    {
        $phone = preg_replace('/[^0-9]/', '', $this->customer_phone);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }
        $msg = urlencode("Halo {$this->customer_name}, pesanan Anda #{$this->order_number} sudah kami terima. Produk: {$this->product_name}, Ukuran: {$this->size}. Kami akan segera menghubungi Anda.");
        return "https://wa.me/{$phone}?text={$msg}";
    }

    public function getWhatsappReminderLinkAttribute(): string
    {
        $phone = preg_replace('/[^0-9]/', '', $this->customer_phone);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }
        $msg = urlencode("Halo {$this->customer_name}, ini adalah pengingat dari Dianca Atelier. Pesanan Anda #{$this->order_number} (Produk: {$this->product_name}) masih berstatus Pending/Belum Dibayar. Silakan selesaikan pembayaran untuk memproses pesanan Anda. Jika ada pertanyaan, hubungi kami!");
        return "https://wa.me/{$phone}?text={$msg}";
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
    }
}
