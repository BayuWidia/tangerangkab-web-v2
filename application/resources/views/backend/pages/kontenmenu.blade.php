@extends('backend.layouts.master')

@section('title')
  <title>Dashboard</title>
  <link rel="stylesheet" href="{{asset('plugins/iCheck/all.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
  <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap-tagsinput.css')}}">
  <script src="{{asset('plugins/ckeditor/ckeditor.js')}}"></script>
  <script src="{{asset('plugins/ckfinder/ckfinder.js')}}"></script>
@stop

@section('breadcrumb')
  <h1>
    Konten Menu
    <small>Input Konten Menu</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Input Konten Menu</li>
  </ol>
@stop

@section('content')
  <script>
    window.setTimeout(function() {
      $(".alert-success").fadeTo(500, 0).slideUp(500, function(){
          $(this).remove();
      });
    }, 2000);

    window.setTimeout(function() {
      $(".alert-danger").fadeTo(500, 0).slideUp(500, function(){
          $(this).remove();
      });
    }, 5000);
  </script>
  <div class="row">
    <div class="col-md-12">
      @if(Session::has('message'))
        <div class="alert alert-success">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
          <p>{{ Session::get('message') }}</p>
        </div>
      @endif

      @if(Session::has('messagefail'))
        <div class="alert alert-danger">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4><i class="icon fa fa-ban"></i> Oops, terjadi kesalahan!</h4>
          <p>{{ Session::get('messagefail') }}</p>
        </div>
      @endif
    </div>
    <div class="col-md-12">
      <form class="form-horizontal"
        @if(isset($getkonten))
          action="{{route('menukonten.update')}}"
        @else
          action="{{route('menukonten.store')}}"
        @endif
      method="post" style="margin-top:10px;" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="box box-success box-solid">
          <div class="box-header">
            @if(isset($getkonten))
              <h3 class="box-title">Form Edit Konten Menu</h3>
            @else
              <h3 class="box-title">Form Input Konten Menu</h3>
            @endif
          </div><!-- /.box-header -->
          <div class="box-body">
              <div class="form-group {{$errors->has('judul_konten') ? 'has-error' : ''}}">
                <label class="col-sm-2 control-label">Judul Konten</label>
                <div class="col-sm-5">
                  @if(isset($getkonten))
                    <input type="hidden" name="id" value="{{$getkonten->id_konten}}">
                  @endif
                  <input type="text" class="form-control" name="judul_konten"
                    @if(isset($getkonten))
                      value="{{$getkonten->judul_konten}}"
                    @endif
                  >
                  @if ($errors->has('judul_konten'))
                    <div>
                      <span class="help-block">
                        <i>* {{$errors->first('judul_konten')}}</i>
                      </span>
                    </div>
                  @endif
                </div>
              </div>
              <div class="form-group {{$errors->has('id_submenu') ? 'has-error' : ''}}">
                <label class="col-sm-2 control-label">Sub Menu</label>
                <div class="col-sm-3">
                  <select class="form-control" name="id_submenu">
                    <option>-- Pilih --</option>
                    @if (isset($getkonten))
                      <option value="{{$getkonten->id_submenu}}" selected>{{$getkonten->nama}}</option>
                    @endif
                    @if(count($getsubmenu)!=0)
                      @foreach($getsubmenu as $key)
                        <option value="{{$key->id}}">{{$key->nama}}</option>
                      @endforeach
                    @endif
                  </select>
                  <span class="text-muted" style="font-size:10px;">Submenu yang dapat dipilih adalah submenu yang belum memiliki konten.</span>
                  @if ($errors->has('id_submenu'))
                    <div>
                      <span class="help-block">
                        <i>* {{$errors->first('id_submenu')}}</i>
                      </span>
                    </div>
                  @endif
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Tanggal Posting</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" name="tanggal_posting"
                    @if(isset($getkonten))
                      <?php $date = explode(" ", $getkonten->tanggal_post);?>
                      value="{{$date[0]}}" readonly>
                    @else
                      value="<?php echo date('Y-m-d'); ?>" readonly>
                    @endif
                </div>
              </div>
              @if (isset($getkonten))
                <div class="form-group {{$errors->has('url_foto') ? 'has-error' : ''}}">
                  <label class="col-sm-2 control-label">Foto Header</label>
                  <div class="col-sm-3">
                    @php
                    $photo = explode(".", $getkonten->url_foto);
                    @endphp
                    <img src="{{url('images')}}/{{$photo[0]}}_200x122.{{$photo[1]}}" alt="Foto Header" />
                  </div><br>
                </div>
                <div class="form-group {{$errors->has('url_foto') ? 'has-error' : ''}}">
                  <label class="col-sm-2 control-label"></label>
                  <div class="col-sm-4">
                    <input type="file" class="form-control" name="url_foto">
                    <div>
                      <span class="text-muted"><i>* Max Size: 2MB.</i></span><br>
                      <span class="text-muted"><i>* Rekomendasi Ukuran Terbaik: 871 x 947px.</i></span>
                    </div>
                    @if(isset($getkonten))
                      <span style="color:red;">* Biarkan kosong jika tidak ingin diganti.</span>
                    @endif
                  </div>
                </div>
              @else
                <div class="form-group {{$errors->has('url_foto') ? 'has-error' : ''}}">
                  <label class="col-sm-2 control-label">Foto Header</label>
                  <div class="col-sm-4">
                    <input type="file" class="form-control" name="url_foto">
                    <div>
                      <span class="text-muted"><i>* Max Size: 2MB.</i></span><br>
                      <span class="text-muted"><i>* Rekomendasi Ukuran Terbaik: 871 x 947px.</i></span>
                    </div>
                    @if(isset($getkonten))
                      <span style="color:red;">* Biarkan kosong jika tidak ingin diganti.</span>
                    @endif
                    @if ($errors->has('url_foto'))
                      <div>
                        <span class="help-block">
                          <i>* {{$errors->first('url_foto')}}</i>
                        </span>
                      </div>
                    @endif
                  </div>
                </div>
              @endif
              <div class="form-group {{$errors->has('tags') ? 'has-error' : ''}}">
                <label class="col-sm-2 control-label">Tags</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" name="tags" data-role="tagsinput" id="tagsinput"
                    @if(isset($getkonten))
                      value="{{$getkonten->tags}}"
                    @endif
                  >
                  @if ($errors->has('tags'))
                    <div>
                      <span class="help-block">
                        <i>* {{$errors->first('tags')}}</i>
                      </span>
                    </div>
                  @endif
                </div>
              </div>
              <div class="form-group {{$errors->has('isi_konten') ? 'has-error' : ''}}">
                <label class="col-sm-2 control-label">Isi Konten</label>
                <div class="col-sm-9">
                  <textarea name="isi_konten" id="editor1">
                    @if(isset($getkonten))
                      {{$getkonten->isi_konten}}
                    @endif
                  </textarea>
                  @if ($errors->has('isi_konten'))
                    <div>
                      <span class="help-block">
                        <i>* {{$errors->first('isi_konten')}}</i>
                      </span>
                    </div>
                  @endif
                </div>
              </div>
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-success pull-right btn-flat">Simpan</button>
            <button type="reset" class="btn btn-default pull-right btn-flat" style="margin-right:5px;">Reset Form</button>
          </div>
        </div><!-- /.box -->
      </form>
    </div>
  </div>

  <!-- jQuery 2.1.4 -->
  <script src="{{asset('plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
  <!-- Bootstrap 3.3.5 -->
  <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
  <!-- Tags Input -->
  <script src="{{asset('bootstrap/js/bootstrap-tagsinput.js')}}"></script>
  <!-- SlimScroll -->
  <script src="{{asset('plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
  <!-- FastClick -->
  <script src="{{asset('plugins/fastclick/fastclick.min.js')}}"></script>
  <!-- iCheck 1.0.1 -->
  <script src="{{asset('plugins/iCheck/icheck.min.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('dist/js/app.min.js')}}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{asset('dist/js/demo.js')}}"></script>

  <script type="text/javascript">
    $(function(){
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass: 'iradio_flat-green'
        });

        $('#tagsinput').tagsinput();
    })
  </script>

  <script language="javascript">
    CKEDITOR.replace('editor1');
    CKFinder.setupCKEditor( null, { basePath : '{{url('/')}}/plugins/ckfinder/'} );
  </script>

@stop
