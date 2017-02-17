<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

///////////////////////////////////////// BACKEND ROUTE /////////////////////////////////////////

//ROUTE LOGIN
Route::get('admin/login', function () {
  return view('backend/pages/login');
})->name('login.pages');
Route::get('logout-process', 'AkunController@logoutProcess')->name('logout');
Route::post('login-process', 'AkunController@loginProcess')->name('login');

//ROUTE GROUP ISLOGGEDIN
Route::group(['middleware' => ['isLoggedIn']], function () {
  Route::get('admin/dashboard', 'DashboardController@index')->name('dashboard');

  //Informasi Utama
  Route::get('admin/lihat-info-utama', 'InfoUtamaController@lihat')->name('infoutama.lihat');
  Route::get('admin/tambah-info-utama', 'InfoUtamaController@tambah')->name('infoutama.tambah');
  Route::post('admin/store-info-utama', 'InfoUtamaController@store')->name('infoutama.store');
  Route::get('admin/publish-info-utama/{id}', 'InfoUtamaController@flagpublish')->name('infoutama.flagpublish');
  Route::get('admin/edit-info-utama/{id}', 'InfoUtamaController@edit')->name('infoutama.edit');
  Route::post('admin/update-info-utama/{id}', 'InfoUtamaController@update')->name('infoutama.update');
  Route::get('admin/delete-info-utama/{id}', 'InfoUtamaController@delete')->name('infoutama.delete');

  //Kategori Informasi Utama
  Route::get('admin/lihat-kategori-info-utama', 'KategoriUtamaController@lihatkategori')->name('kategoriutama.lihat');
  Route::post('admin/store-kategori-info-utama', 'KategoriUtamaController@store')->name('kategoriutama.store');
  Route::post('admin/edit-kategori-info-utama', 'KategoriUtamaController@edit')->name('kategoriutama.edit');

  //Berita
  Route::get('admin/lihat-berita', 'BeritaBackendController@lihat')->name('berita.lihat')->middleware('isLoggedIn');
  Route::get('admin/tambah-berita', 'BeritaBackendController@tambah')->name('berita.tambah');
  Route::post('admin/store-berita', 'BeritaBackendController@store')->name('berita.store');
  Route::get('admin/edit-berita/{id}', 'BeritaBackendController@edit')->name('berita.edit');
  Route::post('admin/update-berita', 'BeritaBackendController@update')->name('berita.update');
  Route::get('admin/publish-berita/{id}', 'BeritaBackendController@flagpublish')->name('berita.flagpublish');
  Route::get('admin/headline-berita/{id}', 'BeritaBackendController@headline')->name('berita.headline');
  Route::get('admin/delete-berita/{id}', 'BeritaBackendController@delete')->name('berita.delete');
  Route::get('admin/preview-konten/{id}', 'BeritaBackendController@preview')->name('berita.preview');
  Route::get('admin/headline-utama/{id}', 'BeritaBackendController@headlineutama')->name('berita.headlineutama');

  //Kategori Berita
  Route::get('admin/kategori-berita', 'KategoriBeritaController@index')->name('kategori.index');
  Route::post('admin/store-kategori-berita', 'KategoriBeritaController@store')->name('kategori.store');
  Route::post('admin/edit-kategori-berita', 'KategoriBeritaController@edit')->name('kategori.edit');
  Route::get('admin/bind-kategori-berita/{id}', 'KategoriBeritaController@bind')->name('kategori.bind');
  Route::get('admin/delete-kategori-berita/{id}', 'KategoriBeritaController@delete')->name('kategori.delete');
  Route::get('admin/change-status-kategori/{id}', 'KategoriBeritaController@changeflag')->name('kategori.changeflag');

  //Data SKPD
  Route::get('admin/lihat-skpd', 'SKPDController@index')->name('skpd.kelola');
  Route::post('admin/store-skpd', 'SKPDController@store')->name('skpd.store');
  Route::get('admin/change-status-skpd/{id}', 'SKPDController@changeflag')->name('skpd.changeflag');
  Route::get('admin/delete-skpd/{id}', 'SKPDController@delete')->name('skpd.delete');
  Route::post('admin/edit-skpd', 'SKPDController@edit')->name('skpd.edit');
  Route::get('admin/bind-skpd/{id}', 'SKPDController@bind')->name('skpd.bind');

  //Management Akun
  Route::get('admin/kelola-akun', 'AkunController@index')->name('akun.kelola');
  Route::post('admin/store-akun', 'AkunController@store')->name('akun.store');
  Route::post('admin/update-akun', 'AkunController@update')->name('akun.update');
  Route::get('admin/delete-akun/{id}', 'AkunController@delete')->name('akun.delete');
  Route::get('admin/bind-akun/{id}', 'AkunController@bind')->name('akun.bind');
  Route::get('email-activation/{code}', 'AkunController@emailActivation');
  Route::post('set-password', 'AkunController@setPassword')->name('setpassword');

  //Slider
  Route::get('admin/kelola-slider', 'SliderController@index')->name('slider.index');
  Route::post('admin/store-slider', 'SliderController@store')->name('slider.store');
  Route::get('admin/delete-slider/{id}', 'SliderController@delete')->name('slider.delete');
  Route::post('admin/edit-slider', 'SliderController@edit')->name('slider.edit');
  Route::get('admin/publish-slider/{id}', 'SliderController@publish')->name('slider.publish');
  Route::get('admin/bind-slider/{id}', 'SliderController@bind')->name('slider.bind');

  //Media Sosial
  Route::get('admin/kelola-sosmed', 'MediaSosialController@index')->name('sosmed.index');
  Route::post('admin/store-sosmed', 'MediaSosialController@store')->name('sosmed.store');
  Route::get('admin/delete-sosmed/{id}', 'MediaSosialController@delete')->name('sosmed.delete');
  Route::post('admin/edit-sosmed', 'MediaSosialController@edit')->name('sosmed.edit');
  Route::get('admin/publish-sosmed/{id}', 'MediaSosialController@publish')->name('sosmed.publish');
  Route::get('admin/bind-sosmed/{id}', 'MediaSosialController@bind')->name('sosmed.bind');

  //Galeri
  Route::get('admin/kelola-galeri', 'GalleryController@index')->name('galeri.index');
  Route::post('admin/store-galeri', 'GalleryController@store')->name('galeri.store');
  Route::get('admin/delete-galeri/{id}', 'GalleryController@delete')->name('galeri.delete');
  Route::post('admin/edit-galeri', 'GalleryController@edit')->name('galeri.edit');
  Route::get('admin/publish-galeri/{id}', 'GalleryController@publish')->name('galeri.publish');
  Route::get('admin/bind-galeri/{id}', 'GalleryController@bind')->name('galeri.bind');

  //Video
  Route::get('admin/kelola-video', 'VideoController@index')->name('video.index');
  Route::post('admin/store-video', 'VideoController@store')->name('video.store');
  Route::get('admin/delete-video/{id}', 'VideoController@delete')->name('video.delete');
  Route::post('admin/edit-video', 'VideoController@edit')->name('video.edit');
  Route::get('admin/publish-video/{id}', 'VideoController@publish')->name('video.publish');
  Route::get('admin/bind-video/{id}', 'VideoController@bind')->name('video.bind');
  Route::get('admin/edit-important-video/{id}', 'VideoController@editimportantvideo')->name('importantvideo.publish');

  //Aplikasi
  Route::get('admin/kelola-aplikasi', 'AplikasiController@index')->name('aplikasi.index');
  Route::post('admin/store-aplikasi', 'AplikasiController@store')->name('aplikasi.store');
  Route::get('admin/delete-aplikasi/{id}', 'AplikasiController@delete')->name('aplikasi.delete');
  Route::post('admin/edit-aplikasi', 'AplikasiController@edit')->name('aplikasi.edit');
  Route::get('admin/publish-aplikasi/{id}', 'AplikasiController@publish')->name('aplikasi.publish');
  Route::get('admin/bind-aplikasi/{id}', 'AplikasiController@bind')->name('aplikasi.bind');

  //Profile
  Route::get('admin/kelola-profile', 'UserProfileController@index')->name('profile.index');
  Route::post('admin/edit-profile', 'UserProfileController@edit')->name('profile.edit');
  Route::post('admin/change-password', 'UserProfileController@changepassword')->name('profile.changepassword');

  //Data Pegawai
  Route::get('admin/kelola-pegawai', 'PegawaiController@index')->name('pegawai.index');
  Route::post('admin/store-pegawai', 'PegawaiController@store')->name('pegawai.store');
  Route::get('admin/delete-pegawai/{id}', 'PegawaiController@delete')->name('pegawai.delete');
  Route::post('admin/edit-pegawai', 'PegawaiController@edit')->name('pegawai.edit');
  Route::get('admin/publish-pegawai/{id}', 'PegawaiController@publish')->name('pegawai.publish');
  Route::get('admin/bind-pegawai/{id}', 'PegawaiController@bind')->name('pegawai.bind');

  //Anggaran
  Route::get('admin/kelola-anggaran', 'AnggaranController@index')->name('anggaran.index');
  Route::post('admin/store-anggaran', 'AnggaranController@store')->name('anggaran.store');
  Route::get('admin/delete-anggaran/{id}', 'AnggaranController@delete')->name('anggaran.delete');
  Route::post('admin/edit-anggaran', 'AnggaranController@edit')->name('anggaran.edit');
  Route::get('admin/publish-anggaran/{id}', 'AnggaranController@publish')->name('anggaran.publish');
  Route::get('admin/bind-anggaran/{id}', 'AnggaranController@bind')->name('anggaran.bind');

  //Menu
  Route::get('admin/kelola-menu', 'ManajemenMenuController@index')->name('menu.index');
  Route::post('admin/store-menu', 'ManajemenMenuController@store')->name('menu.store');
  Route::get('admin/delete-menu/{id}', 'ManajemenMenuController@delete')->name('menu.delete');
  Route::post('admin/edit-menu', 'ManajemenMenuController@edit')->name('menu.edit');
  Route::get('admin/bind-menu/{id}', 'ManajemenMenuController@bind')->name('menu.bind');

  //Menu Konten
  Route::get('admin/view-konten-menu', 'MenuKontenController@viewall')->name('view.menukonten');
  Route::get('admin/input-menukonten', 'MenuKontenController@inputkonten')->name('input.menukonten');
  Route::get('admin/list-menukonten', 'MenuKontenController@list')->name('menukonten.list');
  Route::post('admin/store-menukonten', 'MenuKontenController@store')->name('menukonten.store');
  Route::get('admin/delete-menukonten/{id}', 'MenuKontenController@delete')->name('menukonten.delete');
  Route::get('admin/edit-menukonten/{id}', 'MenuKontenController@edit')->name('menukonten.edit');
  Route::post('admin/update-menukonten', 'MenuKontenController@update')->name('menukonten.update');
  Route::get('admin/bind-menukonten/{id}', 'MenuKontenController@bind')->name('menukonten.bind');
  Route::get('admin/change-menukonten/{id}', 'MenuKontenController@changestatus')->name('menukonten.change');

  //Media Promosi
  Route::get('admin/kelola-media-promosi', 'MediaPromosiController@index')->name('media-promosi.index');
  Route::post('admin/store-media-promosi', 'MediaPromosiController@store')->name('media-promosi.store');
  Route::get('admin/delete-media-promosi/{id}', 'MediaPromosiController@delete')->name('media-promosi.delete');
  Route::post('admin/edit-media-promosi', 'MediaPromosiController@edit')->name('media-promosi.edit');
  Route::get('admin/bind-media-promosi/{id}', 'MediaPromosiController@bind')->name('media-promosi.bind');
  Route::get('admin/publish-media-promosi/{id}', 'MediaPromosiController@publish')->name('media-promosi.publish');
});

