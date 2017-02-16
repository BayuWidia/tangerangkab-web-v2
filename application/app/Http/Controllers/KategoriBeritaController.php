<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Validator;
use App\Http\Requests;

use App\Models\Berita;
use App\Models\KategoriBerita;

class KategoriBeritaController extends Controller
{
  public function index()
  {
    if (Auth::user()->level=="1") {
      $getkategori = KategoriBerita::where([
        ['id_skpd', null],
        ['flag_utama','!=',1]
      ])->paginate(10);
    } else {
      $getkategori = KategoriBerita::where([
        ['id_skpd', Auth::user()->masterskpd->id],
        ['flag_utama','!=',1]
      ])->paginate(10);
    }

    return view('backend/pages/kategoriberita')->with('getkategori', $getkategori);
  }

  public function store(Request $request)
  {
    $messages = [
      'nama_kategori.required' => 'Tidak boleh kosong.',
      'keterangan_kategori.required' => 'Tidak boleh kosong.'
    ];

    $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required',
            'keterangan_kategori' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return redirect()->route('kategori.index')
                        ->withErrors($validator)
                        ->withInput();
        }

    if (Auth::user()->level=="1") {
      $set = new KategoriBerita;
      $set->nama_kategori = $request->nama_kategori;
      $set->keterangan_kategori = $request->keterangan_kategori;
      $set->flag_kategori = $request->flag_kategori;
      $set->flag_utama = 0;
      $set->save();
    } else {
      $set = new KategoriBerita;
      $set->nama_kategori = $request->nama_kategori;
      $set->keterangan_kategori = $request->keterangan_kategori;
      $set->flag_kategori = $request->flag_kategori;
      $set->id_skpd = Auth::user()->masterskpd->id;
      $set->flag_utama = 0;
      $set->save();
    }
    return redirect()->route('kategori.index')->with('message', 'Berhasil memasukkan data kategori baru.');
  }

  public function changeflag($id)
  {
    $get = KategoriBerita::find($id);

    if($get->flag_kategori=="1") {
      $get->flag_kategori = "0";
    } elseif($get->flag_kategori=="0") {
      $get->flag_kategori = "1";
    }

    $get->save();

    if ($get->flag_utama=="1") {
      return redirect()->route('kategoriutama.lihat')->with('message', 'Berhasil mengubah status kategori.');
    } else {
      return redirect()->route('kategori.index')->with('message', 'Berhasil mengubah status kategori.');
    }
  }

  public function edit(Request $request)
  {
    $set = KategoriBerita::find($request->id);
    $set->nama_kategori = $request->nama_kategori;
    $set->keterangan_kategori = $request->keterangan_kategori;
    $set->flag_kategori = $request->flag_kategori;
    $set->save();

    return redirect()->route('kategori.index')->with('message', 'Berhasil mengubah data kategori berita.');
  }
  public function bind($id)
  {
    $get = KategoriBerita::find($id);
    return $get;
  }
  public function delete($id)
  {
    $check = Berita::where('id_kategori', $id)->first();
    if($check=="") {
      $set = KategoriBerita::find($id);
      $set->delete();

      if ($set->flag_utama=="1") {
        return redirect()->route('kategoriutama.lihat')->with('message', 'Berhasil menghapus data kategori informasi utama.');
      } else {
        return redirect()->route('kategori.index')->with('message', 'Berhasil menghapus data kategori berita.');
      }
    } else {
      $set = KategoriBerita::find($id);

      if ($set->flag_utama=="1") {
        return redirect()->route('kategoriutama.lihat')->with('messagefail', 'Gagal melakukan hapus data. Data kategori berita telah memiliki relasi dengan data yang lain.');
      } else {
        return redirect()->route('kategori.index')->with('messagefail', 'Gagal melakukan hapus data. Data kategori berita telah memiliki relasi dengan data yang lain.');
      }
    }
  }
}
