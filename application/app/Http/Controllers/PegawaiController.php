<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Image;
use Validator;
use App\Http\Requests;
use App\Models\Esselon;
use App\Models\Pangkat;
use App\Models\Pegawai;

class PegawaiController extends Controller
{
  public function index()
  {
    $getpegawai = Pegawai::with('esselon')->with('pangkat')
                    ->where('id_skpd', Auth::user()->id_skpd)->get();

    $getesselon = Esselon::all();
    $getpangkat = Pangkat::all();

    return view('backend/pages/kelolapegawai')
      ->with('getpegawai', $getpegawai)
      ->with('getesselon', $getesselon)
      ->with('getpangkat', $getpangkat);
  }

  public function store(Request $request)
  {
    $messages = [
      'nama_pegawai.required' => 'Tidak boleh kosong.',
      'jenis_kelamin.required' => 'Pilih salah satu.',
      'id_esselon.required' => 'Tidak boleh kosong.',
      'id_esselon.not_in' => 'Pilih salah satu.',
      'id_pangkat.required' => 'Tidak boleh kosong.',
      'id_pangkat.not_in' => 'Pilih salah satu.',
      'flag_pegawai.required' => 'Tidak boleh kosong.',
    ];

    $validator = Validator::make($request->all(), [
            'nama_pegawai' => 'required',
            'jenis_kelamin' => 'required',
            'id_esselon' => 'required|not_in:-- Pilih --',
            'id_pangkat' => 'required|not_in:-- Pilih --',
            'flag_pegawai' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->route('pegawai.index')
                        ->withErrors($validator)
                        ->withInput();
        }

    $file = $request->file('url_foto');
    if ($file!=null) {
      $photo = time().".".$file->getClientOriginalExtension();

      $photo1 = explode('.', $photo);
      $photo170 = $photo1[0]."_115x155.".$photo1[1];

      Image::make($file)->fit(115,155)->save('images/'. $photo170);

      $set = new Pegawai;
      $set->nama_pegawai = $request->nama_pegawai;
      $set->jenis_kelamin = $request->jenis_kelamin;
      $set->id_esselon = $request->id_esselon;
      $set->id_pangkat = $request->id_pangkat;
      $set->flag_pegawai = $request->flag_pegawai;
      $set->id_skpd = Auth::user()->masterskpd->id;
      $set->url_foto = $photo;
      $set->save();
    } else {
      $set = new Pegawai;
      $set->nama_pegawai = $request->nama_pegawai;
      $set->jenis_kelamin = $request->jenis_kelamin;
      $set->id_esselon = $request->id_esselon;
      $set->id_pangkat = $request->id_pangkat;
      $set->flag_pegawai = $request->flag_pegawai;
      $set->id_skpd = Auth::user()->masterskpd->id;
      $set->save();
    }

    return redirect()->route('pegawai.index')->with('message', 'Berhasil memasukkan data pegawai.');
  }

  public function publish($id)
  {
    $set = Pegawai::find($id);
    if($set->flag_pegawai=="1") {
      $set->flag_pegawai = 0;
      $set->save();
    } elseif ($set->flag_pegawai=="0") {
      $set->flag_pegawai = 1;
      $set->save();
    }

    return redirect()->route('pegawai.index')->with('message', 'Berhasil mengubah status pegawai.');
  }

  public function delete($id)
  {
    $set = Pegawai::find($id);
    $set->delete();

    return redirect()->route('pegawai.index')->with('message', 'Berhasil menghapus data pegawai.');
  }

  public function bind($id)
  {
    $get = Pegawai::find($id);
    return $get;
  }

  public function edit(Request $request)
  {
    $file = $request->file('url_foto');
    if ($file!=null) {
      $photo = time().".".$file->getClientOriginalExtension();

      $photo1 = explode('.', $photo);
      $photo170 = $photo1[0]."_115x155.".$photo1[1];

      Image::make($file)->fit(115,155)->save('images/'. $photo170);

      $set = Pegawai::find($request->id);
      $set->nama_pegawai = $request->nama_pegawai;
      $set->jenis_kelamin = $request->jenis_kelamin;
      $set->id_esselon = $request->id_esselon;
      $set->id_pangkat = $request->id_pangkat;
      $set->flag_pegawai = $request->flag_pegawai;
      $set->id_skpd = Auth::user()->masterskpd->id;
      $set->url_foto = $photo;
      $set->save();
    } else {
      $set = Pegawai::find($request->id);
      $set->nama_pegawai = $request->nama_pegawai;
      $set->jenis_kelamin = $request->jenis_kelamin;
      $set->id_esselon = $request->id_esselon;
      $set->id_pangkat = $request->id_pangkat;
      $set->flag_pegawai = $request->flag_pegawai;
      $set->id_skpd = Auth::user()->masterskpd->id;
      $set->save();
    }

    return redirect()->route('pegawai.index')->with('message', 'Berhasil mengubah data pegawai.');
  }
}
