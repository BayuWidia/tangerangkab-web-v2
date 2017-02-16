<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Image;
use Validator;
use App\Http\Requests;
use App\Models\Gallery;

class GalleryController extends Controller
{
  public function index()
  {
    if (Auth::user()->level=="1") {
      $getgaleri = Gallery::where('id_skpd', null)->limit(9)->get();
    } else {
      $getgaleri = Gallery::where('id_skpd', Auth::user()->masterskpd->id)->limit(9)->get();
    }

    return view('backend/pages/kelolagaleri')->with('getgaleri', $getgaleri);
  }

  public function store(Request $request)
  {
    $messages = [
      'keterangan_gambar.required' => 'Tidak boleh kosong.',
      'flag_gambar.required' => 'Tidak boleh kosong.',
      'url_gambar.required' => 'Periksa kembali file image anda.',
      'url_gambar.image' => 'File upload harus image.',
      'url_gambar.mimes' => 'Ekstensi file tidak valid.',
      'url_gambar.max' => 'Ukuran file terlalu besar.',
    ];

    $validator = Validator::make($request->all(), [
            'keterangan_gambar' => 'required',
            'flag_gambar' => 'required',
            'url_gambar' => 'required|image|mimes:jpeg,jpg,png|max:20000',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->route('galeri.index')
                        ->withErrors($validator)
                        ->withInput();
        }

    $file = $request->file('url_gambar');
    if($file!="") {
      if (Auth::user()->level=="1") {
        $photo_name = time(). '.' . $file->getClientOriginalExtension();

        $photo1 = explode('.', $photo_name);
        $photo40 = $photo1[0]."_40x40.".$photo1[1];
        $photo200 = $photo1[0]."_200x122.".$photo1[1];

        Image::make($file)->fit(570,325)->save('images/'. $photo_name);
        Image::make($file)->fit(40,40)->save('images/'. $photo40);
        Image::make($file)->fit(200,122)->save('images/'. $photo200);

        $set = new Gallery;
        $set->url_gambar = $photo_name;
        $set->keterangan_gambar = $request->keterangan_gambar;
        $set->flag_gambar = $request->flag_gambar;
        $set->save();
      } else {
        $photo_name = time(). '.' . $file->getClientOriginalExtension();

        $photo1 = explode('.', $photo_name);
        $photo40 = $photo1[0]."_40x40.".$photo1[1];
        $photo200 = $photo1[0]."_200x122.".$photo1[1];

        Image::make($file)->fit(570,325)->save('images/'. $photo_name);
        Image::make($file)->fit(40,40)->save('images/'. $photo40);
        Image::make($file)->fit(200,122)->save('images/'. $photo200);

        $set = new Gallery;
        $set->url_gambar = $photo_name;
        $set->keterangan_gambar = $request->keterangan_gambar;
        $set->flag_gambar = $request->flag_gambar;
        $set->id_skpd = Auth::user()->masterskpd->id;
        $set->save();
      }
    } else {
      return redirect()->route('galeri.index')->with('messagefail', 'Gambar galeri harus di upload.');
    }

    return redirect()->route('galeri.index')->with('message', 'Berhasil memasukkan galeri baru.');
  }

  public function publish($id)
  {
    $set = Gallery::find($id);
    if($set->flag_gambar=="1") {
      $set->flag_gambar = 0;
      $set->save();
    } elseif ($set->flag_gambar=="0") {
      $set->flag_gambar = 1;
      $set->save();
    }

    return redirect()->route('galeri.index')->with('message', 'Berhasil mengubah status gambar.');
  }

  public function bind($id)
  {
    $get = Gallery::find($id);
    return $get;
  }

  public function edit(Request $request)
  {
    $file = $request->file('url_gambar');
    if($file!="") {
      $photo_name = time(). '.' . $file->getClientOriginalExtension();

      $photo1 = explode('.', $photo_name);
      $photo40 = $photo1[0]."_40x40.".$photo1[1];
      $photo200 = $photo1[0]."_200x122.".$photo1[1];

      Image::make($file)->fit(570,325)->save('images/'. $photo_name);
      Image::make($file)->fit(40,40)->save('images/'. $photo40);
      Image::make($file)->fit(200,122)->save('images/'. $photo200);

      $set = Gallery::find($request->id);
      $set->url_gambar = $photo_name;
      $set->keterangan_gambar = $request->keterangan_gambar;
      $set->flag_gambar = $request->flag_gambar;
      $set->save();
    } else {
      $set = Gallery::find($request->id);
      $set->keterangan_gambar = $request->keterangan_gambar;
      $set->flag_gambar = $request->flag_gambar;
      $set->save();
    }

    return redirect()->route('galeri.index')->with('message', 'Berhasil mengubah konten galeri.');
  }
  public function delete($id)
  {
    $set = Gallery::find($id);
    $set->delete();

    return redirect()->route('galeri.index')->with('message', 'Berhasil menghapus gambar.');
  }
}
