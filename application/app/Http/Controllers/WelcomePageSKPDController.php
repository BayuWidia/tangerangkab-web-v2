<?php

namespace App\Http\Controllers;

use DB;
use App\Http\Requests;
use App\Models\Berita;
use App\Models\Slider;
use App\Models\Gallery;
use App\Models\MasterSKPD;
use Illuminate\Http\Request;
use App\Models\KategoriBerita;
use App\Models\Video;
use App\Models\Anggaran;
use App\Models\Menu;
use App\Models\Aplikasi;
use App\Models\MediaSosial;
use App\Http\Controllers\Controller;

class WelcomePageSKPDController extends Controller
{

  public function index($singkatan)
  {
    $getidskpd = MasterSKPD::where('singkatan', $singkatan)->first();
    if (count($getidskpd)==0) {
      return view('errors.404');
    }

    if ($getidskpd->flag_skpd==0) {
      return view('errors.404');
    }
    // NAVBAR //
    $getsekilastangerang = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select(DB::raw('distinct(kategori_berita.nama_kategori)'), 'kategori_berita.id', 'kategori_berita.id_skpd')
      ->where('berita.id_skpd', $getidskpd->id)
      ->where('kategori_berita.flag_utama', 1)
      ->get();

    $getberita = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select(DB::raw('distinct(kategori_berita.nama_kategori)'), 'kategori_berita.id', 'kategori_berita.id_skpd')
      ->where('berita.id_skpd', $getidskpd->id)
      ->where('kategori_berita.flag_utama', 0)
      ->get();

    // SLIDER //
    $getslider = Slider::where([
      ['id_skpd', $getidskpd->id],
      ['flag_slider', 1]
    ])->orderby('created_at', 'desc')
    ->get();

    // BERITA TERKINI (MARQUEE) //
    $getberitaterbaru = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->join('master_skpd', 'master_skpd.id', '=', 'berita.id_skpd')
      ->select('berita.flag_headline', 'berita.judul_berita', 'berita.id_skpd', 'berita.id', 'berita.created_at', 'berita.url_foto', 'kategori_berita.nama_kategori', 'master_skpd.singkatan')
      ->where('berita.id_skpd', $getidskpd->id)
      ->where('kategori_berita.flag_utama', 0)
      ->orderby('berita.created_at', 'desc')
      ->limit(12)
      ->get();

    // HEADLINE //
    $getheadline = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
    ->join('master_skpd', 'master_skpd.id', '=', 'berita.id_skpd')
    ->select('berita.judul_berita', 'berita.id', 'berita.created_at', 'berita.url_foto', 'kategori_berita.nama_kategori', 'kategori_berita.id_skpd', 'master_skpd.singkatan')
    ->where('berita.id_skpd', $getidskpd->id)
    ->where('kategori_berita.flag_utama', 0)
    ->where('flag_headline', 1)
    ->orderby('berita.updated_at', 'desc')
    ->limit(4)
    ->get();

    // BERITA SKPD //
    $getberitaskpd = Berita::join('master_skpd', 'master_skpd.id', '=', 'berita.id_skpd')
      ->join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select('berita.id', 'berita.judul_berita', 'master_skpd.singkatan', 'berita.url_foto', 'berita.id_skpd')
      ->where('kategori_berita.flag_utama', '=', 0)
      ->orderby('tanggal_publish', 'desc')
      ->limit(4)
      ->get();

    // JEJARING //
    $getjejaring = MasterSKPD::where('flag_skpd', 1)->get();

    // BERITA PER KATEGORI //
    $gettop4 = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select('id_kategori', DB::raw('count(*) as jumlah'))
      ->where('berita.id_skpd', $getidskpd->id)
      ->where('flag_utama', 0)
      ->groupby('id_kategori')
      ->orderby('jumlah', 'desc')
      ->limit(4)
      ->get();

    $getberitabykategori = array();

    $i=0;
    foreach ($gettop4 as $key) {
      $getberitabykategori[$i] = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
        ->join('master_skpd', 'master_skpd.id', '=', 'berita.id_skpd')
        ->select('*', 'berita.created_at as tanggal_posting', 'berita.id as id_berita', 'kategori_berita.id as id_kategori')
        ->where('id_kategori', $key->id_kategori)
        ->where('flag_utama', 0)
        ->orderby('berita.updated_at', 'desc')
        ->get();
      $i++;
    }

    // GET KATEGORI FOR FOOTER //
    $getfooterkat = KategoriBerita::where('id_skpd', $getidskpd->id)->where('flag_utama', 0)->get();

    // GET GALERI //
    $getgaleri = Gallery::where('id_skpd', $getidskpd->id)->get();

    //GET VIDEO
    $getvideo = Video::where('id_skpd', $getidskpd->id)->orderBy('created_at', 'desc')->limit(3)->get();

    //GET APLIKASI
    $getaplikasi = Aplikasi::where('id_skpd', $getidskpd->id)->orderBy('created_at')->limit(12)->get();

    //GET MENU
    $getmenu = Menu::where([['level', 1], ['id_skpd', $getidskpd->id]])->get();
    $getsubmenu = Menu::select('*', 'menu_konten.id as menukontenid')
                    ->join('menu_konten', 'menu.id', '=', 'menu_konten.id_submenu')
                    ->where([['level', 2], ['menu.id_skpd', $getidskpd->id]])->get();

    $getanggaran = Anggaran::where([['flag_anggaran', 1], ['id_skpd', $getidskpd->id]])->get();

    //GET sosmed
    $getsosmed = MediaSosial::where('id_skpd', $getidskpd->id)->get();

    return view('skpd.pages.berandaskpd')
      ->with('getidskpd', $getidskpd)
      ->with('getanggaran', $getanggaran)
      ->with('singkatan', $singkatan)
      ->with('getmenu', $getmenu)
      ->with('getsubmenu', $getsubmenu)
      ->with('getsekilastangerang', $getsekilastangerang)
      ->with('getberita', $getberita)
      ->with('getslider', $getslider)
      ->with('getberitaterbaru', $getberitaterbaru)
      ->with('getberitaskpd', $getberitaskpd)
      ->with('getjejaring', $getjejaring)
      ->with('getberitabykategori', $getberitabykategori)
      ->with('getfooterkat', $getfooterkat)
      ->with('getgaleri', $getgaleri)
      ->with('getsosmed', $getsosmed)
      ->with('getvideo', $getvideo)
      ->with('getaplikasi', $getaplikasi)
      ->with('getheadline', $getheadline);
  }
}
