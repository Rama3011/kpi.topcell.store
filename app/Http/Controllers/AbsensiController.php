<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Shift;
use App\Models\Absensi;
use App\Models\Jabatan;
use App\Models\karyawan;
use App\Models\Penempatan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;


class AbsensiController extends Controller
{

         // Daftar penempatan untuk Top Gym
    protected $topGym = [
        'TOP GYM',
        // Tambahkan penempatan Top Gym lainnya
    ];

    protected $topFood = [
        'TOP FOOD GOWA',
        'TOP FOOD VIDA',
        // Tambahkan penempatan Top Food lainnya
    ];
        // Daftar penempatan untuk Top Cellular
        protected $topCellular = [
            '003 - MP TOP CELLULAR',
            '001 - TOP INDO MAJU',
            '006 - VIVO STORE MP-TOP CELLULAR',
            '010 - GRAND TOSERBA-TOP CELLULAR',
            '031 - XIAOMI STORE-TOP CELLULAR',
            '021 - TOP ASIA PHONE',
            '020 - MI SHOP RAPPOCINI-TOP CELLULAR',
            'HEAD ASIA',
            'HEAD MP',
            'HEAD BULSAR',
            'HEAD RPC-GRAND',
            // Tambahkan penempatan Top Cellular lainnya
        ];

    // Daftar penempatan untuk Top Beauty
    protected $topBeauty = [
        'TOP BEAUTY MAROS',
        'TOP BEAUTY SALON VIDAVIEW',
        'TOP BEAUTY SALON PS',
        'NIPAH-TOP BEAUTY SALON',
        'YOU STORE MALL PANAKUKANG',
        'TOP BARBER NIPAH',
        // Tambahkan penempatan Top Beauty lainnya
    ];

   


    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    
    public function index()
    {
        return view('backend.absensi.index');
    }

    // public function data()
    // {
    //     $absensi = Absensi::
    //         latest()->limit(1000)->get();

    //         $absensi_karyawan = Absensi::where('karyawan_id', auth()->user()->id)->latest()->get();


    //         if(auth()->user()->level == 0 || auth()->user()->level == 3){
    //             return datatables()
    //             ->of($absensi)//source
    //             ->addIndexColumn() //untuk nomer
    //             ->addColumn('select_all', function($absensi){
    //                 return '<input type="checkbox" name="id_absen[]" value="'.$absensi->id.'">';
    //             })
    //             ->addColumn('tanggal', function($absensi){
    //                 $result = formatTanggal($absensi->created_at);
    //                 return $result;
    //             })
    //             ->addColumn('karyawan', function($absensi){
    //                 $result = '<h1 class="badge badge-light">'.$absensi->karyawan->name.'</h1>';
    //                 return $result;
    //             })
    //             ->addColumn('jabatan', function($absensi){
    //                 $karyawan_id = karyawan::where('id',$absensi->karyawan->karyawan_id)->first();
    //                 $jabatan = Jabatan::where('id',$karyawan_id->jabatan_id)->first();
    //                 $result = '<h1 class="badge badge-info">'.$jabatan->jabatan.'</h1>';
    //                 return $result;
    //             })
    //             ->addColumn('jam_masuk', function($absensi){
    //                 $result = '<h1 class="badge badge-success">'.$absensi->jam_masuk.'</h1><a href="'.route('absen.edit', $absensi->id).'" class="btn btn-xs btn-warning"><i class="fa fa-cog"></i></a>';
    //                 return $result;
    //             })
    //             ->addColumn('foto_masuk', function($absensi){
    //                 return ' <a href="'.$absensi->foto_masuk.'" data-toggle="lightbox" class="col-sm-4">
    //                 <img src="'.$absensi->foto_masuk.'" class="img-fluid" alt="">
    //               </a>';
    //             })
    //             ->addColumn('jam_istirahat', function($absensi){
    //                 $result = '<h1 class="badge badge-info">'.$absensi->jam_istirahat.'</h1>';
    //                 return $result;
    //             })
    //             ->addColumn('foto_istirahat', function($absensi){
    //                 return ' <a href="'.$absensi->foto_istirahat.'" data-toggle="lightbox" class="col-sm-4">
    //                 <img src="'.$absensi->foto_istirahat.'" class="img-fluid" alt="">
    //               </a>';
    //             })
    //             ->addColumn('jam_akhir', function($absensi){
    //                 $result = '<h1 class="badge badge-info">'.$absensi->jam_akhir.'</h1>';
    //                 return $result;
    //             })
    //             ->addColumn('foto_akhir', function($absensi){
    //                 return ' <a href="'.$absensi->foto_akhir.'" data-toggle="lightbox" class="col-sm-4">
    //                 <img src="'.$absensi->foto_akhir.'" class="img-fluid" alt="">
    //               </a>';
    //             })
    //             ->addColumn('jam_pulang', function($absensi){
    //                 $result = '<h1 class="badge badge-danger">'.$absensi->jam_pulang.'</h1>';
    //                 return $result;
    //             })
    //             ->addColumn('foto_pulang', function($absensi){
    //                 return ' <a href="'.$absensi->foto_pulang.'" data-toggle="lightbox" class="col-sm-4">
    //                 <img src="'.$absensi->foto_pulang.'" class="img-fluid" alt="">
    //               </a>';
    //             })
    //             ->addColumn('accept', function($absensi){
    //                 if($absensi->accept == 0){
    //                     return '<span class="badge badge-danger">Ditolak</span>';
      
    //                 }else if($absensi->accept == 1){
    //                   return '<span class="badge badge-success">Diterima</span>';
    //                 }else{
    //                     return '<span class="badge badge-light">Pending</span>';

    //                 }
    //             })
               


    //             ->addColumn('status', function($absensi){
    //                 if($absensi->status == 0){
    //                     return '<span class="badge badge-warning">Sakit</span>|'.$absensi->keterangan.'';
      
    //                 }else if($absensi->status == 1){
    //                   return '<span class="badge badge-success">Hadir</span>';
    //                 }else if($absensi->status == 3){
    //                     return '<span class="badge badge-warning">Izin</span>|'.$absensi->keterangan.'';
    //                 }else{
    //                     return '<span class="badge badge-danger">Telat</span>';

    //                 }
    //             })
             
