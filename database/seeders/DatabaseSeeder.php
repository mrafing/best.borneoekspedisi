<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Mitra;
use App\Models\Outlet;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'id_outlet' => 'OT1',
            'nama' => 'Aidil Fitra',
            'nomor_kontak' => '080890978766',
            'username' => 'aidil',
            'password' => bcrypt('gm'),
            'role' => 'gm',
        ]);
        User::create([
            'id_outlet' => 'OT3',
            'nama' => 'Muhammad Rafi',
            'nomor_kontak' => '085346037205',
            'username' => 'rafi',
            'password' => bcrypt('admin'),
            'role' => 'admin',
        ]);

        Outlet::create([
            'id' => 'OT1',
            'id_mitra' => 'MT1',
            'nama_agen' => 'PNK001P',
            'tipe' => 'mitra j',
            'id_kecamatan' => '61.71.05',
            'alamat' => 'Jl. Pak Bencang Gg. Morodadi 5 Jalur 1 No. 17',
            'nama_cs' => NULL,
            'nomor_kontak' => '0813-4783-2837',
            'link_alamat' => 'https://goo.gl/maps/RgX9bhToMN55uwBL9',
            'lokasi' => NULL,
            'status_bangunan' => NULL,
            'jenis_bangunan' => NULL,
            'status' => 'active'
        ]);

        Outlet::create([
            'id' => 'OT3',
            'id_mitra' => 'MT1',
            'nama_agen' => 'PNK001A',
            'tipe' => 'mitra a',
            'id_kecamatan' => '61.71.05',
            'alamat' => 'Jl. Pangeran Natakusuma (Seberang Indomaret PNK)',
            'nama_cs' => 'rizky',
            'nomor_kontak' => '0813-4783-2837',
            'link_alamat' => 'https://goo.gl/maps/AP2m8djNetQe4PYE9',
            'lokasi' => NULL,
            'status_bangunan' => NULL,
            'jenis_bangunan' => NULL,
            'status' => 'active'
        ]);

        Mitra::create([
            'id' => 'MT1',
            'tipe' => 'perusahaan',
            'status' => 'accepted',
            'nama_pendaftar' => 'aidil fitra',
            'nomor_kontak' => NULL,
            'alamat_pendaftar' => NULL,
            'nama_perusahaan' => 'pt. borneo citra express',
            'nama_pemimpin_perusahaan' => 'aidil fitra',
            'alamat_perusahaan' => 'Jl. Pak Bencang Gg. Morodadi 5 Jalur 1 No. 17',
            'kategori_perusahaan' => 'Logistics & Transportation',
            'nama_toko' => NULL,
            'jenis_produk_toko' => NULL,
            'alamat_toko' => NULL
        ]);
    }
}
