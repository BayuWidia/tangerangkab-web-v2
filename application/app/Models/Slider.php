<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
  protected $table = 'slider';

  protected $fillable = [
    'id_skpd', 'url_slider', 'keterangan_slider', 'flag_slider'
  ];

  public function master_skpd()
  {
    return $this->belongsTo('App\Models\MasterSKPD', 'id_skpd');
  }
}
