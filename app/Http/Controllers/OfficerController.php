<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Officer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class OfficerController extends Controller
{

    // app/Http/Controllers/Api/OfficerController.php

    // Tampilkan semua officer
    public function index(Request $request)
    {
        // Jika request menginginkan JSON (dari JavaScript atau API tools)
        if ($request->wantsJson()) {
            $officers = Officer::all();
            return response()->json([
                'status' => 'success',
                'message' => 'Daftar officer berhasil diambil.',
                'data' => $officers
            ]);
        }

        return view('officer.index');
    }



    // Simpan officer baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'badge_number' => 'required|string|max:20|unique:officers,badge_number',
            'rank' => 'required|string|max:50',
            'assigned_area' => 'required|string|max:100',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama maksimal 100 karakter.',

            'badge_number.required' => 'Nomor badge wajib diisi.',
            'badge_number.string' => 'Nomor badge harus berupa teks.',
            'badge_number.max' => 'Nomor badge maksimal 20 karakter.',
            'badge_number.unique' => 'Nomor badge sudah digunakan.',

            'rank.required' => 'Pangkat wajib diisi.',
            'rank.string' => 'Pangkat harus berupa teks.',
            'rank.max' => 'Pangkat maksimal 50 karakter.',

            'assigned_area.required' => 'Wilayah tugas wajib diisi.',
            'assigned_area.string' => 'Wilayah tugas harus berupa teks.',
            'assigned_area.max' => 'Wilayah tugas maksimal 100 karakter.',
        ]);

        $data['user_id'] = Auth::id();
        $officer = Officer::create($data);

        return response()->json([
            'message' => 'Officer berhasil ditambahkan',
            'data' => $officer
        ], 201);
    }


    // Tampilkan officer berdasarkan ID
    public function show($id)
    {
        $officer = Officer::find($id);

        if (!$officer) {
            return response()->json([
                'status' => 'error',
                'message' => 'Officer tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $officer
        ]);
    }

    // Update data officer
    public function update(Request $request, $id)
    {
        $officer = Officer::find($id);

        if (!$officer) {
            return response()->json([
                'status' => 'error',
                'message' => 'Officer tidak ditemukan.'
            ], 404);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'badge_number' => 'required|string|max:20|unique:officers,badge_number,' . $id,
            'rank' => 'required|string|max:50',
            'assigned_area' => 'required|string|max:100',
        ]);

        $officer->update($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Data officer berhasil diperbarui.',
            'data' => $officer
        ]);
    }

    // Hapus officer
    public function destroy($id)
    {
        $officer = Officer::find($id);

        if (!$officer) {
            return response()->json([
                'status' => 'error',
                'message' => 'Officer tidak ditemukan.'
            ], 404);
        }

        $officer->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Officer berhasil dihapus.'
        ]);
    }
}
