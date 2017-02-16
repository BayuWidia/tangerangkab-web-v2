<?php

namespace App\Http\Controllers;


use DB;
use App\Http\Requests;
use App\Models\Berita;
use App\Models\MasterSKPD;
use App\Models\MediaSosial;
use Illuminate\Http\Request;
use App\Models\KategoriBerita;
use App\Models\Anggaran;
use App\Models\Menu;
use App\Models\Pegawai;
use App\Models\Video;
use App\Http\Controllers\Controller;

class ProfileSKPDController extends Controller
{
  public function viewvideo($singkatan)
  {
    $getidskpd = MasterSKPD::where('singkatan', $singkatan)->first();
    if (!$getidskpd) {
      return view('errors.404');
    }

    $get = Video::where('id_skpd', $getidskpd->id)
            ->where('flag_video', 1)
            ->orderby('id', 'desc')
            ->paginate(10);

    //GET SOSMED
    $getsosmed = MediaSosial::where('id_skpd', $getidskpd->id)->get();

    //GET RANDOM
    $getrandom = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select('*', 'berita.id as id_berita')
      ->where('flag_utama', 0)
      ->where('flag_publish', 1)
      ->orderby(DB::raw('rand()'))
      ->limit(6)
      ->get();

    $getsekilastangerang = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select(DB::raw('distinct(kategori_berita.nama_kategori)'), 'kategori_berita.id', 'berita.id_skpd as id_skpd_berita')
      ->where('berita.id_skpd', $getidskpd->id)
      ->where('kategori_berita.flag_utama', 1)
      ->get();

    $getberita = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select(DB::raw('distinct(kategori_berita.nama_kategori)'), 'kategori_berita.id')
      ->where('berita.id_skpd', $getidskpd->id)
      ->where('kategori_berita.flag_utama', 0)
      ->get();

    $getmenu = Menu::where([['level', 1], ['id_skpd', $getidskpd->id]])->get();
    $getsubmenu = Menu::select('*', 'menu_konten.id as menukontenid')
                    ->join('menu_konten', 'menu.id', '=', 'menu_konten.id_submenu')
                    ->where([['level', 2], ['menu.id_skpd', $getidskpd->id]])->get();

    //GET ANGGARAN
    $getanggaran = Anggaran::where('id_skpd', $getidskpd->id)->get();

    // GET KATEGORI FOR FOOTER //
    $getfooterkat = KategoriBerita::where('id_skpd', $getidskpd->id)->where('flag_utama', 0)->get();

    // JEJARING //
    $getjejaring = MasterSKPD::where('flag_skpd', 1)->get();

    return view('skpd/pages/video')
      ->with('getdata', $get)
      ->with('getmenu', $getmenu)
      ->with('singkatan', $singkatan)
      ->with('getjejaring', $getjejaring)
      ->with('getsubmenu', $getsubmenu)
      ->with('getfooterkat', $getfooterkat)
      ->with('getanggaran', $getanggaran)
      ->with('getberita', $getberita)
      ->with('getsekilastangerang', $getsekilastangerang)
      ->with('getrandom', $getrandom)
      ->with('getsosmed', $getsosmed);
  }

