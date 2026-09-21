<?php

namespace Database\Seeders;

use App\Models\FinancialRecord;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;

class SampleOrderSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();
        if ($products->isEmpty()) return;

        $statuses = ['pending','confirmed','processing','done','done','done','cancelled'];
        $names = ['Siti Rahayu','Dewi Lestari','Rina Wulandari','Mega Putri','Aulia Sari','Budi Santoso','Hana Pertiwi'];
        $phones = ['081234567890','082345678901','083456789012','084567890123','085678901234','086789012345','087890123456'];

        for ($i = 0; $i < 15; $i++) {
            $product = $products->random();
            $qty     = rand(1, 3);
            $price   = (float)($product->sale_price ?? $product->price);
            $status  = $statuses[array_rand($statuses)];
            $sizes   = $product->sizes ?? ['M'];

            $order = Order::create([
                'order_number'  => Order::generateOrderNumber(),
                'product_id'    => $product->id,
                'product_name'  => $product->name,
                'customer_name' => $names[array_rand($names)],
                'customer_phone'=> $phones[array_rand($phones)],
                'customer_email'=> 'pelanggan' . $i . '@email.com',
                'size'          => $sizes[array_rand($sizes)],
                'quantity'      => $qty,
                'unit_price'    => $price,
                'total_price'   => $price * $qty,
                'notes'         => $i % 3 === 0 ? 'Tolong dikemas rapi ya.' : null,
                'status'        => $status,
                'done_at'       => $status === 'done' ? now()->subDays(rand(1,30)) : null,
                'created_at'    => now()->subDays(rand(1,60)),
            ]);

            // Auto financial record for done orders
            if ($status === 'done') {
                FinancialRecord::create([
                    'order_id'         => $order->id,
                    'reference_number' => $order->order_number,
                    'type'             => 'income',
                    'category'         => 'Penjualan',
                    'amount'           => $order->total_price,
                    'description'      => "Pesanan #{$order->order_number} - {$order->product_name}",
                    'date'             => $order->done_at->toDateString(),
                    'recorded_by'      => 'System',
                ]);
            }
        }

        // Sample expense records
        $expenses = [
            ['Operasional', 'Listrik dan Air bulan ini', 350000],
            ['Operasional', 'Sewa toko bulan ini', 2500000],
            ['Pembelian Stok', 'Bahan kain premium', 1500000],
            ['Marketing', 'Iklan Instagram', 200000],
            ['Operasional', 'Peralatan jahit', 450000],
        ];
        foreach ($expenses as [$cat, $desc, $amount]) {
            FinancialRecord::create([
                'type'             => 'expense',
                'category'         => $cat,
                'amount'           => $amount,
                'description'      => $desc,
                'date'             => now()->subDays(rand(1,30))->toDateString(),
                'reference_number' => 'EXP-' . date('YmdHis') . rand(10,99),
                'recorded_by'      => 'Admin',
            ]);
        }
    }
}
