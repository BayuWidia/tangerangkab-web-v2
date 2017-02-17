<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Berita extends Model
{
  use Searchable;

  protected $table = 'berita';

  protected $fillable = [
    'id_kategori', 'id_skpd', 'flag_headline', 'flag_publish', 'judul_berita', 'tanggal_publish', 'url_foto', 'tags', 'isi_berita'
  ];

  public function kategori()
  {
    return $this->belongsTo('App\Models\KategoriBerita', 'id_kategori');
  }

  public function masterskpd()
  {
    return $this->belongsTo('App\Models\KategoriBerita', 'id_skpd');
  }

  public function searchableAs()
  {
      return 'berita';
  }
}
