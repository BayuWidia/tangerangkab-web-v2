<section class="sidebar">
  <!-- Sidebar user panel -->
  <div class="user-panel">
    <div class="pull-left image">
      @if(Auth::user()->url_foto=="")
        <img src="{{ url('images') }}/user-not-found.png" class="img-circle" alt="User Image">
      @else
        <img src="{{ url('images') }}/{{Auth::user()->url_foto}}" class="img-circle" alt="User Image">
      @endif
    </div>
    <div class="pull-left info">
      <p>
        @if(Auth::user()->name=="")
          {{Auth::user()->email}}
        @else
          {{Auth::user()->name}}
        @endif
      </p>
      <a href="#"><i class="fa fa-circle text-success"></i>
        @php
          echo strtoupper(Auth::user()->masterskpd->singkatan);
        @endphp
      </a>
    </div>
  </div>
  <!-- /.search form -->
  <!-- sidebar menu: : style can be found in sidebar.less -->
  <ul class="sidebar-menu">
    <li class="header">MAIN NAVIGATION</li>
    <li>
      <a href="{{url('admin/dashboard')}}">
        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
      </a>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-star"></i>
        @if (Auth::user()->level=="1")
          <span>Sekilas Tangerang</span>
        @else
          <span>Profile SKPD</span>
        @endif
        <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
        <li><a href="{{url('admin/lihat-info-utama')}}"><i class="fa fa-circle-o"></i> Seluruh Informasi</a></li>
        <li><a href="{{url('admin/tambah-info-utama')}}"><i class="fa fa-circle-o"></i> Tambah Informasi</a></li>
        <li><a href="{{route('kategoriutama.lihat')}}"><i class="fa fa-circle-o"></i> Tambah Kategori Informasi</a></li>
        @if(Auth::user()->level=="1")
         <li><a href="{{url('admin/kelola-chart-jumlah-berita')}}"><i class="fa fa-circle-o"></i> Chart Berita</a></li>
         <li><a href="{{url('admin/kelola-chart-jumlah-kategori-berita')}}"><i class="fa fa-circle-o"></i> Chart Kategori Berita</a></li>
        @endif
      </ul>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-newspaper-o"></i>
        <span>Berita</span>
        <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
        <li><a href="{{route('berita.lihat')}}"><i class="fa fa-circle-o"></i> Seluruh Berita</a></li>
        <li><a href="{{route('berita.tambah')}}"><i class="fa fa-circle-o"></i> Tambah Berita Baru</a></li>
        <li><a href="{{route('kategori.index')}}"><i class="fa fa-circle-o"></i> Tambah Kategori Berita</a></li>
      </ul>
    </li>
    @if(Auth::user()->level=="1")
      <li class="treeview">
        <a href="#">
          <i class="fa fa-building"></i>
          <span>Data SKPD</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{url('admin/lihat-skpd')}}"><i class="fa fa-circle-o"></i> Kelola Data SKPD</a></li>
          <li><a href="{{url('admin/kelola-chart-akun')}}"><i class="fa fa-circle-o"></i> Chart Akun SKPD</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-users"></i>
          <span>Akun</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{url('admin/kelola-akun')}}"><i class="fa fa-circle-o"></i> Kelola Akun</a></li>
        </ul>
      </li>
    @endif
    @if(Auth::user()->level=="2")
      <li class="treeview">
        <a href="#">
          <i class="fa fa-users"></i>
          <span>Data Pegawai</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{route('pegawai.index')}}"><i class="fa fa-circle-o"></i> Kelola Data Pegawai</a></li>
        </ul>
      </li>
    @endif
    <li class="treeview">
      <a href="#">
        <i class="fa fa-mouse-pointer"></i>
        <span>Aplikasi</span>
        <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
        <li><a href="{{url('admin/kelola-aplikasi')}}"><i class="fa fa-circle-o"></i> Kelola Aplikasi</a></li>
      </ul>
    </li>
    @if (Auth::user()->level=="1")
      <li class="treeview">
        <a href="#">
          <i class="fa fa-line-chart"></i>
          <span>Link Statistik</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{url('admin/kelola-statistik')}}"><i class="fa fa-circle-o"></i> Kelola Statistik</a></li>
        </ul>
      </li>
    @endif
    <li class="treeview">
      <a href="#">
        <i class="fa fa-money"></i>
        <span>Anggaran</span>
        <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
        <li><a href="{{route('anggaran.index')}}"><i class="fa fa-circle-o"></i> Kelola Data Anggaran</a></li>
      </ul>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-bars"></i>
        <span>Menu</span>
        <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
        <li><a href="{{route('menu.index')}}"><i class="fa fa-circle-o"></i> Kelola Menu</a></li>
        <li><a href="{{route('view.menukonten')}}"><i class="fa fa-circle-o"></i> Seluruh Konten Menu</a></li>
        <li><a href="{{route('input.menukonten')}}"><i class="fa fa-circle-o"></i> Tambah Konten Menu</a></li>
      </ul>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-image"></i>
        <span>Galeri & Slider</span>
        <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
        <li><a href="{{url('admin/kelola-slider')}}"><i class="fa fa-circle-o"></i> Kelola Slider</a></li>
        <li><a href="{{url('admin/kelola-galeri')}}"><i class="fa fa-circle-o"></i> Kelola Galeri Foto</a></li>
        <li><a href="{{url('admin/kelola-video')}}"><i class="fa fa-circle-o"></i> Kelola Galeri Video</a></li>
      </ul>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-facebook-square"></i>
        <span>Media Sosial</span>
        <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
        <li><a href="{{route('sosmed.index')}}"><i class="fa fa-circle-o"></i> Kelola Media Sosial</a></li>
      </ul>
    </li>
    @if (Auth::user()->level=="1")
      <li class="treeview">
        <a href="#">
          <i class="fa fa-image"></i>
          <span>Media Promosi</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{url('admin/kelola-media-promosi')}}"><i class="fa fa-circle-o"></i> Kelola Media Promosi</a></li>
        </ul>
      </li>
    @endif
  </ul>
</section>