    //             ->addColumn('aksi', function($absensi){ //untuk aksi
    //                 $button = '<div class="btn-group"><button type="button" onclick="editForm(`'.route('absen.update', $absensi->id).'`)" class="btn btn-xs btn-info btn-flat"><i class="fas fa-edit"></i></button><button type="button" onclick="deleteData(`'.route('absen.destroy', $absensi->id).'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button><a href="'.route('absen.acc', $absensi->id).'" class="btn btn-xs btn-success btn-flat"><i class="fa fa-check"></i></a><a href="'.route('absen.decline', $absensi->id).'" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-times"></i></a></div>';
    //               return $button;
    //             })
    //             ->rawColumns(['aksi','karyawan','jam_masuk','foto_masuk','jam_istirahat','foto_istirahat','jam_akhir','foto_akhir','jam_pulang','foto_pulang','tanggal','status','accept','select_all','jabatan'])//biar kebaca html
    //             ->make(true);
    //         }else{
    //             return datatables()
    //             ->of($absensi_karyawan)//source
    //             ->addIndexColumn() //untuk nomer
    //             ->addColumn('select_all', function($absensi_karyawan){
    //                 return '<input type="checkbox" name="id_absen[]" value="'.$absensi_karyawan->id.'">';
    //             })
    //             ->addColumn('tanggal', function($absensi_karyawan){
    //                 $result = formatTanggal($absensi_karyawan->created_at);
    //                 return $result;
    //             })
    //             ->addColumn('karyawan', function($absensi_karyawan){
    //                 $result = '<h1 class="badge badge-light">'.$absensi_karyawan->karyawan->name.'</h1>';
    //                 return $result;
    //             })
    //             ->addColumn('jabatan', function($absensi_karyawan){
    //                 $karyawan_id = karyawan::where('id',$absensi_karyawan->karyawan->karyawan_id)->first();
    //                 $jabatan = Jabatan::where('id',$karyawan_id->jabatan_id)->first();
    //                 $result = '<h1 class="badge badge-info">'.$jabatan->jabatan.'</h1>';
    //                 return $result;
    //             })
    //             ->addColumn('jam_masuk', function($absensi_karyawan){
    //                 $result = '<h1 class="badge badge-success">'.$absensi_karyawan->jam_masuk.'</h1><a href="'.route('absen.edit', $absensi_karyawan->id).'" class="btn btn-xs btn-warning"><i class="fa fa-cog"></i></a>';
    //                 return $result;
    //             })
    //             ->addColumn('foto_masuk', function($absensi_karyawan){
    //                 return ' <a href="'.$absensi_karyawan->foto_masuk.'" data-toggle="lightbox">
    //                 <img src="'.$absensi_karyawan->foto_masuk.'" class="img-fluid" alt="">
    //               </a>';
    //             })
    //             ->addColumn('jam_istirahat', function($absensi_karyawan){
    //                 $result = '<h1 class="badge badge-info">'.$absensi_karyawan->jam_istirahat.'</h1>';
    //                 return $result;
    //             })
    //             ->addColumn('foto_istirahat', function($absensi_karyawan){
    //                 return ' <a href="'.$absensi_karyawan->foto_istirahat.'" data-toggle="lightbox">
    //                 <img src="'.$absensi_karyawan->foto_istirahat.'" class="img-fluid" alt="">
    //               </a>';
    //             })
    //             ->addColumn('jam_akhir', function($absensi_karyawan){
    //                 $result = '<h1 class="badge badge-info">'.$absensi_karyawan->jam_akhir.'</h1>';
    //                 return $result;
    //             })
    //             ->addColumn('foto_akhir', function($absensi_karyawan){
    //                 return ' <a href="'.$absensi_karyawan->foto_akhir.'" data-toggle="lightbox" class="col-sm-4">
    //                 <img src="'.$absensi_karyawan->foto_akhir.'" class="img-fluid" alt="">
    //               </a>';
    //             })
    //             ->addColumn('jam_pulang', function($absensi_karyawan){
    //                 $result = '<h1 class="badge badge-danger">'.$absensi_karyawan->jam_pulang.'</h1>';
    //                 return $result;
    //             })
    //             ->addColumn('foto_pulang', function($absensi_karyawan){
    //                 return ' <a href="'.$absensi_karyawan->foto_pulang.'" data-toggle="lightbox">
    //                 <img src="'.$absensi_karyawan->foto_pulang.'" class="img-fluid" alt="">
    //               </a>';
    //             })
             
    //             ->addColumn('accept', function($absensi_karyawan){
    //                 if($absensi_karyawan->accept == 0){
    //                     return '<span class="badge badge-danger">Ditolak</span>';
      
    //                 }else if($absensi_karyawan->accept == 1){
    //                   return '<span class="badge badge-success">Diterima</span>';
    //                 }else{  
    //                     return '<span class="badge badge-light">Pending</span>';

    //                 }
    //             })


    //             ->addColumn('status', function($absensi_karyawan){
    //                 if($absensi_karyawan->status == 0){
    //                     return '<span class="badge badge-warning">Sakit</span>|'.$absensi_karyawan->keterangan.'';
      
    //                 }else if($absensi_karyawan->status == 1){
    //                   return '<span class="badge badge-success">Hadir</span>';
    //                 }else if($absensi_karyawan->status == 3){
    //                     return '<span class="badge badge-warning">Izin</span>|'.$absensi_karyawan->keterangan.'';
    //                 }else{
    //                     return '<span class="badge badge-danger">Telat</span>';

    //                 }
    //             })
             
    //             ->addColumn('aksi', function($absensi_karyawan){ //untuk aksi
    //                 $button = '<div class="btn-group"><button type="button" onclick="editForm(`'.route('absen.update', $absensi_karyawan->id).'`)" class="btn btn-xs btn-info btn-flat"><i class="fas fa-edit"></i></button></div>';
    //               return $button;
    //             })
    //             ->rawColumns(['aksi','karyawan','jam_masuk','foto_masuk','jam_istirahat','foto_istirahat','jam_akhir','foto_akhir','jam_pulang','foto_pulang','tanggal','status','accept','select_all','jabatan'])//biar kebaca html
    //             ->make(true);
    //         }
        
