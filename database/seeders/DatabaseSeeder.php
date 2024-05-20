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
            'id_outlet' => '0',
            'nama' => 'Aidil Fitra',
            'nomor_hp' => '0',
            'username' => 'aidil',
            'password' => bcrypt('12345'),
            'email' => 'aidil@gmail.com',
            'role' => 'gm',
        ]);
        User::create([
            'id_outlet' => '0',
            'nama' => 'ellen',
            'nomor_hp' => '0',
            'username' => 'ellen',
            'password' => bcrypt('12345'),
            'email' => 'ellen@gmail.com',
            'role' => 'admin',
        ]);

        Outlet::create([
            'id_mitra' => '0',
            'nama_agen' => 'PNK89',
            'tipe' => 'mitra gw',
            'id_kecamatan' => '61.71.05',
            'alamat' => NULL,
            'nama_cs' => NULL,
            'nomor_kontak' => NULL,
            'link_alamat' => NULL,
            'lokasi' => NULL,
            'status_bangunan' => NULL,
            'jenis_bangunan' => NULL,
            'status' => 'active'
        ]);
        Outlet::create([
            'id_mitra' => '0',
            'nama_agen' => 'PNK001P',
            'tipe' => 'mitra j',
            'id_kecamatan' => '61.71.05',
            'alamat' => NULL,
            'nama_cs' => NULL,
            'nomor_kontak' => NULL,
            'link_alamat' => NULL,
            'lokasi' => NULL,
            'status_bangunan' => NULL,
            'jenis_bangunan' => NULL,
            'status' => 'active'
        ]);
        Outlet::create([
            'id_mitra' => '0',
            'nama_agen' => 'PNK001A',
            'tipe' => 'mitra a',
            'id_kecamatan' => '61.71.05',
            'alamat' => NULL,
            'nama_cs' => NULL,
            'nomor_kontak' => NULL,
            'link_alamat' => NULL,
            'lokasi' => NULL,
            'status_bangunan' => NULL,
            'jenis_bangunan' => NULL,
            'status' => 'active'
        ]);

        Mitra::create([
            'tipe' => 'perusahaan',
            'status' => 'accepted',
            'nama_pendaftar' => 'aidil fitra',
            'nomor_kontak' => NULL,
            'alamat_pendaftar' => NULL,
            'nama_perusahaan' => 'pt. borneo citra express',
            'nama_pemimpin_perusahaan' => 'aidil fitra',
            'alamat_perusahaan' => NULL,
            'kategori_perusahaan' => NULL,
            'nama_toko' => NULL,
            'jenis_produk_toko' => NULL,
            'alamat_toko' => NULL
        ]);
    }
}
