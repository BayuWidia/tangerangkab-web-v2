<?php

namespace App\Http\Controllers;


use DB;

use App\Models\Berita;
use App\Models\MasterSKPD;
use App\Models\KategoriBerita;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class ChartBeritaController extends Controller
{

  
  public function jumlahberita()
  {
    $getberitaall = Berita::select('*')
                  ->join('kategori_berita', 'berita.id_kategori', '=', 'kategori_berita.id')
                  ->where('kategori_berita.flag_utama', '0')
                  ->count('berita.id');
    $getberitablmpublish = Berita::select('*')->where('flag_publish', '0')
                          ->join('kategori_berita', 'berita.id_kategori', '=', 'kategori_berita.id')
                          ->where('kategori_berita.flag_utama', '0')
                          ->count('berita.id');;
    $getberitasdhpublish = Berita::select('*')->where('flag_publish', '1')
                          ->join('kategori_berita', 'berita.id_kategori', '=', 'kategori_berita.id')
                          ->where('kategori_berita.flag_utama', '0')
                          ->count('berita.id');
    // dd($getberitaall);
    
     return view('backend/pages/chartjumlahberita', compact('getberitaall', 'getberitablmpublish', 'getberitasdhpublish'));
  }

  public function skpdberita()
  {
    // dd("asdasd");
    $skpdberita = DB::table('master_skpd')
                   ->join('berita', 'master_skpd.id', '=', 'berita.id_skpd')
                   ->join('kategori_berita', 'berita.id_kategori', '=', 'kategori_berita.id')
                   ->select('master_skpd.id', 'master_skpd.nama_skpd', 
                      DB::raw('count(berita.id) as jumlahberita'), 'master_skpd.flag_skpd', 'master_skpd.id')
                   ->where('kategori_berita.flag_utama', '0')
                   ->groupBy('master_skpd.id')
                   ->orderby('jumlahberita', 'desc')
                   ->get();
      
    
     return view('backend/pages/beritaskpd', compact('skpdberita'));
  }

  public function beritabyskpd($id)
  {
    // dd($id);
    $getberita = Berita::join('kategori_berita', 'kategori_berita.id', '=', 'berita.id_kategori')
      ->leftjoin('master_skpd', 'berita.id_skpd', '=', 'master_skpd.id')
      ->select('berita.*', 'kategori_berita.nama_kategori', 'master_skpd.nama_skpd')
      ->where('berita.id_skpd', $id)
      ->where('kategori_berita.flag_utama', '0')
      ->get();
      // dd($getberita);
    
     return view('backend/pages/beritabyskpd', compact('getberita'));
  }

 public function beritachart()
  {
    $getbignumber = DB::table('master_skpd')
                      ->join('berita', 'berita.id_skpd', '=', 'master_skpd.id')
                      ->join('kategori_berita', 'berita.id_kategori', '=', 'kategori_berita.id')
                      ->select(DB::raw('count(berita.id) as jumlahberita'), 'master_skpd.nama_skpd')
                      ->where('kategori_berita.flag_utama', '0')
                      ->groupBy('master_skpd.nama_skpd')
                      ->orderby('jumlahberita', 'desc')
                      ->limit(5)->get();

    $getnamaskpd = array();
    $i = 0;
    foreach ($getbignumber as $key) {
      $getnamaskpd[$i] = $key->nama_skpd;
      $i++;
    }
    $getdataforareachart = array();
    if (count($getnamaskpd) == 1) {
      $getdataforareachart = DB::table('berita')
                              ->select(DB::raw('substr(berita.created_at, 1, 7) as y'),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[0]') as 'a'"))
                              ->join('master_skpd', 'berita.id_skpd', '=', 'master_skpd.id')
                              ->join('kategori_berita', 'berita.id_kategori', '=', 'kategori_berita.id')
                              ->where('kategori_berita.flag_utama', '0')
                              ->groupBy(DB::raw('extract(month from berita.created_at)'))
                              ->orderby('berita.created_at', 'asc')
                              ->get();

                      
    } elseif (count($getnamaskpd) == 2) {
      $getdataforareachart = DB::table('berita')
                              ->select(DB::raw('substr(berita.created_at, 1, 7) as y'),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[0]') as 'a'"),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[1]') as 'a'"))
                              ->join('master_skpd', 'berita.id_skpd', '=', 'master_skpd.id')
                              ->join('kategori_berita', 'berita.id_kategori', '=', 'kategori_berita.id')
                              ->where('kategori_berita.flag_utama', '0')
                              ->groupBy(DB::raw('extract(month from berita.created_at)'))
                              ->orderby('berita.created_at', 'asc')
                              ->get();

                      
    } elseif (count($getnamaskpd) == 3) {
      $getdataforareachart = DB::table('berita')
                              ->select(DB::raw('substr(berita.created_at, 1, 7) as y'),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[0]') as 'a'"),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[1]') as 'b'"),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[2]') as 'c'"))
                              ->join('master_skpd', 'berita.id_skpd', '=', 'master_skpd.id')
                              ->join('kategori_berita', 'berita.id_kategori', '=', 'kategori_berita.id')
                              ->where('kategori_berita.flag_utama', '0')
                              ->groupBy(DB::raw('extract(month from berita.created_at)'))
                              ->orderby('berita.created_at', 'asc')
                              ->get();

                      
    } elseif (count($getnamaskpd) == 4) {
      $getdataforareachart = DB::table('berita')
                              ->select(DB::raw('substr(berita.created_at, 1, 7) as y'),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[0]') as 'a'"),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[1]') as 'b'"),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[2]') as 'c'"),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[3]') as 'd'"))
                              ->join('master_skpd', 'berita.id_skpd', '=', 'master_skpd.id')
                              ->join('kategori_berita', 'berita.id_kategori', '=', 'kategori_berita.id')
                              ->where('kategori_berita.flag_utama', '0')
                              ->groupBy(DB::raw('extract(month from berita.created_at)'))
                              ->orderby('berita.created_at', 'asc')
                              ->get();

                      
    } elseif (count($getnamaskpd) == 5) {
      $getdataforareachart = DB::table('berita')
                              ->select(DB::raw('substr(berita.created_at, 1, 7) as y'),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[0]') as 'a'"),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[1]') as 'b'"),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[2]') as 'c'"),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[3]') as 'd'"),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[4]') as 'e'"))
                              ->join('master_skpd', 'berita.id_skpd', '=', 'master_skpd.id')
                              ->join('kategori_berita', 'berita.id_kategori', '=', 'kategori_berita.id')
                              ->where('kategori_berita.flag_utama', '0')
                              ->groupBy(DB::raw('extract(month from berita.created_at)'))
                              ->orderby('berita.created_at', 'asc')
                              ->get();

                      
    }     
                      // dd($getbignumber);
                      // dd($getnamaskpd);
                      // dd($getdataforareachart);

    return $getdataforareachart;
  }


  public function countberitabyskpd()
  {
    $getbignumber = DB::table('master_skpd')
                      ->join('berita', 'berita.id_skpd', '=', 'master_skpd.id')
                      ->join('kategori_berita', 'berita.id_kategori', '=', 'kategori_berita.id')
                      ->select(DB::raw('count(berita.id) as jumlahberita'), 'master_skpd.nama_skpd')
                      ->where('kategori_berita.flag_utama', '0')
                      ->groupBy('master_skpd.nama_skpd')
                      ->orderby('jumlahberita', 'desc')
                      ->limit(5)->get();

    $getnamaskpd = array();
    $i = 0;
    foreach ($getbignumber as $key) {
      $getnamaskpd[$i] = $key->nama_skpd;
      $i++;
    }
    
    return $getnamaskpd;
  }

}
