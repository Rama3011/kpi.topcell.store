@extends('layouts.backend_master')

@section('title')
Daftar Riwayat Absensi
@endsection

@section('content')

<style>
  .table-agent {
    font-size: 0.85em; /* Decrease font size */
  }

  .table-agent th, .table-agent td {
    padding: 5px; /* Reduce padding */
    vertical-align: middle; /* Center-align vertically */
  }

  .dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 0.25em 0.5em; /* Adjust pagination button padding */
  }
</style>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Daftar Absensi</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Absensi</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <div class="btn-group">
                @if (auth()->user()->level == 0)
                <button class="btn btn-success xs" id="accept-btn" onclick="acceptSelected('{{ route('absen.accselected') }}')"> 
                  <i class="fa fa-check"></i> Terima Absen
                </button>
                @endif
</div>
                <div class="float-right">
                        <a href="{{ route('absen.topcellular') }}" class="btn btn-primary">Top Cellular</a>
                        <a href="{{ route('absen.topbeauty') }}" class="btn btn-primary">Top Beauty</a>
                        <a href="{{ route('absen.topgym') }}" class="btn btn-primary">Top Gym</a>
                        <a href="{{ route('absen.topfood') }}" class="btn btn-primary">Top Food</a>
                        <a href="/absen" class="btn btn-primary">All</a>
                      </div> 
            </div>
            <!-- /.card-header -->
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <div class="row mb-2">
                      <div class="col-md-6"></div>
                    </div>
                    <form action="" method="post" class="form-absen">
                      @csrf
                      <div class="table-responsive">
                        <table class="table table-bordered table-striped dataTable dtr-inline table-agent">
                          <thead>
                            <tr>
                              <th width="3%">
                                <input type="checkbox" id="select_all"> <!-- Checkbox untuk memilih semua -->
                              </th>
                              <th width="5%">No</th>
                              <th width="5%">Tanggal</th>
                              <th width="8%">Karyawan</th> <!-- Adjusted width -->
                              <th width="8%">Jabatan</th> <!-- Adjusted width -->
                              <th width="8%">Penempatan</th> <!-- Adjusted width -->
                              <th width="8%">Masuk</th>
                              <th width="5%"><i class="fa fa-image"></i></th>
                              <th width="8%">Istirahat</th>
                              <th width="5%"><i class="fa fa-image"></i></th>
                              <th width="8%">A.Istirahat</th>
                              <th width="5%"><i class="fa fa-image"></i></th>
                              <th width="8%">Pulang</th>
                              <th width="5%"><i class="fa fa-image"></i></th>
                              <th width="8%">Info</th>
                              <th width="5%">Status</th>
                              <th width="5%"><i class="fa fa-cog"></i></th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                      </div>
                    </form>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!--/. container-fluid -->
  </section>
  <!-- /.content -->
</div>

@include('backend.absensi.form')

@endsection

