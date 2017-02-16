<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
  protected $table = 'menu';

  protected $fillable = [
    'nama', 'level', 'parent_menu'
  ];

  public function menukonten()
  {
    return $this->hasOne('App\Models\MenuKonten');
  }
}
