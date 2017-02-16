<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password', 'level', 'id_skpd', 'url_foto', 'activated', 'activation_code', 'remember_token'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function masterskpd()
    {
      return $this->belongsTo('App\Models\MasterSKPD', 'id_skpd');
    }

    public function slider()
    {
      return $this->hasMany('App\Models\Slider');
    }
}
