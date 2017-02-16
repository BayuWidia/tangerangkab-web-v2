<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterSKPD extends Model
{
  protected $table = 'master_skpd';

  protected $fillable = [
    'nama_skpd', 'domain_skpd', 'flag_skpd'
  ];

  public function users()
  {
    return $this->hasMany('App\Models\User');
  }

  public function berita()
  {
    return $this->hasMany('App\Models\Berita');
  }

  public function gallery()
  {
    return $this->hasMany('App\Models\Gallery');
  }

  public function video()
  {
    return $this->hasMany('App\Models\Video');
  }

  public function aplikasi()
  {
    return $this->hasMany('App\Models\Aplikasi');
  }
}
