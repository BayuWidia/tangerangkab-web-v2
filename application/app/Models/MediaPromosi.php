<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaPromosi extends Model
{
  protected $table = 'media_promosi';

  protected $fillable = [
    'id_skpd', 'id_user', 'nama_promosi', 'link', 'url_foto', 'flag_aktif'
  ];

  public function masterskpd()
  {
    return $this->belongsTo('App\Models\MasterSKPD', 'id_skpd');
  }
}
