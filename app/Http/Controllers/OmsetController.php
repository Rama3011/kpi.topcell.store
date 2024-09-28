<?php

namespace App\Http\Controllers;

use App\Models\Omset;
use App\Models\User;
use App\Models\Penempatan;
use App\Models\karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class OmsetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $sales = karyawan::where('jabatan_id', 4)->pluck('name','id');
        return view('backend.omset.index');
    }

    public function data(Request $request)
{
    $query = Omset::query();

    if (auth()->user()->level == 0 || auth()->user()->level == 1) {
        // Admin and higher-level users (no restriction)
        $query->with(['user.data_karyawan.penempatan']);
    } else {
        // Restrict data for sales users
        $query->where('karyawan_id', auth()->user()->id)
              ->with(['user.data_karyawan.penempatan']);
              
    }
    
     $query->orderBy('tanggal_setor', 'desc');

    return datatables()
        ->eloquent($query) // Use eloquent for server-side processing
        ->addIndexColumn()
        ->addColumn('select_all', function($omset) {
            return '<input type="checkbox" name="id_omset[]" value="'.$omset->id.'">';
        })
        ->addColumn('sales', function($omset) {
            return '<span class="badge badge-success">'.$omset->user->name.'</span>';
        })
        ->addColumn('outlet', function($omset) {
            $penempatanNama = optional(optional(optional($omset->user)->data_karyawan)->penempatan)->nama ?? 'Tidak Ada Penempatan'; 
            return '<span class="badge badge-dark">'.$penempatanNama.'</span>';
        })
        ->addColumn('nominal', function($omset) {
            return 'Rp ' . formatUang($omset->nominal);
        })
        ->addColumn('tanggal_setor', function($omset) {
            return formatTanggal($omset->tanggal_setor);
        })
        ->addColumn('status', function($omset) {
            if ($omset->status == 0) {
                return '<span class="badge badge-danger">Ditolak</span>';
            } elseif ($omset->status == 1) {
                return '<span class="badge badge-success">Diterima</span>';
            } else {
                return '<span class="badge badge-light">Pending</span>';
            }
        })
        ->addColumn('aksi', function($omset) {
            $button = '<div class="btn-group">
                        <button type="button" onclick="editForm(`'.route('omset.update', $omset->id).'`)" class="btn btn-xs btn-info btn-flat"><i class="fas fa-edit"></i></button>
                        <button type="button" onclick="deleteData(`'.route('omset.destroy', $omset->id).'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                        <a href="'.route('omset.acc', $omset->id).'" class="btn btn-xs btn-success btn-flat"><i class="fa fa-check"></i></a>
                        <a href="'.route('omset.decline', $omset->id).'" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-times"></i></a>
                        </div>';
            return $button;
        })
        ->rawColumns(['aksi', 'sales', 'nominal', 'status', 'outlet', 'select_all'])
        ->make(true);
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
        $request->validate([
            'tanggal_setor' => 'required',
            'catatan' => 'sometimes',
            'nominal' => 'required',
        ]);
        $karyawan_id = auth()->user()->karyawan_id;
        $data_karyawan = karyawan::where('id',$karyawan_id)->first();

        $omset = new Omset();

        $omset->tanggal_setor = $request->tanggal_setor;
        $omset->karyawan_id = auth()->user()->id;
        $omset->catatan = $request->catatan;
        $omset->nominal = $request->nominal;
        $omset->penempatan_id = $data_karyawan->penempatan_id;
        // $omset->user_id = auth()->user()->id;

        $omset->save();

        $penempatan_nominal = Penempatan::where('id',$data_karyawan->penempatan_id)->first();

        if($request->nominal){

            $penempatan_nominal->nominal += $request->nominal;
            $penempatan_nominal->update();
        }


        return redirect()->route('omset.index');
    }

    public function accept($id)
    {
        $omset = Omset::findOrFail($id);
        $user = User::where('id',$omset->karyawan_id)->first(); //ambil user 17
        $data_karyawan = karyawan::where('id',$user->karyawan_id)->first();

        if($omset->status == 0){ //ditolak
            $data_karyawan->omset += 1;
            $data_karyawan->update();   
        }
        if($omset->status == 2){ //pending
            $data_karyawan->omset += 1;
            $data_karyawan->update();
        }else{

        }
        Omset::findOrFail($id)->update([
            'status' => 1
        ]);

        $notif = array(
            'message' => 'Data Omset Diterima',
            'alert-type' => 'success'
        );

      
       return redirect()->back()->with($notif);

    }

    public function decline($id)
    {
        $omset = Omset::findOrFail($id);
        $user = User::where('id',$omset->karyawan_id)->first(); //ambil user 17
        $data_karyawan = karyawan::where('id',$user->karyawan_id)->first();

        if($omset->status == 1){ //diterima
            $data_karyawan->omset--;
            $data_karyawan->update();   
        }
        if($omset->status == 2){ //pending
            $data_karyawan->omset--;
            $data_karyawan->update();
        }else{

        }

        Omset::findOrFail($id)->update([
            'status' => 0
        ]);

        $notif = array(
            'message' => 'Data Omset Ditolak',
            'alert-type' => 'success'
        );

      
       return redirect()->back()->with($notif);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Omset  $omset
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $omset = Omset::find($id);
        return response()->json($omset);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Omset  $omset
     * @return \Illuminate\Http\Response
     */
    public function edit(Omset $omset)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Omset  $omset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $omset = Omset::find($id);
        $omset->tanggal_setor = $request->tanggal_setor;
        $omset->karyawan_id = auth()->user()->id;
        $omset->catatan = $request->catatan;
        $omset->nominal = $request->nominal;

        $omset->update();

        return response()->json('Omset Berhasil Disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Omset  $omset
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $omset = Omset::find($id);

        $omset->delete();


    }

    public function acceptSelected(Request $request)
    {
        foreach($request->id_omset  as $id){
            $omset = Omset::find($id);

            $omset->status = 1;

            $omset->update();
        }
        return response()->json('omset berhasil diterima');
        
    }
}