  public function show($singkatan, $id, $id_skpd)
  {
    $getidskpd = MasterSKPD::where('singkatan', $singkatan)->first();
    if (!$getidskpd) {
      return view('errors.404');
    }

    // SET VIEW COUNTER //
    $set = Berita::where('id_kategori', $id)
      ->orderby('updated_at', 'desc')->first();
    if (!$set) {
      return view('errors.404');
    }

    $setsave = Berita::find($set->id);
    if (!$setsave) {
      return view('errors.404');
    }

    if ($setsave->view_counter=="") {
      $setsave->view_counter = 1;
    } else {
      $setsave->view_counter = $set->view_counter+1;
    }
    $setsave->save();

    $getsekilastangerang = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select(DB::raw('distinct(kategori_berita.nama_kategori)'), 'kategori_berita.id', 'berita.id_skpd as id_skpd_berita')
      ->where('berita.id_skpd', $id_skpd)
      ->where('kategori_berita.flag_utama', 1)
      ->get();


      // dd($getsekilastangerang);

    $getberita = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select(DB::raw('distinct(kategori_berita.nama_kategori)'), 'kategori_berita.id', 'berita.id_skpd as id_skpd_berita')
      ->where('berita.id_skpd', $id_skpd)
      ->where('kategori_berita.flag_utama', 0)
      ->get();

    $getdata = DB::table('kategori_berita')
      ->leftJoin('berita', 'kategori_berita.id','=','berita.id_kategori')
      ->Join('users', 'berita.id_user','=','users.id')
      ->select('*', 'kategori_berita.id', 'berita.id as id_berita', 'berita.id_skpd as id_skpd_berita')
      ->where('kategori_berita.id', $id)
      ->where('berita.flag_publish', '1')
      ->orderBy('berita.tanggal_publish')
      ->first();

    $getberitaterkait = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select('*', 'berita.id as id_berita', 'berita.id_skpd as id_skpd_berita')
      ->where('flag_utama', 0)
      ->where('berita.id_skpd', $id_skpd)
      // ->where('flag_publish', 1)
      ->orderby(DB::raw('rand()'))
      ->limit(6)
      ->get();

    // GET KATEGORI FOR FOOTER //
    $getfooterkat = KategoriBerita::where('id_skpd', $id_skpd)->get();

    // JEJARING //
    $getjejaring = MasterSKPD::where('flag_skpd', 1)->get();

    //GET MENU
    $getmenu = Menu::where([['level', 1], ['id_skpd', $getidskpd->id]])->get();
    $getsubmenu = Menu::select('*', 'menu_konten.id as menukontenid')
                    ->join('menu_konten', 'menu.id', '=', 'menu_konten.id_submenu')
                    ->where([['level', 2], ['menu.id_skpd', $getidskpd->id]])->get();

    $getanggaran = Anggaran::where([['flag_anggaran', 1], ['id_skpd', $getidskpd->id]])->get();

    //GET SOSMED
    $getsosmed = MediaSosial::where('id_skpd', $getidskpd->id)->get();
    // dd($getsosmed);

    if ($getdata == null) {
        return view('errors.404');
    } else {
        return view('skpd.pages.detailkontenskpd', compact('getsosmed', 'getanggaran', 'singkatan', 'getmenu', 'getsubmenu', 'getjejaring', 'getfooterkat', 'getberitaterkait','getdata','getsekilastangerang', 'getberita'));
    }
  }

  public function viewpegawai($singkatan)
  {
    $getidskpd = MasterSKPD::where('singkatan', $singkatan)->first();
    if (!$getidskpd) {
      return view('errors.404');
    }

    $getsekilastangerang = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select(DB::raw('distinct(kategori_berita.nama_kategori)'), 'kategori_berita.id', 'berita.id_skpd as id_skpd_berita')
      ->where('berita.id_skpd', $getidskpd->id)
      ->where('kategori_berita.flag_utama', 1)
      ->get();

    $getberita = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select(DB::raw('distinct(kategori_berita.nama_kategori)'), 'kategori_berita.id')
      ->where('berita.id_skpd', $getidskpd->id)
      ->where('kategori_berita.flag_utama', 0)
      ->get();

    $getberitaterkait = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select('*', 'berita.id as id_berita')
      ->where('flag_utama', 0)
      ->where('flag_publish', 1)
      ->orderby(DB::raw('rand()'))
      ->limit(3)
      ->get();

    // GET KATEGORI FOR FOOTER //
    $getfooterkat = KategoriBerita::where('id_skpd', $getidskpd->id)->get();

    // JEJARING //
    $getjejaring = MasterSKPD::where('flag_skpd', 1)->get();

    $getmenu = Menu::where([['level', 1], ['id_skpd', $getidskpd->id]])->get();
    $getsubmenu = Menu::select('*', 'menu_konten.id as menukontenid')
                    ->join('menu_konten', 'menu.id', '=', 'menu_konten.id_submenu')
                    ->where([['level', 2], ['menu.id_skpd', $getidskpd->id]])->get();

    //GET PEGAWAI
    $getpegawai = Pegawai::join('esselon', 'esselon.id', '=', 'pegawai.id_esselon')
                    ->join('pangkat', 'pangkat.id', '=', 'pegawai.id_pangkat')
                    ->orderby('esselon.urutan_esselon', 'desc')
                    ->where('id_skpd', $getidskpd->id)->get();

    //GET SOSMED
    $getsosmed = MediaSosial::where('id_skpd', $getidskpd->id)->get();

    if ($getpegawai == null) {
        return view('errors.404');
    } else {
        return view('skpd.pages.kepegawaian', compact('getsosmed', 'getpegawai', 'getanggaran', 'getmenu', 'getsubmenu', 'getjejaring', 'getfooterkat', 'getberitaterkait','getsekilastangerang', 'getberita', 'singkatan'));
    }
  }

