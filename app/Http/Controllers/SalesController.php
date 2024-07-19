<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\Location;
use App\Models\TaskLog;

class SalesController extends Controller
{
    public function index()
    {
        return view('sales.Dashboard');
    }

    public function index2()
    {
        $salesId = Auth::user()->id;
        $tasks = Task::where('sales_id', $salesId)->with(['outlet'])->get();
        return view('sales.DaftarTugas', compact('tasks'));
    }

    public function storeLocation(Request $request)
    {
        $request->validate([
            'sales_id' => 'required|exists:users,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $salesId = $request->sales_id;

        // Periksa apakah lokasi dengan koordinat yang sama sudah ada
        $existingLocation = Location::where('latitude', $latitude)
            ->where('longitude', $longitude)
            ->where('sales_id', $salesId)
            ->first();

        if ($existingLocation) {
            // Lokasi sudah ada, kembalikan respon JSON bahwa data sudah ada
            return response()->json(['status' => 'exists']);
        }

        // Simpan data lokasi ke database
        Location::create([
            'sales_id' => $salesId,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);

        // Kembalikan respon JSON success
        return response()->json(['status' => 'success']);
    }

    public function selesaiTugas(Request $request, $id)
    {
        $task = Task::find($id);
        if ($task) {
            $task->status = 'Selesai';
            $task->save();

            // Simpan log tugas setelah status diupdate
            TaskLog::create([
                'task_id' => $task->id,
                'user_id' => Auth::id(), // ID Sales yang menyelesaikan tugas
                'outlet_name' => $task->outlet->nama,
                'outlet_address' => $task->outlet->alamat,
                'description' => $task->deskripsi,
                'status' => 'Selesai',
                'distance' => $task->distance,
            ]);

            return redirect()->back()->with('success', 'Tugas berhasil diselesaikan.');
        }
        return redirect()->back()->with('error', 'Tugas tidak ditemukan.');
    }
}
