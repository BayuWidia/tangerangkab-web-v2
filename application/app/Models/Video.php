<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
  protected $table = 'video';

  protected $fillable = [
    'id_skpd', 'url_video', 'judul_video', 'flag_video'
  ];

  public function master_skpd()
  {
    return $this->belongsTo('App\Models\MasterSKPD', 'id_skpd');
  }
}
