<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SurveiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('survei')->insert([
            'nama_pengisi' => 'Budi',
            'instansi_pengisi' => 'PT Teknologi',
            'jabatan_pengisi' => 'Programmer',
            'email_pengisi' => 'budi@example.com',
            'alumni_id' => 1,
            'kerjasama_tim' => 1,
            'keahlian_ti' => 1,
            'kemampuan_bahasa_asing' => 0,
            'kemampuan_komunikasi' => 1,
            'pengembangan_diri' => 1,
            'kepemimpinan' => 0,
            'etos_kerja' => 1,
            'kompetensi_belum_terpenuhi' => 'Kurangnya pengetahuan bisnis',
            'saran_kurikulum' => 'Lebih banyak praktik kerja nyata',
        ]);
    }
}
