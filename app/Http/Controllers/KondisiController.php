<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\item;
use App\Models\bengkel;
use App\Models\rusak;
use Illuminate\Support\Facades\Validator;
use Alert;

class KondisiController extends Controller
{
    public function index()
    {
        $id=auth()->user()->id;
        $bengkel=bengkel::where('id_pj','=',$id)->get();
        $data=item::where('id_bengkel','=',$bengkel[0]->id)
                    ->where('kondisi','=',"baik")
                    ->orderBy('tanggal_cek','asc')->get();
        // dd($bengkel[0]->id);
        return view('kondisi.view',compact('data'));
    }
    public function baik($id){
        $data=item::find($id);
        $data->update([
            'kondisi'=>"baik",
            'tanggal_cek'=>date('Y-m-d'),
        ]);
        return back();
    }
    public function rusak(Request $request,$id){
        $validator=Validator::make($request->all(),[
            // $this->validate($request,[
                'detail'=>'required',
            ],[
                'detail.required'=>'Detail kerusakan harus diisi',
            ]);
            if ($validator->fails()) {
                Alert::toast($validator->messages()->all(), 'error');
                return back();
            }
        $data=item::find($id);
        $data->update([
            'kondisi'=>"rusak",
            'tanggal_cek'=>date('Y-m-d'),
        ]);
        rusak::create([
            'id_barang'=>$id,
            'kode_barang'=>$data->kode,
            'detail'=>$request->detail,
            'status'=>"Menunggu Perbaikan",
        ]);
        return back();
    }
}
