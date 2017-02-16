<!DOCTYPE html>
<html lang="id">
  <head>
    @yield('title')
    @include('frontend.includes.head')
  </head>

  <body>

    <div id="main-wrapper" class="homepage-two fixed-nav">
      @include('frontend.includes.topbarnav')

      <div class="container">
      @yield('content')
      </div>

    </div>

    <footer id="footer">
      @include('frontend.includes.footer')
    </footer>

    @include('frontend.includes.script')

  </body>
</html>