  public function viewAnggaran($singkatan)
  {
    $getidskpd = MasterSKPD::where('singkatan', $singkatan)->first();

    $getsekilastangerang = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select(DB::raw('distinct(kategori_berita.nama_kategori)'), 'kategori_berita.id', 'berita.id_skpd as id_skpd_berita')
      ->where('berita.id_skpd', $getidskpd->id)
      ->where('kategori_berita.flag_utama', 1)
      ->get();

    $getberita = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select(DB::raw('distinct(kategori_berita.nama_kategori)'), 'kategori_berita.id')
      ->where('berita.id_skpd', $getidskpd->id)
      ->where('kategori_berita.flag_utama', 0)
      ->get();

    $getberitaterkait = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select('*', 'berita.id as id_berita')
      ->where('flag_utama', 0)
      ->where('flag_publish', 1)
      ->orderby(DB::raw('rand()'))
      ->limit(3)
      ->get();

    // GET KATEGORI FOR FOOTER //
    $getfooterkat = KategoriBerita::where('id_skpd', $getidskpd->id)->get();

    // JEJARING //
    $getjejaring = MasterSKPD::where('flag_skpd', 1)->get();

    $getmenu = Menu::where([['level', 1], ['id_skpd', $getidskpd->id]])->get();
    $getsubmenu = Menu::select('*', 'menu_konten.id as menukontenid')
                    ->join('menu_konten', 'menu.id', '=', 'menu_konten.id_submenu')
                    ->where([['level', 2], ['menu.id_skpd', $getidskpd->id]])->get();

    //GET ANGGARAN
    // $getanggaran = Anggaran::where('id_skpd', $getidskpd->id)->orderby('tahun', 'desc')->get();
    $getanggaran = Anggaran::leftjoin('master_skpd', 'master_skpd.id', '=', 'anggaran.id_skpd')->orderby('tahun', 'desc')->where('id_skpd', $getidskpd->id)->paginate(30);

    //GET SOSMED
    $getsosmed = MediaSosial::where('id_skpd', $getidskpd->id)->get();

    if ($getanggaran == null) {
        return view('errors.404');
    } else {
        return view('frontend.pages.anggaran', compact('getsosmed', 'getanggaran', 'getmenu', 'getsubmenu', 'getjejaring', 'getfooterkat', 'getberitaterkait','getsekilastangerang', 'getberita', 'singkatan'));
    }
  }

