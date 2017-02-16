<style type="text/css">
  a.footer-custom{
    color:#787878;
  }
</style>
<div class="footer-top">
  <div class="container text-center">
    <div class="logo-icon"><img class="img-responsive" src="{{ asset('images/logo-icon.png') }}" alt="" /></div>
  </div>
</div>
<div class="footer-menu">
  <div class="container">
    <ul class="nav navbar-nav">
      <li><a>Mewujudkan Masyarakat Kabupaten Tangerang Yang Cerdas, Makmur, Religius dan Berwawasan Lingkungan.</a></li>
    </ul>
  </div>
</div>
<div class="bottom-widgets">
  <div class="container">
    <div class="col-sm-8">
      <div class="widget">
        <h2>
          @if ($singkatan=="englishpage")
            GOVERNMENT INSTANCE
          @else
            INSTANSI PEMERINTAH
          @endif
        </h2>
        @if(isset($getjejaring))
          <ul>
            <?php $i=1; ?>
            @foreach($getjejaring as $key)
              @if($i<=6)
                <li><a class="footer-custom">{{$key->nama_skpd}}</a></li>
              @endif
              <?php $i++; ?>
            @endforeach
          </ul>

          @if(count($getjejaring)>5)
            <ul>
              <?php $i=1; ?>
              @foreach($getjejaring as $key)
                @if($i>6 && $i<=11)
                  <li><a class="footer-custom">{{$key->nama_skpd}}</a></li>
                @endif
                <?php $i++; ?>
              @endforeach
              <li><a class="footer-custom">Lainnya</a></li>
            </ul>

          @else

          @endif
        @endif
      </div>
    </div>
    <div class="col-sm-4">
      <div class="widget">
        <h2>
          @if ($singkatan=="englishpage")
            CATEGORY
          @else
            KATEGORI
          @endif
        </h2>
        @if(count($getfooterkat)!=0)
          <ul>
            <?php $i=0; ?>
            @foreach($getfooterkat as $key)
              @if($i<6)
                <li><a class="footer-custom" href="#">{{$key->nama_kategori}}</a></li>
              @endif
              <?php $i++; ?>
            @endforeach
          </ul>
        @endif
        @if(count($getfooterkat)>6)
          <ul>
            <?php $i=0; ?>
            @foreach($getfooterkat as $key)
              @if($i<6)
                <li><a class="footer-custom" href="#">{{$key->nama_kategori}}</a></li>
              @endif
              <?php $i++; ?>
            @endforeach
          </ul>
        @endif
      </div>
    </div>
  </div>
</div>
<div class="footer-bottom">
  <div class="container text-center">
    <p><a class="footer-custom" href="#">
      @if ($singkatan=="englishpage")
        Tangerang Regency &copy; 2016
      @else
        Kabupaten Tangerang &copy; 2016
      @endif
    </a></p>
  </div>
</div>
