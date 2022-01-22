<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Pesanan;
use App\Models\PesananBarang;
use Carbon\Carbon;
use Auth;

class OwnerController extends Controller
{

    public function dashboard()
    {
        // Carbon::setWeekStartsAt(Carbon::SUNDAY);
        // Carbon::setWeekEndsAt(Carbon::SATURDAY);
        
        $hari_ini = PesananBarang::whereDate('created_at', '=', date('Y-m-d'))->get();
        $bulan_ini = PesananBarang::whereMonth('created_at', '=', date('m'))->get();
        $semua = PesananBarang::all();
        $produk_terlaris = Barang::where('terjual', '>', 0)->orderByDesc('terjual')->take(4)->get();
        $sering_dilihat = Barang::where('dilihat', '>', 10)->orderByDesc('dilihat')->take(4)->get();
        $produk = Barang::all();
        $transaksi_terbaru = Pesanan::where('status', '!=', 'menunggu_konfirmasi')->orderByDesc('created_at')->take(5)->get();

        return view('owner.dashboard', compact(
            'hari_ini',
            'bulan_ini',
            'semua',
            'produk_terlaris',
            'sering_dilihat',
            'produk',
            'transaksi_terbaru'
        ));
    }

    public function produk_data()
    {
        $produk = Barang::all();
        return view('owner.produk-data', compact('produk'));
    }

    public function kitchen_set()
    {
        $produk = Barang::where('jenis', 'kitchen_set')->get();
        return view('owner.produk-data', compact('produk'));
    }

    public function tempat_tidur()
    {
        $produk = Barang::where('jenis', 'tempat_tidur')->get();
        return view('owner.produk-data', compact('produk'));
    }

    public function lemari()
    {
        $produk = Barang::where('jenis', 'lemari')->get();
        return view('owner.produk-data', compact('produk'));
    }

    public function meja()
    {
        $produk = Barang::where('jenis', 'meja')->get();
        return view('owner.produk-data', compact('produk'));
    }

    public function kursi()
    {
        $produk = Barang::where('jenis', 'kursi')->get();
        return view('owner.produk-data', compact('produk'));
    }

    public function cari_produk($id)
    {
        $produk = Barang::where('nama', 'like', "%".$id."%")->get();
        return view('owner.produk-data', compact('produk'));
    }

    public function detail_pesanan($id)
    {
        $pesanan = Pesanan::find($id);
        return view('admin.detail-pesanan', compact('pesanan'));
    }

    public function semua_transaksi()
    {
        $pesanan = Pesanan::where('status', '!=', 'menunggu_konfirmasi')->orderByDesc('created_at')->get();
        return view('owner.semua-transaksi', compact('pesanan'));
    }

    public function semua_transaksi_data()
    {
        $pesanan = Pesanan::where('status', '!=', 'menunggu_konfirmasi')->orderByDesc('created_at')->get();
        return view('owner.semua-transaksi-data', compact('pesanan'));
    }

    public function cari_pesanan($id)
    {
        $pesanan = Pesanan::where('id', 'like', "%".$id."%")->orderByDesc('created_at')->get();
        return view('owner.semua-transaksi-data', compact('pesanan'));
    }
}
