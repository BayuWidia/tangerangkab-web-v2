<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use Image;
use App\Models\MediaPromosi;

class MediaPromosiController extends Controller
{
  public function index()
  {
    if (Auth::user()->level=="1") {
      $getdata = MediaPromosi::where('id_skpd', null)->get();
    } else {
      $getdata = MediaPromosi::where('id_skpd', Auth::user()->masterskpd->id)->get();
    }

    return view('backend/pages/kelolamediapromosi')->with('getdata', $getdata);
  }

  public function store(Request $request)
  {
    $file = $request->file('url_foto');
    if($file!="") {
      if (Auth::user()->level=="1") {
        $photo_name = time(). '.' . $file->getClientOriginalExtension();

        Image::make($file)->resize(250, null, function($constraint){
          $constraint->aspectRatio();
        })->save('images/'. $photo_name);

        $set = new MediaPromosi;
        $set->id_user = Auth::user()->id;
        $set->nama_promosi = $request->nama_promosi;
        $set->link = $request->link;
        $set->url_foto = $photo_name;
        $set->flag_aktif = $request->flag_aktif;
        $set->save();
      } else {
        $photo_name = time(). '.' . $file->getClientOriginalExtension();

        Image::make($file)->resize(250, null, function($constraint){
          $constraint->aspectRatio();
        })->save('images/'. $photo_name);

        $set = new MediaPromosi;
        $set->id_skpd = Auth::user()->masterskpd->id;
        $set->id_user = Auth::user()->id;
        $set->nama_promosi = $request->nama_promosi;
        $set->link = $request->link;
        $set->url_foto = $photo_name;
        $set->flag_aktif = $request->flag_aktif;
        $set->save();
      }
    }

    return redirect()->route('media-promosi.index')->with('message', 'Berhasil memasukkan promosi baru.');
  }

  public function edit(Request $request)
  {
    //dd($request);
    $file = $request->file('url_foto');
    if($file!="") {
      if (Auth::user()->level=="1") {
        $photo_name = time(). '.' . $file->getClientOriginalExtension();

        Image::make($file)->resize(250, null, function($constraint){
          $constraint->aspectRatio();
        })->save('images/'. $photo_name);

        $set = MediaPromosi::find($request->id);
        $set->nama_promosi = $request->nama_promosi;
        $set->link = $request->link;
        $set->url_foto = $photo_name;
        $set->flag_aktif = $request->flag_aktif;
        $set->id_user = Auth::user()->id;
        $set->save();
      } else {
        $photo_name = time(). '.' . $file->getClientOriginalExtension();

        Image::make($file)->resize(250, null, function($constraint){
          $constraint->aspectRatio();
        })->save('images/'. $photo_name);

        $set = MediaPromosi::find($request->id);
        $set->nama_promosi = $request->nama_promosi;
        $set->link = $request->link;
        $set->url_foto = $photo_name;
        $set->flag_aktif = $request->flag_aktif;
        $set->id_skpd = Auth::user()->masterskpd->id;
        $set->id_user = Auth::user()->id;
        $set->save();
      }
    } else {
      if (Auth::user()->level=="1") {
        $set = MediaPromosi::find($request->id);
        $set->nama_promosi = $request->nama_promosi;
        $set->link = $request->link;
        $set->flag_aktif = $request->flag_aktif;
        $set->id_user = Auth::user()->id;
        $set->save();
      } else {
        $set = MediaPromosi::find($request->id);
        $set->nama_promosi = $request->nama_promosi;
        $set->link = $request->link;
        $set->flag_aktif = $request->flag_aktif;
        $set->id_skpd = Auth::user()->masterskpd->id;
        $set->id_user = Auth::user()->id;
        $set->save();
      } 
    }
   
    return redirect()->route('media-promosi.index')->with('message', 'Berhasil mengubah data promosi.');
  }

  public function publish($id)
  {
    $set = MediaPromosi::find($id);
    if($set->flag_aktif=="1") {
      $set->flag_aktif = 0;
      $set->save();
    } elseif ($set->flag_aktif=="0") {
      $set->flag_aktif = 1;
      $set->save();
    }

    return redirect()->route('media-promosi.index')->with('message', 'Berhasil mengubah status promosi.');
  }


  public function delete($id)
  {
    $find = MediaPromosi::find($id);
    $find->delete();

    return redirect()->route('media-promosi.index')->with('message', 'Berhasil menghapus data.');
  }

  public function bind($id)
  {
    $find = MediaPromosi::find($id);
    return $find;
  }
}
