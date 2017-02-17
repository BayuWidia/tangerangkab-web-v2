<?php

namespace App\Http\Controllers;


use DB;
use Input;
use App\Models\Menu;
use App\Models\Berita;
use App\Models\MediaSosial;
use App\Http\Requests;
use App\Models\MasterSKPD;
use Illuminate\Http\Request;
use App\Models\KategoriBerita;
use App\Models\Anggaran;
use App\Http\Controllers\Controller;

class BeritaController extends Controller
{
  public function SKPDsearchByParam($singkatan)
  {
    // SEARCH DATA WITH LARAVEL SCOUT
    $param = Input::get('param');
    $getdata = Berita::search($param)->where('flag_publish', 1)->paginate(10);

    $getidskpd = MasterSKPD::where('singkatan', $singkatan)->first();
    if(!$getidskpd) {
      return view('errors.404');
    }

    // NAVBAR //
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

    $getrandom = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select('*', 'berita.id as id_berita')
      ->where('flag_utama', 0)
      ->where('berita.id_skpd', '!=', null)
      // ->where('flag_publish', 1)
      ->orderby(DB::raw('rand()'))
      ->limit(5)
      ->get();

      // dd($getrandom);

    // GET KATEGORI FOR FOOTER //
    $getfooterkat = KategoriBerita::where('id_skpd', $getidskpd->id)->get();

    // JEJARING //
    $getjejaring = MasterSKPD::where('flag_skpd', 1)->get();

    $getmenu = Menu::where([['level', 1], ['id_skpd', $getidskpd->id]])->get();
    $getsubmenu = Menu::select('*', 'menu_konten.id as menukontenid')
                    ->join('menu_konten', 'menu.id', '=', 'menu_konten.id_submenu')
                    ->where([['level', 2], ['menu.id_skpd', $getidskpd->id]])->get();

    $getanggaran = Anggaran::where([['flag_anggaran', 1], ['id_skpd', $getidskpd->id]])->get();

    //GET sosmed
    $getsosmed = MediaSosial::where('id_skpd', $getidskpd->id)->get();

    if ($getdata->total() == 0) {
        return view('errors.404');
    } else {
        return view('frontend.pages.searchresult', compact('param', 'getsosmed', 'getanggaran', 'singkatan', 'getmenu', 'getsubmenu', 'getjejaring', 'getfooterkat', 'getrandom','getdata','getsekilastangerang','getberita'));
    }
  }

  public function searchByParam()
  {
    // SEARCH DATA WITH LARAVEL SCOUT
    $param = Input::get('param');
    $getdata = Berita::search($param)->where('flag_publish', 1)->paginate(10);

    // NAVBAR //
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

    $getrandom = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select('*', 'berita.id as id_berita')
      ->where('flag_utama', 0)
      ->where('flag_publish', 1)
      ->orderby(DB::raw('rand()'))
      ->limit(6)
      ->get();

    // GET KATEGORI FOR FOOTER //
    $getfooterkat = KategoriBerita::where('id_skpd', null)->where('flag_utama', 0)->get();

    // JEJARING //
    $getjejaring = MasterSKPD::where('flag_skpd', 1)->get();

    $getmenu = Menu::where([['level', 1], ['id_skpd', null]])->get();
    $getsubmenu = Menu::select('*', 'menu_konten.id as menukontenid')
                    ->join('menu_konten', 'menu.id', '=', 'menu_konten.id_submenu')
                    ->where([['level', 2], ['menu.id_skpd', null]])->get();

    //GET ANGGARAN
    $getanggaran = Anggaran::where('id_skpd', null)->get();

    //GET sosmed
    $getsosmed = MediaSosial::where('id_skpd', null)->get();

    if ($getdata->total() == 0) {
        return view('errors.404');
    } else {
        return view('frontend.pages.searchresult', compact('param', 'getsosmed', 'getanggaran', 'getmenu', 'getsubmenu', 'getjejaring', 'getfooterkat', 'getrandom','getdata','getsekilastangerang','getberita'));
    }
  }