////////////////////////////////////// END OF BACKEND ROUTE //////////////////////////////////////


///////////////////////////////////////// FRONTEND UTAMA ROUTE /////////////////////////////////////////
Route::get('/', ['as' => 'index', 'uses' => 'WelcomePageController@index']);

Route::get('sekilas-tangerang/show/{id}', 'ProfileController@show');
Route::get('detail-konten/show-berita/{id}', 'ProfileController@showBerita');

Route::get('berita/show/{id}', 'BeritaController@show');
Route::get('berita/search-news', 'BeritaController@searchByParam')->name('berita.search');
Route::get('berita-skpd/show', 'BeritaController@showberitaskpd');

Route::get('menu-konten/show-berita/{id}', 'MenuKontenController@showBerita');

Route::get('anggaran/view', 'ProfileController@viewAnggaran')->name('frontanggaran.view');
Route::get('pegawai/view', 'ProfileController@viewpegawai')->name('frontpegawai.view');
Route::get('video/view', 'ProfileController@viewvideo')->name('frontvideo.view');

////////////////////////////////////// END OF FRONTEND UTAMA ROUTE //////////////////////////////////////


///////////////////////////////////////// FRONTEND SKPD ROUTE /////////////////////////////////////////
Route::get('/{singkatan}', ['as' => 'skpd', 'uses' => 'WelcomePageSKPDController@index']);

Route::get('{singkatan}/detail-konten-skpd/show-berita-skpd/{id}/{id_skpd}', 'ProfileSKPDController@showBerita');
Route::get('{singkatan}/profile-skpd/show/{id}/{id_skpd}', 'ProfileSKPDController@show');

Route::get('{singkatan}/menu-konten-skpd/show-berita/{id}', 'MenuKontenSKPDController@showBerita');
Route::get('{singkatan}/berita-skpd/show', 'BeritaController@showberitaskpdbykategori');
Route::get('{singkatan}/berita-skpd/search-news', 'BeritaController@SKPDsearchByParam')->name('skpdberita.search');
Route::get('{singkatan}/berita-skpd/show/{id}', 'BeritaController@showberitaskpdparam');

Route::get('{singkatan}/anggaran/view', 'ProfileSKPDController@viewAnggaran')->name('skpdanggaran.view');
Route::get('{singkatan}/pegawai/view', 'ProfileSKPDController@viewpegawai')->name('skpdpegawai.view');
Route::get('{singkatan}/video/view', 'ProfileSKPDController@viewvideo')->name('skpdvideo.view');
////////////////////////////////////// END OF FRONTEND SKPD ROUTE //////////////////////////////////////
