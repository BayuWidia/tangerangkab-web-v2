<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statistik extends Model
{
  protected $table = 'statistik';

  protected $fillable = [
    'nama_statistik', 'link_statistik', 'url_logo', 'id_skpd', 'flag_statistik'
  ];

  public function master_skpd()
  {
    return $this->belongsTo('App\Models\MasterSKPD', 'id_skpd');
  }
}
