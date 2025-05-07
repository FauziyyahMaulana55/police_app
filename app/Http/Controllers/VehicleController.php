<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'license_plate' => 'required|string|max:15|unique:vehicles,license_plate',
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

        $vehicle = Vehicle::create([
            'user_id'       => $request->user()->id,
            'license_plate' => $validated['license_plate'],
            'type'          => $validated['type'],
            'brand'         => $validated['brand'],
            'color'         => $validated['color'],
            'is_stolen'     => $validated['is_stolen'],
        ]);

        if (!$vehicle) {
            return response()->json([
                'status'  => 'failed',
                'message' => 'Gagal menambahkan kendaraan',
                'data'    => []
            ], 400);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Kendaraan berhasil ditambahkan',
            'data'    => $vehicle
        ], 201);
    }

    public function index(Request $request)
    {
        $vehicles = Vehicle::where('user_id', $request->user()->id)->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Daftar kendaraan berhasil ditemukan',
            'data'    => $vehicles
        ], 200);
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
