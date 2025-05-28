<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle; 

class DashboardController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function vehicles()
    {
        // Ambil semua data kendaraan dari database
        $vehicles = Vehicle::all();

        // Kirim data ke view
        return view('vehicles.vehicle', compact('vehicles'));
    }
}
