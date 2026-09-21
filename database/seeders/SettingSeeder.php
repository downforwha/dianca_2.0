<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Butik info
            ['key' => 'butik_name',    'value' => 'DIANCA ATELIER',               'group' => 'butik', 'type' => 'text',     'label' => 'Nama Butik'],
            ['key' => 'butik_tagline', 'value' => 'Tampil Cantik, Tampil Percaya Diri', 'group' => 'butik', 'type' => 'text', 'label' => 'Tagline'],
            ['key' => 'butik_wa',      'value' => '6281234567890',               'group' => 'butik', 'type' => 'text',     'label' => 'Nomor WhatsApp'],
            ['key' => 'butik_address', 'value' => 'Jl. Contoh No. 1, Kota Anda','group' => 'butik', 'type' => 'textarea', 'label' => 'Alamat'],
            ['key' => 'butik_hours',   'value' => 'Senin - Sabtu: 09.00 - 21.00 WIB', 'group' => 'butik', 'type' => 'text', 'label' => 'Jam Operasional'],
            ['key' => 'butik_email',   'value' => 'butik.elegan@email.com',      'group' => 'butik', 'type' => 'text',     'label' => 'Email'],
            ['key' => 'butik_ig',      'value' => '@butikelegan',                'group' => 'butik', 'type' => 'text',     'label' => 'Instagram'],
            ['key' => 'butik_fb',      'value' => 'DIANCA ATELIER',               'group' => 'butik', 'type' => 'text',     'label' => 'Facebook'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
