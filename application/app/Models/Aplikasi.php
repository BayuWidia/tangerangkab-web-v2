<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aplikasi extends Model
{
  protected $table = 'aplikasi';

  protected $fillable = [
    'id_skpd', 'nama_aplikasi', 'domain_aplikasi', 'url_logo', 'keterangan_aplikasi', 'flag_aplikasi'
  ];

  public function master_skpd()
  {
    return $this->belongsTo('App\Models\MasterSKPD', 'id_skpd');
  }
}
