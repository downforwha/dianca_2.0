<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FinancialRecord;
use App\Models\Order;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PesananController extends Controller
{
    public function invoice(Order $order)
    {
        $order->load('product');
        return view('admin.pesanan.invoice', compact('order'));
    }

    public function index(Request $request)
    {
        $query = Order::with('product')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('order_number', 'like', "%{$keyword}%")
                  ->orWhere('customer_name', 'like', "%{$keyword}%")
                  ->orWhere('customer_phone', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $orders = $query->paginate(20)->withQueryString();

        $counts = [
            'all'        => Order::count(),
            'pending'    => Order::where('status', 'pending')->count(),
            'confirmed'  => Order::where('status', 'confirmed')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'done'       => Order::where('status', 'done')->count(),
            'cancelled'  => Order::where('status', 'cancelled')->count(),
        ];

        return view('admin.pesanan.index', compact('orders', 'counts'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status'      => 'required|in:pending,confirmed,processing,done,cancelled',
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        $order->update([
            'status'       => $newStatus,
            'admin_notes'  => $request->admin_notes ?? $order->admin_notes,
            'confirmed_at' => $newStatus === 'confirmed' && $oldStatus !== 'confirmed' ? now() : $order->confirmed_at,
            'done_at'      => $newStatus === 'done' && $oldStatus !== 'done' ? now() : $order->done_at,
        ]);

        // Auto-create financial record when order is done
        if ($newStatus === 'done' && $oldStatus !== 'done' && !$order->financialRecord) {
            FinancialRecord::create([
                'order_id'         => $order->id,
                'reference_number' => $order->order_number,
                'type'             => 'income',
                'category'         => 'Penjualan',
                'amount'           => $order->total_price,
                'description'      => "Pesanan #{$order->order_number} - {$order->product_name} (oleh {$order->customer_name})",
                'date'             => now()->toDateString(),
                'recorded_by'      => auth()->user()->name,
            ]);
        }

        if ($request->ajax()) {
            return response()->json(['success' => true, 'status' => $newStatus]);
        }

        return back()->with('success', "Status pesanan #{$order->order_number} berhasil diperbarui!");
    }

    public function show(Order $order)
    {
        $order->load('product', 'financialRecord');
        if (request()->ajax()) {
            return response()->json($order);
        }
        return view('admin.pesanan.show', compact('order'));
    }

    public function destroy(Order $order)
    {
        if ($order->financialRecord) {
            $order->financialRecord->delete();
        }
        $order->delete();
        return back()->with('success', 'Pesanan berhasil dihapus!');
    }

    public function export(Request $request): StreamedResponse
    {
        $query = Order::with('product')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('order_number', 'like', "%{$keyword}%")
                  ->orWhere('customer_name', 'like', "%{$keyword}%")
                  ->orWhere('customer_phone', 'like', "%{$keyword}%");
            });
        }
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $orders = $query->get();
        $filename = 'pesanan_' . now()->format('Ymd') . '.csv';

        return response()->streamDownload(function () use ($orders) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No. Order', 'Tanggal', 'Pelanggan', 'No. HP', 'Produk', 'Ukuran', 'Qty', 'Total Harga', 'Status', 'Catatan Pembeli', 'Catatan Admin']);
            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->order_number,
                    $order->created_at->format('d/m/Y H:i'),
                    $order->customer_name,
                    $order->customer_phone,
                    $order->product_name,
                    $order->size ?? '-',
                    $order->quantity,
                    $order->total_price,
                    $order->status,
                    $order->notes,
                    $order->admin_notes,
                ]);
            }
            fclose($file);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}
