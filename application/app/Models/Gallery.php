<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
  protected $table = 'galeri';

  protected $fillable = [
    'id_skpd', 'url_gambar', 'keterangan_gambar', 'flag_gambar'
  ];

  public function masterskpd()
  {
    return $this->belongsTo('App\Models\MasterSKPD', 'id_skpd');
  }
}