    // }
    
public function data()
{
    // Ambil jabatan_id dan level user yang sedang login
    $jabatanId = auth()->user()->jabatan_id;
    $userLevel = auth()->user()->level;
    $karyawanId = auth()->user()->id;

    // Cek apakah user dengan level 0 atau 1, atau berdasarkan jabatan HRD (misal jabatan HRD id=1)
    if ($userLevel == 0 || $userLevel == 1 || $jabatanId == 1) {
        // HRD atau admin level tinggi bisa melihat semua data absensi
        $absensi = Absensi::with('karyawan')->orderBy('created_at', 'desc'); // Tambahkan orderBy untuk sorting terbaru
    } else {
        // Jika bukan HRD atau admin, hanya bisa melihat absensi milik sendiri
        $absensi = Absensi::with('karyawan')
            ->where('karyawan_id', $karyawanId)
            ->orderBy('created_at', 'desc'); // Sorting berdasarkan created_at terbaru
    }

    // Return DataTables with server-side processing
    return datatables()
        ->eloquent($absensi) // Use Eloquent Builder for server-side processing
        ->addIndexColumn() // Add index
        ->addColumn('select_all', function ($absensi) {
            return '<input type="checkbox" name="id_absen[]" value="' . $absensi->id . '">';
        })
        ->addColumn('tanggal', function ($absensi) {
            return formatTanggal($absensi->created_at); // Assuming formatTanggal is a helper function
        })
        ->addColumn('karyawan', function ($absensi) {
            return '<h1 class="badge badge-light">' . $absensi->karyawan->name . '</h1>';
        })
        ->addColumn('jabatan', function ($absensi) {
            $karyawan = karyawan::where('id', $absensi->karyawan->karyawan_id)->first();
            $jabatan = Jabatan::where('id', $karyawan->jabatan_id)->first();
            return '<h1 class="badge badge-info">' . $jabatan->jabatan . '</h1>';
        })
        ->addColumn('penempatan', function ($absensi) {
            $karyawan = karyawan::where('id', $absensi->karyawan->karyawan_id)->first();
            $penempatan = Penempatan::where('id', $karyawan->penempatan_id)->first();
            return $penempatan->nama;
        })
        ->addColumn('jam_masuk', function ($absensi) {
            return '<h1 class="badge badge-success">' . $absensi->jam_masuk . '</h1><a href="' . route('absen.edit', $absensi->id) . '" class="btn btn-xs btn-warning"><i class="fa fa-cog"></i></a>';
        })
        ->addColumn('foto_masuk', function ($absensi) {
            return '<a href="' . $absensi->foto_masuk . '" data-toggle="lightbox"><img src="' . $absensi->foto_masuk . '" class="img-fluid" alt=""></a>';
        })
        ->addColumn('jam_istirahat', function ($absensi) {
            return '<h1 class="badge badge-info">' . $absensi->jam_istirahat . '</h1>';
        })
        ->addColumn('foto_istirahat', function ($absensi) {
            return '<a href="' . $absensi->foto_istirahat . '" data-toggle="lightbox"><img src="' . $absensi->foto_istirahat . '" class="img-fluid" alt=""></a>';
        })
        ->addColumn('jam_akhir', function ($absensi) {
            return '<h1 class="badge badge-info">' . $absensi->jam_akhir . '</h1>';
        })
        ->addColumn('foto_akhir', function ($absensi) {
            return '<a href="' . $absensi->foto_akhir . '" data-toggle="lightbox"><img src="' . $absensi->foto_akhir . '" class="img-fluid" alt=""></a>';
        })
        ->addColumn('jam_pulang', function ($absensi) {
            return '<h1 class="badge badge-danger">' . $absensi->jam_pulang . '</h1>';
        })
        ->addColumn('foto_pulang', function ($absensi) {
            return '<a href="' . $absensi->foto_pulang . '" data-toggle="lightbox"><img src="' . $absensi->foto_pulang . '" class="img-fluid" alt=""></a>';
        })
        ->addColumn('accept', function ($absensi) {
            if ($absensi->accept == 0) {
                return '<span class="badge badge-danger">Ditolak</span>';
            } elseif ($absensi->accept == 1) {
                return '<span class="badge badge-success">Diterima</span>';
            } else {
                return '<span class="badge badge-light">Pending</span>';
            }
        })
        ->addColumn('status', function ($absensi) {
            if ($absensi->status == 0) {
                return '<span class="badge badge-warning">Sakit</span>|' . $absensi->keterangan;
            } elseif ($absensi->status == 1) {
                return '<span class="badge badge-success">Hadir</span>';
            } elseif ($absensi->status == 3) {
                return '<span class="badge badge-warning">Izin</span>|' . $absensi->keterangan;
            } else {
                return '<span class="badge badge-danger">Telat</span>';
            }
        })
        ->addColumn('aksi', function($absensi){ //untuk aksi
            $button = '<div class="btn-group"><button type="button" onclick="editForm(`'.route('absen.update', $absensi->id).'`)" class="btn btn-xs btn-info btn-flat">
            <i class="fas fa-edit"></i></button><button type="button" onclick="deleteData(`'.route('absen.destroy', $absensi->id).'`)" class="btn btn-xs btn-danger btn-flat">
            <i class="fa fa-trash"></i></button><a href="'.route('absen.acc', $absensi->id).'" class="btn btn-xs btn-success btn-flat">
            <i class="fa fa-check"></i></a><a href="'.route('absen.decline', $absensi->id).'" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-times">
            </i></a></div>';
           return $button;
        })
        ->rawColumns([
            'aksi', 'karyawan', 'jam_masuk', 'foto_masuk', 'jam_istirahat', 'foto_istirahat', 'jam_akhir', 'foto_akhir',
            'jam_pulang', 'foto_pulang', 'tanggal', 'status', 'accept', 'select_all', 'jabatan'
        ]) // Ensure HTML is rendered correctly
        ->make(true);
}

public function topcellular()
{
    return view('backend.absensi.filter_cellular');
}


public function dataTopCellular()
{
    $jabatanId = auth()->user()->jabatan_id;
        $userLevel = auth()->user()->level;
        $karyawanId = auth()->user()->id;
    
        // Kondisi untuk user dengan level tertentu atau jabatan tertentu
        if ($userLevel == 0 || $userLevel == 1 || $jabatanId == 1) {
            $absensi = Absensi::with(['karyawan.data_karyawan.penempatan'])
                ->whereHas('karyawan.data_karyawan.penempatan', function ($query) {
                    $query->whereIn('nama', $this->topCellular); // Filter untuk penempatan Top Beauty
                })
                ->orderBy('created_at', 'desc');
        } else {
            // Jika user bukan admin atau memiliki jabatan lain
            $absensi = Absensi::with(['karyawan.data_karyawan.penempatan'])
                ->where('karyawan_id', $karyawanId) // Hanya mengambil absensi user terkait
                ->whereHas('karyawan.data_karyawan.penempatan', function ($query) {
                    $query->whereIn('nama', $this->topCellular); // Filter untuk penempatan Top Beauty
                })
                ->orderBy('created_at', 'desc');
        }

    return datatables()
    ->eloquent($absensi) // Use Eloquent Builder for server-side processing
    ->addIndexColumn() // Add index
    ->addColumn('select_all', function ($absensi) {
        return '<input type="checkbox" name="id_absen[]" value="' . $absensi->id . '">';
    })
    ->addColumn('tanggal', function ($absensi) {
        return formatTanggal($absensi->created_at); // Assuming formatTanggal is a helper function
    })
    ->addColumn('karyawan', function ($absensi) {
        return '<h1 class="badge badge-light">' . $absensi->karyawan->name . '</h1>';
    })
    ->addColumn('jabatan', function ($absensi) {
        $karyawan = karyawan::where('id', $absensi->karyawan->karyawan_id)->first();
        $jabatan = Jabatan::where('id', $karyawan->jabatan_id)->first();
        return '<h1 class="badge badge-info">' . $jabatan->jabatan . '</h1>';
    })
    ->addColumn('penempatan', function ($absensi) {
        $karyawan = karyawan::where('id', $absensi->karyawan->karyawan_id)->first();
        $penempatan = Penempatan::where('id', $karyawan->penempatan_id)->first();
        return $penempatan->nama;
    })
    ->addColumn('jam_masuk', function ($absensi) {
        return '<h1 class="badge badge-success">' . $absensi->jam_masuk . '</h1><a href="' . route('absen.edit', $absensi->id) . '" class="btn btn-xs btn-warning"><i class="fa fa-cog"></i></a>';
    })
    ->addColumn('foto_masuk', function ($absensi) {
        return '<a href="' . $absensi->foto_masuk . '" data-toggle="lightbox"><img src="' . $absensi->foto_masuk . '" class="img-fluid" alt=""></a>';
    })
    ->addColumn('jam_istirahat', function ($absensi) {
        return '<h1 class="badge badge-info">' . $absensi->jam_istirahat . '</h1>';
    })
    ->addColumn('foto_istirahat', function ($absensi) {
        return '<a href="' . $absensi->foto_istirahat . '" data-toggle="lightbox"><img src="' . $absensi->foto_istirahat . '" class="img-fluid" alt=""></a>';
    })
    ->addColumn('jam_akhir', function ($absensi) {
        return '<h1 class="badge badge-info">' . $absensi->jam_akhir . '</h1>';
    })
    ->addColumn('foto_akhir', function ($absensi) {
        return '<a href="' . $absensi->foto_akhir . '" data-toggle="lightbox"><img src="' . $absensi->foto_akhir . '" class="img-fluid" alt=""></a>';
    })
    ->addColumn('jam_pulang', function ($absensi) {
        return '<h1 class="badge badge-danger">' . $absensi->jam_pulang . '</h1>';
    })
    ->addColumn('foto_pulang', function ($absensi) {
        return '<a href="' . $absensi->foto_pulang . '" data-toggle="lightbox"><img src="' . $absensi->foto_pulang . '" class="img-fluid" alt=""></a>';
    })
    ->addColumn('accept', function ($absensi) {
        if ($absensi->accept == 0) {
            return '<span class="badge badge-danger">Ditolak</span>';
        } elseif ($absensi->accept == 1) {
            return '<span class="badge badge-success">Diterima</span>';
        } else {
            return '<span class="badge badge-light">Pending</span>';
        }
    })
    ->addColumn('status', function ($absensi) {
        if ($absensi->status == 0) {
            return '<span class="badge badge-warning">Sakit</span>|' . $absensi->keterangan;
        } elseif ($absensi->status == 1) {
            return '<span class="badge badge-success">Hadir</span>';
        } elseif ($absensi->status == 3) {
            return '<span class="badge badge-warning">Izin</span>|' . $absensi->keterangan;
        } else {
            return '<span class="badge badge-danger">Telat</span>';
        }
    })
    ->addColumn('aksi', function ($absensi) {
        return '<div class="btn-group">
                    <button type="button" onclick="editForm(`' . route('absen.update', $absensi->id) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fas fa-edit"></i></button>
                    <button type="button" onclick="deleteData(`' . route('absen.destroy', $absensi->id) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                    <a href="' . route('absen.acc', $absensi->id) . '" class="btn btn-xs btn-success btn-flat"><i class="fa fa-check"></i></a>
                    <a href="' . route('absen.decline', $absensi->id) . '" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-times"></i></a>
                </div>';
    })
    ->rawColumns([
        'aksi', 'karyawan', 'jam_masuk', 'foto_masuk', 'jam_istirahat', 'foto_istirahat', 'jam_akhir', 'foto_akhir',
        'jam_pulang', 'foto_pulang', 'tanggal', 'status', 'accept', 'select_all', 'jabatan'
    ]) // Ensure HTML is rendered correctly
    ->make(true);
    
}


    
    public function topbeauty()
    {
        return view('backend.absensi.filter_beauty');
    }
    public function dataTopBeauty()
    {
        $jabatanId = auth()->user()->jabatan_id;
        $userLevel = auth()->user()->level;
        $karyawanId = auth()->user()->id;
    
        // Kondisi untuk user dengan level tertentu atau jabatan tertentu
        if ($userLevel == 0 || $userLevel == 1 || $jabatanId == 1) {
            $absensi = Absensi::with(['karyawan.data_karyawan.penempatan'])
                ->whereHas('karyawan.data_karyawan.penempatan', function ($query) {
                    $query->whereIn('nama', $this->topBeauty); // Filter untuk penempatan Top Beauty
                })
                ->orderBy('created_at', 'desc');
        } else {
            // Jika user bukan admin atau memiliki jabatan lain
            $absensi = Absensi::with(['karyawan.data_karyawan.penempatan'])
                ->where('karyawan_id', $karyawanId) // Hanya mengambil absensi user terkait
                ->whereHas('karyawan.data_karyawan.penempatan', function ($query) {
                    $query->whereIn('nama', $this->topBeauty); // Filter untuk penempatan Top Beauty
                })
                ->orderBy('created_at', 'desc');
        }
    
        // Mengembalikan data dalam format DataTables
      // Return DataTables with server-side processing
      return datatables()
      ->eloquent($absensi) // Use Eloquent Builder for server-side processing
      ->addIndexColumn() // Add index
      ->addColumn('select_all', function ($absensi) {
          return '<input type="checkbox" name="id_absen[]" value="' . $absensi->id . '">';
      })
      ->addColumn('tanggal', function ($absensi) {
          return formatTanggal($absensi->created_at); // Assuming formatTanggal is a helper function
      })
      ->addColumn('karyawan', function ($absensi) {
          return '<h1 class="badge badge-light">' . $absensi->karyawan->name . '</h1>';
      })
      ->addColumn('jabatan', function ($absensi) {
          $karyawan = karyawan::where('id', $absensi->karyawan->karyawan_id)->first();
          $jabatan = Jabatan::where('id', $karyawan->jabatan_id)->first();
          return '<h1 class="badge badge-info">' . $jabatan->jabatan . '</h1>';
      })
      ->addColumn('penempatan', function ($absensi) {
          $karyawan = karyawan::where('id', $absensi->karyawan->karyawan_id)->first();
          $penempatan = Penempatan::where('id', $karyawan->penempatan_id)->first();
          return $penempatan->nama;
      })
      ->addColumn('jam_masuk', function ($absensi) {
          return '<h1 class="badge badge-success">' . $absensi->jam_masuk . '</h1><a href="' . route('absen.edit', $absensi->id) . '" class="btn btn-xs btn-warning"><i class="fa fa-cog"></i></a>';
      })
      ->addColumn('foto_masuk', function ($absensi) {
          return '<a href="' . $absensi->foto_masuk . '" data-toggle="lightbox"><img src="' . $absensi->foto_masuk . '" class="img-fluid" alt=""></a>';
      })
      ->addColumn('jam_istirahat', function ($absensi) {
          return '<h1 class="badge badge-info">' . $absensi->jam_istirahat . '</h1>';
      })
      ->addColumn('foto_istirahat', function ($absensi) {
          return '<a href="' . $absensi->foto_istirahat . '" data-toggle="lightbox"><img src="' . $absensi->foto_istirahat . '" class="img-fluid" alt=""></a>';
      })
      ->addColumn('jam_akhir', function ($absensi) {
          return '<h1 class="badge badge-info">' . $absensi->jam_akhir . '</h1>';
      })
      ->addColumn('foto_akhir', function ($absensi) {
          return '<a href="' . $absensi->foto_akhir . '" data-toggle="lightbox"><img src="' . $absensi->foto_akhir . '" class="img-fluid" alt=""></a>';
      })
      ->addColumn('jam_pulang', function ($absensi) {
          return '<h1 class="badge badge-danger">' . $absensi->jam_pulang . '</h1>';
      })
      ->addColumn('foto_pulang', function ($absensi) {
          return '<a href="' . $absensi->foto_pulang . '" data-toggle="lightbox"><img src="' . $absensi->foto_pulang . '" class="img-fluid" alt=""></a>';
      })
      ->addColumn('accept', function ($absensi) {
          if ($absensi->accept == 0) {
              return '<span class="badge badge-danger">Ditolak</span>';
          } elseif ($absensi->accept == 1) {
              return '<span class="badge badge-success">Diterima</span>';
          } else {
              return '<span class="badge badge-light">Pending</span>';
          }
      })
      ->addColumn('status', function ($absensi) {
          if ($absensi->status == 0) {
              return '<span class="badge badge-warning">Sakit</span>|' . $absensi->keterangan;
          } elseif ($absensi->status == 1) {
              return '<span class="badge badge-success">Hadir</span>';
          } elseif ($absensi->status == 3) {
              return '<span class="badge badge-warning">Izin</span>|' . $absensi->keterangan;
          } else {
              return '<span class="badge badge-danger">Telat</span>';
          }
      })
      ->addColumn('aksi', function ($absensi) {
          return '<div class="btn-group">
                      <button type="button" onclick="editForm(`' . route('absen.update', $absensi->id) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fas fa-edit"></i></button>
                      <button type="button" onclick="deleteData(`' . route('absen.destroy', $absensi->id) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                      <a href="' . route('absen.acc', $absensi->id) . '" class="btn btn-xs btn-success btn-flat"><i class="fa fa-check"></i></a>
                      <a href="' . route('absen.decline', $absensi->id) . '" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-times"></i></a>
                  </div>';
      })
      ->rawColumns([
          'aksi', 'karyawan', 'jam_masuk', 'foto_masuk', 'jam_istirahat', 'foto_istirahat', 'jam_akhir', 'foto_akhir',
          'jam_pulang', 'foto_pulang', 'tanggal', 'status', 'accept', 'select_all', 'jabatan'
      ]) // Ensure HTML is rendered correctly
      ->make(true);
}

public function topgym()
{
    return view('backend.absensi.filter_gym');
}
public function dataTopGym()
{
    $jabatanId = auth()->user()->jabatan_id;
    $userLevel = auth()->user()->level;
    $karyawanId = auth()->user()->id;

    // Kondisi untuk user dengan level tertentu atau jabatan tertentu
    if ($userLevel == 0 || $userLevel == 1 || $jabatanId == 1) {
        $absensi = Absensi::with(['karyawan.data_karyawan.penempatan'])
            ->whereHas('karyawan.data_karyawan.penempatan', function ($query) {
                $query->whereIn('nama', $this->topGym); // Filter untuk penempatan Top Beauty
            })
            ->orderBy('created_at', 'desc');
    } else {
        // Jika user bukan admin atau memiliki jabatan lain
        $absensi = Absensi::with(['karyawan.data_karyawan.penempatan'])
            ->where('karyawan_id', $karyawanId) // Hanya mengambil absensi user terkait
            ->whereHas('karyawan.data_karyawan.penempatan', function ($query) {
                $query->whereIn('nama', $this->topGym); // Filter untuk penempatan Top Beauty
            })
            ->orderBy('created_at', 'desc');
    }

    // Mengembalikan data dalam format DataTables
  // Return DataTables with server-side processing
  return datatables()
  ->eloquent($absensi) // Use Eloquent Builder for server-side processing
  ->addIndexColumn() // Add index
  ->addColumn('select_all', function ($absensi) {
      return '<input type="checkbox" name="id_absen[]" value="' . $absensi->id . '">';
  })
  ->addColumn('tanggal', function ($absensi) {
      return formatTanggal($absensi->created_at); // Assuming formatTanggal is a helper function
  })
  ->addColumn('karyawan', function ($absensi) {
      return '<h1 class="badge badge-light">' . $absensi->karyawan->name . '</h1>';
  })
  ->addColumn('jabatan', function ($absensi) {
      $karyawan = karyawan::where('id', $absensi->karyawan->karyawan_id)->first();
      $jabatan = Jabatan::where('id', $karyawan->jabatan_id)->first();
      return '<h1 class="badge badge-info">' . $jabatan->jabatan . '</h1>';
  })
  ->addColumn('penempatan', function ($absensi) {
      $karyawan = karyawan::where('id', $absensi->karyawan->karyawan_id)->first();
      $penempatan = Penempatan::where('id', $karyawan->penempatan_id)->first();
      return $penempatan->nama;
  })
  ->addColumn('jam_masuk', function ($absensi) {
      return '<h1 class="badge badge-success">' . $absensi->jam_masuk . '</h1><a href="' . route('absen.edit', $absensi->id) . '" class="btn btn-xs btn-warning"><i class="fa fa-cog"></i></a>';
  })
  ->addColumn('foto_masuk', function ($absensi) {
      return '<a href="' . $absensi->foto_masuk . '" data-toggle="lightbox"><img src="' . $absensi->foto_masuk . '" class="img-fluid" alt=""></a>';
  })
  ->addColumn('jam_istirahat', function ($absensi) {
      return '<h1 class="badge badge-info">' . $absensi->jam_istirahat . '</h1>';
  })
  ->addColumn('foto_istirahat', function ($absensi) {
      return '<a href="' . $absensi->foto_istirahat . '" data-toggle="lightbox"><img src="' . $absensi->foto_istirahat . '" class="img-fluid" alt=""></a>';
  })
  ->addColumn('jam_akhir', function ($absensi) {
      return '<h1 class="badge badge-info">' . $absensi->jam_akhir . '</h1>';
  })
  ->addColumn('foto_akhir', function ($absensi) {
      return '<a href="' . $absensi->foto_akhir . '" data-toggle="lightbox"><img src="' . $absensi->foto_akhir . '" class="img-fluid" alt=""></a>';
  })
  ->addColumn('jam_pulang', function ($absensi) {
      return '<h1 class="badge badge-danger">' . $absensi->jam_pulang . '</h1>';
  })
  ->addColumn('foto_pulang', function ($absensi) {
      return '<a href="' . $absensi->foto_pulang . '" data-toggle="lightbox"><img src="' . $absensi->foto_pulang . '" class="img-fluid" alt=""></a>';
  })
  ->addColumn('accept', function ($absensi) {
      if ($absensi->accept == 0) {
          return '<span class="badge badge-danger">Ditolak</span>';
      } elseif ($absensi->accept == 1) {
          return '<span class="badge badge-success">Diterima</span>';
      } else {
          return '<span class="badge badge-light">Pending</span>';
      }
  })
  ->addColumn('status', function ($absensi) {
      if ($absensi->status == 0) {
          return '<span class="badge badge-warning">Sakit</span>|' . $absensi->keterangan;
      } elseif ($absensi->status == 1) {
          return '<span class="badge badge-success">Hadir</span>';
      } elseif ($absensi->status == 3) {
          return '<span class="badge badge-warning">Izin</span>|' . $absensi->keterangan;
      } else {
          return '<span class="badge badge-danger">Telat</span>';
      }
  })
  ->addColumn('aksi', function ($absensi) {
      return '<div class="btn-group">
                  <button type="button" onclick="editForm(`' . route('absen.update', $absensi->id) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fas fa-edit"></i></button>
                  <button type="button" onclick="deleteData(`' . route('absen.destroy', $absensi->id) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                  <a href="' . route('absen.acc', $absensi->id) . '" class="btn btn-xs btn-success btn-flat"><i class="fa fa-check"></i></a>
                  <a href="' . route('absen.decline', $absensi->id) . '" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-times"></i></a>
              </div>';
  })
  ->rawColumns([
      'aksi', 'karyawan', 'jam_masuk', 'foto_masuk', 'jam_istirahat', 'foto_istirahat', 'jam_akhir', 'foto_akhir',
      'jam_pulang', 'foto_pulang', 'tanggal', 'status', 'accept', 'select_all', 'jabatan'
  ]) // Ensure HTML is rendered correctly
  ->make(true);
}
public function topfood()
{
    return view('backend.absensi.filter_food');
}
public function dataTopFood()
{
    $jabatanId = auth()->user()->jabatan_id;
    $userLevel = auth()->user()->level;
    $karyawanId = auth()->user()->id;

    // Kondisi untuk user dengan level tertentu atau jabatan tertentu
    if ($userLevel == 0 || $userLevel == 1 || $jabatanId == 1) {
        $absensi = Absensi::with(['karyawan.data_karyawan.penempatan'])
            ->whereHas('karyawan.data_karyawan.penempatan', function ($query) {
                $query->whereIn('nama', $this->topFood); // Filter untuk penempatan Top Food
            })
            ->orderBy('created_at', 'desc');
    } else {
        // Jika user bukan admin atau memiliki jabatan lain
        $absensi = Absensi::with(['karyawan.data_karyawan.penempatan'])
            ->where('karyawan_id', $karyawanId) // Hanya mengambil absensi user terkait
            ->whereHas('karyawan.data_karyawan.penempatan', function ($query) {
                $query->whereIn('nama', $this->topFood); // Filter untuk penempatan Top Food
            })
            ->orderBy('created_at', 'desc');
    }

    // Mengembalikan data dalam format DataTables
  // Return DataTables with server-side processing
  return datatables()
  ->eloquent($absensi) // Use Eloquent Builder for server-side processing
  ->addIndexColumn() // Add index
  ->addColumn('select_all', function ($absensi) {
      return '<input type="checkbox" name="id_absen[]" value="' . $absensi->id . '">';
  })
  ->addColumn('tanggal', function ($absensi) {
      return formatTanggal($absensi->created_at); // Assuming formatTanggal is a helper function
  })
  ->addColumn('karyawan', function ($absensi) {
      return '<h1 class="badge badge-light">' . $absensi->karyawan->name . '</h1>';
  })
  ->addColumn('jabatan', function ($absensi) {
      $karyawan = karyawan::where('id', $absensi->karyawan->karyawan_id)->first();
      $jabatan = Jabatan::where('id', $karyawan->jabatan_id)->first();
      return '<h1 class="badge badge-info">' . $jabatan->jabatan . '</h1>';
  })
  ->addColumn('penempatan', function ($absensi) {
      $karyawan = karyawan::where('id', $absensi->karyawan->karyawan_id)->first();
      $penempatan = Penempatan::where('id', $karyawan->penempatan_id)->first();
      return $penempatan->nama;
  })
  ->addColumn('jam_masuk', function ($absensi) {
      return '<h1 class="badge badge-success">' . $absensi->jam_masuk . '</h1><a href="' . route('absen.edit', $absensi->id) . '" class="btn btn-xs btn-warning"><i class="fa fa-cog"></i></a>';
  })
  ->addColumn('foto_masuk', function ($absensi) {
      return '<a href="' . $absensi->foto_masuk . '" data-toggle="lightbox"><img src="' . $absensi->foto_masuk . '" class="img-fluid" alt=""></a>';
  })
  ->addColumn('jam_istirahat', function ($absensi) {
      return '<h1 class="badge badge-info">' . $absensi->jam_istirahat . '</h1>';
  })
  ->addColumn('foto_istirahat', function ($absensi) {
      return '<a href="' . $absensi->foto_istirahat . '" data-toggle="lightbox"><img src="' . $absensi->foto_istirahat . '" class="img-fluid" alt=""></a>';
  })
  ->addColumn('jam_akhir', function ($absensi) {
      return '<h1 class="badge badge-info">' . $absensi->jam_akhir . '</h1>';
  })
  ->addColumn('foto_akhir', function ($absensi) {
      return '<a href="' . $absensi->foto_akhir . '" data-toggle="lightbox"><img src="' . $absensi->foto_akhir . '" class="img-fluid" alt=""></a>';
  })
  ->addColumn('jam_pulang', function ($absensi) {
      return '<h1 class="badge badge-danger">' . $absensi->jam_pulang . '</h1>';
  })
  ->addColumn('foto_pulang', function ($absensi) {
      return '<a href="' . $absensi->foto_pulang . '" data-toggle="lightbox"><img src="' . $absensi->foto_pulang . '" class="img-fluid" alt=""></a>';
  })
  ->addColumn('accept', function ($absensi) {
      if ($absensi->accept == 0) {
          return '<span class="badge badge-danger">Ditolak</span>';
      } elseif ($absensi->accept == 1) {
          return '<span class="badge badge-success">Diterima</span>';
      } else {
          return '<span class="badge badge-light">Pending</span>';
      }
  })
  ->addColumn('status', function ($absensi) {
      if ($absensi->status == 0) {
          return '<span class="badge badge-warning">Sakit</span>|' . $absensi->keterangan;
      } elseif ($absensi->status == 1) {
          return '<span class="badge badge-success">Hadir</span>';
      } elseif ($absensi->status == 3) {
          return '<span class="badge badge-warning">Izin</span>|' . $absensi->keterangan;
      } else {
          return '<span class="badge badge-danger">Telat</span>';
      }
  })
  ->addColumn('aksi', function ($absensi) {
      return '<div class="btn-group">
                  <button type="button" onclick="editForm(`' . route('absen.update', $absensi->id) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fas fa-edit"></i></button>
                  <button type="button" onclick="deleteData(`' . route('absen.destroy', $absensi->id) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                  <a href="' . route('absen.acc', $absensi->id) . '" class="btn btn-xs btn-success btn-flat"><i class="fa fa-check"></i></a>
                  <a href="' . route('absen.decline', $absensi->id) . '" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-times"></i></a>
              </div>';
  })
  ->rawColumns([
      'aksi', 'karyawan', 'jam_masuk', 'foto_masuk', 'jam_istirahat', 'foto_istirahat', 'jam_akhir', 'foto_akhir',
      'jam_pulang', 'foto_pulang', 'tanggal', 'status', 'accept', 'select_all', 'jabatan'
  ]) // Ensure HTML is rendered correctly
  ->make(true);
}    

