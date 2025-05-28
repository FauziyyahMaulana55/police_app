<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VehicleController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'license_plate' => 'required|string|max:20',
            'type' => 'required|string',
            'brand' => 'required|string',
            'color' => 'required|string',
            'is_stolen' => 'boolean',
        ], [
            'license_plate.required' => 'Plat nomor wajib diisi.',
            'license_plate.string' => 'Plat nomor harus berupa teks.',
            'license_plate.max' => 'Plat nomor maksimal 20 karakter.',

            'type.required' => 'Tipe kendaraan wajib diisi.',
            'type.string' => 'Tipe kendaraan harus berupa teks.',

            'brand.required' => 'Merk kendaraan wajib diisi.',
            'brand.string' => 'Merk kendaraan harus berupa teks.',

            'color.required' => 'Warna kendaraan wajib diisi.',
            'color.string' => 'Warna kendaraan harus berupa teks.',

            'is_stolen.boolean' => 'Status pencurian harus berupa nilai ya/tidak.',
        ]);

        $data['user_id'] = Auth::id();
        $vehicle = Vehicle::create($data);

        return response()->json([
            'message' => 'Kendaraan berhasil ditambahkan',
            'data' => $vehicle
        ], 201);
    }

  public function index(Request $request)
    {
        try {
            $vehicles = $request->user()->vehicles;

            return response()->json([
                'status' => 'success',
                'message' => 'Data kendaraan berhasil ditemukan.',
                'data' => $vehicles,
            ]);
        } catch (\Exception $e) {
            Log::error('Error retrieving vehicles: ' . $e->getMessage());
            return response()->json([
                'status' => 'failed',
                'message' => 'Gagal mengambil data kendaraan.',
                'data' => [],
            ], 500);
        }
    }


    public function show(Request $request, $id)
    {
        $vehicle = $request->user()->vehicles()->find($id);

        if (!$vehicle) {
            return response()->json([
                'status'  => 'failed',
                'message' => 'Kendaraan tidak ditemukan',
                'data'    => []
            ], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Detail kendaraan ditemukan',
            'data'    => $vehicle
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'license_plate' => 'required|string|max:15|unique:vehicles,license_plate,' . $id,
            'type'          => 'required|string|max:50',
            'brand'         => 'required|string|max:50',
            'color'         => 'required|string|max:30',
            'is_stolen'     => 'required|boolean',
        ], [
            'license_plate.required' => 'Nomor polisi wajib diisi.',
            'license_plate.unique'   => 'Nomor polisi sudah terdaftar.',
            'type.required'          => 'Jenis kendaraan wajib diisi.',
            'brand.required'         => 'Merek kendaraan wajib diisi.',
            'color.required'         => 'Warna kendaraan wajib diisi.',
            'is_stolen.required'     => 'Status kendaraan hilang wajib diisi.',
        ]);

        $vehicle = $request->user()->vehicles()->find($id);

        if (!$vehicle) {
            return response()->json([
                'status'  => 'failed',
                'message' => 'Kendaraan tidak ditemukan',
                'data'    => []
            ], 404);
        }

        $vehicle->update($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Kendaraan berhasil diupdate',
            'data'    => $vehicle
        ], 200);
    }

    public function destroy(Request $request, $id)
    {
        $vehicle = $request->user()->vehicles()->find($id);

        if (!$vehicle) {
            return response()->json([
                'status'  => 'failed',
                'message' => 'Kendaraan tidak ditemukan',
                'data'    => []
            ], 404);
        }

        $vehicle->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Kendaraan berhasil dihapus',
            'data'    => []
        ], 200);
    }
}
