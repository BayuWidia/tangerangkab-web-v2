<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use Image;
use Validator;
use App\Http\Requests;
use App\Models\Menu;
use App\Models\Berita;
use App\Models\KategoriBerita;
use App\Models\MasterSKPD;
use App\Models\MediaSosial;
use App\Models\MenuKonten;
use App\Models\Anggaran;

class MenuKontenController extends Controller
{
  public function viewall()
  {
    if (Auth::user()->level==1) {
      $getkonten = MenuKonten::join('menu', 'menu_konten.id_submenu', '=', 'menu.id')
      ->select('menu_konten.judul_konten', 'menu.nama', 'menu_konten.created_at as tanggal_post', 'menu_konten.id as id_konten', 'menu_konten.flagpublish')
      ->where('menu_konten.id_skpd', null)->get();
    } else {
      $getkonten = MenuKonten::join('menu', 'menu_konten.id_submenu', '=', 'menu.id')
      ->select('menu_konten.judul_konten', 'menu.nama', 'menu_konten.created_at as tanggal_post', 'menu_konten.id as id_konten', 'menu_konten.flagpublish')
      ->where('menu_konten.id_skpd', Auth::user()->id_skpd)->get();
    }

    return view('backend/pages/lihatkontenmenu')->with('getkonten', $getkonten);
  }

  public function bind($id)
  {
    $get = MenuKonten::find($id);
    return $get;
  }

  public function edit($id)
  {
    $getsubmenu = DB::table('menu')->select('menu.id', 'menu.nama')
    ->leftjoin('menu_konten', 'menu.id', '=', 'menu_konten.id_submenu')
    ->where('menu_konten.id', null)
    ->where('menu.level', 2)
    ->get();

    $getkonten = MenuKonten::join('menu', 'menu.id', '=', 'menu_konten.id_submenu')
                  ->select('menu_konten.judul_konten', 'menu.nama', 'menu_konten.created_at as tanggal_post', 'menu_konten.id as id_konten','menu_konten.tags', 'menu_konten.isi_konten', 'menu_konten.url_foto', 'menu_konten.id_submenu')
                  ->where('menu_konten.id', $id)
                  ->first();

    return view('backend/pages/kontenmenu')
      ->with('getsubmenu', $getsubmenu)
      ->with('getkonten', $getkonten);
  }

  public function update(Request $request)
  {
    $file = $request->file('url_foto');
    if ($file!=null) {
      $messages = [
        'judul_konten.required' => 'Tidak boleh kosong.',
        'id_submenu.required' => 'Tidak boleh kosong.',
        'id_submenu.not_in' => 'Pilih salah satu.',
        'tags.required' => 'Tidak boleh kosong.',
        'url_foto.required' => 'Periksa kembali file image anda.',
        'url_foto.image' => 'File upload harus image.',
        'url_foto.mimes' => 'Ekstensi file tidak valid.',
        'url_foto.max' => 'Ukuran file terlalu besar.',
        'isi_konten.required' => 'Tidak boleh kosong.',
      ];

      $validator = Validator::make($request->all(), [
              'judul_konten' => 'required',
              'id_submenu' => 'required|not_in:-- Pilih --',
              'tags' => 'required',
              'url_foto' => 'required|image|mimes:jpeg,jpg,png|max:20000',
              'isi_konten' => 'required',
          ], $messages);

          if ($validator->fails()) {
              return redirect()->route('menukonten.edit', $request->id)
                          ->withErrors($validator)
                          ->withInput();
          }

      $photo_name = time(). '.' . $file->getClientOriginalExtension();

      $photo1 = explode('.', $photo_name);
      $photo871 = $photo1[0]."_871x497.".$photo1[1];
      $photo200 = $photo1[0]."_200x122.".$photo1[1];

      Image::make($file)->fit(871,497)->save('images/'. $photo871);
      Image::make($file)->fit(200,122)->save('images/'. $photo200);

      if (Auth::user()->level=="1") {
        $set = MenuKonten::find($request->id);
        $set->id_submenu = $request->id_submenu;

        $set->id_user = Auth::user()->id;
        $set->url_foto = $photo_name;
        $set->judul_konten = $request->judul_konten;
        $set->tags = $request->tags;
        $set->isi_konten = $request->isi_konten;
        $set->save();
      } else {
        $set = MenuKonten::find($request->id);
        $set->id_submenu = $request->id_submenu;
        $set->id_skpd = Auth::user()->masterskpd->id;

        $set->id_user = Auth::user()->id;
        $set->url_foto = $photo_name;
        $set->judul_konten = $request->judul_konten;
        $set->tags = $request->tags;
        $set->isi_konten = $request->isi_konten;
        $set->save();
      }
    } else {
      $messages = [
        'judul_konten.required' => 'Tidak boleh kosong.',
        'id_submenu.required' => 'Tidak boleh kosong.',
        'id_submenu.not_in' => 'Pilih salah satu.',
        'tags.required' => 'Tidak boleh kosong.',
        'isi_konten.required' => 'Tidak boleh kosong.',
      ];

      $validator = Validator::make($request->all(), [
              'judul_konten' => 'required',
              'id_submenu' => 'required|not_in:-- Pilih --',
              'tags' => 'required',
              'isi_konten' => 'required',
          ], $messages);

          if ($validator->fails()) {
              return redirect()->route('menukonten.edit', $request->id)
                          ->withErrors($validator)
                          ->withInput();
          }

      if (Auth::user()->level=="1") {
        $set = MenuKonten::find($request->id);
        $set->id_submenu = $request->id_submenu;

        $set->id_user = Auth::user()->id;
        $set->judul_konten = $request->judul_konten;
        $set->tags = $request->tags;
        $set->isi_konten = $request->isi_konten;
        $set->save();
      } else {
        $set = MenuKonten::find($request->id);
        $set->id_submenu = $request->id_submenu;
        $set->id_skpd = Auth::user()->masterskpd->id;

        $set->id_user = Auth::user()->id;
        $set->judul_konten = $request->judul_konten;
        $set->tags = $request->tags;
        $set->isi_konten = $request->isi_konten;
        $set->save();
      }
    }

    return redirect()->route('view.menukonten')->with('message', 'Berhasil mengubah konten menu.');
  }