 public function masuk()
    {
        return view('backend.absensi.create_masuk');
    }

    public function absenLogin(Request $request)
    {
        $karyawan = auth()->user()->id;
        $data_lama = Absensi::where('karyawan_id',$karyawan)->latest()->first();
        $data_shift = karyawan::where('id',auth()->user()->karyawan_id)->first();
        $shift = Shift::where('id',$data_shift->shift_id)->first();
        $now = Carbon::now();

        if($data_lama){
            if($data_lama->created_at->format('Y-m-d') < date('Y-m-d')){
                $masuk = new Absensi();

                if($shift->masuk >= date('H:i')){
                    $masuk->status = 1; //hadir
                }else{
                    $masuk->status = 2; //telat
                }
                $masuk->karyawan_id = $karyawan;
                $masuk->jam_masuk = date('H:i');
        
                if($request->foto_masuk == NULL){
                    $notif = array(
                        'message' => 'Anda belum memasukkan foto',
                        'alert-type' => 'error'
                    );
        
                    return redirect()->back()->with($notif);
                }else{
                    $img = $request->foto_masuk;
                    $folderPath = "masuk/";
                    
                    $image_parts = explode(";base64,", $img);
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_type = $image_type_aux[1];
                    
                    $image_base64 = base64_decode($image_parts[1]);
                    $fileName = uniqid() . '.png';
                    
                    $file = $folderPath . $fileName;
                    
                    Storage::disk('public_uploads')->put($file, $image_base64);
        
                    $masuk->foto_masuk = 'uploads/masuk/'.$fileName;
                    $masuk->save();
                }
                  
                $notif = array(
                    'message' => 'Data Absen Berhasil di Upload',
                    'alert-type' => 'success'
                );
        
                return redirect()->route('absen.index')->with($notif);
            }else{
    
                $notif = array(
                    'message' => 'Data Absen sudah ada',
                    'alert-type' => 'error'
                );
    
                return redirect()->back()->with($notif);
            }
        }else{
            $masuk = new Absensi();

            if($shift->masuk >= date('H:i')){
                $masuk->status = 1; //hadir
            }else{
                $masuk->status = 2; //telat
            }
            $masuk->karyawan_id = $karyawan;
            $masuk->jam_masuk = date('H:i');
    
            if($request->foto_masuk == NULL){
                $notif = array(
                    'message' => 'Anda belum memasukkan foto',
                    'alert-type' => 'error'
                );
    
                return redirect()->back()->with($notif);
            }else{
                $img = $request->foto_masuk;
                $folderPath = "masuk/";
                
                $image_parts = explode(";base64,", $img);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                
                $image_base64 = base64_decode($image_parts[1]);
                $fileName = uniqid() . '.png';
                
                $file = $folderPath . $fileName;
                
                Storage::disk('public_uploads')->put($file, $image_base64);
    
                $masuk->foto_masuk = 'uploads/masuk/'.$fileName;
                $masuk->save();
            }
              
            $notif = array(
                'message' => 'Data Absen Berhasil di Upload',
                'alert-type' => 'success'
            );
    
            return redirect()->route('absen.index')->with($notif);
        }
    }

