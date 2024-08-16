<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Sales;
use App\Models\User;
use App\Models\Outlet;
use App\Models\Task;
use App\Models\TaskLog;
use App\Models\Location;
use App\Models\Product;

class AdminController extends Controller
{
    public function index()
    {
        // Mengambil jumlah tugas selesai dan dibatalkan per hari untuk 10 hari terakhir
        $totalSelesaiHariIni = [];
        $totalDibatalkanHariIni = [];
        for ($i = 0; $i < 10; $i++) {
            $tanggal = Carbon::today()->subDays($i);
            $totalSelesaiHariIni[] = Task::whereDate('updated_at', $tanggal)->where('status', 'Selesai')->count();
            $totalDibatalkanHariIni[] = Task::whereDate('updated_at', $tanggal)->where('status', 'Dibatalkan')->count();
        }

        // Mengambil jumlah total sales
        $totalSales = User::where('role', 'Sales')->count();

        // Mengambil jumlah total outlets
        $totalOutlets = Outlet::count();

        // Mengambil jumlah tugas pending per hari ini
        $totalPendingTasksToday = Task::where('status', 'Pending')
            ->whereDate('created_at', Carbon::today())
            ->count(); // Fetch completed task logs
        $completedTaskLogs = TaskLog::whereHas('task', function ($query) {
            $query->where('status', 'Selesai');
        })->get();

        // Pass the data to the view
        return view('admin.Dashboard', compact(
            'totalSelesaiHariIni',
            'totalDibatalkanHariIni',
            'totalSales',
            'totalOutlets',
            'totalPendingTasksToday',
            'completedTaskLogs' // Add this line
        ));
    }

    public function editProfil()
    {
        $user = Auth::user();
        return view('admin.EditProfil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'nullable|string', // Validasi untuk password saat ini yang opsional
            'password' => 'nullable|string|min:8|confirmed', // Validasi untuk password baru yang opsional
        ]);

        $user->nama = $request->nama;
        $user->email = $request->email;

        // Update password jika current_password ada dan benar
        if ($request->current_password && Hash::check($request->current_password, $user->password)) {
            $user->password = Hash::make($request->password);
        } elseif ($request->current_password && !Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        // Update field lainnya sesuai kebutuhan

        $user->save();

        return redirect()->route('edit.profil')->with('success', 'Profil berhasil diperbarui.');
    }

    public function index2()
    {
        $sales = Sales::with(['user.tasks'])->get();

        return view('admin.DaftarSales', compact('sales'));
    }

    public function index3()
    {
        return view('admin.TambahSales');
    }

