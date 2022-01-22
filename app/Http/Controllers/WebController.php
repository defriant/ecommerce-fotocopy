<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\PesananBarang;
use App\Models\Notifikasi;
use Pusher\Pusher;
use Auth;

class WebController extends Controller
{
    public function index()
    {
        $data = Barang::all();
        if (!Auth::guest()) {
            if (Auth::user()->role == 'user') {
                return view('user.index', compact('data'));
            } elseif (Auth::user()->role == 'admin') {
                return redirect('/admin/produk');
            } elseif (Auth::user()->role == 'owner') {
                return redirect('/owner');
            }
        }
        return view('user.index', compact('data'));
    }

    public function attempt_login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(array('success' => true));
        } else {
            return response()->json(array('success' => false));
        }
    }

    public function check_this_user_role()
    {
        if (Auth::user()->role == 'user') {
            return redirect()->back();
        } elseif (Auth::user()->role == 'admin') {
            return redirect('/admin/produk');
        } elseif (Auth::user()->role == 'owner') {
            return redirect('/owner');
        }
    }

    public function user_logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function all_item()
    {
        $data = Barang::all();
        return view('user.product_data', compact('data'));
    }

    public function notifikasi_read()
    {
        Notifikasi::where('user_id', Auth::user()->id)->update([
            'is_read' => 1
        ]);
    }

    public function get_notifikasi()
    {
        return view('user.notifikasi');
    }

    public function keranjang_count()
    {
        $data = Keranjang::where('user_id', Auth::user()->id)->get();
        return response()->json($data);
    }

    public function search_produk($id)
    {
        $data = Barang::where('nama', 'like', "%" . $id . "%")->get();
        return view('user.product_data', compact('data'));
    }

    public function produk_data_kategori($kategori)
    {
        $data = Barang::where('jenis', $kategori)->get();
        return view('user.product_data', compact('data'));
    }

    // public function kitchen_set()
    // {
    //     $data = Barang::where('jenis', 'kitchen_set')->get();
    //     return view('user.product_data', compact('data'));
    // }

    // public function tempat_tidur()
    // {
    //     $data = Barang::where('jenis', 'tempat_tidur')->get();
    //     return view('user.product_data', compact('data'));
    // }

    // public function lemari()
    // {
    //     $data = Barang::where('jenis', 'lemari')->get();
    //     return view('user.product_data', compact('data'));
    // }

    // public function meja()
    // {
    //     $data = Barang::where('jenis', 'meja')->get();
    //     return view('user.product_data', compact('data'));
    // }

    // public function kursi()
    // {
    //     $data = Barang::where('jenis', 'kursi')->get();
    //     return view('user.product_data', compact('data'));
    // }

    public function view($id)
    {
        $data = Barang::find($id);
        Barang::where('id', $id)->update([
            'dilihat' => $data->dilihat + 1
        ]);
        return view('user.view', compact('data'));
    }

    public function view_get($id)
    {
        $data = Barang::find($id);
        return view('user.view_get', compact('data'));
    }

    public function keranjang()
    {
        $total = Keranjang::where('user_id', Auth::user()->id)->sum('total');
        return view('user.keranjang', compact('total'));
    }

    public function keranjang_data()
    {
        $total = Keranjang::where('user_id', Auth::user()->id)->sum('total');
        return view('user.keranjang-data', compact('total'));
    }

    public function tambah_keranjang($id, $jumlah)
    {
        $data_barang = Barang::find($id);
        $total = $data_barang->harga * $jumlah;
        Keranjang::create([
            'user_id' => Auth::user()->id,
            'barang_id' => $id,
            'nama' => $data_barang->nama,
            'harga' => $data_barang->harga,
            'jumlah' => $jumlah,
            'total' => $total,
            'gambar' => $data_barang->gambar,
            'url' => '/produk/' . $id
        ]);
    }

    public function keranjang_produk_update($id, $jumlah)
    {
        $data_keranjang = Keranjang::find($id);
        Keranjang::where('id', $id)->update([
            'jumlah' => $jumlah,
            'total' => $data_keranjang->harga * $jumlah
        ]);

        $total = Keranjang::where('user_id', Auth::user()->id)->sum('total');
        return view('user.keranjang-data', compact('total'));
    }

    public function hapus_keranjang($id)
    {
        Keranjang::where('id', $id)->delete();

        $total = Keranjang::where('user_id', Auth::user()->id)->sum('total');
        return view('user.keranjang-data', compact('total'));
    }

    public function informasi_pesanan()
    {
        if (Auth::user()->keranjang->count() > 0) {
            $total = Keranjang::where('user_id', Auth::user()->id)->sum('total');
            return view('user.informasi-pesanan', compact('total'));
        }

        return redirect('/');
    }

    public function pesanan_proses(Request $request)
    {
        $random = '';
        for ($i = 0; $i < 4; $i++) {
            $angka = random_int(0, 9);
            $random .= $angka;
        }
        $tgl_sekarang = date("md");
        $id_pesanan = Auth::user()->id . $tgl_sekarang . $random;

        $total = Keranjang::where('user_id', Auth::user()->id)->sum('total');

        Pesanan::create([
            'id' => $id_pesanan,
            'user_id' => Auth::user()->id,
            'nama' => $request->nama,
            'telp' => $request->telp,
            'alamat' => $request->alamat,
            'total' => $total,
            'status' => 'menunggu_konfirmasi'
        ]);

        foreach (Auth::user()->keranjang as $k) {
            PesananBarang::create([
                'pesanan_id' => $id_pesanan,
                'barang_id' => $k->barang_id,
                'nama' => $k->nama,
                'harga' => $k->harga,
                'jumlah' => $k->jumlah,
                'jenis_stock' => $k->jenis_stock,
                'total' => $k->total,
                'gambar' => $k->gambar,
                'url' => $k->url
            ]);
        }

        // Kirim notif ke admin
        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true,
        );
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );
        $notif_data = ['pesanan_id' => $id_pesanan];
        $pusher->trigger('admin-channel', 'konfirmasi-pesanan-event', $notif_data);

        Keranjang::where('user_id', Auth::user()->id)->delete();

        return redirect('/pesanan/' . $id_pesanan);
    }

    public function upload_bukti_pembayaran(Request $request)
    {
        $data = Pesanan::find($request->id_pesanan);
        if ($data->status == 'konfirmasi' || $data->status == 'validasi_invalid') {
            // Proses bukti pembayaran
            $fileNameWithExt = $request->file('bukti_pembayaran')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('bukti_pembayaran')->getClientOriginalExtension();
            $request->file('bukti_pembayaran')->move('user/bukti_pembayaran', $fileName . '_' . $data->id . '.' . $extension);
            $bukti_pembayaran = $fileName . '_' . $data->id . '.' . $extension;

            Pesanan::where('id', $request->id_pesanan)->update([
                'status' => 'menunggu_validasi',
                'bukti_pembayaran' => $bukti_pembayaran,
                'menunggu_validasi' => date('Y-m-d H:i:s')
            ]);

            // Kirim notif ke admin
            $options = array(
                'cluster' => 'ap1',
                'useTLS' => true,
            );
            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                $options
            );

            $notif_data = ['pesanan_id' => $request->id_pesanan];
            $pusher->trigger('admin-channel', 'validasi-pembayaran-event', $notif_data);
        }
    }

    public function pesanan()
    {
        return view('user.pesanan');
    }

    public function detail_pesanan($id)
    {
        $data = Pesanan::find($id);
        if ($data == null) {
            return redirect('/');
        } else {
            return view('user.detail-pesanan', compact('data'));
        }
    }

    public function status_pesanan($id)
    {
        $data = Pesanan::find($id);
        return view('user.status-pesanan', compact('data'));
    }

    public function detail_harga($id)
    {
        $pesanan = Pesanan::find($id);
        if ($pesanan->ongkir != null) {
            $pesanan->ongkir = number_format($pesanan->ongkir);
        }
        $pesanan->total = number_format($pesanan->total);

        $pesanan_barang = PesananBarang::where('pesanan_id', $id)->get();
        foreach ($pesanan_barang as $pb) {
            $pb->total = number_format($pb->total);
        }

        $response = [
            "response" => "success",
            "pesanan" => $pesanan,
            "pb" => $pesanan_barang
        ];
        return response()->json($response);
    }

    public function pesanan_batal($id)
    {
        Pesanan::where('id', $id)->delete();
        PesananBarang::where('pesanan_id', $id)->delete();

        return redirect()->back();
    }

    public function pesanan_selesai($id)
    {
        Pesanan::where('id', $id)->update([
            'status' => 'selesai'
        ]);
    }

    public function selesai_pesanan($id)
    {
        Pesanan::where('id', $id)->update([
            'status' => 'selesai'
        ]);

        return redirect()->back();
    }

    public function test()
    {
        // echo intval(str_replace(',', '', $request->total_harga));
        // $barang = Barang::all();
        // foreach ($barang as $key => $value) {
        //     $barang[$key]->gambar = asset('user/barang_img/'.$barang[$key]->gambar);
        // }
        // dd($barang);
    }
}
