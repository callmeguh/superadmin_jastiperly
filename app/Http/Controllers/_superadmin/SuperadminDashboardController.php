<?php

namespace App\Http\Controllers\_superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\Refund;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class SuperadminDashboardController extends Controller
{
    // ================= Dashboard =================
    public function index()
    {
        // Total pengguna
        $totalUsers = User::count();

        // Pengguna baru 30 hari terakhir
        $newUsersLast30 = User::where('created_at', '>=', Carbon::now()->subDays(30))->count();

        // Total transaksi (jumlah nominal)
        $totalTransactions = Transaction::sum('amount');

        // Transaksi 30 hari terakhir
        $transactionsLast30 = Transaction::where('created_at', '>=', Carbon::now()->subDays(30))
            ->sum('amount');

        // Statistik transaksi
        $completedTransactions = Transaction::where('status', 'completed')->count();
        $ongoingTransactions   = Transaction::where('status', 'ongoing')->count();
        $canceledTransactions  = Transaction::where('status', 'canceled')->count();
        $deliveryTransactions  = Transaction::where('status', 'delivery')->count();

        // Grafik user per bulan (12 bulan terakhir)
        $usersByMonth = User::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy('month')
            ->pluck('total', 'month');

        // Transaksi terbaru
        $latestTransactions = Transaction::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('_superadmin.dashboard.index', compact(
            'totalUsers',
            'newUsersLast30',
            'totalTransactions',
            'transactionsLast30',
            'completedTransactions',
            'ongoingTransactions',
            'canceledTransactions',
            'deliveryTransactions',
            'usersByMonth',
            'latestTransactions'
        ));
    }

    // ================= Manajemen Pengguna =================
    public function index2(Request $request)
    {
        $role = $request->get('role', 'traveler');
        $search = $request->get('search');

        $query = User::query();

        if ($role) {
            $query->where('role', $role);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(10);

        $users->appends([
            'role' => $role,
            'search' => $search,
        ]);

        return view('_superadmin.users.index', compact('users', 'role', 'search'));
    }

    // Export data produk
    public function exportProducts()
    {
        $fileName = "products_export_" . now()->format('Y-m-d_H-i-s') . ".csv";
        $products = Product::all();

        $response = new StreamedResponse(function () use ($products) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['ID', 'Nama Barang', 'Deskripsi', 'Harga', 'Status']);

            foreach ($products as $product) {
                fputcsv($handle, [
                    $product->id,
                    $product->name,
                    $product->description,
                    $product->price,
                    $product->status,
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', "attachment; filename={$fileName}");

        return $response;
    }

    // ================= Manajemen Produk =================
    public function index3(Request $request)
    {
        $status = $request->get('status');
        $role   = $request->get('role');

        $query = Product::with('traveler');

        if ($status) {
            $query->where('status', $status);
        }

        if ($role) {
            $query->whereHas('traveler', function ($q) use ($role) {
                $q->where('role', $role);
            });
        }

        $products = $query->latest()->paginate(10);

        return view('_superadmin.products.index', compact('products', 'status', 'role'));
    }

    public function validateProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->status = 'disetujui';
        $product->save();

        return back()->with('success', 'Produk berhasil divalidasi!');
    }

    // ================= Transaksi =================
    public function index4(Request $request)
    {
        $transactions = Transaction::with('user')->latest()->paginate(10);
        return view('_superadmin.transactions.index', compact('transactions'));
    }

    public function show($id)
    {
        $transaction = Transaction::with('user')->findOrFail($id);
        return view('_superadmin.transactions.show', compact('transaction'));
    }

    public function edit($id)
    {
        $transaction = Transaction::with('user')->findOrFail($id);
        return view('_superadmin.transactions.edit', compact('transaction'));
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        $transaction->update([
            'status' => $request->status,
            'amount' => $request->amount,
        ]);

        return redirect()->route('superadmin.transactions')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->back()->with('success', 'Transaksi berhasil dihapus');
    }

    public function export(Request $request)
    {
        $transactions = Transaction::query();

        if($request->filled('search')) {
            $transactions->where('name', 'like', '%'.$request->search.'%');
        }
        if($request->filled('type')) {
            $transactions->where('type', $request->type);
        }
        if($request->filled('status')) {
            $transactions->where('status', $request->status);
        }

        $data = $transactions->get();

        $filename = 'transactions_'.date('Ymd_His').'.csv';
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array_keys($data->first()->toArray()));

        foreach($data as $row) {
            fputcsv($handle, $row->toArray());
        }
        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }

    // ================= Refund =================
    public function index5(Request $request)
    {
        $refunds = Refund::with('user')
            ->when($request->status, fn($q, $status) => $q->where('status', $status))
            ->when($request->search, function ($q, $search) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"))
                  ->orWhere('transaction_id', 'like', "%{$search}%")
                  ->orWhere('payment_method', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('_superadmin.refunds.index', [
            'refunds' => $refunds,
            'status' => $request->status,
            'search' => $request->search,
        ]);
    }

    public function exportRefunds()
    {
        $fileName = "refunds_export_" . now()->format('Y-m-d_H-i-s') . ".csv";
        $refunds = Refund::with('user')->latest()->get();

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename={$fileName}",
        ];

        $callback = function() use ($refunds) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['ID', 'Nama Penitip', 'ID Transaksi', 'Tanggal', 'Status', 'Total', 'Pembayaran']);

            foreach ($refunds as $r) {
                fputcsv($handle, [
                    $r->id,
                    $r->user->name ?? '-',
                    $r->transaction_id ?? '-',
                    $r->created_at->format('d-m-Y'),
                    ucfirst($r->status),
                    number_format($r->amount, 0, ',', '.'),
                    $r->payment_method ?? '-',
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ================= Pengaturan =================
    public function index6()
    {
        $user = Auth::user();
        return view('_superadmin.settings.index', compact('user'));
    }

    public function updateSettings(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|in:L,P',
        ]);

        $user->update($request->only(['username','name','email','telepon','alamat','jenis_kelamin']));

        return back()->with('success','Profil berhasil diperbarui!');
    }

    public function updatePreference(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'language' => 'required|string|in:id,en',
        ]);

        $user->language = $request->language;
        $user->save();

        app()->setLocale($request->language);

        return back()->with('success','Preferensi berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if (!\Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Password lama salah']);
        }

        $user->password = \Hash::make($request->new_password);
        $user->save();

        return back()->with('success','Password berhasil diperbarui!');
    }

    // ================= Halaman Lain =================
    public function index7()
    {
        return view('_superadmin.dashboard.index7');
    }

    public function index8()
    {
        return view('_superadmin.dashboard.index8');
    }

    public function index9()
    {
        return view('_superadmin.dashboard.index9');
    }

    public function index10()
    {
        return view('_superadmin.dashboard.index10');
    }
}