  public function showBerita($singkatan, $id, $id_skpd)
  {
    $getidskpd = MasterSKPD::where('singkatan', $singkatan)->first();
    if (!$getidskpd) {
      return view('errors.404');
    }

    $checkskpd = MasterSKPD::find($id_skpd);
    if (!$checkskpd) {
      return view('errors.404');
    }

    $set = Berita::find($id);
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

    $getdata = DB::table('kategori_berita')
      ->leftJoin('berita', 'kategori_berita.id','=','berita.id_kategori')
      ->Join('users', 'berita.id_user','=','users.id')
      ->select('*', 'kategori_berita.id', 'berita.id as id_berita', 'berita.id_skpd as id_skpd_berita', 'berita.url_foto as foto_berita')
      ->where('berita.id', $id)
      ->first();

    $getberitaterkait = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select('*', 'berita.id as id_berita', 'berita.id_skpd as id_skpd_berita')
      ->where('flag_utama', 0)
      ->where('berita.id_skpd', $getidskpd->id)
      // ->where('flag_publish', 1)
      ->orderby(DB::raw('rand()'))
      ->limit(6)
      ->get();

    // $getberitaterkait = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
    //   ->select('berita.url_foto', 'berita.judul_berita', 'kategori_berita.nama_kategori', 'berita.id as id_berita')
    //   ->where('id_kategori', $getdata->id_kategori)->limit(7)->get();

    // GET KATEGORI FOR FOOTER //
    $getfooterkat = KategoriBerita::where('id_skpd', $getidskpd->id)->where('flag_utama', 0)->get();

    // JEJARING //
    $getjejaring = MasterSKPD::where('flag_skpd', 1)->get();

    //GET SOSMED
    $getsosmed = MediaSosial::where('id_skpd', $getidskpd->id)->get();

    // GET ANGGARAN
    $getanggaran = Anggaran::where([['flag_anggaran', 1], ['id_skpd', $getidskpd->id]])->get();

    //GET MENU
    $getmenu = Menu::where([['level', 1], ['id_skpd', $getidskpd->id]])->get();
    $getsubmenu = Menu::select('*', 'menu_konten.id as menukontenid')
                    ->join('menu_konten', 'menu.id', '=', 'menu_konten.id_submenu')
                    ->where([['level', 2], ['menu.id_skpd', $getidskpd->id]])->get();

    if ($getdata == null) {
        return view('errors.404');
    } else {
        return view('skpd.pages.detailkontenskpd', compact('getmenu', 'getsubmenu', 'getanggaran', 'singkatan', 'getsosmed', 'getjejaring', 'getfooterkat', 'getdata','getsekilastangerang', 'getberita', 'getberitaterkait'));
    }
  }


  public function showskpd($id)
  {
    // SET VIEW COUNTER //
    $set = Berita::where('id_kategori', $id)
      ->orderby('updated_at', 'desc')->first();

    $setsave = Berita::find($set->id);
    if ($setsave->view_counter=="") {
      $setsave->view_counter = 1;
    } else {
      $setsave->view_counter = $set->view_counter+1;
    }
    $setsave->save();

    $getdata = DB::table('kategori_berita')
      ->leftJoin('berita', 'kategori_berita.id','=','berita.id_kategori')
      ->Join('users', 'berita.id_user','=','users.id')
      ->select('*', 'kategori_berita.id', 'berita.id as id_berita', 'berita.id_skpd as id_skpd_berita', 'berita.id_skpd as id_skpd_berita')
      ->where('kategori_berita.id', $id)
      ->where('berita.flag_publish', '1')
      ->orderBy('berita.tanggal_publish')
      ->first();

    $getsekilastangerang = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select(DB::raw('distinct(kategori_berita.nama_kategori)'), 'kategori_berita.id', 'berita.id_skpd as id_skpd_berita')
      ->where('berita.id_skpd', $getdata->id_skpd_berita)
      ->where('kategori_berita.flag_utama', 1)
      ->get();

    $getberita = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select(DB::raw('distinct(kategori_berita.nama_kategori)'), 'kategori_berita.id', 'berita.id_skpd as id_skpd_berita')
      ->where('berita.id_skpd', $getdata->id_skpd_berita)
      ->where('kategori_berita.flag_utama', 0)
      ->get();

    $getberitaterkait = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select('*', 'berita.id as id_berita')
      ->where('flag_utama', 0)
      ->where('flag_publish', 1)
      ->orderby(DB::raw('rand()'))
      ->limit(6)
      ->get();

    // GET KATEGORI FOR FOOTER //
    $getfooterkat = KategoriBerita::where('id_skpd', null)->get();

    // JEJARING //
    $getjejaring = MasterSKPD::where('flag_skpd', 1)->get();

    //GET SOSMED
    $getsosmed = MediaSosial::where('id_skpd', null)->get();

    if ($getdata == null) {
        return view('errors.404');
    } else {
        return view('skpd.pages.detailkontenskpd', compact('getsosmed', 'getjejaring', 'getfooterkat', 'getberitaterkait','getdata','getsekilastangerang', 'getberita'));
    }
  }

  public function geografi()
  {
    return view('frontend.pages.geografi');
  }

  public function demografi()
  {
    return view('frontend.pages.demografi');
  }
}
