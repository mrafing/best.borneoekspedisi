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

        Mitra::create([
            'tipe' => 'perusahaan',
            'nama_mitra' => 'PT. Borneo Citra Express',
            'nama_pendaftar' => 'aidil fitra',
            'nomor_kontak' => '089693418191',
            'alamat_pendaftar' => 'Jl Prof M Yamin Gg. Morodadi V Jalur 1',
            'nama_perusahaan' => 'PT. Borneo Citra Express',
            'nama_pemimpin_perusahaan' => 'aidil fitra',
            'alamat_perusahaan' => 'JL Bukit Barisan No.22 B',
            'kategori_perusahaan' => NULL,
            'nama_toko' => NULL,
            'jenis_produk_toko' => NULL,
            'alamat_toko' => NULL,
            'status' => 'accepted',
        ]);

        $mitraId = Mitra::first()->id;

        Outlet::create([
            'id' => 'ax5xtz19aa',
            'id_mitra' => $mitraId,
            'kode_agen' => 'PNK89',
            'tipe' => 'gw',
            'id_kecamatan' => '61.71.05',
            'alamat' => 'Jl. Bukit Barisan No.22 B',
            'nama_cs' => 'Rizky',
            'nomor_kontak' => '085250739275',
            'link_alamat' => NULL,
            'lokasi' => NULL,
            'status_bangunan' => NULL,
            'jenis_bangunan' => NULL,
            'status' => 'active'
        ]);
        Outlet::create([
            'id' => 'h7z8maryd5',
            'id_mitra' => $mitraId,
            'kode_agen' => 'PNK001A',
            'tipe' => 'mitra a',
            'id_kecamatan' => '61.71.05',
            'alamat' => 'Jl. Dr. Sutomo No.24',
            'nama_cs' => 'Ellen',
            'nomor_kontak' => '081256955705',
            'link_alamat' => NULL,
            'lokasi' => NULL,
            'status_bangunan' => NULL,
            'jenis_bangunan' => NULL,
            'status' => 'active'
        ]);
        Outlet::create([
            'id' => 'x1a3abeqe1',
            'id_mitra' => $mitraId,
            'kode_agen' => 'PNK002A',
            'tipe' => 'mitra a',
            'id_kecamatan' => '61.71.05',
            'alamat' => 'Jl Bukit Barisan No.22 B (Kantor J&T Cargo)',
            'nama_cs' => 'Fajar',
            'nomor_kontak' => '085250739275',
            'link_alamat' => NULL,
            'lokasi' => NULL,
            'status_bangunan' => NULL,
            'jenis_bangunan' => NULL,
            'status' => 'active'
        ]);
        Outlet::create([
            'id' => 'o17o1uy47',
            'id_mitra' => $mitraId,
            'kode_agen' => 'JKT002A',
            'tipe' => 'mitra a',
            'id_kecamatan' => '31.71.02',
            'alamat' => 'Jl. Krekot Jaya Molek Blok C3 No.4',
            'nama_cs' => NULL,
            'nomor_kontak' => '085893633415',
            'link_alamat' => NULL,
            'lokasi' => NULL,
            'status_bangunan' => NULL,
            'jenis_bangunan' => NULL,
            'status' => 'active'
        ]);

        // $pnk001aId = Outlet::first()->id;
        // $pnk89Id = Outlet::skip(1)->first()->id;

        User::create([
            'id_outlet' => 'ax5xtz19aa',
            'nama' => 'Annisa',
            'username' => 'PNK89',
            'password' => bcrypt('root'),
            'role' => 'gm',
        ]);
        User::create([
            'id_outlet' => 'h7z8maryd5',
            'nama' => 'Ellen',
            'username' => 'PNK001A',
            'password' => bcrypt('root'),
            'role' => 'admin',
        ]);
    }
}
