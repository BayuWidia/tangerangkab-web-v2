<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuKonten extends Model
{
  protected $table = 'menu_konten';

  protected $fillable = [
    'id_skpd', 'id_user', 'flagpublish', 'view_counter', 'id_submenu', 'judul_konten', 'tanggal_publish', 'url_foto', 'tags', 'isi_konten'
  ];

  public function menu()
  {
    return $this->belongsTo('App\Models\Menu', 'id_submenu');
  }
}
