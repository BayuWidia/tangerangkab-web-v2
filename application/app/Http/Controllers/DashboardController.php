<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\User;
use App\Http\Requests;
use App\Models\Berita;
use App\Models\Aplikasi;
use App\Models\MasterSKPD;

class DashboardController extends Controller
{
  public function index()
  {
    if (Auth::user()->level=="1") {
      $beritaterbaru = Berita::leftjoin('kategori_berita', 'berita.id_kategori', '=', 'kategori_berita.id')
      ->leftjoin('master_skpd', 'master_skpd.id', '=', 'berita.id_skpd')
      ->where('kategori_berita.flag_utama', 0)
      ->select('berita.view_counter', 'master_skpd.singkatan', 'berita.url_foto', 'berita.judul_berita', 'master_skpd.nama_skpd', 'berita.created_at', 'berita.flag_headline', 'berita.isi_berita', 'kategori_berita.nama_kategori', 'berita.id_skpd')
      ->orderby('berita.created_at', 'desc')
      ->get();

      $beritaheadline = Berita::leftjoin('kategori_berita', 'berita.id_kategori', '=', 'kategori_berita.id')
      ->leftjoin('master_skpd', 'master_skpd.id', '=', 'berita.id_skpd')
      ->select('berita.id as id_berita', 'berita.view_counter', 'master_skpd.singkatan', 'berita.url_foto', 'berita.judul_berita', 'master_skpd.nama_skpd', 'berita.created_at', 'berita.flag_headline', 'berita.isi_berita', 'kategori_berita.nama_kategori', 'berita.id_skpd')
      ->where('berita.id_skpd', null)
      ->where('berita.flag_headline_utama', 1)
      ->orderby('berita.created_at', 'desc')
      ->limit(6)
      ->get();

      $countberita = Berita::all()->count();
      $countskpd = MasterSKPD::all()->count();
      $countaplikasi = Aplikasi::where('id_skpd', null)->count();
      $countuser = User::where('activated', 1)->count();

    } else {
      $beritaterbaru = Berita::leftjoin('kategori_berita', 'berita.id_kategori', '=', 'kategori_berita.id')
      ->leftjoin('master_skpd', 'master_skpd.id', '=', 'berita.id_skpd')
      ->where([
          ['kategori_berita.flag_utama', 0],
          ['berita.id_skpd', Auth::user()->masterskpd->id]
        ])
      ->select('berita.view_counter', 'master_skpd.singkatan', 'berita.url_foto', 'berita.judul_berita', 'master_skpd.nama_skpd', 'berita.created_at', 'berita.flag_headline', 'berita.isi_berita', 'kategori_berita.nama_kategori')
      ->orderby('berita.created_at', 'desc')
      ->get();

      $beritaheadline = Berita::leftjoin('kategori_berita', 'berita.id_kategori', '=', 'kategori_berita.id')
      ->leftjoin('master_skpd', 'master_skpd.id', '=', 'berita.id_skpd')
      ->select('berita.id as id_berita', 'berita.view_counter', 'master_skpd.singkatan', 'berita.url_foto', 'berita.judul_berita', 'master_skpd.nama_skpd', 'berita.created_at', 'berita.flag_headline', 'berita.isi_berita', 'kategori_berita.nama_kategori', 'berita.id_skpd')
      ->where('berita.flag_headline', 1)
      ->where('berita.id_skpd', Auth::user()->masterskpd->id)
      ->orderby('berita.created_at', 'desc')
      ->limit(6)
      ->get();

      $countberita = Berita::where('id_skpd', Auth::user()->masterskpd->id)->count();
      $countskpd = MasterSKPD::all()->count();
      $countaplikasi = Aplikasi::where('id_skpd', Auth::user()->masterskpd->id)->count();
      $countuser = User::where('id_skpd', Auth::user()->masterskpd->id)->count();
    }

    return view('backend/pages/dashboard')
      ->with('countberita', $countberita)
      ->with('countskpd', $countskpd)
      ->with('countaplikasi', $countaplikasi)
      ->with('countuser', $countuser)
      ->with('beritaheadline', $beritaheadline)
      ->with('beritaterbaru', $beritaterbaru);
  }
}