    public function storeSales(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'jenis_kendaraan' => 'required',
            'plat_kendaraan' => 'required',
            'password' => 'required|min:6'
        ]);

        // Simpan ke tabel Sales
        $sales = Sales::create([
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'plat_kendaraan' => $request->plat_kendaraan,
            'password' => Hash::make($request->password),
        ]);

        // Simpan ke tabel Users
        $user = new User();
        $user->nama = $request->nama; // Atur username, misalnya nama Sales
        $user->email = $request->email;
        $user->password = Hash::make($request->password); // Atur password hashed
        $user->sales_id = $sales->id; // Tautkan user dengan sales menggunakan sales_id atau field yang sesuai
        $user->save();

        return redirect()->route('daftar.sales')->with('success', 'Sales berhasil ditambahkan');
    }

    public function editSales($id)
    {
        $sales = Sales::findOrFail($id);
        return view('admin.EditSales', compact('sales'));
    }

    public function updateSales(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'jenis_kelamin' => 'required',
            'jenis_kendaraan' => 'required',
            'plat_kendaraan' => 'required',
            'password' => 'nullable|min:6',
        ]);

        // Cari record Sales
        $sales = Sales::find($id);

        if (!$sales) {
            return redirect()->back()->with('error', 'Sales tidak ditemukan');
        }

        // Update data Sales
        $sales->nama = $request->nama;
        $sales->jenis_kelamin = $request->jenis_kelamin;
        $sales->jenis_kendaraan = $request->jenis_kendaraan;
        $sales->plat_kendaraan = $request->plat_kendaraan;

        // Simpan perubahan pada model Sales
        $sales->save();

        // Update data User terkait (jika ada)
        if ($sales->user) {
            $sales->user->nama = $request->nama; // Update nama User
            $sales->user->email = $request->email; // Update email User

            // Update password jika diisi
            if ($request->filled('password')) {
                $sales->user->password = Hash::make($request->password);
            }

            // Simpan perubahan pada model User
            $sales->user->save();
        }

        return redirect()->route('daftar.sales')->with('success', 'Sales berhasil diupdate');
    }

    public function destroySales($id)
    {
        $user = User::findOrFail($id);
        $user->sales()->delete(); // Menghapus semua sales terkait user
        $user->delete(); // Menghapus user itu sendiri

        return redirect()->route('daftar.sales')->with('success', 'Sales berhasil dihapus');
    }

    public function index4()
    {
        $outlets = Outlet::all();
        return view('admin.DaftarOutlet', compact('outlets'));
    }

    public function index5()
    {
        return view('admin.TambahOutlet');
    }

    public function storeOutlet(Request $request)
    {
        $request->validate([
            'id_outlet' => 'required|unique:outlets,id',
            'nama_outlet' => 'required',
            'alamat_outlet' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        try {
            $outlet = new Outlet();
            $outlet->id = $request->id_outlet;
            $outlet->nama = $request->nama_outlet;
            $outlet->alamat = $request->alamat_outlet;
            $outlet->latitude = $request->latitude;
            $outlet->longitude = $request->longitude;
            $outlet->save();

            // Success message using session flash
            return redirect()->route('daftar.outlet')->with('success', 'Outlet berhasil ditambahkan');
        } catch (\Exception $e) {
            // Error message using session flash
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan outlet. ID Outlet sudah ada atau terjadi kesalahan lainnya.');
        }
    }

    public function checkIdOutlet(Request $request)
    {
        $id_outlet = $request->id_outlet;

        // Lakukan pengecekan ke database
        $exists = Outlet::where('id', $id_outlet)->exists();

        return response()->json(['exists' => $exists]);
    }

    public function editOutlet($id)
    {
        $outlet = Outlet::find($id);
        if (!$outlet) {
            abort(404); // Handle jika outlet tidak ditemukan
        }

        // Pass $outlet ke view untuk ditampilkan di form edit
        return view('admin.EditOutlet', compact('outlet'));
    }

    public function updateOutlet(Request $request, $id)
    {
        $request->validate([
            'nama_outlet' => 'required',
            'alamat_outlet' => 'required',
        ]);

        $outlet = Outlet::find($id);
        if (!$outlet) {
            abort(404); // Handle jika outlet tidak ditemukan
        }

        // Update data outlet
        $outlet->nama = $request->nama_outlet;
        $outlet->alamat = $request->alamat_outlet;
        $outlet->save();

        return redirect()->route('daftar.outlet')->with('success', 'Outlet berhasil diperbarui');
    }

    public function destroyOutlet($id)
    {
        try {
            $outlet = Outlet::findOrFail($id);
            $outlet->delete();

            return redirect()->route('daftar.outlet')->with('success', 'Outlet berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('daftar.outlet')->with('error', 'Gagal menghapus outlet');
        }
    }

    public function index6()
    {
        $tasks = Task::with(['sales', 'outlet'])
            ->select('tasks.*') // Pastikan mengambil semua kolom dari tabel tugas
            ->get();
        return view('admin.daftarTugas', compact('tasks'));
    }


    public function index7()
    {
        $users = User::where('role', 'Sales')->get();
        $outlets = Outlet::all();
        $products = Product::all();

        return view('admin.tambahTugas', compact('users', 'outlets', 'products'));
    }

    public function storeTugas(Request $request)
    {
        // Validasi input
        $request->validate([
            'sales_id' => 'required|exists:users,id',
            'outlet_id' => 'required|exists:outlets,id',
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
            'deskripsi' => 'nullable',
        ]);

        // Temukan produk
        $product = Product::find($request->product_id);

        // Validasi kuantitas produk
        if ($product && $product->qty >= $request->qty) {
            // Kurangi kuantitas produk
            $product->qty -= $request->qty;
            $product->save();

            // Tambah tugas baru
            Task::create([
                'sales_id' => $request->sales_id,
                'product_id' => $request->product_id,
                'outlet_id' => $request->outlet_id,
                'deskripsi' => $request->deskripsi,
                'qty' => $request->qty, // Simpan kuantitas yang digunakan
            ]);

            return redirect()->route('daftar.tugas')->with('success', 'Tugas berhasil ditambahkan.');
        } else {
            return redirect()->back()->withErrors(['qty' => 'Kuantitas tidak mencukupi.']);
        }
    }


    public function updateStatusTugas(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $previousStatus = $task->status;

        // Update status tugas
        $task->status = $request->status;
        $task->save();

        // Jika status diubah menjadi "Dibatalkan" dan sebelumnya tidak "Dibatalkan"
        if ($request->status === 'Dibatalkan' && $previousStatus !== 'Dibatalkan') {
            $product = Product::find($task->product_id);

            // Jika produk ditemukan
            if ($product) {
                $product->qty += $task->qty; // Kembalikan kuantitas yang digunakan
                $product->save();
            }
        }

        return redirect()->back()->with('success', 'Status tugas berhasil diupdate.');
    }


    public function editTugas($id)
    {
        $task = Task::findOrFail($id);
        $sales = User::where('role', 'Sales')->get(); // Ambil users dengan role 'Sales'
        $outlets = Outlet::all();
        return view('admin.EditTugas', compact('task', 'sales', 'outlets'));
    }

    public function updateTugas(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->update($request->all());

        return redirect()->route('daftar.tugas')->with('success', 'Tugas berhasil diupdate.');
    }

    public function index8(Task $task)
    {
        // Ambil lokasi terbaru dari sales
        $latestLocation = Location::where('sales_id', $task->sales_id)->latest()->first();

        // Jika latitude atau longitude null, kirim pesan error
        if (!$latestLocation || is_null($latestLocation->latitude) || is_null($latestLocation->longitude)) {
            return redirect()->back()->with('error', 'Lokasi sales belum tersedia.');
        }

        // Ambil semua tasks (tugas) yang belum selesai dari sales ini
        $salesTasks = Task::where('sales_id', $task->sales_id)
            ->where('status', 'Pending') // Filter hanya yang statusnya "Pending"
            ->get();

        return view('admin.LacakSales', compact('task', 'latestLocation', 'salesTasks'));
    }

    public function index9()
    {
        return view('admin.TambahProduk');
    }

    public function storeProduk(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_produk' => 'required|unique:products,id', // Pastikan validasi sesuai dengan primary key
            'nama_produk' => 'required',
            'qty' => 'required|integer',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Ambil data dari request
        $data = [
            'id' => $request->id_produk, // Perbaiki sesuai dengan nama field yang sesuai
            'nama_produk' => $request->nama_produk,
            'qty' => $request->qty,
            'harga' => $request->harga,
            'gambar' => $request->file('gambar') ? $request->file('gambar')->store('images', 'public') : null,
        ];

        // Simpan data ke database
        Product::create($data);

        // Redirect ke halaman daftar produk
        return redirect()->route('daftar.produk')->with('success', 'Produk berhasil ditambahkan');
    }


    public function checkIdProduk(Request $request)
    {
        $id_produk = $request->id_produk;

        // Lakukan pengecekan ke database
        $exists = Product::where('id', $id_produk)->exists();

        // Kembalikan hasil pengecekan dalam format JSON
        return response()->json(['exists' => $exists]);
    }

    public function index10()
    {
        $products = Product::all(); // Mengambil semua produk
        return view('admin.DaftarProduk', compact('products')); // Mengirimkan data produk ke view
    }

    public function destroyProduk($id)
    {
        // Temukan produk berdasarkan ID
        $product = Product::findOrFail($id);

        // Hapus file gambar jika ada
        if ($product->gambar) {
            \Storage::disk('public')->delete($product->gambar);
        }

        // Hapus produk dari database
        $product->delete();

        // Redirect kembali dengan pesan sukses
        return redirect()->route('daftar.produk')->with('success', 'Produk berhasil dihapus');
    }

    public function editProduk($id)
    {
        $product = Product::find($id);
        if (!$product) {
            abort(404); // Handle jika produk tidak ditemukan
        }

        return view('admin.EditProduk', compact('product'));
    }

    public function updateProduk(Request $request, $id_produk)
    {
        // Validasi input
        $request->validate([
            'nama_produk' => 'required',
            'qty' => 'required|integer',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Temukan produk berdasarkan id_produk
        $product = Product::where('id', $id_produk)->firstOrFail();

        // Jika ada gambar baru diunggah
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($product->gambar) {
                \Storage::disk('public')->delete($product->gambar);
            }
            // Simpan gambar baru
            $gambarPath = $request->file('gambar')->store('images', 'public');
        } else {
            // Jika tidak ada gambar baru, gunakan gambar lama
            $gambarPath = $product->gambar;
        }

        // Update produk
        $product->update([
            'nama_produk' => $request->nama_produk,
            'qty'         => $request->qty,
            'harga'       => $request->harga,
            'gambar'      => $gambarPath,
        ]);

        return redirect()->route('daftar.produk')->with('success', 'Produk berhasil diperbarui');
    }


    /* public function showTasks()
    {
        $salesId = 3; // Gunakan sales_id yang diketahui ada di database untuk pengujian
        $tasks = \App\Models\Task::where('sales_id', $salesId)->with(['outlet'])->get();

        $tasks = Task::where('sales_id', $salesId)->with(['outlet'])->get();

        return view('admin.LihatTugas', compact('tasks'));
    } */

    public function showTasks($user_id)
    {
        $tasks = Task::where('sales_id', $user_id)->with(['outlet'])->get();
        return view('admin.LihatTugas', compact('tasks'));
    }
}
