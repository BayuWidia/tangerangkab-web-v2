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
    Berita
    <small>Tambah Berita Baru</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Tambah Berita Baru</li>
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
        @if(isset($editberita))
          action="{{route('berita.update')}}"
        @else
          action="{{route('berita.store')}}"
        @endif
      method="post" style="margin-top:10px;" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="box box-success box-solid">
          <div class="box-header">
            @if(isset($editberita))
              <h3 class="box-title">Form Edit Berita</h3>
            @else
              <h3 class="box-title">Form Tambah Berita Baru</h3>
            @endif
          </div><!-- /.box-header -->
          <div class="box-body">
              <div class="form-group {{ $errors->has('judul_berita') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label">Judul Konten</label>
                <div class="col-sm-5">
                  @if(isset($editberita))
                    <input type="hidden" name="id" value="{{$editberita->id}}">
                  @endif
                  <input type="text" class="form-control" name="judul_berita"
                    @if(isset($editberita))
                      value="{{$editberita->judul_berita}}"
                    @endif
                    @if(!$errors->has('judul_berita'))
                     value="{{ old('judul_berita') }}"
                    @endif
                  >
                  @if($errors->has('judul_berita'))
                   <span class="help-block">
                     <strong>* {{ $errors->first('judul_berita')}}
                     </strong>
                   </span>
                  @endif
                </div>
              </div>
              <div class="form-group {{ $errors->has('id_kategori') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label">Kategori</label>
                <div class="col-sm-3">
                  <select class="form-control" name="id_kategori">
                    <option>-- Pilih --</option>
                      @if(!$getkategori->isEmpty())
                        @if(isset($editberita))
                          @foreach($getkategori as $key)
                            @if($editberita->id_kategori==$key->id)
                              <option value="{{$key->id}}" selected="true">{{$key->nama_kategori}}</option>
                            @else
                              <option value="{{$key->id}}">{{$key->nama_kategori}}</option>
                            @endif
                          @endforeach
                        @else
                          @if(!$errors->has('id_kategori'))
                            @foreach($getkategori as $key)
                              @if (old('id_kategori')==$key->id)
                                <option value="{{$key->id}}" selected>{{$key->nama_kategori}}</option>
                              @else
                                <option value="{{$key->id}}">{{$key->nama_kategori}}</option>
                              @endif
                            @endforeach
                          @else
                            @foreach($getkategori as $key)
                              <option value="{{$key->id}}">{{$key->nama_kategori}}</option>
                            @endforeach
                          @endif
                        @endif
                      @endif
                  </select>
                  @if($getkategori->isEmpty())
                    <span style="color:red;">* Anda belum memiliki kategori</span>
                  @endif
                  @if($errors->has('id_kategori'))
                   <span class="help-block">
                     <strong>* {{ $errors->first('id_kategori')}}
                     </strong>
                   </span>
                  @endif
                </div>
              </div>
              <div class="form-group {{ $errors->has('tanggal_posting') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label">Tanggal Posting</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" name="tanggal_posting"
                    @if(isset($editberita))
                      <?php $date = explode(" ", $editberita->created_at);?>
                      value="{{$date[0]}}" readonly>
                    @else
                      value="<?php echo date('Y-m-d'); ?>" readonly>
                    @endif
                    @if($errors->has('tanggal_posting'))
                     <span class="help-block">
                       <strong>* {{ $errors->first('tanggal_posting')}}
                       </strong>
                     </span>
                    @endif
                </div>
              </div>
              <div class="form-group {{ $errors->has('url_foto') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label">Foto Header</label>
                <div class="col-sm-4">
                  @if(isset($editberita))
                    @php
                      $foto = explode(".", $editberita->url_foto);
                    @endphp
                    <img src="{{url('/images')}}/{{$foto[0]}}_270x225.{{$foto[1]}}" width="100%" alt="Foto Header" style="margin-bottom:10px;"/>
                  @endif
                  <input type="file" class="form-control" name="url_foto">
                  <div>
                    <span class="text-muted"><i>* Max Size: 2MB.</i></span><br>
                    <span class="text-muted"><i>* Rekomendasi Ukuran Terbaik: 871 x 947px.</i></span>
                  </div>
                  @if(isset($editberita))
                    <span style="color:red;">* Biarkan kosong jika tidak ingin diganti.</span>
                  @endif
                  @if($errors->has('url_foto'))
                   <span class="help-block">
                     <strong>* {{ $errors->first('url_foto')}}
                     </strong>
                   </span>
                  @endif
                </div>
              </div>
              <div class="form-group {{ $errors->has('tags') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label">Tags</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" name="tags" data-role="tagsinput" id="tagsinput"
                    @if(isset($editberita))
                      value="{{$editberita->tags}}"
                    @endif
                    @if(!$errors->has('tags'))
                     value="{{ old('tags') }}"
                    @endif
                  >
                  <div>
                    <span class="text-muted"><i>* Pisahkan isi tags dengan koma.</i></span>
                  </div>
                  @if($errors->has('tags'))
                   <span class="help-block">
                     <strong>* {{ $errors->first('tags')}}
                     </strong>
                   </span>
                  @endif
                </div>
              </div>
              @if (Auth::user()->level=="1")
                <div class="form-group">
                  <label class="col-sm-2 control-label">Headline</label>
                  <div class="col-sm-4">
                    <input type="checkbox" class="flat-red"
                    @if(isset($editberita))
                      @if($editberita->flag_headline_utama=="1")
                        checked
                      @endif
                    @endif
                    name="flag_headline" value="1">
                    <span class="text-muted">&nbsp;&nbsp;* Ya, tampilkan berita ini sebagai Headline</span>
                  </div>
                </div>
              @else
                <div class="form-group">
                  <label class="col-sm-2 control-label">Headline</label>
                  <div class="col-sm-4">
                    <input type="checkbox" class="flat-red"
                    @if(isset($editberita))
                      @if($editberita->flag_headline=="1")
                        checked
                      @endif
                    @endif
                    name="flag_headline" value="1">
                    <span class="text-muted">&nbsp;&nbsp;* Ya, tampilkan berita ini sebagai Headline</span>
                  </div>
                </div>
              @endif
              <div class="form-group {{ $errors->has('isi_berita') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label">Isi Konten</label>
                <div class="col-sm-9">
                  <textarea name="isi_berita" id="editor1">
                    @if(isset($editberita))
                      {{$editberita->isi_berita}}
                    @endif
                    @if(!$errors->has('isi_berita'))
                     {{ old('isi_berita') }}
                    @endif
                  </textarea>
                  @if($errors->has('isi_berita'))
                   <span class="help-block">
                     <strong>* {{ $errors->first('isi_berita')}}
                     </strong>
                   </span>
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
