<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggaran extends Model
{
  protected $table = 'anggaran';

  protected $fillable = [
    'uraian', 'tahun', 'id_skpd', 'flag_anggaran'
  ];

  public function masterskpd()
  {
    return $this->belongsTo('App\Models\MasterSKPD', 'id_skpd');
  }
}
