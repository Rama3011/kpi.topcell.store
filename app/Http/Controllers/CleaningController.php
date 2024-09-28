<?php

namespace App\Http\Controllers;

use App\Models\Cleaning;
use App\Models\Penempatan;
use App\Models\karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class CleaningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.cleaning.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    // public function data()
    // {
    //     if(auth()->user()->level == 0 || auth()->user()->level == 3){
    //         $cleaning = Cleaning::latest();
    //     } else {
    //         $cleaning = Cleaning::where('user_id', auth()->user()->id)->latest();
    //     }

    //     return DataTables::of($cleaning)
    //         ->addIndexColumn()
    //         ->addColumn('select_all', function($cleaning){
    //             return '<input type="checkbox" name="id_cleaning[]" value="'.$cleaning->id.'">';
    //         })
    //         ->addColumn('path_foto', function($cleaning){
    //             return ' <a href="'.$cleaning->path_foto.'" data-toggle="lightbox">
    //                     <img src="'.$cleaning->path_foto.'" class="img-fluid" alt="" style="width: 40px;" data-(width|height)="[0-9]+">
    //                   </a>';
    //         })
    //         ->addColumn('penempatan', function($cleaning){
    //             return '<h1 class="badge badge-dark">'.$cleaning->penempatan->nama.'</h1>';
    //         })
    //         ->addColumn('user', function($cleaning){
    //             return '<h1 class="badge badge-success">'.$cleaning->user->name.'</h1>';
    //         })
    //         ->addColumn('tanggal', function($cleaning){
    //             $result = Carbon::parse($cleaning->created_at);
    //             return $result;
    //         })
    //         ->addColumn('status', function($cleaning){
    //             if($cleaning->status == 0){
    //                 return '<span class="badge badge-danger">Ditolak</span>';
    //             } else if($cleaning->status == 1){
    //                 return '<span class="badge badge-success">Diterima</span>';
    //             } else {
    //                 return '<span class="badge badge-light">Pending</span>';
    //             }
    //         })
    //         ->addColumn('aksi', function($cleaning){
    //             $button = '<div class="btn-group"><a href="'.route('cleaning.edit', $cleaning->id).'" class="btn btn-xs btn-info btn-flat"><i class="fas fa-edit"></i></a><button type="button" onclick="deleteData(`'.route('cleaning.destroy', $cleaning->id).'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button><a href="'.route('cleaning.acc', $cleaning->id).'" class="btn btn-xs btn-success btn-flat"><i class="fa fa-check"></i></a><a href="'.route('cleaning.decline', $cleaning->id).'" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-times"></i></a><a href="'.route('cleaning.show', $cleaning->id).'" class="btn btn-xs btn-warning btn-flat"><i class="fa fa-eye"></i></a></div>';
    //             return $button;
    //         })
    //         ->rawColumns(['aksi','path_foto','penempatan','user','tanggal','status','select_all'])
    //         ->make(true);
    // }
    
    public function data()
{
    $user = auth()->user();

    // Query preparation with conditional checks
    if ($user->level == 0 || $user->level == 1) {
        $cleaningQuery = Cleaning::latest();
    } else {
        $cleaningQuery = Cleaning::where('user_id', $user->id)->latest();
    }

    // Server-side pagination (optimized with skip and take)
    return DataTables::of($cleaningQuery)
    ->addIndexColumn()
    ->addColumn('select_all', function($cleaning) {
        return '<input type="checkbox" name="id_cleaning[]" value="'.$cleaning->id.'">';
    })
    ->addColumn('path_foto', function($cleaning) {
        return '<a href="'.$cleaning->path_foto.'" data-toggle="lightbox">
                    <img src="'.$cleaning->path_foto.'" class="img-fluid" alt="" style="width: 40px;">
                </a>';
    })
    ->addColumn('penempatan', function($cleaning) {
        if ($cleaning->penempatan) {
            return '<h1 class="badge badge-dark">'.$cleaning->penempatan->nama.'</h1>';
        } else {
            return '<span class="badge badge-warning">No Penempatan</span>';
        }
    })
    ->addColumn('user', function($cleaning) {
        if ($cleaning->user) {
            return '<h1 class="badge badge-success">'.$cleaning->user->name.'</h1>';
        } else {
            return '<span class="badge badge-warning">No User</span>';
        }
    })
    ->addColumn('tanggal', function($cleaning) {
        return Carbon::parse($cleaning->created_at)->format('Y-m-d');
    })
    ->addColumn('status', function($cleaning) {
        switch ($cleaning->status) {
            case 0:
                return '<span class="badge badge-danger">Ditolak</span>';
            case 1:
                return '<span class="badge badge-success">Diterima</span>';
            default:
                return '<span class="badge badge-light">Pending</span>';
        }
    })
    ->addColumn('aksi', function($cleaning) {
        return '<div class="btn-group">
                    <a href="'.route('cleaning.edit', $cleaning->id).'" class="btn btn-xs btn-info"><i class="fas fa-edit"></i></a>
                    <button type="button" onclick="deleteData(`'.route('cleaning.destroy', $cleaning->id).'`)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                    <a href="'.route('cleaning.acc', $cleaning->id).'" class="btn btn-xs btn-success"><i class="fa fa-check"></i></a>
                    <a href="'.route('cleaning.decline', $cleaning->id).'" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                    <a href="'.route('cleaning.show', $cleaning->id).'" class="btn btn-xs btn-warning"><i class="fa fa-eye"></i></a>
                </div>';
    })
    ->rawColumns(['select_all', 'path_foto', 'penempatan', 'user', 'tanggal', 'status', 'aksi'])
    ->make(true);

}


    public function create()
    {
        $penempatan = Penempatan::all()->pluck('nama','id');

        return view('backend.cleaning.create', compact('penempatan'));
    }

    public function accept($id)
    {
        $kebersihan = Cleaning::findOrFail($id);
        $user = User::where('id',$kebersihan->user_id)->first();
        $data_karyawan = karyawan::where('id',$user->karyawan_id)->first();

        if($kebersihan->status == 0){
            $data_karyawan->kebersihan += 1;
            $data_karyawan->update();   
        }
        if($kebersihan->status == 2){
            $data_karyawan->kebersihan += 1;
            $data_karyawan->update();
        }

        Cleaning::findOrFail($id)->update([
            'status' => 1
        ]);

        $notif = array(
            'message' => 'Data Cleaning Diterima',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notif);
    }
 public function edit($id)
    {
        $cleaning = Cleaning::findOrfail($id);
        $penempatan = Penempatan::all();

        return view('backend.cleaning.edit',compact('penempatan','cleaning'));
    }
    
    public function destroy($id)
    {
        $cleaning = Cleaning::findOrFail($id); // Pastikan data ditemukan
        $user = User::where('id', $cleaning->user_id)->first(); // Perbaiki pengambilan user
        $data_karyawan = karyawan::where('id', $user->karyawan_id)->first();

        if ($cleaning->status == 1) { // Jika diterima
            $data_karyawan->kebersihan--;
            $data_karyawan->update();
        }

        // Hapus file jika ada
        if ($cleaning->path_foto && file_exists(public_path($cleaning->path_foto))) {
            unlink(public_path($cleaning->path_foto));
        }
        if ($cleaning->path_foto_2 && file_exists(public_path($cleaning->path_foto_2))) {
            unlink(public_path($cleaning->path_foto_2));
        }
        if ($cleaning->path_foto_3 && file_exists(public_path($cleaning->path_foto_3))) {
            unlink(public_path($cleaning->path_foto_3));
        }
        if ($cleaning->path_foto_4 && file_exists(public_path($cleaning->path_foto_4))) {
            unlink(public_path($cleaning->path_foto_4));
        }

        $cleaning->delete();

        return response()->json('Data berhasil dihapus');
    }
    
    public function decline($id)
    {
        $cleaning = Cleaning::findOrFail($id);
        $user = User::where('id',$cleaning->user_id)->first();
        $data_karyawan = karyawan::where('id',$user->karyawan_id)->first();

        if($cleaning->status == 1){
            $data_karyawan->kebersihan--;
            $data_karyawan->update();   
        }
        if($cleaning->status == 2){
            $data_karyawan->kebersihan--;
            $data_karyawan->update();
        }

        Cleaning::findOrFail($id)->update([
            'status' => 0
        ]);

        $notif = array(
            'message' => 'Data Cleaning Ditolak',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notif);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     
     public function show($id)
    {
        $cleaning = Cleaning::findOrFail($id);
        $penempatan = Penempatan::all();

        return view('backend.cleaning.show',compact('cleaning','penempatan'));
    }
    
    public function store(Request $request)
    {
        $karyawan = auth()->user()->id;
        $data_lama = Cleaning::where('user_id',$karyawan)->latest()->first();
        $now = Carbon::now();

        if($data_lama){
            if($data_lama->created_at->format('Y-m-d') < date('Y-m-d')){
                $cleaning = new Cleaning();

                $cleaning->penempatan_id = $request->penempatan_id;
                $cleaning->catatan = $request->catatan;
                $cleaning->created_at = now();
                $cleaning->user_id = auth()->user()->id;
        
                if($request->path_foto == NULL){
                    $notif = array(
                        'message' => 'Anda belum memasukkan foto',
                        'alert-type' => 'error'
                    );
        
                    return redirect()->back()->with($notif);
                } else {
                    $folderPath = "foto_clean/";
                    if($request->path_foto){
                        $img = $request->path_foto;
                        $image_parts = explode(";base64,", $img);
                        $image_type_aux = explode("image/", $image_parts[0]);
                        $image_type = $image_type_aux[1];
            
                        $image_base64 = base64_decode($image_parts[1]);
                        $fileName = uniqid() . '.png';
            
                        $file = $folderPath . $fileName;
            
                        Storage::disk('public_uploads')->put($file, $image_base64);
            
                        $cleaning->path_foto = 'uploads/foto_clean/'.$fileName;
                    }
            
                    if($request->path_foto_2){
                        $img = $request->path_foto_2;
                        $image_parts = explode(";base64,", $img);
                        $image_type_aux = explode("image/", $image_parts[0]);
                        $image_type = $image_type_aux[1];
            
                        $image_base64 = base64_decode($image_parts[1]);
                        $fileName = uniqid() . '.png';
            
                        $file = $folderPath . $fileName;
            
                        Storage::disk('public_uploads')->put($file, $image_base64);
            
                        $cleaning->path_foto_2 = 'uploads/foto_clean/'.$fileName;
                    }
                     
                    if($request->path_foto_3){
                        $img = $request->path_foto_3;
                        $image_parts = explode(";base64,", $img);
                        $image_type_aux = explode("image/", $image_parts[0]);
                        $image_type = $image_type_aux[1];
            
                        $image_base64 = base64_decode($image_parts[1]);
                        $fileName = uniqid() . '.png';
            
                        $file = $folderPath . $fileName;
            
                        Storage::disk('public_uploads')->put($file, $image_base64);
            
                        $cleaning->path_foto_3 = 'uploads/foto_clean/'.$fileName;
                    }
            
                    if($request->path_foto_4){
                        $img = $request->path_foto_4;
                        $image_parts = explode(";base64,", $img);
                        $image_type_aux = explode("image/", $image_parts[0]);
                        $image_type = $image_type_aux[1];
            
                        $image_base64 = base64_decode($image_parts[1]);
                        $fileName = uniqid() . '.png';
            
                        $file = $folderPath . $fileName;
            
                        Storage::disk('public_uploads')->put($file, $image_base64);
            
                        $cleaning->path_foto_4 = 'uploads/foto_clean/'.$fileName;
                    }
            
                    $cleaning->save();
                }
                  
                $notif = array(
                    'message' => 'Data Kebersihan Berhasil di Upload',
                    'alert-type' => 'success'
                );
        
                return redirect()->route('cleaning.index')->with($notif);
            } else {
                $notif = array(
                    'message' => 'Data Cleaning sudah ada',
                    'alert-type' => 'error'
                );
    
                return redirect()->back()->with($notif);
            }
        } else {
            $cleaning = new Cleaning();

            $cleaning->penempatan_id = $request->penempatan_id;
            $cleaning->catatan = $request->catatan;
            $cleaning->created_at = now();
            $cleaning->user_id = auth()->user()->id;
    
            if($request->path_foto == NULL){
                $notif = array(
                    'message' => 'Anda belum memasukkan foto',
                    'alert-type' => 'error'
                );
    
                return redirect()->back()->with($notif);
            } else {
                $folderPath = "foto_clean/";
                if($request->path_foto){
                    $img = $request->path_foto;
                    $image_parts = explode(";base64,", $img);
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_type = $image_type_aux[1];
        
                    $image_base64 = base64_decode($image_parts[1]);
                    $fileName = uniqid() . '.png';
        
                    $file = $folderPath . $fileName;
        
                    Storage::disk('public_uploads')->put($file, $image_base64);
        
                    $cleaning->path_foto = 'uploads/foto_clean/'.$fileName;
                }
        
                if($request->path_foto_2){
                    $img = $request->path_foto_2;
                    $image_parts = explode(";base64,", $img);
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_type = $image_type_aux[1];
        
                    $image_base64 = base64_decode($image_parts[1]);
                    $fileName = uniqid() . '.png';
        
                    $file = $folderPath . $fileName;
        
                    Storage::disk('public_uploads')->put($file, $image_base64);
        
                    $cleaning->path_foto_2 = 'uploads/foto_clean/'.$fileName;
                }
                 
                if($request->path_foto_3){
                    $img = $request->path_foto_3;
                    $image_parts = explode(";base64,", $img);
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_type = $image_type_aux[1];
        
                    $image_base64 = base64_decode($image_parts[1]);
                    $fileName = uniqid() . '.png';
        
                    $file = $folderPath . $fileName;
        
                    Storage::disk('public_uploads')->put($file, $image_base64);
        
                    $cleaning->path_foto_3 = 'uploads/foto_clean/'.$fileName;
                }
        
                if($request->path_foto_4){
                    $img = $request->path_foto_4;
                    $image_parts = explode(";base64,", $img);
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_type = $image_type_aux[1];
        
                    $image_base64 = base64_decode($image_parts[1]);
                    $fileName = uniqid() . '.png';
        
                    $file = $folderPath . $fileName;
        
                    Storage::disk('public_uploads')->put($file, $image_base64);
        
                    $cleaning->path_foto_4 = 'uploads/foto_clean/'.$fileName;
                }
        
                $cleaning->save();
            }
              
            $notif = array(
                'message' => 'Data Kebersihan Berhasil di Upload',
                'alert-type' => 'success'
            );
    
            return redirect()->route('cleaning.index')->with($notif);
        }
    }
}