<?php

namespace App\Http\Controllers;

use Auth;
use Image;
use Validator;
use App\Http\Requests;
use App\Models\Aplikasi;
use Illuminate\Http\Request;

class AplikasiController extends Controller
{
  public function index()
  {
    if (Auth::user()->level=="1") {
      $getapps = Aplikasi::where('id_skpd', null)->get();
    } else {
      $getapps = Aplikasi::where('id_skpd', Auth::user()->masterskpd->id)->get();
    }

    return view('backend/pages/kelolaaplikasi')->with('getapps', $getapps);
  }

  public function store(Request $request)
  {
    $messages = [
      'nama_aplikasi.required' => 'Tidak boleh kosong.',
      'domain_aplikasi.required' => 'Tidak boleh kosong.',
      'keterangan_aplikasi.required' => 'Tidak boleh kosong.',
      'url_logo.required' => 'Periksa kembali file image anda.',
      'url_logo.image' => 'File upload harus image.',
      'url_logo.mimes' => 'Ekstensi file tidak valid.',
      'url_logo.max' => 'Ukuran file terlalu besar.',
    ];

    $validator = Validator::make($request->all(), [
            'nama_aplikasi' => 'required',
            'domain_aplikasi' => 'required',
            'keterangan_aplikasi' => 'required',
            'url_logo' => 'required|image|mimes:jpeg,jpg,png|max:20000',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->route('aplikasi.index')
                        ->withErrors($validator)
                        ->withInput();
        }

    $file = $request->file('url_logo');
    if ($file!=null) {
      if (Auth::user()->level=="1") {
        $photo = time().".".$file->getClientOriginalExtension();

        $photo1 = explode('.', $photo);
        $photo200 = $photo1[0]."_200x122.".$photo1[1];

        Image::make($file)->fit(263,150)->save('images/'. $photo);
        Image::make($file)->fit(200,122)->save('images/'. $photo200);

        $set = new Aplikasi;
        $set->nama_aplikasi = $request->nama_aplikasi;
        $set->domain_aplikasi = $request->domain_aplikasi;
        $set->keterangan_aplikasi = $request->keterangan_aplikasi;
        $set->flag_aplikasi = $request->flag_aplikasi;
        $set->url_logo = $photo;
        $set->save();
      } else {
        $photo = time().".".$file->getClientOriginalExtension();

        $photo1 = explode('.', $photo);
        $photo200 = $photo1[0]."_200x122.".$photo1[1];

        Image::make($file)->fit(263,150)->save('images/'. $photo);
        Image::make($file)->fit(200,122)->save('images/'. $photo200);

        $set = new Aplikasi;
        $set->nama_aplikasi = $request->nama_aplikasi;
        $set->domain_aplikasi = $request->domain_aplikasi;
        $set->keterangan_aplikasi = $request->keterangan_aplikasi;
        $set->flag_aplikasi = $request->flag_aplikasi;
        $set->url_logo = $photo;
        $set->id_skpd = Auth::user()->masterskpd->id;
        $set->save();
      }
    } else {
      if (Auth::user()->level=="1") {
        $set = new Aplikasi;
        $set->nama_aplikasi = $request->nama_aplikasi;
        $set->domain_aplikasi = $request->domain_aplikasi;
        $set->keterangan_aplikasi = $request->keterangan_aplikasi;
        $set->flag_aplikasi = $request->flag_aplikasi;
        $set->save();
      } else {
        $set = new Aplikasi;
        $set->nama_aplikasi = $request->nama_aplikasi;
        $set->domain_aplikasi = $request->domain_aplikasi;
        $set->keterangan_aplikasi = $request->keterangan_aplikasi;
        $set->flag_aplikasi = $request->flag_aplikasi;
        $set->id_skpd = Auth::user()->masterskpd->id;
        $set->save();
      }
    }

    return redirect()->route('aplikasi.index')->with('message', "Berhasil memasukkan data aplikasi baru.");
  }

  public function edit(Request $request)
  {
    $file = $request->file('url_logo');
    if ($file!=null) {
      if (Auth::user()->level=="1") {
        $photo = time().".".$file->getClientOriginalExtension();

        $photo1 = explode('.', $photo);
        $photo200 = $photo1[0]."_200x122.".$photo1[1];

        Image::make($file)->fit(263,150)->save('images/'. $photo);
        Image::make($file)->fit(200,122)->save('images/'. $photo200);

        $set = Aplikasi::find($request->id);
        $set->nama_aplikasi = $request->nama_aplikasi;
        $set->domain_aplikasi = $request->domain_aplikasi;
        $set->keterangan_aplikasi = $request->keterangan_aplikasi;
        $set->flag_aplikasi = $request->flag_aplikasi;
        $set->url_logo = $photo;
        $set->save();
      } else {
        $photo = time().".".$file->getClientOriginalExtension();

        $photo1 = explode('.', $photo);
        $photo200 = $photo1[0]."_200x122.".$photo1[1];

        Image::make($file)->fit(263,150)->save('images/'. $photo);
        Image::make($file)->fit(200,122)->save('images/'. $photo200);

        $set = Aplikasi::find($request->id);
        $set->nama_aplikasi = $request->nama_aplikasi;
        $set->domain_aplikasi = $request->domain_aplikasi;
        $set->keterangan_aplikasi = $request->keterangan_aplikasi;
        $set->flag_aplikasi = $request->flag_aplikasi;
        $set->url_logo = $photo;
        $set->id_skpd = Auth::user()->masterskpd->id;
        $set->save();
      }
    } else {
      if (Auth::user()->level=="1") {
        $set = Aplikasi::find($request->id);
        $set->nama_aplikasi = $request->nama_aplikasi;
        $set->domain_aplikasi = $request->domain_aplikasi;
        $set->keterangan_aplikasi = $request->keterangan_aplikasi;
        $set->flag_aplikasi = $request->flag_aplikasi;
        $set->save();
      } else {
        $set = Aplikasi::find($request->id);
        $set->nama_aplikasi = $request->nama_aplikasi;
        $set->domain_aplikasi = $request->domain_aplikasi;
        $set->keterangan_aplikasi = $request->keterangan_aplikasi;
        $set->flag_aplikasi = $request->flag_aplikasi;
        $set->id_skpd = Auth::user()->masterskpd->id;
        $set->save();
      }
    }

    return redirect()->route('aplikasi.index')->with('message', "Berhasil mengubah data aplikasi.");
  }

  public function bind($id)
  {
    $get = Aplikasi::find($id);
    return $get;
  }

  public function delete($id)
  {
    $set = Aplikasi::find($id);
    $set->delete();

    return redirect()->route('aplikasi.index')->with('message', 'Berhasil menghapus data aplikasi.');
  }

  public function publish($id)
  {
    $set = Aplikasi::find($id);
    if($set->flag_aplikasi=="1") {
      $set->flag_aplikasi = 0;
      $set->save();
    } elseif ($set->flag_aplikasi=="0") {
      $set->flag_aplikasi = 1;
      $set->save();
    }

    return redirect()->route('aplikasi.index')->with('message', 'Berhasil mengubah status aplikasi.');
  }
}
