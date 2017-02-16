<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Image;
use Auth;
use App\Http\Requests;
use App\Models\Menu;
use App\Models\MediaSosial;
use App\Models\Berita;
use App\Models\KategoriBerita;
use App\Models\MasterSKPD;
use App\Models\MenuKonten;
use App\Models\Anggaran;
use DB;

class MenuKontenSKPDController extends Controller
{
  public function showBerita($singkatan, $id)
  {
    $getidskpd = MasterSKPD::where('singkatan', $singkatan)->first();
    if (!$getidskpd) {
      return view('errors.404');
    }

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
      ->where('berita.id_skpd', $getidskpd->id)
      ->where('kategori_berita.flag_utama', 1)
      ->get();

    $getberita = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select(DB::raw('distinct(kategori_berita.nama_kategori)'), 'kategori_berita.id', 'berita.id_skpd as id_skpd_berita')
      ->where('berita.id_skpd', $getidskpd->id)
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
    $getfooterkat = KategoriBerita::where('id_skpd', $getidskpd->id)->where('flag_utama', 0)->get();

    // JEJARING //
    $getjejaring = MasterSKPD::where('flag_skpd', 1)->get();

    $getmenu = Menu::where([['level', 1], ['id_skpd', $getidskpd->id]])->get();
    $getsubmenu = Menu::select('*', 'menu_konten.id as menukontenid')
                    ->join('menu_konten', 'menu.id', '=', 'menu_konten.id_submenu')
                    ->where([['level', 2], ['menu.id_skpd', $getidskpd->id]])->get();

    $getanggaran = Anggaran::where([['flag_anggaran', 1], ['id_skpd', $getidskpd->id]])->get();

    //GET SOSMED
    $getsosmed = MediaSosial::where('id_skpd', $getidskpd->id)->get();

    if ($getdata == null) {
        return view('errors.404');
    } else {
        return view('frontend.pages.detailmenukonten', compact('getsosmed', 'getanggaran', 'singkatan', 'getmenu', 'getsubmenu', 'getjejaring', 'getfooterkat', 'getdata','getsekilastangerang', 'getberita', 'getberitaterkait'));
    }
  }
}
