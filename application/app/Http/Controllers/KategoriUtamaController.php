<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Validator;
use App\Http\Requests;
use App\Models\KategoriBerita;

class KategoriUtamaController extends Controller
{
  public function lihatkategori()
  {
    if (Auth::user()->level=="1") {
      $getkategori = KategoriBerita::where([['id_skpd', null], ['flag_utama', 1]])->paginate(10);
    } else {
      $getkategori = KategoriBerita::where([['id_skpd', Auth::user()->masterskpd->id], ['flag_utama', 1]])->paginate(10);
    }
    return view('backend/pages/kategoriutama')->with('getkategori', $getkategori);
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
            return redirect()->route('kategoriutama.lihat')
                        ->withErrors($validator)
                        ->withInput();
        }

    if (Auth::user()->level=="1") {
      $set = new KategoriBerita;
      $set->nama_kategori = $request->nama_kategori;
      $set->keterangan_kategori = $request->keterangan_kategori;
      $set->flag_kategori = $request->flag_kategori;
      $set->flag_utama = 1;
      $set->save();
    } else {
      $set = new KategoriBerita;
      $set->nama_kategori = $request->nama_kategori;
      $set->keterangan_kategori = $request->keterangan_kategori;
      $set->id_skpd = Auth::user()->masterskpd->id;
      $set->flag_kategori = $request->flag_kategori;
      $set->flag_utama = 1;
      $set->save();
    }

    return redirect()->route('kategoriutama.lihat')->with('message', 'Berhasil memasukkan kategori untuk informasi utama.');
  }

  public function edit(Request $request)
  {
    $set = KategoriBerita::find($request->id);
    $set->nama_kategori = $request->nama_kategori;
    $set->keterangan_kategori = $request->keterangan_kategori;
    $set->flag_kategori = $request->flag_kategori;
    $set->save();

    return redirect()->route('kategoriutama.lihat')->with('message', 'Berhasil mengubah data kategori informasi utama.');
  }
}
