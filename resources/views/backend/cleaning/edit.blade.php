@extends('layouts.backend_master')

@section('title')
Edit Daily Cleaning
@endsection

@push('css')
<style>
  @media (max-width: 576px) {
    #my_camera video {
        max-width: 80%;
        max-height: 80%;
    }

    .hasil img {
        max-width: 80%;
        max-height: 80%;

    }
}
</style>
@endpush

@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0"></h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Daily Cleaning</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <!-- /.row -->

      <div class="row">
        <div class="col-md-12">
          <div class="card card-danger">
            <div class="card-header">
              <h3 class="card-title">Data Cleaning</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('cleaning.updated',$cleaning->id) }}" class="form-profile" data-toggle="validator" method="post" enctype="multipart/form-data" >
              @csrf
              <div class="card-body">
              
                <div class="form-group row">
                    <label for="jabatan" class="col-md-4 col-md-offset-1 control-label">Lokasi</label>
                    <div class="col-md-8">
                      <select class="form-control" name="penempatan_id" id="penempatan_id" required>
                        <option value="">Pilih Lokasi</option>
                        @foreach($penempatan as $row)
                          <option value="{{ $row->id }}" @if($cleaning->penempatan_id == $row->id) selected @endif>{{ $row->nama }}</option>
                          @endforeach
          
                      </select>
                        <span class="help-block with-errors text-danger"></span>
    
                    </div>
                </div>

                <div class="form-group row">

                  <label for="path_slider" class="col-md-4 col-md-offset-1 control-label">Foto lama</label>
                </div>
                <div class="form-group row">
                    <div class="col-md-3">
                      <a href="{{ asset($cleaning->path_foto) }}" data-toggle="lightbox" data-gallery="example-gallery" class="col-sm-4">
                      <img src="{{ asset($cleaning->path_foto) }}" class="img-fluid" width="550" alt="">
                    </a>
                  </div>
                  <div class="col-md-3">
                    <a href="{{ asset($cleaning->path_foto_2) }}" data-toggle="lightbox" data-gallery="example-gallery" class="col-sm-4">
                    <img src="{{ asset($cleaning->path_foto_2) }}" class="img-fluid" width="550" alt="">
                  </a>
                </div>
                <div class="col-md-3">
                  <a href="{{ asset($cleaning->path_foto_3) }}" data-toggle="lightbox" data-gallery="example-gallery" class="col-sm-4">
                  <img src="{{ asset($cleaning->path_foto_3) }}" class="img-fluid" width="550" alt="">
                </a>
              </div>
              <div class="col-md-3">
                <a href="{{ asset($cleaning->path_foto_4) }}" data-toggle="lightbox" data-gallery="example-gallery" class="col-sm-4">
                <img src="{{ asset($cleaning->path_foto_4) }}" class="img-fluid" width="550" alt="">
              </a>
            </div>
                  </div>
    
                  <div class="form-group row">
                    <label for="path_slider" class="col-md-4 col-md-offset-1 control-label">Foto Area</label>
                    <div id="my_camera" width="50"></div>
                    <div class="col-md-6" style="margin: auto;"> <br>
                      <input type=button class="btn btn-outline-danger btn-sm" value="Ambil Gambar" onClick="take_snapshot()">
                      <input type="hidden" name="path_foto" class="image-tag">
                    </div>
                    </div>
  

                    <div class="form-group row">
                      <label for="path_slider" class="col-md-4 col-md-offset-1 control-label">HASIL</label>
                    </div>
  
                    <div class="hasil">
  
                   
                    <div class="form-group row">
                      <div class="col-md-12">
                        <div id="results"></div>
                      </div>
                    </div>
                  </div>
    
                    <div class="form-group row">
                      <label for="deskripsi" class="col-md-4 col-md-offset-1 control-label">Catatan</label>
                      <div class="col-md-8">
                          <textarea class="form-control" name="catatan" id="" cols="30" rows="5">{{ $cleaning->catatan }}</textarea>
                          <span class="help-block with-errors text-danger"></span>
          
                      </div>
                  </div>


            

               
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                
                <button type="submit" class="btn btn-danger float-right">Update</button>
              </div>
              <!-- /.card-footer -->
            </form>
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->


      <!-- /.row -->
    </div>
    <!--/. container-fluid -->
  </section>
  <!-- /.content -->
</div>


@endsection


@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
<script language="JavaScript">

    Webcam.set('constraints',{
            facingMode: "environment"
        });
        
        Webcam.set({
        width: 350,
        height: 500,
        align:'center',
        image_format: 'jpeg',
        jpeg_quality: 50
    });
    
    Webcam.attach( '#my_camera' );
    
    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'" width="250"/>';
        } );
    }

    function take_snapshot2() {
        Webcam.snap( function(data_uri) {
            $(".image-tag2").val(data_uri);
            document.getElementById('results2').innerHTML = '<img src="'+data_uri+'" width="250"/>';
        } );
    }

    function take_snapshot3() {
        Webcam.snap( function(data_uri) {
            $(".image-tag3").val(data_uri);
            document.getElementById('results3').innerHTML = '<img src="'+data_uri+'" width="250"/>';
        } );
    }

    function take_snapshot4() {
        Webcam.snap( function(data_uri) {
            $(".image-tag4").val(data_uri);
            document.getElementById('results4').innerHTML = '<img src="'+data_uri+'" width="250"/>';
        } );
    }
</script>
@endpush