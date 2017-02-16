<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <p>
      Yth, Bapak/Ibu.
    </p>

    <p>
      Email anda telah didaftarkan sebagai <b>{{ $data['akses'] }}</b> pada Web Terpadu Pemerintahan Kabupaten Tangerang.
      <br>Silahkan klik link berikut untuk aktifasi :<br><br>

      <a href="{{ URL::to('email-activation/' . $data['activation_code']) }}">
        {{ URL::to('email-activation/' . $data['activation_code']) }}
      </a>
    </p>

  </body>
</html>
