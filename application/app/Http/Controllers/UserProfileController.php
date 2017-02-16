<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Hash;
use Image;
use Validator;
use App\Models\User;
use App\Http\Requests;
use App\Models\Berita;
use App\Models\MasterSKPD;

class UserProfileController extends Controller
{
  public function index()
  {
    $getuser = User::find(Auth::user()->id);
    $countberita = Berita::where('id_user', $getuser->id)->count();
    $getskpd = MasterSKPD::where('id', $getuser->id_skpd)->first();

    return view('backend/pages/profile')
      ->with('getuser', $getuser)
      ->with('getskpd', $getskpd)
      ->with('countberita', $countberita);
  }

  public function edit(Request $request)
  {
    $file = $request->file('url_foto');
    if ($file!=null) {
      $photo = time(). '.' . $file->getClientOriginalExtension();
      Image::make($file)->fit(160,160)->save('images/'. $photo);

      $set = User::find($request->id);
      $set->name = $request->name;
      $set->url_foto = $photo;
      $set->save();
    } else {
      $set = User::find($request->id);
      $set->name = $request->name;
      $set->save();
    }

    return redirect()->route('profile.index')->with('message', 'Berhasil menyimpan data profile.');
  }

  public function changepassword(Request $request)
  {
    $get = Auth::user();

    if (Hash::check($request->oldpassword, $get->password)) {
      $messages = [
        'oldpassword.required' => 'Tidak boleh kosong.',
        'newpassword.required' => 'Tidak boleh kosong.',
        'newpassword_confirmation.required' => 'Tidak boleh kosong.',
        'newpassword.confirmed' => 'Periksa password baru anda.'
      ];

      $validator = Validator::make($request->all(), [
              'oldpassword' => 'required',
              'newpassword' => 'required|confirmed',
              'newpassword_confirmation' => 'required'
          ], $messages);

          if ($validator->fails()) {
              return redirect()->route('profile.index')
                          ->withErrors($validator)
                          ->with('messagefail', 'Periksa kembali password baru anda.')
                          ->withInput();
          }

      $get->password = Hash::make($request->newpassword);
      $get->save();

      return redirect()->route('profile.index')
        ->with('message', 'Berhasil melakukan perubahan password.');
    } else {
      return redirect()->route('profile.index')
      ->with('messagefail', 'Password lama tidak valid.');
    }
  }
}
