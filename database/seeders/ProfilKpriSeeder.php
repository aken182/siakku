<?php

namespace Database\Seeders;

use App\Models\Profil_kpri;
use Illuminate\Database\Seeder;

class ProfilKpriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profil_kpri::create([
            'nama' => 'Koperasi Pegawai Negeri Usaha Jaya Larantuka',
            'badan_hukum' => '305/BH/XIV/1977',
            'tgl_badan_hukum' => '1977-06-16',
            'nmr_pad' => null,
            'tgl_pad' => null,
            'tgl_rat' => '2020-02-25',
            'alamat' => 'Puken Tobi Wangi Bao',
            'kelurahan' => 'PTW. Bao',
            'kecamatan' => 'Larantuka',
            'kabupaten' => 'Flores Timur',
            'provinsi' => 'Nusa Tenggara Timur',
            'bentuk_koperasi' => 'Primer Kabupaten/Kota',
            'jenis' => 'Konsumen',
            'kelompok_koperasi' => 'Koperasi Pegawai Negeri (KPRI)',
            'sektor' => 'Jasa Keuangan dan Asuransi',
            'nik' => '5309030020007',
            'status_nik' => 'Sudah Bersertifikat',
            'status_grade' => 'A',
        ]);
    }
}
