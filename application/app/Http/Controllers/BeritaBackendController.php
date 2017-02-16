<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Image;
use Validator;
use App\Http\Requests;
use App\Models\Berita;
use App\Models\KategoriBerita;

class BeritaBackendController extends Controller
{
  public function lihat()
  {
    if (Auth::user()->level=="1") {
      $getberita = Berita::leftjoin('kategori_berita', 'berita.id_kategori', '=', 'kategori_berita.id')
        ->leftjoin('master_skpd', 'berita.id_skpd', '=', 'master_skpd.id')
        ->join('users', 'users.id', '=', 'berita.id_user')
        ->where([
          ['kategori_berita.flag_utama', 0]
        ])
        ->select('berita.flag_headline_utama', 'berita.judul_berita', 'kategori_berita.nama_kategori', 'berita.created_at as tanggal_posting', 'users.name', 'users.email', 'berita.id as id_berita', 'berita.flag_publish', 'master_skpd.nama_skpd', 'berita.flag_headline')
        ->orderby('berita.created_at', 'desc')
        ->get();
    } else {
      $getberita = Berita::join('kategori_berita', 'berita.id_kategori', '=', 'kategori_berita.id')
      ->join('master_skpd', 'berita.id_skpd', '=', 'master_skpd.id')
      ->join('users', 'users.id', '=', 'berita.id_user')
      ->where([
        ['berita.id_skpd', Auth::user()->masterskpd->id],
        ['kategori_berita.flag_utama', 0]
      ])
      ->select('berita.judul_berita', 'kategori_berita.nama_kategori', 'berita.created_at as tanggal_posting', 'users.name', 'users.email', 'berita.id as id_berita', 'berita.flag_publish', 'master_skpd.nama_skpd', 'berita.flag_headline')
      ->orderby('berita.created_at', 'desc')
      ->get();
    }

    return view('backend/pages/lihatberita')->with('getberita', $getberita);
  }

  public function tambah()
  {
    if (Auth::user()->level=="1") {
      $getkategori = KategoriBerita::where([['id_skpd', null], ['flag_utama', 0]])->paginate(10);
    } else {
      $getkategori = KategoriBerita::where([['id_skpd', Auth::user()->masterskpd->id], ['flag_utama', 0]])->paginate(10);
    }

    return view('backend/pages/tambahberita')->with('getkategori', $getkategori);
  }

