@extends('backend.layouts.master')

@section('title')
  <title>Dashboard</title>
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
@stop

@section('breadcrumb')
  <h1>
    Informasi Utama
    <small>Kategori Informasi Utama</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Kategori Informasi Utama</li>
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

  <div class="modal fade" id="modaldelete" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Hapus Data Kategori Informasi Utama</h4>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin untuk menghapus data kategori informasi utama ini?</p>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn btn-default pull-left btn-flat" data-dismiss="modal">Tidak</button>
          <a class="btn btn-danger  btn-flat" id="sethapus">Ya, saya yakin</a>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalflagedit" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Status Kategori Informasi Utama</h4>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin untuk mengubah status kategori informasi utama ini?</p>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn btn-default pull-left btn-flat" data-dismiss="modal">Tidak</button>
          <a class="btn btn-danger  btn-flat" id="setflagedit">Ya, saya yakin</a>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modaledit" role="dialog">
    <div class="modal-dialog">
      <form class="form-horizontal" action="{{route('kategoriutama.edit')}}" method="post">
        {{ csrf_field() }}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Kategori Informasi Utama</h4>
          </div>
          <div class="modal-body">
            <div class="col-md-14 ">
              <label class="control-label">Nama Kategori</label>
              <input type="hidden" name="id" class="form-control" id="id">
              <input type="text" name="nama_kategori" class="form-control" placeholder="Nama Kategori" id="nama_kategori">
            </div>
            <div class="col-md-14 ">
              <label class="control-label">Keterangan</label>
              <textarea name="keterangan_kategori" rows="5" cols="40" class="form-control" id="keterangan_kategori"></textarea>
            </div>
            <div class="col-md-14 ">
              <label class="control-label">Status</label>
              <select class="form-control" name="flag_kategori">
                <option value="1" id="flag_aktif">Aktif</option>
                <option value="0" id="flag_nonaktif">Tidak Aktif</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn btn-default pull-left btn-flat" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success btn-flat">Simpan Perubahan</a>
          </div>
        </div>
      </form>
    </div>
  </div>

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

    <form class="form-horizontal" action="{{route('kategoriutama.store')}}" method="post">
      {{ csrf_field() }}
      <div class="col-md-4">
        <div class="box box-success box-solid">
          <div class="box-header with-border">
            <h3 class="box-title">Tambah Kategori Informasi Utama</h3>
          </div>
          <div class="box-body">
            <div class="col-md-14 {{ $errors->has('nama_kategori') ? 'has-error' : '' }}">
              <label class="control-label">Nama Kategori</label>
              <input type="text" name="nama_kategori" class="form-control" placeholder="Nama Kategori"
                @if(!$errors->has('nama_kategori'))
                 value="{{ old('nama_kategori') }}"
                @endif
              >
              @if($errors->has('nama_kategori'))
               <span class="help-block">
                 <strong>* {{ $errors->first('nama_kategori')}}
                 </strong>
               </span>
              @endif
            </div>
            <div class="col-md-14 {{ $errors->has('keterangan_kategori') ? 'has-error' : '' }}">
              <label class="control-label">Keterangan</label>
              <textarea name="keterangan_kategori" rows="5" cols="40" class="form-control">@if(!$errors->has('keterangan_kategori')){{ old('keterangan_kategori') }}@endif</textarea>
              @if($errors->has('keterangan_kategori'))
               <span class="help-block">
                 <strong>* {{ $errors->first('keterangan_kategori')}}
                 </strong>
               </span>
              @endif
            </div>
            <div class="col-md-14">
              <label class="control-label">Status</label>
              <select class="form-control" name="flag_kategori">
                <option value="1">Aktif</option>
                <option value="0">Tidak Aktif</option>
              </select>
            </div>
            <input type="hidden" name="id_skpd" value="
              @if(Auth::user()->level!="1")
                {{Auth::user()->masterskpd->id_skpd}}
              @endif
            ">
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-success pull-right btn-sm btn-flat">Simpan</button>
            <button type="reset" class="btn btn-default btn-sm btn-flat pull-right" style="margin-right:5px;">Reset Formulir</button>
          </div>
        </div>
      </div>
    </form>

    <div class="col-md-8">
      <div class="box box-success box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Daftar Kategori Informasi Utama</h3>
        </div>
        <div class="box-body no-padding">
          <table class="table table-hover">
            <tbody>
              <tr class="bg-green">
                <th style="width:10px;">#</th>
                <th>Nama Kategori</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
              <?php
                 $no;
                 if($getkategori->currentPage()==1)
                   $no = 1;
                 else
                   $no = (($getkategori->currentPage() - 1) * $getkategori->perPage())+1;
               ?>
              @if($getkategori->isEmpty())
                  <tr>
                    <td class="text-muted" colspan="5" style="text-align:center;">
                      Data kategori tidak tersedia.
                    </td>
                  </tr>
              @else
                @foreach($getkategori as $key)
                  <tr>
                    <td>{{$no}}</td>
                    <td>{{$key->nama_kategori}}</td>
                    <td>{{$key->keterangan_kategori}}</td>
                    <td>
                      @if($key->flag_kategori=="1")
                        <span class="label bg-green">Aktif</span>
                      @else
                        <span class="label bg-red">Tidak Aktif</span>
                      @endif
                    </td>
                    <td>
                      @if($key->flag_kategori=="1")
                        <span data-toggle="tooltip" title="Non Aktifkan">
                          <a href="#" class="btn btn-xs btn-danger btn-flat flagedit" data-toggle="modal" data-target="#modalflagedit" data-value="{{$key->id}}"><i class="fa fa-heartbeat"></i></a>
                        </span>
                      @else
                        <span data-toggle="tooltip" title="Aktifkan">
                          <a href="#" class="btn btn-xs btn-success btn-flat flagedit" data-toggle="modal" data-target="#modalflagedit" data-value="{{$key->id}}"><i class="fa fa-heart"></i></a>
                        </span>
                      @endif
                      <span data-toggle="tooltip" title="" data-original-title="Ubah">
                        <a href="#" data-value="{{$key->id}}" class="btn btn-warning btn-flat btn-xs edit" data-toggle="modal" data-target="#modaledit"><i class="fa fa-edit"></i></a>
                      </span>
                      <span data-toggle="tooltip" title="" data-original-title="Hapus">
                        <a href="#" data-value="{{$key->id}}" class="btn btn-danger btn-flat btn-xs hapus" data-toggle="modal" data-target="#modaldelete"><i class="fa fa-remove"></i></a>
                      </span>
                    </td>
                  </tr>
                  <?php $no++; ?>
                @endforeach
              @endif
            </tbody>
          </table>
        </div>
        <div class="box-footer">
          <ul class="pagination pagination-sm no-margin pull-right">
            {{ $getkategori->links() }}
          </ul>
        </div>
      </div>
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

  <script type="text/javascript">
    $(function(){
      $('a.flagedit').click(function(){
        var a = $(this).data('value');
        $('#setflagedit').attr('href', '{{url('admin/change-status-kategori/')}}/'+a);
      });

      $('a.hapus').click(function(){
        var a = $(this).data('value');
        $('#sethapus').attr('href', '{{url('admin/delete-kategori-berita/')}}/'+a);
      });

      $('a.edit').click(function(){
        var a = $(this).data('value');
        $.ajax({
          url: "{{url('/')}}/admin/bind-kategori-berita/"+a,
          dataType: 'json',
          success: function(data){
            //get
            var id = data.id;
            var nama_kategori = data.nama_kategori;
            var keterangan_kategori = data.keterangan_kategori;
            var flag_kategori = data.flag_kategori;

            //set
            $('#id').attr('value', id);
            $('#nama_kategori').attr('value', nama_kategori);
            $('#keterangan_kategori').val(keterangan_kategori);
            if (flag_kategori=="1") {
              $('#flag_aktif').attr('selected', true);
            } else {
              $('#flag_nonaktif').attr('selected', true);
            }
          }
        });
      });
    });
  </script>

@stop
