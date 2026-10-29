<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Task;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_pengguna_belum_login_dialihkan_ke_halaman_login()
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_pengguna_dapat_melihat_dashboard_setelah_login()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Progres Produktivitas');
    }

    public function test_pengguna_dapat_membuat_tugas_baru()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/tasks', [
            'title' => 'Menyelesaikan Modul Laravel Breeze',
            'description' => 'Mempelajari arsitektur Blade dan Tailwind CSS',
            'priority' => 'Tinggi',
            'status' => 'Belum Dikerjakan',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('tasks', [
            'user_id' => $user->id,
            'title' => 'Menyelesaikan Modul Laravel Breeze',
            'priority' => 'Tinggi',
        ]);
    }

    public function test_validasi_judul_tugas_minimal_tiga_karakter()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/tasks', [
            'title' => 'ab', // Kurang dari 3 karakter
            'priority' => 'Sedang',
            'status' => 'Belum Dikerjakan',
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_pengguna_hanya_dapat_mengubah_dan_menghapus_tugas_miliknya_sendiri()
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $taskA = Task::create([
            'user_id' => $userA->id,
            'title' => 'Tugas Pribadi User A',
            'priority' => 'Sedang',
            'status' => 'Belum Dikerjakan',
        ]);

        // User B mencoba menghapus tugas milik User A -> Harus ditolak 403 Forbidden
        $response = $this->actingAs($userB)->delete("/tasks/{$taskA->id}");
        $response->assertStatus(403);

        // Pastikan tugas User A masih ada di database
        $this->assertDatabaseHas('tasks', ['id' => $taskA->id]);
    }

    public function test_pengguna_dapat_menandai_tugas_sebagai_selesai()
    {
        $user = User::factory()->create();

        $task = Task::create([
            'user_id' => $user->id,
            'title' => 'Tugas Siap Selesai',
            'priority' => 'Rendah',
            'status' => 'Belum Dikerjakan',
        ]);

        $response = $this->actingAs($user)->patch("/tasks/{$task->id}/toggle");
        $response->assertRedirect();

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => 'Selesai',
        ]);
    }
}