  public function store(Request $request)
  {
    $messages = [
      'judul_berita.required' => 'Tidak boleh kosong.',
      'id_kategori.required' => 'Tidak boleh kosong.',
      'id_kategori.not_in' => 'Pilih salah satu.',
      'tanggal_posting.required' => 'Tidak boleh kosong.',
      'isi_berita.required' => 'Tidak boleh kosong.',
      'url_foto.required' => 'Periksa kembali file image anda.',
      'url_foto.image' => 'File upload harus image.',
      'url_foto.mimes' => 'Ekstensi file tidak valid.',
      'url_foto.max' => 'Ukuran file terlalu besar.',
      'tags.required' => 'Tidak boleh kosong.'
    ];

    $validator = Validator::make($request->all(), [
            'judul_berita' => 'required',
            'id_kategori' => 'required|not_in:-- Pilih --',
            'tanggal_posting' => 'required',
            'isi_berita' => 'required',
            'url_foto' => 'required|image|mimes:jpeg,jpg,png|max:20000',
            'tags' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->route('berita.tambah')
                        ->withErrors($validator)
                        ->withInput();
        }

    $file = $request->file('url_foto');
    if ($file!=null) {
      $photo_name = time(). '.' . $file->getClientOriginalExtension();

      $photo1 = explode('.', $photo_name);
      $photo350 = $photo1[0]."_350x448.".$photo1[1];
      $photo270 = $photo1[0]."_270x225.".$photo1[1];
      $photo95 = $photo1[0]."_95x95.".$photo1[1];
      $photo871 = $photo1[0]."_871x497.".$photo1[1];
      $photo450 = $photo1[0]."_450x258.".$photo1[1];

      Image::make($file)->fit(472,270)->save('images/'. $photo_name);
      Image::make($file)->fit(350,448)->save('images/'. $photo350);
      Image::make($file)->fit(270,225)->save('images/'. $photo270);
      Image::make($file)->fit(95,95)->save('images/'. $photo95);
      Image::make($file)->fit(871,497)->save('images/'. $photo871);
      Image::make($file)->fit(450,258)->save('images/'. $photo450);

      if (Auth::user()->level=="1") {
        $set = new Berita;
        $set->id_kategori = $request->id_kategori;

        $valheadline="";
        if($request->flag_headline=="") {
          $valheadline=0;
        } else {
          $valheadline=1;
        }

        $set->flag_headline_utama = $valheadline;
        $set->flag_headline = 0;
        $set->id_user = Auth::user()->id;
        $set->url_foto = $photo_name;
        $set->judul_berita = $request->judul_berita;
        $set->tags = $request->tags;
        $set->isi_berita = $request->isi_berita;
        $set->save();
      } else {
        $set = new Berita;
        $set->id_kategori = $request->id_kategori;
        $set->id_skpd = Auth::user()->masterskpd->id;

        $valheadline="";
        if($request->flag_headline=="") {
          $valheadline=0;
        } else {
          $valheadline=1;
        }

        $set->flag_headline = $valheadline;
        $set->id_user = Auth::user()->id;
        $set->url_foto = $photo_name;
        $set->judul_berita = $request->judul_berita;
        $set->tags = $request->tags;
        $set->isi_berita = $request->isi_berita;
        $set->save();
      }
    } else {
      return redirect()->route('berita.tambah')->with('messagefail', 'Foto header tidak boleh kosong.');
    }

    return redirect()->route('berita.tambah')->with('message', 'Berhasil menambahkan konten berita baru.');
  }

  public function edit($id)
  {
    $editberita = Berita::find($id);

    if (Auth::user()->level=="1") {
      $getkategori = KategoriBerita::where([['id_skpd', $editberita->id_skpd], ['flag_utama', 0]])->paginate(10);
      // dd($getkategori);
    } else {
      $getkategori = KategoriBerita::where([['id_skpd', Auth::user()->masterskpd->id], ['flag_utama', 0]])->paginate(10);
    }

    return view('backend/pages/tambahberita')
      ->with('getkategori', $getkategori)
      ->with('editberita', $editberita);
  }

  public function update(Request $request)
  {
    $file = $request->file('url_foto');
    if ($file!=null) {
      $messages = [
        'judul_berita.required' => 'Tidak boleh kosong.',
        'id_kategori.required' => 'Tidak boleh kosong.',
        'id_kategori.not_in' => 'Pilih salah satu.',
        'tanggal_posting.required' => 'Tidak boleh kosong.',
        'isi_berita.required' => 'Tidak boleh kosong.',
        'url_foto.required' => 'Periksa kembali file image anda.',
        'url_foto.image' => 'File upload harus image.',
        'url_foto.mimes' => 'Ekstensi file tidak valid.',
        'url_foto.max' => 'Ukuran file terlalu besar.',
        'tags.required' => 'Tidak boleh kosong.'
      ];

      $validator = Validator::make($request->all(), [
              'judul_berita' => 'required',
              'id_kategori' => 'required|not_in:-- Pilih --',
              'tanggal_posting' => 'required',
              'isi_berita' => 'required',
              'url_foto' => 'required|image|mimes:jpeg,jpg,png|max:20000',
              'tags' => 'required',
          ], $messages);

          if ($validator->fails()) {
              return redirect()->route('berita.edit', $request->id)
                          ->withErrors($validator)
                          ->withInput();
          }

      $photo_name = time(). '.' . $file->getClientOriginalExtension();

      $photo1 = explode('.', $photo_name);
      $photo350 = $photo1[0]."_350x448.".$photo1[1];
      $photo270 = $photo1[0]."_270x225.".$photo1[1];
      $photo95 = $photo1[0]."_95x95.".$photo1[1];
      $photo871 = $photo1[0]."_871x497.".$photo1[1];
      $photo450 = $photo1[0]."_450x258.".$photo1[1];

      Image::make($file)->fit(472,270)->save('images/'. $photo_name);
      Image::make($file)->fit(350,448)->save('images/'. $photo350);
      Image::make($file)->fit(270,225)->save('images/'. $photo270);
      Image::make($file)->fit(95,95)->save('images/'. $photo95);
      Image::make($file)->fit(871,497)->save('images/'. $photo871);
      Image::make($file)->fit(450,258)->save('images/'. $photo450);

      if (Auth::user()->level=="1") {
        $set = Berita::find($request->id);
        $set->id_kategori = $request->id_kategori;

        $valheadline="";
        if($request->flag_headline=="") {
          $valheadline=0;
        } else {
          $valheadline=1;
        }

        $set->flag_headline_utama = $valheadline;
        $set->url_foto = $photo_name;
        $set->judul_berita = $request->judul_berita;
        $set->tags = $request->tags;
        $set->isi_berita = $request->isi_berita;
        $set->save();
      } else {
        $set = Berita::find($request->id);
        $set->id_kategori = $request->id_kategori;

        $valheadline="";
        if($request->flag_headline=="") {
          $valheadline=0;
        } else {
          $valheadline=1;
        }

        $set->flag_headline = $valheadline;
        $set->url_foto = $photo_name;
        $set->judul_berita = $request->judul_berita;
        $set->tags = $request->tags;
        $set->isi_berita = $request->isi_berita;
        $set->save();
      }
    } else {

      $messages = [
        'judul_berita.required' => 'Tidak boleh kosong.',
        'id_kategori.required' => 'Tidak boleh kosong.',
        'id_kategori.not_in' => 'Pilih salah satu.',
        'tanggal_posting.required' => 'Tidak boleh kosong.',
        'isi_berita.required' => 'Tidak boleh kosong.',
        'tags.required' => 'Tidak boleh kosong.'
      ];

      $validator = Validator::make($request->all(), [
              'judul_berita' => 'required',
              'id_kategori' => 'required|not_in:-- Pilih --',
              'tanggal_posting' => 'required',
              'isi_berita' => 'required',
              'tags' => 'required',
          ], $messages);

          if ($validator->fails()) {
              return redirect()->route('berita.edit', $request->id)
                          ->withErrors($validator)
                          ->withInput();
          }

      if (Auth::user()->level=="1") {
        $set = Berita::find($request->id);
        $set->id_kategori = $request->id_kategori;

        $valheadline="";
        if($request->flag_headline=="") {
          $valheadline=0;
        } else {
          $valheadline=1;
        }

        $set->flag_headline_utama = $valheadline;
        $set->judul_berita = $request->judul_berita;
        $set->tags = $request->tags;
        $set->isi_berita = $request->isi_berita;
        $set->save();
      } else {
        $set = Berita::find($request->id);
        $set->id_kategori = $request->id_kategori;

        $valheadline="";
        if($request->flag_headline=="") {
          $valheadline=0;
        } else {
          $valheadline=1;
        }

        $set->flag_headline = $valheadline;
        $set->judul_berita = $request->judul_berita;
        $set->tags = $request->tags;
        $set->isi_berita = $request->isi_berita;
        $set->save();
      }
    }

    return redirect()->route('berita.tambah')->with('message', 'Berhasil mengubah konten berita.');
  }

  public function flagpublish($id)
  {
    $set = Berita::find($id);
    if($set->flag_publish=="1") {
      $set->tanggal_publish = date('Y-m-d');
      $set->flag_publish = 0;
      $set->save();
    } elseif ($set->flag_publish=="0") {
      $set->tanggal_publish = date('Y-m-d');
      $set->flag_publish = 1;
      $set->save();
    }

    return redirect()->route('berita.lihat')->with('message', 'Berhasil mengubah status publikasi berita.');
  }

  public function headlineutama($id)
  {
    $set = Berita::find($id);
    if($set->flag_headline_utama=="1") {
      $set->flag_headline_utama = 0;
      $set->save();
    } elseif ($set->flag_headline_utama=="0") {
      $set->flag_headline_utama = 1;
      $set->save();
    }

    return redirect()->route('berita.lihat')->with('message', 'Berhasil mengubah status headline utama.');
  }

  public function delete($id)
  {
    $set = Berita::find($id);
    $set->delete();

    return redirect()->route('berita.lihat')->with('message', 'Berhasil menghapus konten berita.');
  }

  public function preview($id)
  {
    $getberita = Berita::leftjoin('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->leftjoin('users', 'users.id', '=', 'berita.id_user')
      ->leftjoin('master_skpd', 'master_skpd.id', '=', 'berita.id_skpd')
      ->select('berita.flag_publish', 'users.url_foto as foto_user', 'berita.judul_berita', 'kategori_berita.nama_kategori', 'master_skpd.nama_skpd', 'berita.created_at as tanggal_posting', 'berita.isi_berita', 'berita.id as id_berita')
      ->where('berita.id', $id)
      ->first();

    return view('backend/pages/previewkonten')->with('getberita', $getberita);
  }
}
