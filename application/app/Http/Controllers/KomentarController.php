<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Komentar;
use Validator;

class KomentarController extends Controller
{
  public function userPostComment(Request $req)
  {
    $messages = [
      'name.required' => 'Tidak boleh kosong.',
      'email.required' => 'Tidak boleh kosong.',
      'comment.required' => 'Tidak boleh kosong.',
    ];

    $validator = Validator::make($req->all(), [
            'name' => 'required',
            'email' => 'required',
            'comment' => 'required',
        ], $messages);

    if ($validator->fails()) {
        return redirect()->route('berita.detail-konten', $req->id)
                    ->withErrors($validator)
                    ->withInput();
    }

    $set = new Komentar;
    $set->nama = $req->name;
    $set->email = $req->email;
    $set->komentar = $req->comment;
    $set->id_berita = $req->id;
    $set->save();

    return redirect()->route('berita.detail-konten', $req->id)->with('message', 'Berhasil mengirimkan komentar.');
  }
}
