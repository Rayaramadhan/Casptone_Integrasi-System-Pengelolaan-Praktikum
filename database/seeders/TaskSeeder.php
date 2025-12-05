<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil user asprak (bukan admin/laboran)
        $aspraks = User::where('usertype', '!=', 'laboran')
            ->where('usertype', '!=', 'dosen')
            ->where('usertype', '!=', 'praktikan')
            ->take(3)
            ->get();

        if ($aspraks->isEmpty()) {
            $this->command->info('No asprak users found. Please create asprak users first.');
            return;
        }

        foreach ($aspraks as $asprak) {
            // Task 1: Pending, High Priority, Overdue
            Task::create([
                'user_id' => $asprak->id,
                'title' => 'Input Nilai Praktikum Modul 3',
                'description' => 'Input nilai praktikum modul 3 untuk kelas SI-46-01 dan SI-46-02. Total 60 mahasiswa. Nilai mencakup: kehadiran, tugas pendahuluan, tugas akhir, dan sikap.',
                'deadline' => Carbon::now()->subDays(2),
                'status' => 'pending',
                'priority' => 'high',
                'category' => 'input_nilai',
            ]);

            // Task 2: In Progress, Medium Priority
            Task::create([
                'user_id' => $asprak->id,
                'title' => 'Koreksi Tugas Akhir Modul 2',
                'description' => 'Koreksi tugas akhir modul 2 dari 30 mahasiswa kelas SI-46-03. Periksa implementasi CRUD dan validasi form.',
                'deadline' => Carbon::now()->addDays(3),
                'status' => 'in_progress',
                'priority' => 'medium',
                'category' => 'koreksi_tugas',
            ]);

            // Task 3: Pending, Low Priority
            Task::create([
                'user_id' => $asprak->id,
                'title' => 'Update Materi Modul 4',
                'description' => 'Update materi praktikum modul 4 tentang Authentication dan Authorization. Tambahkan contoh kasus dan latihan.',
                'deadline' => Carbon::now()->addWeek(),
                'status' => 'pending',
                'priority' => 'low',
                'category' => 'persiapan_modul',
            ]);

            // Task 4: Completed, High Priority
            Task::create([
                'user_id' => $asprak->id,
                'title' => 'Rekap Presensi Minggu Ini',
                'description' => 'Rekap presensi asisten dan praktikan untuk minggu ini. Export ke Excel dan kirim ke koordinator.',
                'deadline' => Carbon::now()->subDay(),
                'status' => 'completed',
                'priority' => 'high',
                'category' => 'presensi',
            ]);

            // Task 5: In Progress, High Priority
            Task::create([
                'user_id' => $asprak->id,
                'title' => 'Persiapan Praktikum Modul 5',
                'description' => 'Persiapkan lab dan materi untuk praktikum modul 5 tentang API Development. Setup Postman collection dan database.',
                'deadline' => Carbon::now()->addDays(2),
                'status' => 'in_progress',
                'priority' => 'high',
                'category' => 'persiapan_lab',
            ]);

            // Task 6: Pending, Medium Priority
            Task::create([
                'user_id' => $asprak->id,
                'title' => 'Upload Laporan Praktikum',
                'description' => 'Upload laporan praktikum pertemuan 6-8 ke sistem. Format PDF, max 5MB per file.',
                'deadline' => Carbon::now()->addDays(5),
                'status' => 'pending',
                'priority' => 'medium',
                'category' => 'laporan',
            ]);
        }

        $this->command->info('Task seeder completed successfully!');
    }
}
