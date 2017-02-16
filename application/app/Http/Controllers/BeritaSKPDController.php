<?php

namespace App\Http\Controllers;


use DB;
use App\Models\Berita;
use App\Http\Requests;
use App\Models\MasterSKPD;
use Illuminate\Http\Request;
use App\Models\KategoriBerita;
use App\Models\Menu;
use App\Http\Controllers\Controller;

class BeritaSKPDController extends Controller
{

  public function show($id, $id_skpd)
  {
    // NAVBAR //
    $getsekilastangerang = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select(DB::raw('distinct(kategori_berita.nama_kategori)'), 'kategori_berita.id', 'berita.id_skpd as id_skpd_berita')
      ->where('berita.id_skpd', $id_skpd)
      ->where('kategori_berita.flag_utama', 1)
      ->get();

    $getberita = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select(DB::raw('distinct(kategori_berita.nama_kategori)'), 'kategori_berita.id', 'berita.id_skpd as id_skpd_berita')
      ->where('berita.id_skpd', $id_skpd)
      ->where('kategori_berita.flag_utama', 0)
      ->get();

    // KONTEN //
    $getdata = DB::table('kategori_berita')
          ->leftJoin('berita', 'kategori_berita.id','=','berita.id_kategori')
          ->join('users', 'berita.id_user','=','users.id')
          ->select('*', 'kategori_berita.id',  'berita.id as id_berita', 'berita.updated_at as tanggal_posting', 'berita.url_foto as foto_berita')
          ->where('berita.id_skpd', $id_skpd)
          ->where('kategori_berita.id', $id)
          ->orderBy('berita.updated_at', 'desc')
          ->paginate(5);

    $getrandom = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select('*', 'berita.id as id_berita', 'berita.id_skpd as id_skpd_berita')
      ->where('flag_utama', 0)
      ->where('berita.id_skpd', $id_skpd)
      ->orderby(DB::raw('rand()'))
      ->limit(6)
      ->get();

    $getsingkatan = MasterSKPD::where('id', $id_skpd)->select('singkatan')->first();

    // GET KATEGORI FOR FOOTER //
    $getfooterkat = KategoriBerita::where('id_skpd', $id_skpd)->get();

    $getjejaring = MasterSKPD::where('flag_skpd', 1)->get();

    //GET MENU
    $getmenu = Menu::where([['level', 1], ['id_skpd', $id_skpd]])->get();
    $getsubmenu = Menu::select('*', 'menu_konten.id as menukontenid')
                    ->join('menu_konten', 'menu.id', '=', 'menu_konten.id_submenu')
                    ->where([['level', 2], ['menu.id_skpd', $id_skpd]])->get();

    if ($getdata->total() == 0) {
        return view('errors.404');
    } else {
        return view('skpd.pages.beritaskpd', compact('getmenu', 'getsubmenu', 'getsingkatan', 'getjejaring', 'getfooterkat', 'getrandom','getdata','getsekilastangerang','getberita'));
    }
  }

  public function showBerita($id_skpd)
  {

    // NAVBAR //
    $getsekilastangerang = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select(DB::raw('distinct(kategori_berita.nama_kategori)'), 'kategori_berita.id', 'berita.id_skpd as id_skpd_berita')
      ->where('berita.id_skpd', $id_skpd)
      ->where('kategori_berita.flag_utama', 1)
      ->get();

    $getberita = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select(DB::raw('distinct(kategori_berita.nama_kategori)'), 'kategori_berita.id', 'berita.id_skpd as id_skpd_berita')
      ->where('berita.id_skpd', $id_skpd)
      ->where('kategori_berita.flag_utama', 0)
      ->get();

    // KONTEN //
    $getdata = DB::table('kategori_berita')
          ->leftJoin('berita', 'kategori_berita.id','=','berita.id_kategori')
          ->join('users', 'berita.id_user','=','users.id')
          ->select('*', 'kategori_berita.id',  'berita.id as id_berita', 'berita.updated_at as tanggal_posting', 'berita.url_foto as foto_berita')
          ->where('berita.id_skpd', '=', $id_skpd)
          ->where('kategori_berita.flag_utama', 0)
          ->orderBy('berita.updated_at', 'desc')
          ->paginate(5);

    $getrandom = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select('*', 'berita.id as id_berita', 'berita.id_skpd as id_skpd_berita')
      ->where('flag_utama', 0)
      ->where('berita.id_skpd', $id_skpd)
      ->orderby(DB::raw('rand()'))
      ->limit(6)
      ->get();

    $beritaskpd = 1;


    // GET KATEGORI FOR FOOTER //
    $getfooterkat = KategoriBerita::where('id_skpd', $id_skpd)->get();

    // JEJARING //
    $getjejaring = MasterSKPD::where('flag_skpd', 1)->get();

    if ($getdata->total() == 0) {
        return view('errors.404');
    } else {
        return view('skpd.pages.beritaskpd', compact('getfooterkat', 'getjejaring', 'beritaskpd', 'getrandom','getdata','getsekilastangerang','getberita'));
    }
  }
}
