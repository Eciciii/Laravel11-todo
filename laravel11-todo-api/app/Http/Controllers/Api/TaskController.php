<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Menampilkan daftar tugas.
     */
    public function index()
    {
        $tasks = Task::latest()->paginate(5);

        return response()->json(['success' => true, 'message' => 'List Data Tasks', 'data' => $tasks], 200);
    }

    /**
     * Menyimpan tugas baru.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori'  => 'nullable|string|max:255',
            'prioritas' => 'required|in:rendah,sedang,tinggi',
            'deadline'  => 'nullable|date'
        ]);

        $task = Task::create([
            'judul'     => $validatedData['judul'],
            'deskripsi' => $validatedData['deskripsi'] ?? null,
            'kategori'  => $validatedData['kategori'] ?? null,
            'prioritas' => $validatedData['prioritas'],
            'deadline'  => $validatedData['deadline'] ?? null,
            'status'    => false
        ]);

        return response()->json(['success' => true, 'message' => 'Tugas Berhasil Ditambahkan!', 'data' => $task], 201);
    }

    /**
     * Menampilkan detail tugas berdasarkan ID.
     */
    public function show($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['success' => false, 'message' => 'Tugas Tidak Ditemukan'], 404);
        }

        return response()->json(['success' => true, 'message' => 'Detail Data Task!', 'data' => $task], 200);
    }

    /**
     * Memperbarui tugas berdasarkan ID.
     */
    public function update(Request $request, $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['success' => false, 'message' => 'Tugas Tidak Ditemukan'], 404);
        }

        $validatedData = $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori'  => 'nullable|string|max:255',
            'prioritas' => 'required|in:rendah,sedang,tinggi',
            'status'    => 'sometimes|boolean',
            'deadline'  => 'nullable|date'
        ]);

        $task->update([
            'judul'     => $validatedData['judul'],
            'deskripsi' => $validatedData['deskripsi'] ?? $task->deskripsi,
            'kategori'  => $validatedData['kategori'] ?? $task->kategori,
            'prioritas' => $validatedData['prioritas'],
            'status'    => $validatedData['status'] ?? $task->status,
            'deadline'  => $validatedData['deadline'] ?? $task->deadline
        ]);

        return response()->json(['success' => true, 'message' => 'Data Tugas Berhasil Diubah!', 'data' => $task], 200);
    }

    /**
     * Menghapus tugas berdasarkan ID.
     */
    public function destroy($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['success' => false, 'message' => 'Tugas Tidak Ditemukan'], 404);
        }

        $task->delete();

        return response()->json(['success' => true, 'message' => 'Data Tugas Berhasil Dihapus!'], 200);
    }
}
