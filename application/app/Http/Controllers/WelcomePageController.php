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
use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Aplikasi;
use App\Models\Statistik;
use App\Models\MediaPromosi;
use App\Models\Menu;
use App\Models\MediaSosial;
use App\Models\Anggaran;

class WelcomePageController extends Controller
{
  public function index()
  {
    // NAVBAR //
    $getsekilastangerang = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select(DB::raw('distinct(kategori_berita.nama_kategori)'), 'kategori_berita.id')
      ->where('berita.id_skpd', null)
      ->where('kategori_berita.flag_utama', 1)
      ->get();

    $getberita = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select(DB::raw('distinct(kategori_berita.nama_kategori)'), 'kategori_berita.id')
      ->where('berita.id_skpd', null)
      ->where('kategori_berita.flag_utama', 0)
      ->get();

    // SLIDER //
    $getslider = Slider::where([
      ['id_skpd', null],
      ['flag_slider', 1]
    ])->orderby('created_at', 'desc')
    ->get();

    // BERITA TERKINI (MARQUEE) //
    $getberitaterbaru = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select('berita.judul_berita', 'berita.id', 'berita.created_at', 'berita.url_foto', 'kategori_berita.nama_kategori')
      ->where('flag_publish', 1)
      ->where('kategori_berita.flag_utama', 0)
      ->orderby('berita.created_at', 'desc')
      ->limit(12)
      ->get();

    // HEADLINE //
    $getheadline = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
    ->select('berita.judul_berita', 'berita.id', 'berita.created_at', 'berita.url_foto', 'kategori_berita.nama_kategori')
    ->where('flag_publish', 1)
    ->where('kategori_berita.flag_utama', 0)
    ->where('flag_headline_utama', 1)
    ->orderby('berita.created_at', 'desc')
    ->limit(4)
    ->get();


    // BERITA SKPD //
    $getberitaskpd = Berita::join('master_skpd', 'master_skpd.id', '=', 'berita.id_skpd')
      ->join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select('berita.id', 'berita.judul_berita', 'master_skpd.singkatan', 'berita.url_foto')
      ->where('berita.id_skpd', '!=', null)
      ->where('kategori_berita.flag_utama', 0)
      ->where('flag_publish', 1)
      ->orderby('tanggal_publish', 'desc')
      ->limit(4)
      ->get();

      // dd($getberitaskpd);

    // JEJARING //
    $getjejaring = MasterSKPD::where('flag_skpd', 1)->get();

    // BERITA PER KATEGORI //
    $gettop4 = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->select('id_kategori', DB::raw('count(*) as jumlah'))
      ->where('berita.id_skpd', null)
      ->where('flag_utama', 0)
      ->where('flag_publish', 1)
      ->groupby('id_kategori')
      ->orderby('jumlah', 'desc')
      ->limit(4)
      ->get();

    $getberitabykategori = array();

    $i=0;
    foreach ($gettop4 as $key) {
      $getberitabykategori[$i] = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
        ->select('*', 'berita.created_at as tanggal_posting', 'berita.id as id_berita', 'kategori_berita.id as id_kategori')
        ->where('id_kategori', $key->id_kategori)
        ->where('flag_utama', 0)
        ->where('flag_publish', 1)
        ->orderby('berita.updated_at', 'desc')
        ->get();
      $i++;
    }

    // GET KATEGORI FOR FOOTER //
    $getfooterkat = KategoriBerita::where('id_skpd', null)->where('flag_utama', 0)->get();

    // GET GALERI //
    $getgaleri = Gallery::where('id_skpd', null)->limit(18)->get();

    //GET VIDEO
    $getvideo = Video::where('id_skpd', null)->where('flag_important_video', 1)->orderBy('created_at', 'desc')->limit(3)->get();

    //GET APLIKASI
    $getaplikasi = Aplikasi::where('id_skpd', null)->orderBy('created_at')->limit(12)->get();

    //GET APLIKASI
    $getstatistik = Statistik::where('id_skpd', null)->orderBy('created_at')->limit(12)->get();
    
    //GET MENU
    $getmenu = Menu::where([['level', 1], ['id_skpd', null]])->get();
    $getsubmenu = Menu::select('*', 'menu_konten.id as menukontenid')
                    ->join('menu_konten', 'menu.id', '=', 'menu_konten.id_submenu')
                    ->where([['level', 2], ['menu.id_skpd', null]])->get();

    //GET MEDIA PROMOSI
    $getpromo = MediaPromosi::where([['flag_aktif', 1], ['id_skpd', null]])->limit(10)->get();

    //GET ANGGARAN
    $getanggaran = Anggaran::where('id_skpd', null)->get();

    //GET sosmed
    $getsosmed = MediaSosial::where('id_skpd', null)->get();

    return view('frontend.pages.index')
      ->with('getsosmed', $getsosmed)
      ->with('getstatistik', $getstatistik)
      ->with('getanggaran', $getanggaran)
      ->with('getpromo', $getpromo)
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
      ->with('getvideo', $getvideo)
      ->with('getaplikasi', $getaplikasi)
      ->with('getheadline', $getheadline);
  }
}
