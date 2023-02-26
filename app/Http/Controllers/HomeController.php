<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\item;
use App\Models\bengkel;
use App\Models\perbaikan;
use App\Models\dataPinjam;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if($id=auth()->user()->status==1){
            $id=auth()->user()->id;
            $bengkel=bengkel::where('id_pj','=',$id)->get();
            $item=item::where('id_bengkel','=',$bengkel[0]->id)->count();

            $tunggu=perbaikan::join('items','items.id','=','perbaikans.id_barang')
                        ->select('*')
                        ->whereNull('tanggal_persetujuan')
                        ->where('items.id_bengkel','=',$bengkel[0]->id)
                        ->count();
            $perbaikan=perbaikan::join('items','items.id','=','perbaikans.id_barang')
                        ->select('*')
                        ->whereNull('tanggal_selesai')
                        ->whereNotNull('tanggal_persetujuan')
                        ->where('items.id_bengkel','=',$bengkel[0]->id)
                        ->count();
            $pinjam=dataPinjam::join('items','items.id','=','data_pinjams.id_barang')
                        ->select('*')
                        ->whereNull('tanggal_kembali')
                        ->where('items.id_bengkel','=',$bengkel[0]->id)
                        ->count();
        }else{
            $item=item::select('*')->count();
            $tunggu=perbaikan::whereNull('tanggal_persetujuan')
                            ->count();
            $perbaikan=perbaikan::whereNull('tanggal_selesai')
                            ->whereNotNull('tanggal_persetujuan')
                            ->count();
            $pinjam=dataPinjam::whereNull('tanggal_kembali')
                            ->count();
        }
        return view('dashboard.view',compact('item','tunggu','perbaikan','pinjam'));
    }
}
