<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Impor model BukuModel
use App\Models\BukuModel;

class BukuController extends Controller
{
    // Method untuk menampilkan data buku
    public function bukutampil()
    {
        $databuku = BukuModel::orderBy('kode_buku', 'ASC')->paginate(5);
        return view('halaman/view_buku', ['buku' => $databuku]);
    }

    // Method untuk menambah data buku
    public function bukutambah(Request $request)
    {
        $this->validate($request, [
            'kode_buku' => 'required',
            'judul' => 'required',
            'pengarang' => 'required',
            'kategori' => 'required'
        ]);

        // Buat entri baru jika validasi berhasil
        BukuModel::create([
            'kode_buku' => $request->kode_buku,
            'judul' => $request->judul,
            'pengarang' => $request->pengarang,
            'kategori' => $request->kategori
        ]);

        return redirect('/buku');
    }

    // Method untuk menghapus data buku
    public function bukuhapus($id_buku)
    {
        $databuku = BukuModel::find($id_buku);
        $databuku->delete();
        return redirect()->back();
    }

    // Method untuk mengedit data buku
    public function bukuedit($id_buku, Request $request)
    {
        $this->validate($request, [
            'kode_buku' => 'required',
            'judul' => 'required',
            'pengarang' => 'required',
            'kategori' => 'required'
        ]);

        $buku = BukuModel::find($id_buku);
        if (!$buku) {
            // Tambahkan logika untuk menangani jika buku tidak ditemukan
            return redirect()->back()->with('error', 'Buku tidak ditemukan.');
        }

        // Lakukan update jika validasi berhasil
        $buku->kode_buku = $request->kode_buku;
        $buku->judul = $request->judul;
        $buku->pengarang = $request->pengarang;
        $buku->kategori = $request->kategori;
        $buku->save();

        return redirect()->back();
    }
}