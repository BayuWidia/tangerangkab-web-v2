<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;
use Hash;
use Auth;
use Validator;
use App\Models\User;
use App\Models\Berita;
use App\Models\Slider;
use App\Http\Requests;
use App\Models\MasterSKPD;

class AkunController extends Controller
{
  public function index()
  {
    $getuser = User::all();
    $getskpd = MasterSKPD::all();
    return view('backend/pages/kelolaakun', compact('getuser', 'getskpd'));
  }

  public function store(Request $request)
  {
    $messages = [
      'email.required' => 'Tidak boleh kosong.',
      'email.unique' => 'Email telah terdaftar.',
      'level.required' => 'Pilih salah satu.',
      'level.not_in' => 'Pilih salah satu.',
      'id_skpd.required' => 'Pilih salah satu.',
      'id_skpd.not_in' => 'Pilih salah satu.'
    ];

    $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users,email',
            'level' => 'required|not_in:-- Pilih --',
            'id_skpd' => 'required|not_in:-- Pilih --',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->route('akun.kelola')
                        ->withErrors($validator)
                        ->withInput();
        }

    $activation_code = str_random(30).time();

    $set = new User;
    $set->email = $request->email;
    $set->level = $request->level;
    $set->id_skpd = $request->id_skpd;
    $set->activation_code = $activation_code;
    $set->save();

    $akses = "";
    if ($request->level=="1") {
      $akses = "Administrator";
    } elseif($request->level=="2") {
      $akses = "User SKPD";
    }

    $data = [
      'akses' => $akses,
      'activation_code' => $activation_code
    ];

    Mail::send('backend/pages/emailactivation', ['data' => $data], function($message) use($request) {
      $message->to($request->email, $request->email)->subject('Aktifasi Akun Web Terpadu');
    });

    return redirect()->route('akun.kelola')->with('message', 'Berhasil memasukkan akun baru. Link aktifasi akan dikirim ke email yang telah didaftarkan.');
  }

  public function emailActivation($code)
  {
    $user = User::where('activation_code', $code)->first();
    if($user!="") {
      return view('backend/pages/setpassword')->with('email', $user->email)->with('verifytoken', $code);
    }
    else {
      return "Link aktifasi tidak valid.";
    }
  }

  public function setPassword(Request $request)
  {
    $user = User::where('email', $request->email)->first();
    $user->password = Hash::make($request->password);
    $user->activation_code = null;
    $user->activated = 1;
    $user->save();

    if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password, 'activated'=>1])) {
      return redirect()->route('dashboard')->with('firsttimelogin', "Anda telah berhasil melakukan aktifasi akun. Selanjutnya, anda bisa menggunakan akun ini untuk login ke dalam sistem dan dapat menggunakan fitur yang telah disediakan.");
    }
    else {
      return view('backend/pages/login')->with('message', "Silahkan lakukan login.");
    }
  }

  public function logoutProcess()
  {
    session()->flush();
    Auth::logout();
    return redirect()->route('login.pages');
  }

  public function loginProcess(Request $request)
  {
    if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password, 'activated'=>1])) {
      return redirect()->route('dashboard')->with('message', "Selamat Datang.");
    }
    else {
      return view('backend/pages/login')->with('message', "Silahkan lakukan login.");
    }
  }

  public function update(Request $request)
  {
    $set = User::find($request->id);
    $set->level = $request->level;
    $set->id_skpd = $request->id_skpd;
    $set->save();

    return redirect()->route('akun.kelola')->with('message', 'Berhasil mengubah data akun.');
  }

  public function delete($id)
  {
    $cekberita = Berita::where('id_user', $id)->first();

    if($cekberita==null) {
      $set = User::find($id);
      $set->delete();

      return redirect()->route('akun.kelola')->with('message', 'Berhasil menghapus data akun.');
    } else {
      return redirect()->route('akun.kelola')->with('messagefail', 'Gagal melakukan hapus data. Data akun telah memiliki relasi dengan data yang lain.');
    }
  }

  public function bind($id)
  {
    $get = User::find($id);
    return $get;
  }
}