  public function show($id)
  {
    // NAVBAR //
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

    // KONTEN //
    $getdata = DB::table('kategori_berita')
          ->leftJoin('berita', 'kategori_berita.id','=','berita.id_kategori')
          ->join('users', 'berita.id_user','=','users.id')
          ->select('*', 'kategori_berita.id',  'berita.id as id_berita', 'berita.updated_at as tanggal_posting', 'berita.url_foto as foto_berita')
          ->where('berita.id_skpd', null)
          ->where('kategori_berita.id', $id)
          ->where('berita.flag_publish', '1')
          ->orderBy('berita.updated_at', 'desc')
          ->paginate(5);

    $getrandom = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select('*', 'berita.id as id_berita')
      ->where('flag_utama', 0)
      ->where('flag_publish', 1)
      ->orderby(DB::raw('rand()'))
      ->limit(6)
      ->get();

    // GET KATEGORI FOR FOOTER //
    $getfooterkat = KategoriBerita::where('id_skpd', null)->where('flag_utama', 0)->get();

    // JEJARING //
    $getjejaring = MasterSKPD::where('flag_skpd', 1)->get();

    $getmenu = Menu::where([['level', 1], ['id_skpd', null]])->get();
    $getsubmenu = Menu::select('*', 'menu_konten.id as menukontenid')
                    ->join('menu_konten', 'menu.id', '=', 'menu_konten.id_submenu')
                    ->where([['level', 2], ['menu.id_skpd', null]])->get();

    //GET ANGGARAN
    $getanggaran = Anggaran::where('id_skpd', null)->get();

    //GET sosmed
    $getsosmed = MediaSosial::where('id_skpd', null)->get();

    if ($getdata->total() == 0) {
        return view('errors.404');
    } else {
        return view('frontend.pages.berita', compact('getsosmed', 'getanggaran', 'getmenu', 'getsubmenu', 'getjejaring', 'getfooterkat', 'getrandom','getdata','getsekilastangerang','getberita'));
    }
  }

  public function showberitaskpdparam($singkatan, $idkategori)
  {
    $getidskpd = MasterSKPD::where('singkatan', $singkatan)->first();
    if(!$getidskpd) {
      return view('errors.404');
    }

    // NAVBAR //
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

    // KONTEN //
    $getdata = DB::table('kategori_berita')
          ->leftJoin('berita', 'kategori_berita.id','=','berita.id_kategori')
          ->join('users', 'berita.id_user','=','users.id')
          ->select('*', 'kategori_berita.id',  'berita.id as id_berita', 'berita.updated_at as tanggal_posting', 'berita.url_foto as foto_berita')
          ->where('kategori_berita.flag_utama', 0)
          ->where('kategori_berita.id', $idkategori)
          ->orderBy('berita.updated_at', 'desc')
          ->paginate(5);

          // dd($getdata);

    $getrandom = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select('*', 'berita.id as id_berita')
      ->where('flag_utama', 0)
      ->where('berita.id_skpd', '!=', null)
      // ->where('flag_publish', 1)
      ->orderby(DB::raw('rand()'))
      ->limit(5)
      ->get();

      // dd($getrandom);

    // GET KATEGORI FOR FOOTER //
    $getfooterkat = KategoriBerita::where('id_skpd', $getidskpd->id)->get();

    // JEJARING //
    $getjejaring = MasterSKPD::where('flag_skpd', 1)->get();

    $getmenu = Menu::where([['level', 1], ['id_skpd', $getidskpd->id]])->get();
    $getsubmenu = Menu::select('*', 'menu_konten.id as menukontenid')
                    ->join('menu_konten', 'menu.id', '=', 'menu_konten.id_submenu')
                    ->where([['level', 2], ['menu.id_skpd', $getidskpd->id]])->get();

    $getanggaran = Anggaran::where([['flag_anggaran', 1], ['id_skpd', $getidskpd->id]])->get();

    //GET sosmed
    $getsosmed = MediaSosial::where('id_skpd', $getidskpd->id)->get();

    if ($getdata->total() == 0) {
        return view('errors.404');
    } else {
        return view('frontend.pages.berita', compact('getsosmed', 'getanggaran', 'singkatan', 'getmenu', 'getsubmenu', 'getjejaring', 'getfooterkat', 'getrandom','getdata','getsekilastangerang','getberita'));
    }
  }

