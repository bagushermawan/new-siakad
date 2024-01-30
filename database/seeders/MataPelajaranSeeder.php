<?php

namespace Database\Seeders;

use App\Models\MataPelajaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MataPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MataPelajaran::create(['name' => 'Qurani Jilid 1', 'kategori' => 'MQS']);
        MataPelajaran::create(['name' => 'Qurani Jilid 2', 'kategori' => 'MQS']);
        MataPelajaran::create(['name' => 'Qurani Jilid 3', 'kategori' => 'MQS']);
        MataPelajaran::create(['name' => 'Qurani Jilid 4', 'kategori' => '1 Ula']);
        MataPelajaran::create(['name' => 'Tajwid', 'kategori' => '1 Ula']);
        MataPelajaran::create(['name' => 'Bahasa Arab', 'kategori' => '1 Ula']);
        MataPelajaran::create(['name' => 'Fiqih', 'kategori' => '1 Ula']);
        MataPelajaran::create(['name' => 'Sirotun Nawabi (Kisah Nabi)', 'kategori' => '1 Ula']);
        MataPelajaran::create(['name' => "Imla'", 'kategori' => '1 Ula']);
        MataPelajaran::create(['name' => 'Qurani Jilid 5', 'kategori' => '2 Ula']);
        MataPelajaran::create(['name' => 'Bahasa Arab', 'kategori' => '2 Ula']);
        MataPelajaran::create(['name' => 'Tajwid', 'kategori' => '2 Ula']);
        MataPelajaran::create(['name' => 'Fiqih', 'kategori' => '2 Ula']);
        MataPelajaran::create(['name' => 'Tauhid', 'kategori' => '2 Ula']);
        MataPelajaran::create(['name' => 'Akhlak', 'kategori' => '2 Ula']);
        MataPelajaran::create(['name' => 'Hadist', 'kategori' => '3 Ula']);
        MataPelajaran::create(['name' => 'Ahlusunnah Wal Jamaah', 'kategori' => '3 Ula']);
        MataPelajaran::create(['name' => 'Shoroft', 'kategori' => '3 Ula']);
        MataPelajaran::create(['name' => 'Nahwu', 'kategori' => '3 Ula']);
        MataPelajaran::create(['name' => 'Fiqih', 'kategori' => '3 Ula']);
        MataPelajaran::create(['name' => 'Belajar membaca kitab kuning', 'kategori' => '3 Ula']);
        MataPelajaran::create(['name' => 'Shorof', 'kategori' => '4 Ula']);
        MataPelajaran::create(['name' => 'Tasfir', 'kategori' => '4 Ula']);
        MataPelajaran::create(['name' => 'Tauhid', 'kategori' => '4 Ula']);
        MataPelajaran::create(['name' => 'Nahwu', 'kategori' => '4 Ula']);
        MataPelajaran::create(['name' => 'Fiqih', 'kategori' => '4 Ula']);
        MataPelajaran::create(['name' => "Al A'rab", 'kategori' => '4 Ula']);
        MataPelajaran::create(['name' => 'Shoroft', 'kategori' => '5 Ula']);
        MataPelajaran::create(['name' => 'Fiqih', 'kategori' => '5 Ula']);
        MataPelajaran::create(['name' => 'Membaca kitab kuning', 'kategori' => '5 Ula']);
        MataPelajaran::create(['name' => 'Tauhid', 'kategori' => '5 Ula']);
        MataPelajaran::create(['name' => 'Nahwu', 'kategori' => '5 Ula']);
        MataPelajaran::create(['name' => 'Tasfir', 'kategori' => '5 Ula']);
        MataPelajaran::create(['name' => 'Fiqih', 'kategori' => '1 Wustho']);
        MataPelajaran::create(['name' => 'Membaca kitab kuning', 'kategori' => '1 Wustho']);
        MataPelajaran::create(['name' => 'Nahwu', 'kategori' => '1 Wustho']);
        MataPelajaran::create(['name' => 'Akhlak', 'kategori' => '1 Wustho']);
        MataPelajaran::create(['name' => 'Ushulul Fiqih', 'kategori' => '1 Wustho']);
        MataPelajaran::create(['name' => 'Ahlusunnah Wal Jamaah', 'kategori' => '1 Wustho']);
        MataPelajaran::create(['name' => 'Tauhid', 'kategori' => '1 Wustho']);
        MataPelajaran::create(['name' => 'Nahwu', 'kategori' => '2 Wustho']);
        MataPelajaran::create(['name' => 'Ulumul Quran (Ilmu Al-Quran)', 'kategori' => '2 Wustho']);
        MataPelajaran::create(['name' => 'Mustholahul Hadist', 'kategori' => '2 Wustho']);
        MataPelajaran::create(['name' => 'Ahlusunnah Wal Jamaah', 'kategori' => '2 Wustho']);
        MataPelajaran::create(['name' => 'Membaca kitab kuning', 'kategori' => '2 Wustho']);
        MataPelajaran::create(['name' => 'Fiqih', 'kategori' => '2 Wustho']);
        MataPelajaran::create(['name' => 'Hadist', 'kategori' => '2 Wustho']);
        MataPelajaran::create(['name' => 'Mawaris', 'kategori' => '2 Wustho']);
    }
}
