<?php

namespace App\Http\Controllers;

use App\Models\Stokbahan;
use App\Models\RiwayatStok;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class SupplierController extends Controller
{
    public function dashboard(Request $request)
    {
        $bulanPilih = $request->input('bulan', date('Y-m'));
        $daftarBahan = Stokbahan::all(); 

        $ambangBatasWaktu = Carbon::now()->subDays(7);
        $laporanMasuk = RiwayatStok::query()
            ->where('tanggal_masuk', '>=', $ambangBatasWaktu->format('Y-m-d'))
            ->when($bulanPilih, function ($query, $bulanPilih) {
                return $query->where('tanggal_masuk', 'like', '%' . $bulanPilih . '%');
            })
            ->get();

        $totalPengeluaranMingguan = $laporanMasuk->sum(function ($item) {
            return $item->harga_satuan * $item->jumlah_masuk;
        });

        $bahanMenipis = $daftarBahan->filter(function ($item) {
            $stok = $item->JUMLAH_BAHAN;
            $satuan = strtolower($item->satuan);

            // Jika satuannya Gram (g) atau Mililiter (ml), batas kritisnya di bawah 1000 (artinya < 1 Kg / 1 Liter)
            if (in_array($satuan, ['g', 'gram', 'ml', 'mililiter'])) {
                return $stok < 1000;
            }

            // Untuk satuan Kg, Liter, Pcs, Botol, Pack, batas kritisnya di bawah 1
            return $stok < 1;
        });

        return view('supplier.dashboard', compact(
            'daftarBahan', 
            'laporanMasuk', 
            'bahanMenipis', 
            'bulanPilih', 
            'totalPengeluaranMingguan'
        ));
    }

    public function storeBahan(Request $request)
    {
        $request->validate([
            'nama_bahan'    => 'required|string|max:100',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'jumlah_bahan'  => 'required|numeric|min:0',
            'satuan'        => 'required|string|max:50',
            'harga'         => 'required|numeric|min:0',
            'tanggal_masuk' => 'required|date',
        ]);

        $lastBahan = Stokbahan::orderBy('id_bahan', 'desc')->first();
        $nextNumber = $lastBahan ? (int) substr($lastBahan->id_bahan, 1) + 1 : 1;
        $autoIdBahan = 'B' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('bahan', 'public');
        }

        try {
            Stokbahan::create([
                'id_bahan'      => $autoIdBahan,
                'nama_bahan'    => $request->nama_bahan,
                'foto'          => $fotoPath,
                'jumlah_bahan'  => $request->jumlah_bahan,
                'satuan'        => $request->satuan,
                'harga'         => $request->harga,
                'tanggal_masuk' => $request->tanggal_masuk,
                'tanggal_keluar'=> null,
            ]);

            RiwayatStok::create([
                'id_bahan'      => $autoIdBahan,
                'nama_bahan'    => $request->nama_bahan,
                'foto'          => $fotoPath,
                'jumlah_masuk'  => $request->jumlah_bahan,
                'satuan'        => $request->satuan,
                'harga_satuan'  => $request->harga,
                'tanggal_masuk' => $request->tanggal_masuk,
            ]);

            return redirect()->back()->with('success', 'Bahan baku berhasil ditambahkan dengan foto!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function restockBahan(Request $request, $id)
    {
        $request->validate([
            'tambah_stok'   => 'required|numeric|min:1',
            'harga'         => 'required|numeric|min:0',
            'tanggal_masuk' => 'required|date',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $bahan = Stokbahan::where('id_bahan', $id)->first();

        if ($bahan) {
            $bahan->jumlah_bahan += $request->tambah_stok;
            $bahan->harga = $request->harga; // Perbarui harga satuan terbaru pada data utama
            
            // Catatan: Foto utama bahan ($bahan->foto) TIDAK diubah agar katalog utama tetap konsisten
            $bahan->save();

            // Simpan foto bukti khusus untuk transaksi restock ini
            $fotoBuktiPath = null;
            if ($request->hasFile('foto')) {
                $fotoBuktiPath = $request->file('foto')->store('bahan', 'public');
            }

            RiwayatStok::create([
                'id_bahan'      => $bahan->id_bahan,
                'nama_bahan'    => $bahan->nama_bahan,
                'foto'          => $fotoBuktiPath, // Foto bukti khusus riwayat
                'jumlah_masuk'  => $request->tambah_stok, 
                'satuan'        => $bahan->satuan,
                'harga_satuan'  => $request->harga,
                'tanggal_masuk' => $request->tanggal_masuk,
            ]);

            return redirect()->back()->with('success', 'Stok berhasil direstock dengan harga dan bukti terbaru.');
        }

        return redirect()->back()->with('error', 'Data bahan baku tidak ditemukan.');
    }

    public function destroyBahan($id)
    {
        $bahan = Stokbahan::where('id_bahan', $id)->first();
        
        if ($bahan) {
            if ($bahan->foto) {
                Storage::disk('public')->delete($bahan->foto);
            }
            $bahan->delete();
            return redirect()->back()->with('success', 'Bahan baku berhasil dihapus!');
        }

        return redirect()->back()->with('error', 'Data tidak ditemukan.');
    }

    public function exportExcel(Request $request)
    {
        $bulanPilih = $request->input('bulan', date('Y-m'));
        $ambangBatasWaktu = Carbon::now()->subDays(7);

        $data = RiwayatStok::query()
            ->where('tanggal_masuk', '>=', $ambangBatasWaktu->format('Y-m-d'))
            ->where('tanggal_masuk', 'like', '%' . $bulanPilih . '%')
            ->get();

        $filename = "Laporan_Restock_Mingguan_" . $bulanPilih . ".csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($data) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID Bahan', 'Nama Bahan', 'Harga Satuan', 'Jumlah Masuk', 'Satuan', 'Tanggal Masuk', 'Estimasi Total']);

            foreach ($data as $row) {
                fputcsv($file, [
                    $row->id_bahan,
                    $row->nama_bahan,
                    $row->harga_satuan,
                    $row->jumlah_masuk,
                    $row->satuan,
                    $row->tanggal_masuk,
                    $row->harga_satuan * $row->jumlah_masuk
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}