  public function showberitaskpdbykategori($singkatan)
  {
    $getidskpd = MasterSKPD::where('singkatan', $singkatan)->first();
    if(!$getidskpd) {
      return view('errors.404');
    }

    // NAVBAR //
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

    // KONTEN //
    $getdata = DB::table('kategori_berita')
          ->leftJoin('berita', 'kategori_berita.id','=','berita.id_kategori')
          ->join('users', 'berita.id_user','=','users.id')
          ->select('*', 'kategori_berita.id',  'berita.id as id_berita', 'berita.updated_at as tanggal_posting', 'berita.url_foto as foto_berita')
          ->where('kategori_berita.flag_utama', 0)
          ->orderBy('berita.updated_at', 'desc')
          ->paginate(5);

          // dd($getdata);

    $getrandom = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select('*', 'berita.id as id_berita')
      ->where('flag_utama', 0)
      ->where('berita.id_skpd', '!=', null)
      // ->where('flag_publish', 1)
      ->orderby(DB::raw('rand()'))
      ->limit(5)
      ->get();

      // dd($getrandom);

    // GET KATEGORI FOR FOOTER //
    $getfooterkat = KategoriBerita::where('id_skpd', $getidskpd->id)->get();

    // JEJARING //
    $getjejaring = MasterSKPD::where('flag_skpd', 1)->get();

    $getmenu = Menu::where([['level', 1], ['id_skpd', $getidskpd->id]])->get();
    $getsubmenu = Menu::select('*', 'menu_konten.id as menukontenid')
                    ->join('menu_konten', 'menu.id', '=', 'menu_konten.id_submenu')
                    ->where([['level', 2], ['menu.id_skpd', $getidskpd->id]])->get();

    $getanggaran = Anggaran::where([['flag_anggaran', 1], ['id_skpd', $getidskpd->id]])->get();

    //GET sosmed
    $getsosmed = MediaSosial::where('id_skpd', $getidskpd->id)->get();

    $beritaskpd = 1;

    if ($getdata->total() == 0) {
        return view('errors.404');
    } else {
        return view('frontend.pages.berita', compact('beritaskpd', 'getsosmed', 'getanggaran', 'singkatan', 'getmenu', 'getsubmenu', 'getjejaring', 'getfooterkat', 'getrandom','getdata','getsekilastangerang','getberita'));
    }
  }

  public function showberitaskpd()
  {
    // NAVBAR //
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

    // KONTEN //
    $getdata = DB::table('kategori_berita')
          ->leftJoin('berita', 'kategori_berita.id','=','berita.id_kategori')
          ->join('users', 'berita.id_user','=','users.id')
          ->select('*', 'kategori_berita.id',  'berita.id as id_berita', 'berita.updated_at as tanggal_posting', 'berita.url_foto as foto_berita')
          ->where('berita.id_skpd', '!=', null)
          ->where('berita.flag_publish', '1')
          ->where('kategori_berita.flag_utama', 0)
          ->orderBy('berita.updated_at', 'desc')
          ->paginate(5);

    $getrandom = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select('*', 'berita.id as id_berita')
      ->where('flag_utama', 0)
      ->where('flag_publish', 1)
      ->orderby(DB::raw('rand()'))
      ->limit(6)
      ->get();

    $beritaskpd = 1;

    // GET KATEGORI FOR FOOTER //
    $getfooterkat = KategoriBerita::where('id_skpd', null)->where('flag_utama', 0)->get();

    // JEJARING //
    $getjejaring = MasterSKPD::where('flag_skpd', 1)->get();

    // GET MENU
    $getmenu = Menu::where([['level', 1], ['id_skpd', null]])->get();
    $getsubmenu = Menu::select('*', 'menu_konten.id as menukontenid')
                    ->join('menu_konten', 'menu.id', '=', 'menu_konten.id_submenu')
                    ->where([['level', 2], ['menu.id_skpd', null]])->get();

    //GET ANGGARAN
    $getanggaran = Anggaran::where('id_skpd', null)->get();

    //GET sosmed
    $getsosmed = MediaSosial::where('id_skpd', null)->get();

    if ($getdata->total() == 0) {
        return view('errors.404');
    } else {
        return view('frontend.pages.berita', compact('getsosmed', 'getanggaran', 'getmenu', 'getsubmenu', 'getfooterkat', 'getjejaring', 'beritaskpd', 'getrandom','getdata','getsekilastangerang','getberita'));
    }
  }

  public function beritaDetail()
  {
    return view('frontend.pages.beritaDetail');
  }
}
