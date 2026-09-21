<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name'    => 'required|string|max:255',
            'customer_phone'   => 'required|string|max:20',
            'customer_email'   => 'nullable|email|max:255',
            'customer_address' => 'nullable|string|max:500',
            'product_id'       => 'nullable|exists:products,id',
            'size'             => 'nullable|string|max:10',
            'quantity'         => 'required|integer|min:1|max:100',
            'notes'            => 'nullable|string|max:1000',
            'fitting_date'     => 'nullable|date',
        ]);

        $product = $validated['product_id'] ? Product::find($validated['product_id']) : null;
        $unitPrice = $product ? (float)($product->sale_price ?? $product->price) : 0;
        $totalPrice = $unitPrice * ($validated['quantity'] ?? 1);

        $order = Order::create([
            'order_number'     => Order::generateOrderNumber(),
            'product_id'       => $validated['product_id'] ?? null,
            'product_name'     => $product?->name ?? $request->product_name_custom ?? 'Konsultasi',
            'customer_name'    => $validated['customer_name'],
            'customer_phone'   => $validated['customer_phone'],
            'customer_email'   => $validated['customer_email'] ?? null,
            'customer_address' => $validated['customer_address'] ?? null,
            'size'             => $validated['size'] ?? '-',
            'quantity'         => $validated['quantity'],
            'unit_price'       => $unitPrice,
            'total_price'      => $totalPrice,
            'notes'            => $validated['notes'] ?? null,
            'status'           => 'pending',
            'fitting_date'     => $validated['fitting_date'] ?? null,
        ]);

        // Build WhatsApp message
        $waNumber = env('BUTIK_WA_NUMBER', '6281234567890');
        $productName = $order->product_name;
        $msg = "Halo! Saya ingin memesan:\n\n";
        $msg .= "📋 *Order #{$order->order_number}*\n";
        $msg .= "👤 Nama: {$order->customer_name}\n";
        $msg .= "📞 No. HP: {$order->customer_phone}\n";
        $msg .= "🛍️ Produk: {$productName}\n";
        $msg .= "📏 Ukuran: {$order->size}\n";
        $msg .= "🔢 Jumlah: {$order->quantity}\n";
        if ($totalPrice > 0) {
            $msg .= "💰 Total: Rp " . number_format($totalPrice, 0, ',', '.') . "\n";
        }
        if ($order->fitting_date) {
            $msg .= "📅 Jadwal Fitting: " . \Carbon\Carbon::parse($order->fitting_date)->format('d M Y, H:i') . "\n";
        }
        if ($order->notes) {
            $msg .= "📝 Catatan: {$order->notes}\n";
        }

        $waUrl = "https://wa.me/{$waNumber}?text=" . urlencode($msg);

        return redirect($waUrl)->with('success', "Pesanan #{$order->order_number} berhasil dicatat! Anda akan diarahkan ke WhatsApp.");
    }
}
