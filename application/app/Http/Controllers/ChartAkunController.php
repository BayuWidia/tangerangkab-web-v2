<?php

namespace App\Http\Controllers;


use DB;

use App\Models\MasterSKPD;
use App\Models\User;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class ChartAkunController extends Controller
{

  
  public function jumlahakun()
  {
    $getakunall = User::select('*')->count('id');
    $getakuntdkaktif = User::select('*')->where('activated', '0')->count('id');
    $getakunaktif = User::select('*')->where('activated', '1')->count('id');
      // dd($getakunskpd);
    
     return view('backend/pages/chartjumlahakun', compact('getakunall','getakuntdkaktif','getakunaktif'));
  }

 public function akunchart()
  {
     $getbignumber = DB::table('master_skpd')
                      ->leftJoin('users', 'users.id_skpd', '=', 'master_skpd.id')
                      ->select(DB::raw('count(users.id) as jumlahakun'), 'master_skpd.nama_skpd')
                      ->groupBy('master_skpd.nama_skpd')
                      ->orderby('jumlahakun', 'desc')
                      ->limit(5)->get();

    $getnamaskpd = array();
    $i = 0;
    foreach ($getbignumber as $key) {
      $getnamaskpd[$i] = $key->nama_skpd;
      $i++;
    }

    $getdataforareachart = array();
    if (count($getnamaskpd) == 1) {
      $getdataforareachart = DB::table('users')
                              ->select(DB::raw('substr(users.created_at, 1, 7) as y'),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[0]') as 'a'"))
                              ->join('master_skpd', 'users.id_skpd', '=', 'master_skpd.id')
                              ->groupBy(DB::raw('extract(month from users.created_at)'))
                              ->orderby('users.created_at', 'asc')
                              ->get();

                      
    } elseif (count($getnamaskpd) == 2) {
      $getdataforareachart = DB::table('users')
                              ->select(DB::raw('substr(users.created_at, 1, 7) as y'),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[0]') as 'a'"),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[1]') as 'b'"))
                              ->join('master_skpd', 'users.id_skpd', '=', 'master_skpd.id')
                              ->groupBy(DB::raw('extract(month from users.created_at)'))
                              ->orderby('users.created_at', 'asc')
                              ->get();

                      
    } elseif (count($getnamaskpd) == 3) {
      $getdataforareachart = DB::table('users')
                              ->select(DB::raw('substr(users.created_at, 1, 7) as y'),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[0]') as 'a'"),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[1]') as 'b'"),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[2]') as 'c'"))
                              ->join('master_skpd', 'users.id_skpd', '=', 'master_skpd.id')
                              ->groupBy(DB::raw('extract(month from users.created_at)'))
                              ->orderby('users.created_at', 'asc')
                              ->get();

                      
    } elseif (count($getnamaskpd) == 4) {
      $getdataforareachart = DB::table('users')
                              ->select(DB::raw('substr(users.created_at, 1, 7) as y'),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[0]') as 'a'"),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[1]') as 'b'"),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[2]') as 'c'"),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[3]') as 'd'"))
                              ->join('master_skpd', 'users.id_skpd', '=', 'master_skpd.id')
                              ->groupBy(DB::raw('extract(month from users.created_at)'))
                              ->orderby('users.created_at', 'asc')
                              ->get();

                      
    } elseif (count($getnamaskpd) == 5) {
      $getdataforareachart = DB::table('users')
                              ->select(DB::raw('substr(users.created_at, 1, 7) as y'),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[0]') as 'a'"),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[1]') as 'b'"),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[2]') as 'c'"),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[3]') as 'd'"),
                                  DB::raw("sum(master_skpd.nama_skpd='$getnamaskpd[4]') as 'e'"))
                              ->join('master_skpd', 'users.id_skpd', '=', 'master_skpd.id')
                              ->groupBy(DB::raw('extract(month from users.created_at)'))
                              ->orderby('users.created_at', 'asc')
                              ->get();

                      
    }     
                      // dd($getbignumber);
                      // dd($getnamaskpd);
                      // dd($getdataforareachart);

    return $getdataforareachart;
  }


  public function countakunbyskpd()
  {
    $getbignumber = DB::table('master_skpd')
                      ->leftJoin('users', 'users.id_skpd', '=', 'master_skpd.id')
                      ->select(DB::raw('count(users.id) as jumlahakun'), 'master_skpd.nama_skpd')
                      ->groupBy('master_skpd.nama_skpd')
                      ->orderby('jumlahakun', 'desc')
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
