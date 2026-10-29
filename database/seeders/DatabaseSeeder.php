<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Task;
use App\Models\ActivityLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now('Asia/Jakarta');

        // 1. Buat User Rani Syaeka
        $user = User::updateOrCreate(
            ['email' => 'ranisyaeka48@gmail.com'],
            [
                'name' => 'Rani Syaeka',
                'password' => Hash::make('password'),
                'email_verified_at' => $now,
            ]
        );

        // 2. Kategori Default
        $categoriesData = [
            ['name' => 'Kuliah', 'color' => '#4F7DF3', 'icon' => 'GraduationCap'],
            ['name' => 'Pekerjaan', 'color' => '#10B981', 'icon' => 'Briefcase'],
            ['name' => 'Pribadi', 'color' => '#6366F1', 'icon' => 'User'],
            ['name' => 'Organisasi', 'color' => '#F59E0B', 'icon' => 'Users'],
            ['name' => 'Belanja', 'color' => '#8B5CF6', 'icon' => 'ShoppingBag'],
            ['name' => 'Lainnya', 'color' => '#64748B', 'icon' => 'Folder'],
        ];

        $categoryMap = [];
        foreach ($categoriesData as $cat) {
            $createdCat = Category::updateOrCreate(
                ['user_id' => $user->id, 'name' => $cat['name']],
                ['color' => $cat['color'], 'icon' => $cat['icon']]
            );
            $categoryMap[$cat['name']] = $createdCat->id;
        }

        // 3. Tugas Contoh Realistis
        $tasksData = [
            [
                'title' => 'Menyelesaikan Bab 4 Skripsi & Revisi Dosen',
                'description' => 'Menyusun analisis data kuantitatif serta melampirkan hasil uji validitas SPSS sesuai masukan pembimbing.',
                'category_id' => $categoryMap['Kuliah'] ?? null,
                'priority' => 'Tinggi',
                'status' => 'Sedang Dikerjakan',
                'start_at' => (clone $now)->setTime(8, 0),
                'due_at' => (clone $now)->setTime(21, 0), // Hari ini
                'completed_at' => null,
            ],
            [
                'title' => 'Submit Laporan Mingguan Proyek Web',
                'description' => 'Rangkum sprint review, tiket Jira yang selesai, dan rencana deliverables untuk klien.',
                'category_id' => $categoryMap['Pekerjaan'] ?? null,
                'priority' => 'Tinggi',
                'status' => 'Belum Dikerjakan',
                'start_at' => (clone $now)->setTime(13, 0),
                'due_at' => (clone $now)->setTime(17, 30), // Hari ini
                'completed_at' => null,
            ],
            [
                'title' => 'Kirim Email Penawaran Sponsor Seminar Nasional',
                'description' => 'Follow-up draft proposal sponsorship dan paket kemitraan ke 3 perusahaan teknologi.',
                'category_id' => $categoryMap['Organisasi'] ?? null,
                'priority' => 'Tinggi',
                'status' => 'Belum Dikerjakan',
                'start_at' => (clone $now)->subDays(2)->setTime(9, 0),
                'due_at' => (clone $now)->subDay()->setTime(15, 0), // Terlambat!
                'completed_at' => null,
            ],
            [
                'title' => 'Rapat Koordinasi Divisi Acara Dies Natalis',
                'description' => 'Diskusi rundown acara utama dan gladi kotor via Google Meet bersama panitia pelaksana.',
                'category_id' => $categoryMap['Organisasi'] ?? null,
                'priority' => 'Sedang',
                'status' => 'Belum Dikerjakan',
                'start_at' => (clone $now)->addDay()->setTime(19, 0),
                'due_at' => (clone $now)->addDay()->setTime(21, 0), // Mendatang
                'completed_at' => null,
            ],
            [
                'title' => 'Belanja Kebutuhan Bulanan & Suplemen Kesehatan',
                'description' => 'Membeli susu oat, buah segar, telur omega, dan multivitamin di supermarket.',
                'category_id' => $categoryMap['Belanja'] ?? null,
                'priority' => 'Rendah',
                'status' => 'Belum Dikerjakan',
                'start_at' => null,
                'due_at' => (clone $now)->addDays(3)->setTime(18, 0), // Mendatang
                'completed_at' => null,
            ],
            [
                'title' => 'Membayar Uang Kuliah Tunggal (UKT) Semester 7',
                'description' => 'Pembayaran tagihan UKT melalui Virtual Account Bank BNI dan simpan bukti transaksi.',
                'category_id' => $categoryMap['Kuliah'] ?? null,
                'priority' => 'Tinggi',
                'status' => 'Selesai',
                'start_at' => (clone $now)->subDays(3)->setTime(8, 0),
                'due_at' => (clone $now)->subDays(2)->setTime(14, 0),
                'completed_at' => (clone $now)->subDays(2)->setTime(11, 20),
            ],
            [
                'title' => 'Review Mockup Desain UI Dashboard Laravel Breeze',
                'description' => 'Memberikan feedback komponen card, warna biru pastel #4F7DF3, dan navbar responsive.',
                'category_id' => $categoryMap['Pekerjaan'] ?? null,
                'priority' => 'Sedang',
                'status' => 'Selesai',
                'start_at' => (clone $now)->subDays(2)->setTime(10, 0),
                'due_at' => (clone $now)->subDay()->setTime(16, 0),
                'completed_at' => (clone $now)->subDay()->setTime(15, 45),
            ]
        ];

        foreach ($tasksData as $taskItem) {
            $taskItem['user_id'] = $user->id;
            Task::create($taskItem);
        }

        // 4. Log Aktivitas
        $logs = [
            'Menyelesaikan tugas: "Review Mockup Desain UI Dashboard Laravel Breeze"',
            'Membuat tugas baru: "Submit Laporan Mingguan Proyek Web"',
            'Membuat tugas baru: "Menyelesaikan Bab 4 Skripsi & Revisi Dosen"',
            'Menyelesaikan tugas: "Membayar Uang Kuliah Tunggal (UKT) Semester 7"',
        ];

        foreach ($logs as $i => $desc) {
            ActivityLog::create([
                'user_id' => $user->id,
                'task_id' => null,
                'activity_type' => str_contains($desc, 'Menyelesaikan') ? 'complete' : 'create',
                'description' => $desc,
                'created_at' => (clone $now)->subHours($i * 4 + 1),
            ]);
        }
    }
}