    public function istirahat()
    {
        return view('backend.absensi.create_istirahat');
    }

    public function absenRest(Request $request)
    {
        $karyawan = auth()->user()->id;
        $data_lama = Absensi::where('karyawan_id',$karyawan)->latest()->first();
        $data_shift = karyawan::where('id',auth()->user()->karyawan_id)->first();
        $shift = Shift::where('id',$data_shift->shift_id)->first();
        $now = Carbon::now();

        if($data_lama){
            if($data_lama->created_at->format('Y-m-d') == date('Y-m-d')){
               
                $data_lama->jam_istirahat = date('H:i');
        
                if($request->foto_istirahat == NULL){
                    $notif = array(
                        'message' => 'Anda belum memasukkan foto',
                        'alert-type' => 'error'
                    );
        
                    return redirect()->back()->with($notif);
                }else{
                    if($data_lama->foto_masuk){
                        $img = $request->foto_istirahat;
                        $folderPath = "istirahat/";
                        
                        $image_parts = explode(";base64,", $img);
                        $image_type_aux = explode("image/", $image_parts[0]);
                        $image_type = $image_type_aux[1];
                        
                        $image_base64 = base64_decode($image_parts[1]);
                        $fileName = uniqid() . '.png';
                        
                        $file = $folderPath . $fileName;
                        
                        Storage::disk('public_uploads')->put($file, $image_base64);
            
                        $data_lama->foto_istirahat = 'uploads/istirahat/'.$fileName;
                        $data_lama->update();
                    }else{
                        $notif = array(
                            'message' => 'Data Absen Masuk Belum ada',
                            'alert-type' => 'error'
                        );

                        return redirect()->back()->with($notif);
                    }
                   
                }
                  
                $notif = array(
                    'message' => 'Data Istirahat Berhasil di Upload',
                    'alert-type' => 'success'
                );
        
                return redirect()->route('absen.index')->with($notif);
            }else{
    
                $notif = array(
                    'message' => 'Anda Belum Absen Masuk',
                    'alert-type' => 'error'
                );
    
                return redirect()->back()->with($notif);
            }
        }else{
              
            $notif = array(
                'message' => 'Anda Belum Absen Hari ini',
                'alert-type' => 'error'
            );
    
            return redirect()->back()->with($notif);
        }
    }

