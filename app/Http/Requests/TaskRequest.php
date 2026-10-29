<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255', 'min:3'],
            'description' => ['nullable', 'string'],
            'category_id' => [
                'nullable',
                Rule::exists('categories', 'id')->where(function ($query) {
                    return $query->where('user_id', $this->user()->id);
                }),
            ],
            'start_at' => ['nullable', 'date'],
            'due_at' => ['nullable', 'date', 'after_or_equal:start_at'],
            'priority' => ['required', Rule::in(['Rendah', 'Sedang', 'Tinggi'])],
            'status' => ['required', Rule::in(['Belum Dikerjakan', 'Sedang Dikerjakan', 'Selesai'])],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul tugas wajib diisi.',
            'title.min' => 'Judul tugas minimal 3 karakter.',
            'due_at.after_or_equal' => 'Tenggat waktu tidak boleh lebih awal dari waktu mulai.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid atau bukan milik akun Anda.',
            'priority.required' => 'Prioritas tugas wajib ditentukan.',
            'status.required' => 'Status tugas wajib ditentukan.',
        ];
    }
}