  public function changestatus($id)
  {
    $get = MenuKonten::find($id);
    if ($get->flagpublish==1) {
      $get->flagpublish = 0;
    } else {
      $get->flagpublish = 1;
    }
    $get->save();

    return redirect()->route('view.menukonten')->with('message', 'Berhasil mengubah status publikasi konten menu.');
  }

  public function inputkonten()
  {
    if (Auth::user()->level == "1") {
      $getsubmenu = DB::table('menu')->select('menu.id', 'menu.nama')
      ->leftjoin('menu_konten', 'menu.id', '=', 'menu_konten.id_submenu')
      ->where('menu_konten.id', null)
      ->where('menu.id_skpd', null)
      ->where('menu.level', 2)
      ->get();
    } else {
      $getsubmenu = DB::table('menu')->select('menu.id', 'menu.nama')
      ->leftjoin('menu_konten', 'menu.id', '=', 'menu_konten.id_submenu')
      ->where('menu_konten.id', null)
      ->where('menu.id_skpd', Auth::user()->masterskpd->id)
      ->where('menu.level', 2)
      ->get();
    }


    return view('backend/pages/kontenmenu')->with('getsubmenu', $getsubmenu);
  }

  public function delete($id)
  {
    $get = MenuKonten::find($id);
    $get->delete();

    return redirect()->route('view.menukonten')->with('message', 'Berhasil menghapus konten menu.');
  }