    public function istirahatAkhir()
    {
        return view('backend.absensi.create_istirahat_akhir');
    }

    public function absenRestAkhir(Request $request)
    {
        $karyawan = auth()->user()->id;
        $data_lama = Absensi::where('karyawan_id',$karyawan)->latest()->first();
        $data_shift = karyawan::where('id',auth()->user()->karyawan_id)->first();
        $shift = Shift::where('id',$data_shift->shift_id)->first();
        $now = Carbon::now();

        if($data_lama){
            if($data_lama->created_at->format('Y-m-d') == date('Y-m-d')){
               
                $data_lama->jam_akhir = date('H:i');
        
                if($request->foto_akhir == NULL){
                    $notif = array(
                        'message' => 'Anda belum memasukkan foto',
                        'alert-type' => 'error'
                    );
        
                    return redirect()->back()->with($notif);
                }else{
                    if($data_lama->foto_istirahat){
                        $img = $request->foto_akhir;
                        $folderPath = "istirahat_akhir/";
                        
                        $image_parts = explode(";base64,", $img);
                        $image_type_aux = explode("image/", $image_parts[0]);
                        $image_type = $image_type_aux[1];
                        
                        $image_base64 = base64_decode($image_parts[1]);
                        $fileName = uniqid() . '.png';
                        
                        $file = $folderPath . $fileName;
                        
                        Storage::disk('public_uploads')->put($file, $image_base64);
            
                        $data_lama->foto_akhir = 'uploads/istirahat_akhir/'.$fileName;
                        $data_lama->update();
                    }else{
                        $notif = array(
                            'message' => 'Data Absen Istirahat Belum ada',
                            'alert-type' => 'error'
                        );

                        return redirect()->back()->with($notif);
                    }
                   
                }
                  
                $notif = array(
                    'message' => 'Data Akhir Istirahat Berhasil di Upload',
                    'alert-type' => 'success'
                );
        
                return redirect()->route('absen.index')->with($notif);
            }else{
    
                $notif = array(
                    'message' => 'Anda Belum Absen Hari Ini',
                    'alert-type' => 'error'
                );
    
                return redirect()->back()->with($notif);
            }
        }else{
              
            $notif = array(
                'message' => 'Anda Belum Absen Hari ini',
                'alert-type' => 'error'
            );
    
            return redirect()->back()->with($notif);
        }
    }

