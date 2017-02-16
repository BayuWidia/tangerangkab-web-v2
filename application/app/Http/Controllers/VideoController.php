<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use App\Models\Video;
use App\Http\Requests;
use Illuminate\Http\Request;

class VideoController extends Controller
{
  public function index()
  {
    if (Auth::user()->level=="1") {
      $getvideo = Video::where('id_skpd', null)->orderby('created_at', 'desc')->get();
    } else {
      $getvideo = Video::where('id_skpd', Auth::user()->masterskpd->id)->orderby('created_at', 'desc')->get();
    }

    return view('backend/pages/kelolavideo')->with('getvideo', $getvideo);
  }

  public function store(Request $request)
  {
    $messages = [
      'url_video.required' => 'Tidak boleh kosong.',
      'judul_video.required' => 'Tidak boleh kosong.',
      'flag_video.required' => 'Periksa kembali file image anda.',
    ];

    $validator = Validator::make($request->all(), [
            'url_video' => 'required',
            'judul_video' => 'required',
            'flag_video' => 'required',
        ], $messages);

    if ($validator->fails()) {
        return redirect()->route('video.index')
                    ->withErrors($validator)
                    ->withInput();
    }

    //set important video value
    $valimportantvideo="";
    if($request->flag_important_video=="") {
      $valimportantvideo=0;
    } else {
      $valimportantvideo=1;
    }

    if (Auth::user()->level=="1") {
      $checkimportant = Video::where('flag_important_video', 1)->where('id_skpd', null)->count();

      if ($checkimportant>=3 && $valimportantvideo==1) {
        return redirect()->route('video.index')->with('messagefail', 'Maksimal jumlah video utama adalah 3.');
      }

      $set = new Video;
      $set->url_video = $request->url_video;
      $set->judul_video = $request->judul_video;
      $set->flag_important_video = $valimportantvideo;
      $set->flag_video = $request->flag_video;
      $set->save();
    } else {
      $checkimportant = Video::where('flag_important_video', 1)->where('id_skpd', Auth::user()->masterskpd->id)->count();

      if ($checkimportant>=3 && $valimportantvideo==1) {
        return redirect()->route('video.index')->with('messagefail', 'Maksimal jumlah video utama adalah 3.');
      }

      $set = new Video;
      $set->url_video = $request->url_video;
      $set->judul_video = $request->judul_video;
      $set->flag_important_video = $valimportantvideo;
      $set->flag_video = $request->flag_video;
      $set->id_skpd = Auth::user()->masterskpd->id;
      $set->save();
    }

    return redirect()->route('video.index')->with('message', 'Berhasil memasukkan video baru.');
  }

  public function edit(Request $request)
  {
    if (Auth::user()->level=="1") {
      $set = Video::find($request->id);
      $set->url_video = $request->url_video;
      $set->judul_video = $request->judul_video;
      $set->flag_video = $request->flag_video;
      $set->save();
    } else {
      $set = Video::find($request->id);
      $set->url_video = $request->url_video;
      $set->judul_video = $request->judul_video;
      $set->flag_video = $request->flag_video;
      $set->id_skpd = Auth::user()->masterskpd->id;
      $set->save();
    }

    return redirect()->route('video.index')->with('message', 'Berhasil mengubah konten video.');
  }

  public function bind($id)
  {
    $get = Video::find($id);
    return $get;
  }

  public function delete($id)
  {
    $set = Video::find($id);
    $set->delete();

    return redirect()->route('video.index')->with('message', 'Berhasil menghapus data video.');
  }

  public function publish($id)
  {
    $set = Video::find($id);
    if($set->flag_video=="1") {
      $set->flag_video = 0;
      $set->flag_important_video = 0;
      $set->save();
    } elseif ($set->flag_video=="0") {
      $set->flag_video = 1;
      $set->save();
    }

    return redirect()->route('video.index')->with('message', 'Berhasil mengubah status video.');
  }

  public function editimportantvideo($id)
  {
    $set = Video::find($id);
    if($set->flag_important_video=="1") {
      $set->flag_important_video = 0;
      $set->save();
    } elseif ($set->flag_important_video=="0") {

      if (Auth::user()->level=="1") {
        $checkimportant = Video::where('flag_important_video', 1)->where('id_skpd', null)->count();

        if ($checkimportant>=3) {
          return redirect()->route('video.index')->with('messagefail', 'Maksimal jumlah video utama adalah 3.');
        }
      } else {
        $checkimportant = Video::where('flag_important_video', 1)->where('id_skpd', Auth::user()->masterskpd->id)->count();

        if ($checkimportant>=3) {
          return redirect()->route('video.index')->with('messagefail', 'Maksimal jumlah video utama adalah 3.');
        }
      }

      $set->flag_important_video = 1;
      $set->save();
    }

    return redirect()->route('video.index')->with('message', 'Berhasil mengubah status video utama.');
  }
}
