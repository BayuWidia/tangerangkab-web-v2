<?php

namespace App\Http\Controllers;


use DB;

use App\Models\Berita;
use App\Models\MasterSKPD;
use App\Models\KategoriBerita;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class ChartKategoriBeritaController extends Controller
{

  
  public function jumlahkategoriberita()
  {
    $getkategoriskpd = DB::table('master_skpd')
                   ->join('kategori_berita', 'master_skpd.id', '=', 'kategori_berita.id_skpd')
                   ->select('master_skpd.id', 'master_skpd.nama_skpd',
                      DB::raw('count(kategori_berita.id) as jumlahkategori'), 'master_skpd.flag_skpd', 'master_skpd.id',
                      'kategori_berita.id as id_kategori')
                   ->where('kategori_berita.flag_utama', '0')
                   ->groupBy('master_skpd.id')
                   ->orderby('jumlahkategori', 'desc')
                   ->paginate(5);
      // dd($getkategoriskpd);
    
     return view('backend/pages/chartjumlahkategoriberita', compact('getkategoriskpd'));
  }

  public function kategoribyskpd($id)
  {
    
    $getkategori = KategoriBerita::
      select('kategori_berita.*', 'master_skpd.nama_skpd')
      ->leftjoin('master_skpd', 'kategori_berita.id_skpd', '=', 'master_skpd.id')
      ->where('kategori_berita.id_skpd', $id)
      ->where('kategori_berita.flag_utama', '0')
      ->get();
      // dd($getkategori);
    
     return view('backend/pages/kategoribyskpd', compact('getkategori'));
  }

 public function kategoriberitachart()
  {
     $getbignumber = DB::table('master_skpd')
                      ->join('kategori_berita', 'kategori_berita.id_skpd', '=', 'master_skpd.id')
                      ->select(DB::raw('count(kategori_berita.id) as jumlahkategori'), 'master_skpd.nama_skpd')
                      ->where('flag_utama', '0')
                      ->groupBy('master_skpd.nama_skpd')
                      ->orderby('jumlahkategori', 'desc')
                      ->limit(5)->get();

    $getnamaskpd = array();
    $i = 0;
    foreach ($getbignumber as $key) {
      $getnamaskpd[$i] = $key->nama_skpd;
      $i++;
    }

    $getdataforareachart = array();
    if (count($getnamaskpd) == 1) {
      $getdataforareachart = DB::table('kategori_berita')
                              ->select(DB::raw('substr(kategori_berita.created_at, 1, 7) as y'),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[0]') as 'a'"))
                              ->join('master_skpd', 'kategori_berita.id_skpd', '=', 'master_skpd.id')
                              ->where('flag_utama', '0')
                              ->groupBy(DB::raw('extract(month from kategori_berita.created_at)'))
                              ->orderby('kategori_berita.created_at', 'asc')
                              ->get();

                      
    } elseif (count($getnamaskpd) == 2) {
      $getdataforareachart = DB::table('kategori_berita')
                              ->select(DB::raw('substr(kategori_berita.created_at, 1, 7) as y'),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[0]') as 'a'"),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[1]') as 'b'"))
                              ->join('master_skpd', 'kategori_berita.id_skpd', '=', 'master_skpd.id')
                              ->where('flag_utama', '0')
                              ->groupBy(DB::raw('extract(month from kategori_berita.created_at)'))
                              ->orderby('kategori_berita.created_at', 'asc')
                              ->get();

                      
    } elseif (count($getnamaskpd) == 3) {
      $getdataforareachart = DB::table('kategori_berita')
                              ->select(DB::raw('substr(kategori_berita.created_at, 1, 7) as y'),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[0]') as 'a'"),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[1]') as 'b'"),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[2]') as 'c'"))
                              ->join('master_skpd', 'kategori_berita.id_skpd', '=', 'master_skpd.id')
                              ->where('flag_utama', '0')
                              ->groupBy(DB::raw('extract(month from kategori_berita.created_at)'))
                              ->orderby('kategori_berita.created_at', 'asc')
                              ->get();

                      
    } elseif (count($getnamaskpd) == 4) {
      $getdataforareachart = DB::table('kategori_berita')
                              ->select(DB::raw('substr(kategori_berita.created_at, 1, 7) as y'),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[0]') as 'a'"),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[1]') as 'b'"),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[2]') as 'c'"),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[3]') as 'd'"))
                              ->join('master_skpd', 'kategori_berita.id_skpd', '=', 'master_skpd.id')
                              ->where('flag_utama', '0')
                              ->groupBy(DB::raw('extract(month from kategori_berita.created_at)'))
                              ->orderby('kategori_berita.created_at', 'asc')
                              ->get();

                      
    } elseif (count($getnamaskpd) == 5) {
      $getdataforareachart = DB::table('kategori_berita')
                              ->select(DB::raw('substr(kategori_berita.created_at, 1, 7) as y'),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[0]') as 'a'"),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[1]') as 'b'"),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[2]') as 'c'"),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[3]') as 'd'"),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[4]') as 'e'"))
                              ->join('master_skpd', 'kategori_berita.id_skpd', '=', 'master_skpd.id')
                              ->where('flag_utama', '0')
                              ->groupBy(DB::raw('extract(month from kategori_berita.created_at)'))
                              ->orderby('kategori_berita.created_at', 'asc')
                              ->get();

                      
    }     
                      // dd($getbignumber);
                      // dd($getnamaskpd);
                      // dd($getdataforareachart);

    return $getdataforareachart;
  }


  public function countkategoriberitabyskpd()
  {
    $getbignumber = DB::table('master_skpd')
                      ->join('kategori_berita', 'kategori_berita.id_skpd', '=', 'master_skpd.id')
                      ->select(DB::raw('count(kategori_berita.id) as jumlahkategori'), 'master_skpd.nama_skpd')
                      ->where('flag_utama', '0')
                      ->groupBy('master_skpd.nama_skpd')
                      ->orderby('jumlahkategori', 'desc')
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
