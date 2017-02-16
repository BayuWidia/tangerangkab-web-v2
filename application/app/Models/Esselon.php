<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Esselon extends Model
{
  protected $table = 'esselon';

  protected $fillable = [
    'nama_esselon', 'urutan_esselon'
  ];

  public function pegawai()
  {
    return $this->hasMany('App\Models\Pegawai');
  }
}