    public function pulang()
    {
        return view('backend.absensi.create_pulang');
    }

    public function absenLogout(Request $request)
    {
        $karyawan = auth()->user()->id;
        $data_lama = Absensi::where('karyawan_id',$karyawan)->latest()->first();
        $data_shift = karyawan::where('id',auth()->user()->karyawan_id)->first();
        $shift = Shift::where('id',$data_shift->shift_id)->first();
        $now = Carbon::now();

        if($data_lama){
            if($data_lama->created_at->format('Y-m-d') == date('Y-m-d')){
               
                $data_lama->jam_pulang = date('H:i');
        
                if($request->foto_pulang == NULL){
                    $notif = array(
                        'message' => 'Anda belum memasukkan foto',
                        'alert-type' => 'error'
                    );
        
                    return redirect()->back()->with($notif);
                }else{
                    if($data_lama->foto_akhir){
                        $img = $request->foto_pulang;
                        $folderPath = "pulang/";
                        
                        $image_parts = explode(";base64,", $img);
                        $image_type_aux = explode("image/", $image_parts[0]);
                        $image_type = $image_type_aux[1];
                        
                        $image_base64 = base64_decode($image_parts[1]);
                        $fileName = uniqid() . '.png';
                        
                        $file = $folderPath . $fileName;
                        
                        Storage::disk('public_uploads')->put($file, $image_base64);
            
                        $data_lama->foto_pulang = 'uploads/pulang/'.$fileName;
                        $data_lama->update();
                    }else{
                        $notif = array(
                            'message' => 'Data Absen Istirahat Belum ada',
                            'alert-type' => 'error'
                        );

                        return redirect()->back()->with($notif);
                    }
                   
                }
                  
                $notif = array(
                    'message' => 'Data Pulang Berhasil di Upload',
                    'alert-type' => 'success'
                );
        
                return redirect()->route('absen.index')->with($notif);
            }else{
    
                $notif = array(
                    'message' => 'Anda Belum Absen Hari Ini',
                    'alert-type' => 'error'
                );
    
                return redirect()->back()->with($notif);
            }
        }else{
              
            $notif = array(
                'message' => 'Anda Belum Absen Hari ini',
                'alert-type' => 'error'
            );
    
            return redirect()->back()->with($notif);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function accept($id)
    {
        $absen = Absensi::findOrFail($id);
        $user = User::where('id',$absen->karyawan_id)->first(); //ambil user 17
        $data_karyawan = karyawan::where('id',$user->karyawan_id)->first();

        if($absen->accept == 0){ //ditolak
            $data_karyawan->absen += 1;
            $data_karyawan->update();   
        }
        if($absen->accept == 2){ //pending
            $data_karyawan->absen += 1;
            $data_karyawan->update();
        }else{

        }
        Absensi::findOrFail($id)->update([
            'accept' => 1
        ]);

        $notif = array(
            'message' => 'Data Absen Diterima',
            'alert-type' => 'success'
        );

      
       return redirect()->back()->with($notif);

    }

    public function decline($id)
    {
        $absen = Absensi::findOrFail($id);
        $user = User::where('id',$absen->karyawan_id)->first(); //ambil user 17
        $data_karyawan = karyawan::where('id',$user->karyawan_id)->first();

        if($absen->status == 1){ //diterima
            $data_karyawan->absen--;
            $data_karyawan->update();   
        }
        if($absen->status == 2){ //pending
            $data_karyawan->absen--;
            $data_karyawan->update();
        }else{

        }

        Absensi::findOrFail($id)->update([
            'accept' => 0
        ]);

        $notif = array(
            'message' => 'Data Absen Ditolak',
            'alert-type' => 'error'
        );

      
       return redirect()->back()->with($notif);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $absen = Absensi::find($id);
        return response()->json($absen);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $absen = Absensi::find($id);

        return view('backend.absensi.edit', compact('absen'));
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $absensi = Absensi::find($id);
        if($request->status == NULL){
            $absensi->status = $absensi->status;
        }else{
            $absensi->status = $request->status;
        }
        
        $absensi->keterangan = $request->keterangan;

        $absensi->update();

        return redirect()->back()->with('success', 'Status Kehadiran berhasil diubah');

    }
    
    public function updated(Request $request, $id)
    {
        $absensi = Absensi::find($id);
        
        if($request->path_foto){

            unlink($absensi->foto_masuk);
            $img = $request->path_foto;

            $folderPath = "masuk/";
            
            $image_parts = explode(";base64,", $img);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = uniqid() . '.png';
            
            $file = $folderPath . $fileName;
            
            Storage::disk('public_uploads')->put($file, $image_base64);
    
            $absensi->foto_masuk = 'uploads/masuk/'.$fileName;
    
            $absensi->update();

                   
            $notif = array(
                'message' => 'Data Absen Masuk Berhasil di Upload',
                'alert-type' => 'success'
            );
    
            return redirect()->route('absen.index')->with($notif);
        }else{
            $notif = array(
                'message' => 'Foto Baru Belum Ada',
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notif);
    
        }

    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $absensi = Absensi::find($id);
        $user = User::where('id',$absensi->karyawan_id)->first(); //ambil user 17
        $data_karyawan = karyawan::where('id',$user->karyawan_id)->first();
        if($absensi->accept == 1){ //diterima
            $data_karyawan->absen--;
            $data_karyawan->update();   
        }
        if($absensi->path_foto){
            unlink($absensi->path_foto);
        }
        if($absensi->path_foto_2){
            unlink($absensi->path_foto_2);
        }
        if($absensi->path_foto_3){
            unlink($absensi->path_foto_3);
        }
        if($absensi->path_foto_4){
            unlink($absensi->path_foto_4);
        }

        $absensi->delete();

        return response()->json('data berhasil dihapus');
    }
    

    public function acceptSelected(Request $request)
    {
        // Cek apakah ada ID absen yang dikirim
        if(!$request->has('id_absen') || empty($request->id_absen)) {
            return response()->json(['error' => 'Tidak ada absensi yang dipilih'], 400);
        }
    
        // Ambil semua ID absen dan cari semua absensi yang sesuai
        $absensi = Absensi::whereIn('id', $request->id_absen)->get();
    
        // Cek apakah ada absensi yang ditemukan
        if($absensi->isEmpty()) {
            return response()->json(['error' => 'Data absensi tidak ditemukan'], 404);
        }
    
        // Update field 'accept' menjadi 1 untuk setiap absensi yang dipilih
        foreach($absensi as $absen) {
            $absen->accept = 1;
            $absen->save();
        }
    
        return response()->json(['message' => 'Absensi berhasil diterima'], 200);
    }
    

    public function declineSelected(Request $request)
    {
        foreach($request->id_absen  as $id){
            $absen = Absensi::find($id);

            $absen->accept = 0;

            $absen->update();
        }
        return response()->json('absen berhasil ditolak');
        
    }
}
