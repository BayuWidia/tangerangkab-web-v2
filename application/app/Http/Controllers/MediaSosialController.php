<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Validator;
use App\Models\MediaSosial;
use App\Http\Requests;

class MediaSosialController extends Controller
{
  public function index()
  {
    if (Auth::user()->level=="1") {
      $getsosmed = MediaSosial::where('id_skpd', null)->get();
    } else {
      $getsosmed = MediaSosial::where('id_skpd', Auth::user()->masterskpd->id)->get();
    }

    return view('backend.pages.socialmedia')->with('getsosmed', $getsosmed);
  }

  public function store(Request $request)
  {
    $messages = [
      'sosmed.required' => 'Tidak boleh kosong.',
      'sosmed.not_in' => 'Pilih salah satu.',
      'link.required' => 'Tidak boleh kosong.',
    ];

    $validator = Validator::make($request->all(), [
            'sosmed' => 'required|not_in:-- Pilih --',
            'link' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->route('sosmed.index')
                        ->withErrors($validator)
                        ->withInput();
        }

    // $check = MediaSosial::where('id_skpd', Auth::user()->id_skpd)
    //           ->where('nama_sosmed', $request->sosmed)
    //           ->count();

    if (Auth::user()->level=="1") {
      // if ($check==0) {
        $set = new MediaSosial;
        $set->nama_sosmed = $request->sosmed;
        $set->link_sosmed = $request->link;
        $set->save();

        return redirect()->route('sosmed.index')->with('message', 'Berhasil memasukkan data media sosial.');
      // } else {
      //   return redirect()->route('sosmed.index')->with('messagefail', 'Data telah tersedia pada database.');
      // }
    } else {
      // if ($check==0) {
        $set = new MediaSosial;
        $set->nama_sosmed = $request->sosmed;
        $set->link_sosmed = $request->link;
        $set->id_skpd = Auth::user()->id_skpd;
        $set->save();

        return redirect()->route('sosmed.index')->with('message', 'Berhasil memasukkan data media sosial.');
      // } else {
      //   return redirect()->route('sosmed.index')->with('messagefail', 'Data telah tersedia pada database.');
      // }
    }
  }

  public function edit(Request $request)
  {
    // $messages = [
    //   'editsosmed.required' => 'Tidak boleh kosong.',
    //   'editsosmed.not_in' => 'Pilih salah satu.',
    //   'editlink.required' => 'Tidak boleh kosong.',
    // ];
    //
    // $validator = Validator::make($request->all(), [
    //         'editsosmed' => 'required|not_in:-- Pilih --',
    //         'editlink' => 'required',
    //     ], $messages);
    //
    //     if ($validator->fails()) {
    //         return redirect()->route('sosmed.index')
    //                     ->withErrors($validator)
    //                     ->withInput();
    //     }

    if (Auth::user()->level=="1") {
      $set = MediaSosial::find($request->id);
      $set->nama_sosmed = $request->editsosmed;
      $set->link_sosmed = $request->editlink;
      // $set->id_skpd = Auth::user()->id_skpd;
      $set->save();
    } else {
      $set = MediaSosial::find($request->id);
      $set->nama_sosmed = $request->editsosmed;
      $set->link_sosmed = $request->editlink;
      $set->id_skpd = Auth::user()->id_skpd;
      $set->save();
    }

    return redirect()->route('sosmed.index')->with('message', 'Berhasil mengubah data media sosial.');
  }

  public function delete($id)
  {
    $find = MediaSosial::find($id);
    $find->delete();

    return redirect()->route('sosmed.index')->with('message', 'Berhasil menghapus data.');
  }

  public function bind($id)
  {
    $find = MediaSosial::find($id);
    return $find;
  }
}
