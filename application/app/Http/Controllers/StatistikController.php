<?php

namespace App\Http\Controllers;

use Auth;
use Image;
use Validator;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Statistik;

class StatistikController extends Controller
{
  public function index()
  {
    if (Auth::user()->level=="1") {
      $getapps = Statistik::where('id_skpd', null)->get();
    } else {
      $getapps = Statistik::where('id_skpd', Auth::user()->masterskpd->id)->get();
    }

    return view('backend/pages/kelolastatistik')->with('getapps', $getapps);
  }

  public function store(Request $request)
  {
    $messages = [
      'nama_statistik.required' => 'Tidak boleh kosong.',
      'link_statistik.required' => 'Tidak boleh kosong.',
      'url_logo.required' => 'Periksa kembali file image anda.',
      'url_logo.image' => 'File upload harus image.',
      'url_logo.mimes' => 'Ekstensi file tidak valid.',
      'url_logo.max' => 'Ukuran file terlalu besar.',
    ];

    $validator = Validator::make($request->all(), [
            'nama_statistik' => 'required',
            'link_statistik' => 'required',
            'url_logo' => 'required|image|mimes:jpeg,jpg,png|max:20000',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->route('statistik.index')
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

        $set = new Statistik;
        $set->nama_statistik = $request->nama_statistik;
        $set->link_statistik = $request->link_statistik;
        $set->flag_statistik = $request->flag_statistik;
        $set->url_logo = $photo;
        $set->save();
      } else {
        $photo = time().".".$file->getClientOriginalExtension();

        $photo1 = explode('.', $photo);
        $photo200 = $photo1[0]."_200x122.".$photo1[1];

        Image::make($file)->fit(263,150)->save('images/'. $photo);
        Image::make($file)->fit(200,122)->save('images/'. $photo200);

        $set = new Statistik;
        $set->nama_statistik = $request->nama_statistik;
        $set->link_statistik = $request->link_statistik;
        $set->flag_statistik = $request->flag_statistik;
        $set->url_logo = $photo;
        $set->id_skpd = Auth::user()->masterskpd->id;
        $set->save();
      }
    } else {
      if (Auth::user()->level=="1") {
        $set = new Statistik;
        $set->nama_statistik = $request->nama_statistik;
        $set->link_statistik = $request->link_statistik;
        $set->flag_statistik = $request->flag_statistik;
        $set->save();
      } else {
        $set = new Statistik;
        $set->nama_statistik = $request->nama_statistik;
        $set->link_statistik = $request->link_statistik;
        $set->flag_statistik = $request->flag_statistik;
        $set->id_skpd = Auth::user()->masterskpd->id;
        $set->save();
      }
    }

    return redirect()->route('statistik.index')->with('message', "Berhasil memasukkan data statistik baru.");
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

        $set = Statistik::find($request->id);
        $set->nama_statistik = $request->nama_statistik;
        $set->link_statistik = $request->link_statistik;
        $set->flag_statistik = $request->flag_statistik;
        $set->url_logo = $photo;
        $set->save();
      } else {
        $photo = time().".".$file->getClientOriginalExtension();

        $photo1 = explode('.', $photo);
        $photo200 = $photo1[0]."_200x122.".$photo1[1];

        Image::make($file)->fit(263,150)->save('images/'. $photo);
        Image::make($file)->fit(200,122)->save('images/'. $photo200);

        $set = Statistik::find($request->id);
        $set->nama_statistik = $request->nama_statistik;
        $set->link_statistik = $request->link_statistik;
        $set->flag_statistik = $request->flag_statistik;
        $set->url_logo = $photo;
        $set->id_skpd = Auth::user()->masterskpd->id;
        $set->save();
      }
    } else {
      if (Auth::user()->level=="1") {
        $set = Statistik::find($request->id);
        $set->nama_statistik = $request->nama_statistik;
        $set->link_statistik = $request->link_statistik;
        $set->flag_statistik = $request->flag_statistik;
        $set->save();
      } else {
        $set = Statistik::find($request->id);
        $set->nama_statistik = $request->nama_statistik;
        $set->link_statistik = $request->link_statistik;
        $set->flag_statistik = $request->flag_statistik;
        $set->id_skpd = Auth::user()->masterskpd->id;
        $set->save();
      }
    }

    return redirect()->route('statistik.index')->with('message', "Berhasil mengubah data statistik.");
  }

  public function bind($id)
  {
    $get = Statistik::find($id);
    return $get;
  }

  public function delete($id)
  {
    $set = Statistik::find($id);
    $set->delete();

    return redirect()->route('statistik.index')->with('message', 'Berhasil menghapus data statistik.');
  }

  public function publish($id)
  {
    $set = Statistik::find($id);
    if($set->flag_statistik=="1") {
      $set->flag_statistik = 0;
      $set->save();
    } elseif ($set->flag_statistik=="0") {
      $set->flag_statistik = 1;
      $set->save();
    }

    return redirect()->route('statistik.index')->with('message', 'Berhasil mengubah status statistik.');
  }
}
