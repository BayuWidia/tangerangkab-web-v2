@extends('backend.layouts.master')

@section('title')
  <title>Dashboard</title>
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
  <script src="{{url('/')}}/plugins/ckeditor/ckeditor.js"></script>
  <script src="{{url('/')}}/plugins/ckfinder/ckfinder.js"></script>
@stop

@section('breadcrumb')
  <h1>
    Informasi Utama
    <small>Tambah Informasi Utama</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Tambah Informasi Utama</li>
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
        @if(isset($editinfo))
          action="{{route('infoutama.update', $editinfo->id)}}"
        @else
          action="{{route('infoutama.store')}}"
        @endif
      method="post" style="margin-top:10px;">
        {{csrf_field()}}
        <div class="box box-success box-solid">
          <div class="box-header">
            <h3 class="box-title">Form Tambah Informasi Utama</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <div class="form-group {{ $errors->has('tanggal_posting') ? 'has-error' : '' }}">
              <label class="col-sm-2 control-label">Tanggal Posting</label>
              <div class="col-sm-3">
                <input type="text" class="form-control" name="tanggal_posting"
                @if(isset($editinfo))
                  value="<?php $date = explode(" ", $editinfo->created_at); echo $date[0]; ?>" readonly>
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
            <div class="form-group  {{ $errors->has('id_kategori') ? 'has-error' : '' }}">
              <label class="col-sm-2 control-label">Kategori</label>
              <div class="col-sm-3">
                <select class="form-control" name="id_kategori">
                  <option>-- Pilih --</option>
                  @if(!$getkategori->isEmpty())
                    @if(isset($editinfo))
                      @foreach($getkategori as $key)
                        @if($editinfo->id_kategori==$key->id)
                          <option value="{{$key->id}}" selected="true">{{$key->nama_kategori}}</option>
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
                </select>
                @if($errors->has('id_kategori'))
                 <span class="help-block">
                   <strong>* {{ $errors->first('id_kategori')}}
                   </strong>
                 </span>
                @endif
                @if($getkategori->isEmpty())
                  <span style="color:red;">* Anda belum memiliki kategori.</span>
                @endif
              </div>
            </div>
            <div class="form-group {{ $errors->has('id_kategori') ? 'has-error' : '' }}">
              <label class="col-sm-2 control-label">Isi Konten</label>
              <div class="col-sm-9">
                <textarea name="isi_berita" id="editor1">
                  @if(isset($editinfo))
                    {{$editinfo->isi_berita}}
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
  <!-- SlimScroll -->
  <script src="{{asset('plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
  <!-- FastClick -->
  <script src="{{asset('plugins/fastclick/fastclick.min.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('dist/js/app.min.js')}}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{asset('dist/js/demo.js')}}"></script>

  <script language="javascript">
    CKEDITOR.replace('editor1');
    CKFinder.setupCKEditor( null, { basePath : '{{url('/')}}/plugins/ckfinder/'} );
  </script>

@stop
