@extends('layouts.backend_master')

@section('title')
    Dashboard
@endsection

@push('css')
a:link {
  
  text-decoration: none;
  
}
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
            <h4 class="m-0">Daily Report</h4>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <a href="{{ route('absen.index') }}" class="text-dark">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-cog"></i></span>

              <div class="info-box-content">
                
                <span class="info-box-text">RIwayat Absen</span>
                <span class="info-box-number">
                  {{ $absensi  }}
                </span>
               
              </div>
              <!-- /.info-box-content -->
            </div>
           
          </a>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <a href="{{ route('briefing.index') }}" class="text-dark">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-luggage-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Briefing</span>
                <span class="info-box-number">{{ $briefing }}</span>
                
              </div>
              <!-- /.info-box-content -->
            </div>
            </a>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <a href="{{ route('karyawan.index') }}" class="text-dark">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-id-card-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Karyawan</span>
                <span class="info-box-number">{{ $karyawan }}</span>
               
              </div>
              <!-- /.info-box-content -->
            </div>
          </a>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <a href="{{ route('cleaning.index') }}" class="text-dark">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-cart-plus"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Kebersihan</span>
                <span class="info-box-number">{{ $bersih }}</span>
              
              </div>
              <!-- /.info-box-content -->
            </div>
            </a>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Grafik Daily Report {{ formatTanggal($tanggal_awal,false) }} s/d {{ formatTanggal($tanggal_akhir,false) }}</h5>

               
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="chart">
                      <!-- Sales Chart Canvas -->
                      <canvas id="salesChart" height="180" style="height: 270px;"></canvas>
                    </div>
                    <!-- /.chart-responsive -->
                  </div>
                  <!-- /.col -->
                
                  <!-- /.col -->
                </div>

                
                <!-- /.row -->
              </div>
              <!-- ./card-body -->
             
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Main row -->
      
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection

@push('scripts')

<script>
  window.setTimeout(function() {
  window.location.reload();
}, 300000);

  $('body').addClass('sidebar-collapse');
  
  $(function(){
    var salesChartCanvas = $('#salesChart').get(0).getContext('2d');

var salesChartData = {
  labels: {{ json_encode($data_tanggal) }},
  datasets: [
 
    {
        label: 'Briefing',
        backgroundColor: 'rgba(157, 0, 0, 0.8)',
        borderColor: 'rgba(210, 214, 222, 1)',
        pointRadius: false,
        pointColor: 'rgba(210, 214, 222, 1)',
        pointStrokeColor: '#c1c7d1',
        pointHighlightFill: '#fff',
        pointHighlightStroke: 'rgba(220,220,220,1)',
        data: {{ json_encode($total_stock_keluar) }}
      },  
      
      {
        label: 'Cleaning',
        backgroundColor: '#873e23',
        borderColor: 'rgb(135,62,35,1)',
        pointRadius: false,
        pointColor: 'rgb(135,62,35,1)',
        pointStrokeColor: '#c1c7d1',
        pointHighlightFill: '#fff',
        pointHighlightStroke: 'rgba(220,220,220,1)',
        data: {{ json_encode($total_cleaning) }}
      },    
      {
        label: 'Absensi',
        backgroundColor: '#2596be',
        borderColor: 'rgb(135,62,35,1)',
        pointRadius: false,
        pointColor: 'rgb(135,62,35,1)',
        pointStrokeColor: '#c1c7d1',
        pointHighlightFill: '#fff',
        pointHighlightStroke: 'rgba(220,220,220,1)',
        data: {{ json_encode($total_absen) }}
      },    

   
  ]
};

var salesChartOptions = {
    maintainAspectRatio: true,
    responsive: true,
    legend: {
      display: true
    },
    scales: {
      xAxes: [{
        gridLines: {
          display: true
        }
      }],
      yAxes: [{
        gridLines: {
          display: true
        }
      }]
    }
  };

  // This will get the first returned node in the jQuery collection.
  // eslint-disable-next-line no-unused-vars
  var salesChart = new Chart(salesChartCanvas, {
    type: 'bar',
    data: salesChartData,
    options: salesChartOptions
  }
  );


  //-------------



  });

  var pieChart = new Chart($('#pieChart'), {
        type: 'pie',
        data: {
            labels: ['Option 1', 'Option 2', 'Option 3'],
            datasets: [{
                label: 'Pie Chart',
                data: [300, 50, 20],
                backgroundColor: ['#f56954', '#00a65a', '#f39c12'],
            }]
        },
        options: {
            responsive: true
        }
    });

</script>

@endpush