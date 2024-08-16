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
        $user = Auth::user();

        // Mengambil jumlah tugas hari ini untuk sales
        $tasksToday = Task::whereDate('created_at', today())->where('sales_id', $user->id)->count();

        // Mengambil jumlah tugas selesai untuk sales
        $tasksCompleted = Task::where('status', 'Selesai')->where('sales_id', $user->id)->count();

        // Mengambil jumlah tugas pending untuk sales
        $tasksPending = Task::where('status', 'Pending')->where('sales_id', $user->id)->count();


        return view('sales.Dashboard', compact('tasksToday', 'tasksCompleted', 'tasksPending'));
    }

    /*     public function index2()
    {
        $salesId = Auth::user()->id;
        $tasks = Task::where('sales_id', $salesId)->with(['outlet'])->get();
        return view('sales.DaftarTugas', compact('tasks'));
    } */

    public function index2()
    {
        $salesId = Auth::user()->id;

        // Ambil lokasi sales dari tabel locations
        $salesLocation = \DB::table('locations')
            ->where('sales_id', $salesId)
            ->latest('created_at') // Ambil lokasi terbaru
            ->first();

        // Ambil tugas dengan status 'Pending'
        $tasks = Task::where('sales_id', $salesId)
            ->where('status', 'Pending')
            ->with(['outlet'])
            ->get();

        return view('sales.DaftarTugas', compact('tasks', 'salesLocation'));
    }

    public function editProfil()
    {
        $user = Auth::user(); // Mengambil pengguna yang sedang login
        return view('sales.EditProfil', compact('user'));
    }

    // Menyimpan perubahan edit profil
    public function updateProfil(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'password' => 'nullable|confirmed|min:6',
        ]);

        $user = Auth::user();
        $user->nama = $request->input('nama');
        $user->email = $request->input('email');

        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        return redirect()->route('edit.profil.sales')->with('success', 'Profil berhasil diperbarui.');
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
