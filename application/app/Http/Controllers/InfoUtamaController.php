<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Http\Requests;

use App\Models\Berita;
use App\Models\KategoriBerita;
use Validator;

class InfoUtamaController extends Controller
{
  public function lihat()
  {
    if (Auth::user()->level=="1") {
      $getinfoutama = Berita::join('kategori_berita', 'berita.id_kategori', '=', 'kategori_berita.id')
        ->where([
          ['berita.id_skpd', null],
          ['kategori_berita.flag_utama', 1]
        ])->select('*', 'berita.id as id_berita', 'berita.created_at as tanggal_posting')->get();
    } else {
      $getinfoutama = Berita::join('kategori_berita', 'berita.id_kategori', '=', 'kategori_berita.id')
          ->where([
            ['berita.id_skpd', Auth::user()->masterskpd->id],
            ['kategori_berita.flag_utama', 1]
          ])->select('*', 'berita.id as id_berita', 'berita.created_at as tanggal_posting')->get();
    }

    return view('backend/pages/lihatinfoutama')->with('getinfoutama', $getinfoutama);
  }

  public function tambah()
  {
    if (Auth::user()->level=="1") {
      $getkategori = KategoriBerita::where([['id_skpd', null], ['flag_utama', 1]])->paginate(10);
    } else {
      $getkategori = KategoriBerita::where([['id_skpd', Auth::user()->masterskpd->id], ['flag_utama', 1]])->paginate(10);
    }

    return view('backend/pages/tambahinfoutama')->with('getkategori', $getkategori);
  }

  public function store(Request $request)
  {
    $messages = [
      'tanggal_posting.required' => 'Tidak boleh kosong.',
      'isi_berita.required' => 'Tidak boleh kosong.',
      'id_kategori.required' => 'Tidak boleh kosong.',
      'id_kategori.not_in' => 'Pilih salah satu.'
    ];

    $validator = Validator::make($request->all(), [
            'tanggal_posting' => 'required',
            'isi_berita' => 'required',
            'id_kategori' => 'required|not_in:-- Pilih --'
        ], $messages);

        if ($validator->fails()) {
            return redirect()->route('infoutama.tambah')
                        ->withErrors($validator)
                        ->withInput();
        }


    if (Auth::user()->level=="1") {
      $set = new Berita;
      $set->id_kategori = $request->id_kategori;
      $set->isi_berita = $request->isi_berita;
      $set->id_user = Auth::user()->id;
      $set->save();
    } else {
      $set = new Berita;
      $set->id_kategori = $request->id_kategori;
      $set->isi_berita = $request->isi_berita;
      $set->id_skpd = Auth::user()->masterskpd->id;
      $set->id_user = Auth::user()->id;
      $set->save();
    }

    return redirect()->route('infoutama.tambah')->with('message', 'Berhasil memasukkan konten informasi utama.');
  }

  public function flagpublish($id)
  {
    $set = Berita::find($id);
    if($set->flag_publish=="1") {
      $set->flag_publish = 0;
      $set->save();
    } elseif ($set->flag_publish=="0") {
      $set->flag_publish = 1;
      $set->save();
    }

    return redirect()->route('infoutama.lihat')->with('message', 'Berhasil mengubah status publikasi.');
  }

  public function edit($id)
  {
    $editinfo = Berita::find($id);

    if (Auth::user()->level=="1") {
      $getkategori = KategoriBerita::where([['id_skpd', null], ['flag_utama', 1]])->paginate(10);
    } else {
      $getkategori = KategoriBerita::where([['id_skpd', Auth::user()->masterskpd->id], ['flag_utama', 1]])->paginate(10);
    }

    return view('backend/pages/tambahinfoutama', compact('editinfo', 'getkategori'));
  }

  public function update(Request $request, $id)
  {
    $messages = [
      'tanggal_posting.required' => 'Tidak boleh kosong.',
      'isi_berita.required' => 'Tidak boleh kosong.',
      'id_kategori.required' => 'Tidak boleh kosong.',
      'id_kategori.not_in' => 'Pilih salah satu.'
    ];

    $validator = Validator::make($request->all(), [
            'tanggal_posting' => 'required',
            'isi_berita' => 'required',
            'id_kategori' => 'required|not_in:-- Pilih --'
        ], $messages);

        if ($validator->fails()) {
            return redirect()->route('infoutama.edit', $id)
                        ->withErrors($validator)
                        ->withInput();
        }

    if (Auth::user()->level=="1") {
      $set = Berita::find($id);
      $set->id_kategori = $request->id_kategori;
      $set->isi_berita = $request->isi_berita;
      $set->save();
    } else {
      $set = Berita::find($id);
      $set->id_kategori = $request->id_kategori;
      $set->isi_berita = $request->isi_berita;
      $set->id_skpd = Auth::user()->masterskpd->id;
      $set->save();
    }

    return redirect()->route('infoutama.lihat')->with('message', 'Berhasil mengubah konten informasi utama.');
  }

  public function delete($id)
  {
    $set = Berita::find($id);
    $set->delete();

    return redirect()->route('infoutama.lihat')->with('message', 'Berhasil menghapus konten informasi utama.');
  }
}
