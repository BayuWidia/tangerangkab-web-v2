<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pangkat extends Model
{
  protected $table = 'pangkat';

  protected $fillable = [
    'pangkat', 'golongan', 'urutan_pangkat'
  ];

  public function pegawai()
  {
    return $this->hasMany('App\Models\Pegawai');
  }
}