@push('scripts')
<script>
  let table;
  $(function() {
    $('body').addClass('sidebar-collapse');
    
    // Inisialisasi DataTable
    table = $('.table-agent').DataTable({
      dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
           "<'row'<'col-sm-12'B>>" +
           "<'row'<'col-sm-12'tr>>" +
           "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
           buttons: [
    { 
      extend: 'copy', 
      className: 'btn btn-secondary',
      exportOptions: {
        columns: [1, 2, 3, 4, 5, 6, 8, 10, 12, 13, 14, 15] // Indeks kolom yang akan diekspor
      }
    },
    { 
      extend: 'csv', 
      className: 'btn btn-secondary',
      exportOptions: {
        columns: [1, 2, 3, 4, 5, 6, 8, 10, 12, 13,14, 15] // Indeks kolom yang akan diekspor
      }
    },
    { 
      extend: 'excel', 
      className: 'btn btn-secondary',
      exportOptions: {
        columns: [1, 2, 3, 4, 5, 6, 8, 10, 12, 13, 14, 15] // Indeks kolom yang akan diekspor
      }
    },
    { 
      extend: 'pdf', 
      className: 'btn btn-secondary',
      exportOptions: {
        columns: [1, 2, 3, 4, 5, 6, 8, 10, 12, 13, 14, 15] // Indeks kolom yang akan diekspor
      },
      customize: function(doc) {
  doc.styles.tableHeader.fontSize = 8;
  doc.defaultStyle.fontSize = 7;
}
    },
    { 
      extend: 'print', 
      className: 'btn btn-secondary',
      exportOptions: {
        columns: [1, 2, 3, 4, 5, 6, 8, 10, 12, 13, 14, 15] // Indeks kolom yang akan diekspor
      }
    }
  ],
      searching: true,
      search: { "smart": false },
      processing: true,
      autoWidth: true, // Enable auto width adjustment
      serverSide: true,
      ajax: {
        url: '{{ route('dataTopBeauty') }}',
        type: 'GET',
        data: function(d) {
          d.penempatan = $('#penempatan-filter').val(); // Kirim nilai filter penempatan ke server
        }
      },
      columns: [
        {data: 'select_all', name: 'select_all', orderable: false, searchable: false},
        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
        {data: 'tanggal', name: 'tanggal' , searchable: true},
        {data: 'karyawan', name: 'karyawan'},
        {data: 'jabatan', name: 'jabatan'},
        {data: 'penempatan', name: 'penempatan'},
        {data: 'jam_masuk', name: 'jam_masuk'},
        {data: 'foto_masuk', name: 'foto_masuk'},
        {data: 'jam_istirahat', name: 'jam_istirahat'},
        {data: 'foto_istirahat', name: 'foto_istirahat'},
        {data: 'jam_akhir', name: 'jam_akhir'},
        {data: 'foto_akhir', name: 'foto_akhir'},
        {data: 'jam_pulang', name: 'jam_pulang'},
        {data: 'foto_pulang', name: 'foto_pulang'},
        {data: 'accept', name: 'accept'},
        {data: 'status', name: 'status'},
        {data: 'aksi', name: 'aksi', orderable: false, searchable: false},
      ]
    });
    
    // Function to accept selected absences
    $('#accept-btn').on('click', function() {
        acceptSelected('{{ route('absen.accselected') }}');
    });
  });

  // Fungsi untuk filter berdasarkan penempatan
  function filterPenempatan(penempatan) {
    $('#penempatan-filter').val(penempatan); // Set nilai filter
    table.ajax.reload(); // Reload tabel setelah filter diubah
  }

  // Function to accept selected absences
  function acceptSelected(url) {
    var selectedIds = [];
    $('input[name="id_absen[]"]:checked').each(function() {
      selectedIds.push($(this).val());
    });

    if (selectedIds.length === 0) {
      alert('Tidak ada absensi yang dipilih');
      return;
    }

    if (!confirm('Apakah Anda yakin ingin menerima absen yang dipilih?')) {
      return;
    }

    $.ajax({
      url: url,
      method: 'POST',
      data: {
        _token: '{{ csrf_token() }}',
        id_absen: selectedIds
      },
      success: function(response) {
        alert(response.message);
        location.reload();
      },
      error: function(xhr) {
        alert('Terjadi kesalahan: ' + xhr.responseJSON.error);
      }
    });
  }

  function addForm(url) {
    $('#modal-agent').modal('show');
    $('#modal-agent .modal-title').text('Tambah Jabatan');
    $('#modal-agent form')[0].reset();
    $('#modal-agent form').attr('action', url);
    $('#modal-agent [name=_method]').val('post');
    $('#modal-agent [name=jabatan]').focus();
  }

  function editForm(url) {
    $('#modal-agent').modal('show');
    $('#modal-agent .modal-title').text('Edit Jabatan');

    $.get(url, function(data) {
      $('#modal-agent [name=jabatan]').val(data.jabatan);
      $('#modal-agent [name=status]').val(data.status);
    });
  }
</script>
@endpush