  public function store(Request $request)
  {
    $messages = [
      'judul_konten.required' => 'Tidak boleh kosong.',
      'id_submenu.required' => 'Tidak boleh kosong.',
      'id_submenu.not_in' => 'Pilih salah satu.',
      'tags.required' => 'Tidak boleh kosong.',
      'url_foto.required' => 'Periksa kembali file image anda.',
      'url_foto.image' => 'File upload harus image.',
      'url_foto.mimes' => 'Ekstensi file tidak valid.',
      'url_foto.max' => 'Ukuran file terlalu besar.',
      'isi_konten.required' => 'Tidak boleh kosong.',
    ];

    $validator = Validator::make($request->all(), [
            'judul_konten' => 'required',
            'id_submenu' => 'required|not_in:-- Pilih --',
            'tags' => 'required',
            'url_foto' => 'required|image|mimes:jpeg,jpg,png|max:20000',
            'isi_konten' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->route('input.menukonten')
                        ->withErrors($validator)
                        ->withInput();
        }

    $file = $request->file('url_foto');
    if ($file!=null) {
      $photo_name = time(). '.' . $file->getClientOriginalExtension();

      $photo1 = explode('.', $photo_name);
      $photo871 = $photo1[0]."_871x497.".$photo1[1];
      $photo200 = $photo1[0]."_200x122.".$photo1[1];

      Image::make($file)->fit(871,497)->save('images/'. $photo871);
      Image::make($file)->fit(200,122)->save('images/'. $photo200);

      if (Auth::user()->level=="1") {
        $set = new MenuKonten;
        $set->id_submenu = $request->id_submenu;

        $set->id_user = Auth::user()->id;
        $set->url_foto = $photo_name;
        $set->judul_konten = $request->judul_konten;
        $set->tags = $request->tags;
        $set->isi_konten = $request->isi_konten;
        $set->save();
      } else {
        $set = new MenuKonten;
        $set->id_submenu = $request->id_submenu;
        $set->id_skpd = Auth::user()->masterskpd->id;

        $set->id_user = Auth::user()->id;
        $set->url_foto = $photo_name;
        $set->judul_konten = $request->judul_konten;
        $set->tags = $request->tags;
        $set->isi_konten = $request->isi_konten;
        $set->save();
      }
    } else {
      return redirect()->route('input.menukonten')->with('messagefail', 'Foto header harus di upload.');
    }

    return redirect()->route('input.menukonten')->with('message', 'Berhasil menambahkan konten menu.');
  }

  public function showBerita($id)
  {
    // SET VIEW COUNTER //
    $set = MenuKonten::find($id);
    if (!$set) {
      return view('errors.404');
    }

    if ($set->view_counter=="") {
      $set->view_counter = 1;
    } else {
      $set->view_counter = $set->view_counter+1;
    }
    $set->save();

    $getsekilastangerang = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select(DB::raw('distinct(kategori_berita.nama_kategori)'), 'kategori_berita.id', 'berita.id_skpd as id_skpd_berita')
      ->where('berita.id_skpd', null)
      ->where('kategori_berita.flag_utama', 1)
      ->get();

    $getberita = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select(DB::raw('distinct(kategori_berita.nama_kategori)'), 'kategori_berita.id', 'berita.id_skpd as id_skpd_berita')
      ->where('berita.id_skpd', null)
      ->where('kategori_berita.flag_utama', 0)
      ->get();

    $getdata = DB::table('menu_konten')
      ->join('menu', 'menu.id', '=', 'menu_konten.id_submenu')
      ->join('users', 'menu_konten.id_user','=','users.id')
      ->select('*', 'menu_konten.id as id_berita', 'menu_konten.id_skpd as id_skpd_berita', 'menu_konten.url_foto as foto_berita', 'menu_konten.isi_konten as judul_berita', 'menu_konten.updated_at as konten_update', 'menu.nama as namasubmenu')
      ->where('menu_konten.id', $id)
      ->first();

    $getberitaterkait = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select('*', 'berita.id as id_berita')
      ->where('flag_utama', 0)
      ->where('flag_publish', 1)
      ->orderby(DB::raw('rand()'))
      ->limit(6)
      ->get();

    $getberitaterkait = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select('berita.url_foto', 'berita.judul_berita', 'kategori_berita.nama_kategori', 'berita.id as id_berita')
      ->limit(7)->get();

    // GET KATEGORI FOR FOOTER //
    $getfooterkat = KategoriBerita::where('id_skpd', null)->where('flag_utama', 0)->get();

    // JEJARING //
    $getjejaring = MasterSKPD::where('flag_skpd', 1)->get();

    $getmenu = Menu::where([['level', 1], ['id_skpd', null]])->get();
    $getsubmenu = Menu::select('*', 'menu_konten.id as menukontenid')
                    ->join('menu_konten', 'menu.id', '=', 'menu_konten.id_submenu')
                    ->where([['level', 2], ['menu.id_skpd', null]])->get();

    //GET ANGGARAN
    // $getanggaran = Anggaran::where('id_skpd', null)->get();
    $getanggaran = Anggaran::where('id_skpd', null)->get();

    //GET SOSMED
    $getsosmed = MediaSosial::where('id_skpd', null)->get();

    if ($getdata == null) {
        return view('errors.404');
    } else {
        return view('frontend.pages.detailmenukonten', compact('getsosmed', 'getanggaran', 'getmenu', 'getsubmenu', 'getjejaring', 'getfooterkat', 'getdata','getsekilastangerang', 'getberita', 'getberitaterkait'));
    }
  }
}
