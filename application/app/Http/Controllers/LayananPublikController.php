<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class LayananPublikController extends Controller
{

  public function index()
  {
    return view('frontend.pages.layananpublik');
  }

  public function layananpublikDetail()
  {
    return view('frontend.pages.layananpublikDetail');
  }
}
