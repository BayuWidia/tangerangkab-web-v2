<?php

namespace App\Http\Controllers;


use DB;
use App\Http\Requests;
use App\Models\Berita;
use App\Models\MasterSKPD;
use Illuminate\Http\Request;
use App\Models\KategoriBerita;
use App\Models\Menu;
use App\Models\MediaSosial;
use App\Models\Pegawai;
use App\Models\Anggaran;
use App\Models\Video;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
  public function viewvideo()
  {
    $get = Video::where('id_skpd', null)
            ->where('flag_video', 1)
            ->orderby('id', 'desc')
            ->paginate(10);

    //GET SOSMED
    $getsosmed = MediaSosial::where('id_skpd', null)->get();

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
      ->where('berita.id_skpd', null)
      ->where('kategori_berita.flag_utama', 1)
      ->get();

    $getberita = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select(DB::raw('distinct(kategori_berita.nama_kategori)'), 'kategori_berita.id')
      ->where('berita.id_skpd', null)
      ->where('kategori_berita.flag_utama', 0)
      ->get();

    $getmenu = Menu::where([['level', 1], ['id_skpd', null]])->get();
    $getsubmenu = Menu::select('*', 'menu_konten.id as menukontenid')
                    ->join('menu_konten', 'menu.id', '=', 'menu_konten.id_submenu')
                    ->where([['level', 2], ['menu.id_skpd', null]])->get();

    //GET ANGGARAN
    $getanggaran = Anggaran::where('id_skpd', null)->get();

    // GET KATEGORI FOR FOOTER //
    $getfooterkat = KategoriBerita::where('id_skpd', null)->where('flag_utama', 0)->get();

    // JEJARING //
    $getjejaring = MasterSKPD::where('flag_skpd', 1)->get();

    return view('frontend/pages/video')
      ->with('getdata', $get)
      ->with('getmenu', $getmenu)
      ->with('getjejaring', $getjejaring)
      ->with('getsubmenu', $getsubmenu)
      ->with('getfooterkat', $getfooterkat)
      ->with('getanggaran', $getanggaran)
      ->with('getberita', $getberita)
      ->with('getsekilastangerang', $getsekilastangerang)
      ->with('getrandom', $getrandom)
      ->with('getsosmed', $getsosmed);
  }

  public function show($id)
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

    $getsekilastangerang = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select(DB::raw('distinct(kategori_berita.nama_kategori)'), 'kategori_berita.id', 'berita.id_skpd as id_skpd_berita')
      ->where('berita.id_skpd', null)
      ->where('kategori_berita.flag_utama', 1)
      ->get();

    $getberita = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select(DB::raw('distinct(kategori_berita.nama_kategori)'), 'kategori_berita.id')
      ->where('berita.id_skpd', null)
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

    //GET SOSMED
    $getsosmed = MediaSosial::where('id_skpd', null)->get();

    if ($getdata == null) {
        return view('errors.404');
    } else {
        return view('frontend.pages.detailkonten', compact('getsosmed', 'getanggaran', 'getmenu', 'getsubmenu', 'getjejaring', 'getfooterkat', 'getberitaterkait','getdata','getsekilastangerang', 'getberita'));
    }
  }

  public function viewpegawai()
  {
    $getsekilastangerang = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select(DB::raw('distinct(kategori_berita.nama_kategori)'), 'kategori_berita.id', 'berita.id_skpd as id_skpd_berita')
      ->where('berita.id_skpd', null)
      ->where('kategori_berita.flag_utama', 1)
      ->get();

    $getberita = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select(DB::raw('distinct(kategori_berita.nama_kategori)'), 'kategori_berita.id')
      ->where('berita.id_skpd', null)
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
    $getfooterkat = KategoriBerita::where('id_skpd', null)->where('flag_utama', 0)->get();

    // JEJARING //
    $getjejaring = MasterSKPD::where('flag_skpd', 1)->get();

    $getmenu = Menu::where([['level', 1], ['id_skpd', null]])->get();
    $getsubmenu = Menu::select('*', 'menu_konten.id as menukontenid')
                    ->join('menu_konten', 'menu.id', '=', 'menu_konten.id_submenu')
                    ->where([['level', 2], ['menu.id_skpd', null]])->get();

    //
    $getskpdforchart = Pegawai::join('master_skpd', 'pegawai.id_skpd', '=', 'master_skpd.id')
                        ->select(DB::raw('count(*) as jumlah'), 'master_skpd.nama_skpd')
                        ->groupby('pegawai.id_skpd')
                        ->orderby('jumlah', 'desc')
                        ->limit(10)
                        ->get();
                        // dd($getskpdforchart);


    $getjumlahesselon = Pegawai::join('master_skpd', 'pegawai.id_skpd', '=', 'master_skpd.id')
                        ->select(DB::raw('count(*) as jumlah'), 'master_skpd.nama_skpd')
                        ->where('pegawai.id_esselon', '!=', 8)
                        ->groupby('pegawai.id_skpd')
                        // ->orderby('jumlah', 'desc')
                        // ->limit(10)
                        ->get();
                        // dd($getjumlahesselon);

    $getjumlahnonesselon = Pegawai::join('master_skpd', 'pegawai.id_skpd', '=', 'master_skpd.id')
                        ->select(DB::raw('count(*) as jumlah'), 'master_skpd.nama_skpd')
                        ->where('pegawai.id_esselon', 8)
                        ->groupby('pegawai.id_skpd')
                        // ->orderby('jumlah', 'desc')
                        // ->limit(10)
                        ->get();
                        // return response()->json($getjumlahnonesselon);

    $skpd = array();
    foreach ($getskpdforchart as $key) {
      $skpd[] = $key->nama_skpd;
    }

    $esselon = array();
    foreach ($getskpdforchart as $key) {
      foreach ($getjumlahesselon as $keys) {
        if ($key->nama_skpd==$keys->nama_skpd) {
          $esselon[] = $keys->jumlah;
        }
      }
    }

    $nonesselon = array();
    foreach ($getskpdforchart as $key) {
      foreach ($getjumlahnonesselon as $keys) {
        if ($key->nama_skpd==$keys->nama_skpd) {
          $nonesselon[] = $keys->jumlah;
        }
      }
    }

    //GET SOSMED
    $getsosmed = MediaSosial::where('id_skpd', null)->get();

    //GET DETAIL TABLE
    // $detailtable = DB::select("select c.nama_skpd, d.nama_esselon, count(*) as 'jumlah_pegawai'
    //                             from pegawai a join esselon b
    //                             on a.id_esselon = b.id
    //                             join master_skpd c
    //                             on a.id_skpd = c.id
    //                             join esselon d
    //                             on a.id_esselon = d.id
    //                             group by a.id_skpd, a.id_esselon");

    // GET DETAIL TABLE 2
    $detailtable2 = DB::select("select id_skpd, nama_skpd, id_esselon, count(*) as 'jumlah_pegawai'
                                from (
                                select id_skpd, nama_skpd, id_esselon, nama_pegawai
                                from pegawai a join esselon b
                                on a.id_esselon = b.id
                                join master_skpd c on a.id_skpd = c.id
                                order by id_skpd, id_esselon
                                ) as pegawai
                                group by id_skpd, id_esselon");

    $getjumlahpegawaiperskpd = Pegawai::join('master_skpd', 'pegawai.id_skpd', '=', 'master_skpd.id')
                                ->select('id_skpd', 'nama_skpd', DB::raw('count(*) as jumlah'))
                                ->groupby('nama_skpd')
                                ->get();

    return view('frontend.pages.kepegawaian', compact('getjumlahpegawaiperskpd', 'detailtable2', 'getsosmed', 'skpd', 'esselon', 'nonesselon', 'getpegawai', 'getmenu', 'getsubmenu', 'getjejaring', 'getfooterkat', 'getberitaterkait','getsekilastangerang', 'getberita'));

  }

  public function viewAnggaran()
  {
    $getsekilastangerang = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select(DB::raw('distinct(kategori_berita.nama_kategori)'), 'kategori_berita.id', 'berita.id_skpd as id_skpd_berita')
      ->where('berita.id_skpd', null)
      ->where('kategori_berita.flag_utama', 1)
      ->get();

    $getberita = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select(DB::raw('distinct(kategori_berita.nama_kategori)'), 'kategori_berita.id')
      ->where('berita.id_skpd', null)
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
    $getfooterkat = KategoriBerita::where('id_skpd', null)->where('flag_utama', 0)->get();

    // JEJARING //
    $getjejaring = MasterSKPD::where('flag_skpd', 1)->get();

    $getmenu = Menu::where([['level', 1], ['id_skpd', null]])->get();
    $getsubmenu = Menu::select('*', 'menu_konten.id as menukontenid')
                    ->join('menu_konten', 'menu.id', '=', 'menu_konten.id_submenu')
                    ->where([['level', 2], ['menu.id_skpd', null]])->get();

    //GET ANGGARAN
    // $getanggaran = Anggaran::where('id_skpd', null)->orderby('tahun', 'desc')->get();
    $getanggaran = Anggaran::leftjoin('master_skpd', 'master_skpd.id', '=', 'anggaran.id_skpd')->orderby('tahun', 'desc')->paginate(30);

    //GET SOSMED
    $getsosmed = MediaSosial::where('id_skpd', null)->get();

    if ($getanggaran == null) {
        return view('errors.404');
    } else {
        return view('frontend.pages.anggaran', compact('getsosmed', 'getanggaran', 'getmenu', 'getsubmenu', 'getjejaring', 'getfooterkat', 'getberitaterkait','getsekilastangerang', 'getberita'));
    }
  }

  public function showBerita($id)
  {
    // SET VIEW COUNTER //
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
      ->where('berita.id_skpd', null)
      ->where('kategori_berita.flag_utama', 1)
      ->get();

    $getberita = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select(DB::raw('distinct(kategori_berita.nama_kategori)'), 'kategori_berita.id', 'berita.id_skpd as id_skpd_berita')
      ->where('berita.id_skpd', null)
      ->where('kategori_berita.flag_utama', 0)
      ->get();

    $getdata = DB::table('kategori_berita')
      ->leftJoin('berita', 'kategori_berita.id','=','berita.id_kategori')
      ->Join('users', 'berita.id_user','=','users.id')
      ->select('*', 'kategori_berita.id', 'berita.id as id_berita', 'berita.id_skpd as id_skpd_berita', 'berita.url_foto as foto_berita')
      ->where('berita.id', $id)
      ->first();

    $getberitaterkait = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select('berita.url_foto', 'berita.judul_berita', 'kategori_berita.nama_kategori', 'berita.id as id_berita')
      ->where('id_kategori', $getdata->id_kategori)->limit(7)->get();

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

    //GET SOSMED
    $getsosmed = MediaSosial::where('id_skpd', null)->get();

    if ($getdata == null) {
        return view('errors.404');
    } else {
        return view('frontend.pages.detailkonten', compact('getsosmed', 'getanggaran', 'getmenu', 'getsubmenu', 'getjejaring', 'getfooterkat', 'getdata','getsekilastangerang', 'getberita', 'getberitaterkait'));
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

    if ($getdata == null) {
        return view('errors.404');
    } else {
        return view('frontend.pages.detailkonten', compact('getjejaring', 'getfooterkat', 'getberitaterkait','getdata','getsekilastangerang', 'getberita'));
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
