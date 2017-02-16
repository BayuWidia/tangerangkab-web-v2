<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriBerita extends Model
{
  protected $table = 'kategori_berita';

  protected $fillable = [
    'nama_kategori', 'keterangan_kategori', 'flag_kategori'
  ];

  public function users()
  {
    return $this->hasMany('App\Models\Berita');
  }
}
