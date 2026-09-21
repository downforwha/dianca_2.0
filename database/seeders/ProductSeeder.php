<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $dress   = Category::where('slug', 'dress')->first();
        $blouse  = Category::where('slug', 'blouse')->first();
        $outer   = Category::where('slug', 'outer')->first();
        $rok     = Category::where('slug', 'rok')->first();

        $products = [
            // Dress
            [
                'category_id' => $dress->id,
                'name'        => 'Maxi Dress Floral Elegan',
                'description' => 'Dress panjang motif bunga dengan bahan premium. Cocok untuk acara formal maupun semi-formal. Tersedia berbagai pilihan warna.',
                'price'       => 485000,
                'sizes'       => ['S','M','L','XL'],
                'material'    => 'Kain Satin Premium',
                'color'       => 'Navy Blue',
                'stock'       => 15,
                'is_featured' => true,
                'sort_order'  => 1,
            ],
            [
                'category_id' => $dress->id,
                'name'        => 'Mini Dress Casual Chic',
                'description' => 'Dress kasual dengan potongan A-line yang flattering. Sempurna untuk aktivitas sehari-hari.',
                'price'       => 320000,
                'sale_price'  => 285000,
                'sizes'       => ['XS','S','M','L'],
                'material'    => 'Katun Combed',
                'color'       => 'Dusty Rose',
                'stock'       => 20,
                'is_featured' => true,
                'sort_order'  => 2,
            ],
            [
                'category_id' => $dress->id,
                'name'        => 'Dress Midi Batik Modern',
                'description' => 'Perpaduan batik kontemporer dengan siluet modern. Bangga memakai karya lokal.',
                'price'       => 550000,
                'sizes'       => ['S','M','L','XL','XXL'],
                'material'    => 'Batik Premium',
                'color'       => 'Multicolor',
                'stock'       => 10,
                'is_featured' => true,
                'sort_order'  => 3,
            ],
            // Blouse
            [
                'category_id' => $blouse->id,
                'name'        => 'Blouse Ruffled Sleeve',
                'description' => 'Blouse cantik dengan lengan ruffle yang anggun. Pasangkan dengan celana atau rok favorit Anda.',
                'price'       => 245000,
                'sizes'       => ['S','M','L','XL'],
                'material'    => 'Organza',
                'color'       => 'Cream',
                'stock'       => 25,
                'is_featured' => true,
                'sort_order'  => 4,
            ],
            [
                'category_id' => $blouse->id,
                'name'        => 'Blouse Casual Linen',
                'description' => 'Blouse bahan linen yang nyaman dan breathable. Pilihan tepat untuk cuaca tropis.',
                'price'       => 195000,
                'sizes'       => ['S','M','L','XL','XXL'],
                'material'    => 'Linen',
                'color'       => 'Sage Green',
                'stock'       => 30,
                'is_featured' => false,
                'sort_order'  => 5,
            ],
            // Outer
            [
                'category_id' => $outer->id,
                'name'        => 'Outer Blazer Formal',
                'description' => 'Blazer formal yang memberikan tampilan profesional dan percaya diri. Cocok untuk meeting dan presentasi.',
                'price'       => 650000,
                'sizes'       => ['S','M','L','XL'],
                'material'    => 'Wool Blend',
                'color'       => 'Charcoal Grey',
                'stock'       => 8,
                'is_featured' => true,
                'sort_order'  => 6,
            ],
            [
                'category_id' => $outer->id,
                'name'        => 'Cardigan Knit Premium',
                'description' => 'Cardigan rajut tebal berkualitas tinggi. Hangat dan stylish untuk musim dingin AC.',
                'price'       => 380000,
                'sale_price'  => 320000,
                'sizes'       => ['S','M','L','XL'],
                'material'    => 'Knit Wool',
                'color'       => 'Caramel Brown',
                'stock'       => 12,
                'is_featured' => false,
                'sort_order'  => 7,
            ],
            // Rok
            [
                'category_id' => $rok->id,
                'name'        => 'Rok Midi Plisket',
                'description' => 'Rok plisket midi yang elegan dan versatile. Cocok dipadu dengan berbagai atasan.',
                'price'       => 265000,
                'sizes'       => ['S','M','L','XL'],
                'material'    => 'Satin Plisket',
                'color'       => 'Pastel Purple',
                'stock'       => 18,
                'is_featured' => true,
                'sort_order'  => 8,
            ],
        ];

        $statuses = ['Ready', 'Rent', 'On Process'];
        
        foreach ($products as $data) {
            $data['slug']      = Str::slug($data['name']) . '-' . Str::random(4);
            $data['is_active'] = true;
            $data['rental_status'] = $statuses[array_rand($statuses)];
            Product::create($data);
        }
    }
}
