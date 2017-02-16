<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Image;
use Validator;
use App\Models\Slider;
use App\Http\Requests;

class SliderController extends Controller
{
  public function index()
  {
    if (Auth::user()->level=="1") {
      $getslider = Slider::where('id_skpd', null)->get();
    } else {
      $getslider = Slider::where('id_skpd', Auth::user()->masterskpd->id)->get();
    }

    return view('backend/pages/kelolaslider')->with('getslider', $getslider);
  }

  public function store(Request $request)
  {
    $messages = [
      'keterangan_slider.required' => 'Tidak boleh kosong.',
      'flag_slider.required' => 'Tidak boleh kosong.',
      'url_slider.required' => 'Periksa kembali file image anda.',
      'url_slider.image' => 'File upload harus image.',
      'url_slider.mimes' => 'Ekstensi file tidak valid.',
      'url_slider.max' => 'Ukuran file terlalu besar.',
    ];

    $validator = Validator::make($request->all(), [
            'keterangan_slider' => 'required',
            'flag_slider' => 'required',
            'url_slider' => 'required|image|mimes:jpeg,jpg,png|max:20000',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->route('slider.index')
                        ->withErrors($validator)
                        ->withInput();
        }

    $file = $request->file('url_slider');
    if($file!="") {
      if (Auth::user()->level=="1") {
        $photo_name = time(). '.' . $file->getClientOriginalExtension();
        // Image::make($file)->fit(572,350)->save('images/'. $photo_name);
        Image::make($file)->fit(1144,550)->save('images/'. $photo_name);
        Image::make($file)->fit(200,122)->save('_thumbs/slider/'. $photo_name);

        $set = new Slider;
        $set->url_slider = $photo_name;
        $set->keterangan_slider = $request->keterangan_slider;
        $set->flag_slider = $request->flag_slider;
        $set->save();
      } else {
        $photo_name = time(). '.' . $file->getClientOriginalExtension();
        // Image::make($file)->fit(572,350)->save('images/'. $photo_name);
        Image::make($file)->fit(1144,550)->save('images/'. $photo_name);
        Image::make($file)->fit(200,122)->save('_thumbs/slider/'. $photo_name);

        $set = new Slider;
        $set->url_slider = $photo_name;
        $set->keterangan_slider = $request->keterangan_slider;
        $set->flag_slider = $request->flag_slider;
        $set->id_skpd = Auth::user()->masterskpd->id;
        $set->save();
      }
    } else {
      return redirect()->route('slider.index')->with('messagefail', 'Gambar slider harus di upload.');
    }

    return redirect()->route('slider.index')->with('message', 'Berhasil memasukkan slider baru.');
  }

  public function publish($id)
  {
    $set = Slider::find($id);
    if($set->flag_slider=="1") {
      $set->flag_slider = 0;
      $set->save();
    } elseif ($set->flag_slider=="0") {
      $set->flag_slider = 1;
      $set->save();
    }

    return redirect()->route('slider.index')->with('message', 'Berhasil mengubah status slider.');
  }

  public function bind($id)
  {
    $get = Slider::find($id);
    return $get;
  }

  public function edit(Request $request)
  {
    $file = $request->file('url_slider');
    if($file!="") {
      $photo_name = time(). '.' . $file->getClientOriginalExtension();
      // Image::make($file)->fit(572,350)->save('images/'. $photo_name);
      Image::make($file)->fit(1144,350)->save('images/'. $photo_name);
      Image::make($file)->fit(200,122)->save('_thumbs/slider/'. $photo_name);

      $set = Slider::find($request->id);
      $set->url_slider = $photo_name;
      $set->keterangan_slider = $request->keterangan_slider;
      $set->flag_slider = $request->flag_slider;
      $set->save();
    } else {
      $set = Slider::find($request->id);
      $set->keterangan_slider = $request->keterangan_slider;
      $set->flag_slider = $request->flag_slider;
      $set->save();
    }

    return redirect()->route('slider.index')->with('message', 'Berhasil mengubah konten slider.');
  }
  public function delete($id)
  {
    $set = Slider::find($id);
    $set->delete();

    return redirect()->route('slider.index')->with('message', 'Berhasil menghapus slider.');
  }
}
