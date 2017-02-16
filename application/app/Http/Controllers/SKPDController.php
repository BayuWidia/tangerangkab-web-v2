<?php

namespace App\Http\Controllers;

use Image;
use Validator;
use App\Models\User;
use App\Http\Requests;
use App\Models\Slider;
use App\Models\MasterSKPD;
use Illuminate\Http\Request;

class SKPDController extends Controller
{
  public function index()
  {
    $getskpd = MasterSKPD::orderby('created_at', 'desc')->get();
    return view('backend/pages/lihatskpd')->with('getskpd', $getskpd);
  }

  public function store(Request $request)
  {
    $messages = [
      'nama_skpd.required' => 'Tidak boleh kosong.',
      'singkatan.required' => 'Tidak boleh kosong.',
      'alamat_skpd.required' => 'Tidak boleh kosong.',
      'logo_skpd.required' => 'Periksa kembali file anda.',
      'logo_skpd.image' => 'File upload harus image.',
    ];

    $validator = Validator::make($request->all(), [
            'nama_skpd' => 'required',
            'singkatan' => 'required',
            'alamat_skpd' => 'required',
            'logo_skpd' => 'required|image'
        ], $messages);

        if ($validator->fails()) {
            return redirect()->route('skpd.kelola')
                        ->withErrors($validator)
                        ->withInput();
        }

    $file = $request->file('logo_skpd');

    if ($file!=null) {
      $photo_name = time(). '.' . $file->getClientOriginalExtension();
      Image::make($file)->save('images/'. $photo_name);

      $photo1 = explode('.', $photo_name);
      $photo200 = $photo1[0]."_200x122.".$photo1[1];
      Image::make($file)->fit(200,122)->save('images/'. $photo200);

      $set = new MasterSKPD;
      $set->nama_skpd = $request->nama_skpd;
      $set->singkatan = $request->singkatan;
      $set->alamat_skpd = $request->alamat_skpd;
      $set->flag_skpd = $request->flag_skpd;
      $set->logo_skpd = $photo_name;
      $set->save();
    } else {
      return redirect()->route('skpd.kelola')->with('messagefail', 'Logo SKPD harus di set.');
    }

    return redirect()->route('skpd.kelola')->with('message', 'Berhasil memasukkan data SKPD baru.');
  }

  public function changeflag($id)
  {
    $get = MasterSKPD::find($id);

    if($get->flag_skpd=="1") {
      $get->flag_skpd = "0";
    } elseif($get->flag_skpd=="0") {
      $get->flag_skpd = "1";
    }

    $get->save();

    return redirect()->route('skpd.kelola')->with('message', 'Berhasil mengubah status SKPD.');
  }

  public function delete($id)
  {
    $check = User::where('id_skpd', $id)->first();
    $checkslider = Slider::where('id_skpd', $id)->first();
    if($check=="" && $checkslider=="") {
      $set = MasterSKPD::find($id);
      $set->delete();
      return redirect()->route('skpd.kelola')->with('message', 'Berhasil menghapus data SKPD.');
    } else {
      return redirect()->route('skpd.kelola')->with('messagefail', 'Gagal melakukan hapus data. Data SKPD telah memiliki relasi dengan data yang lain.');
    }
  }

  public function edit(Request $request)
  {
    $file = $request->file('logo_skpd');
    // dd($request);
    if ($file!=null) {
      $photo_name = time(). '.' . $file->getClientOriginalExtension();
      Image::make($file)->save('images/'. $photo_name);

      $set = MasterSKPD::find($request->id);
      $set->nama_skpd = $request->nama_skpd;
      $set->singkatan = $request->singkatan;
      $set->alamat_skpd = $request->alamat_skpd;
      $set->domain_skpd = $request->domain_skpd;
      $set->flag_skpd = $request->flag_skpd;
      $set->logo_skpd = $photo_name;
      $set->save();
    } else {
      $set = MasterSKPD::find($request->id);
      $set->nama_skpd = $request->nama_skpd;
      $set->singkatan = $request->singkatan;
      $set->alamat_skpd = $request->alamat_skpd;
      $set->flag_skpd = $request->flag_skpd;
      $set->domain_skpd = $request->domain_skpd;
      $set->save();
    }

    return redirect()->route('skpd.kelola')->with('message', 'Berhasil mengubah data SKPD.');
  }

  public function bind($id)
  {
    $get = MasterSKPD::find($id);
    return $get;
  }
}
