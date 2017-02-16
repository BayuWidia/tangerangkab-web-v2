<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
  protected $table = 'pegawai';

  protected $fillable = [
    'nama_pegawai', 'jenis_kelamin', 'id_esselon', 'id_pangkat', 'id_skpd', 'flag_pegawai'
  ];

  public function esselon()
  {
    return $this->belongsTo('App\Models\Esselon', 'id_esselon');
  }

  public function pangkat()
  {
    return $this->belongsTo('App\Models\Pangkat', 'id_pangkat');
  }

}
