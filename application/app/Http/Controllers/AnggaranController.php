<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Validator;
use App\Http\Requests;
use App\Models\Anggaran;

class AnggaranController extends Controller
{
  public function index()
  {
    if (Auth::user()->level=="1") {
      $getanggaran = Anggaran::where('id_skpd', null)->get();
    } else {
      $getanggaran = Anggaran::where('id_skpd', Auth::user()->masterskpd->id)->get();
    }

    return view('backend/pages/kelolaanggaran')->with('getanggaran', $getanggaran);
  }

  public function store(Request $request)
  {
    $messages = [
      'uraian.required' => 'Tidak boleh kosong.',
      'tahun.required' => 'Tidak boleh kosong.',
      'flag_anggaran.required' => 'Tidak boleh kosong.',
      'url_file.required' => 'Periksa kembali file dokumen anda.',
    ];

    $validator = Validator::make($request->all(), [
            'uraian' => 'required',
            'tahun' => 'required',
            'flag_anggaran' => 'required',
            'url_file' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->route('anggaran.index')
                        ->withErrors($validator)
                        ->withInput();
        }

    $file = $request->file('url_file');
    if ($file!=null) {
      if (Auth::user()->level=="1") {
        $filename = time().'.'.$file->getClientOriginalExtension();
        $file->move('documents', $filename);

        $set = new Anggaran;
        $set->uraian = $request->uraian;
        $set->tahun = $request->tahun;
        $set->flag_anggaran = $request->flag_anggaran;
        $set->url_file = $filename;
        $set->save();
      } else {
        $filename = time().'.'.$file->getClientOriginalExtension();
        $file->move('documents', $filename);

        $set = new Anggaran;
        $set->uraian = $request->uraian;
        $set->tahun = $request->tahun;
        $set->flag_anggaran = $request->flag_anggaran;
        $set->url_file = $filename;
        $set->id_skpd = Auth::user()->masterskpd->id;
        $set->save();
      }
    } else {
      return redirect()->route('anggaran.index')->with('messagefail', 'File anggaran harus di upload.');
    }

    return redirect()->route('anggaran.index')->with('message', 'Berhasil memasukkan data anggaran.');
  }

  public function publish($id)
  {
    $set = Anggaran::find($id);
    if($set->flag_anggaran=="1") {
      $set->flag_anggaran = 0;
      $set->save();
    } elseif ($set->flag_anggaran=="0") {
      $set->flag_anggaran = 1;
      $set->save();
    }

    return redirect()->route('anggaran.index')->with('message', 'Berhasil mengubah status data anggaran.');
  }

  public function delete($id)
  {
    $get = Anggaran::find($id);
    $get->delete();

    return redirect()->route('anggaran.index')->with('message', 'Berhasil menghapus data anggaran.');
  }

  public function bind($id)
  {
    $get = Anggaran::find($id);
    return $get;
  }

  public function edit(Request $request)
  {
    $file = $request->file('url_file');
    if ($file!=null) {
      if (Auth::user()->level=="1") {
        $filename = time().'.'.$file->getClientOriginalExtension();
        $file->move('documents', $filename);

        $set = Anggaran::find($request->id);
        $set->uraian = $request->uraian;
        $set->tahun = $request->tahun;
        $set->flag_anggaran = $request->flag_anggaran;
        $set->url_file = $filename;
        $set->save();
      } else {
        $filename = time().'.'.$file->getClientOriginalExtension();
        $file->move('documents', $filename);

        $set = Anggaran::find($request->id);
        $set->uraian = $request->uraian;
        $set->tahun = $request->tahun;
        $set->flag_anggaran = $request->flag_anggaran;
        $set->url_file = $filename;
        $set->id_skpd = Auth::user()->masterskpd->id;
        $set->save();
      }
    } else {
      if (Auth::user()->level=="1") {
        $set = Anggaran::find($request->id);
        $set->uraian = $request->uraian;
        $set->tahun = $request->tahun;
        $set->flag_anggaran = $request->flag_anggaran;
        $set->save();
      } else {
        $set = Anggaran::find($request->id);
        $set->uraian = $request->uraian;
        $set->tahun = $request->tahun;
        $set->flag_anggaran = $request->flag_anggaran;
        $set->id_skpd = Auth::user()->masterskpd->id;
        $set->save();
      }
    }

    return redirect()->route('anggaran.index')->with('message', 'Berhasil mengubah data anggaran.');
  }
}
