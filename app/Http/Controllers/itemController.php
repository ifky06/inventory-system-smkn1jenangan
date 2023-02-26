<?php

namespace App\Http\Controllers;

use App\Models\item;
use App\Models\bengkel;
use App\Models\fund;
use App\Models\keluar;
use App\Models\masuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Exports\ItemExport;
use App\Exports\ItemExportBengkel;
use Excel;
use PDF;
use Alert;

class itemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->status == 1) {
            $id=auth()->user()->id;
            $bengkel=bengkel::where('id_pj','=',$id)->get();
            $data=item::where('id_bengkel','=',$bengkel[0]->id)->get();
            // $data=item::join('bengkels','bengkels.id','=','items.id_bengkel')
            $data2=bengkel::all();
            $data3=fund::all();
            // dd($bengkel[0]->id);
        } else {
            $data=bengkel::all();
            $data2=bengkel::all();
            $data3=fund::all();
        }
        return view('barang.view',compact('data','data2','data3'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        $data=item::where('id_bengkel','=',$id)->get();
        $data2=bengkel::all();
        $data3=fund::all();
        $data4=bengkel::select('bengkel','id')->where('id','=',$id)->get();
        return view('barang.detail',compact('data','data2','data3','data4'));
    }
    public function detailBarang($id)
    {
        $data=item::find($id);
        return view('barang.detail_barang',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (auth()->user()->status == 1) {
            $validator=Validator::make($request->all(),[
                'nama'=>'required',
                'sumber_dana'=>'required',
                'gambar'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],[
                'nama.required'=>'Nama tidak boleh kosong',
                'bengkel.required'=>'Bengkel Tidak boleh kosong',
                'sumber_dana.required'=>'Sumber Dana Tidak boleh kosong',
                'gambar.max'=>'Gambar Melebihi 2 Mb',
            ]);
        }else {
                $validator=Validator::make($request->all(),[
                    'nama'=>'required',
                    'bengkel'=>'required',
                    'sumber_dana'=>'required',
                    'gambar'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ],[
                    'nama.required'=>'Nama tidak boleh kosong',
                    'bengkel.required'=>'Bengkel Tidak boleh kosong',
                    'sumber_dana.required'=>'Sumber Dana Tidak boleh kosong',
                    'gambar.max'=>'Gambar Melebihi 2 Mb',
                ]);
            # code...
        }
        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back();
        }

        date_default_timezone_set("Asia/Jakarta");
        $kode=date('dmyHis');
        $tanggal=date('Y-m-d');
        // dd($kode);

        if ($request->gambar=="") {
            $image_name="barang.png";
        } else {
            $image_name=date('dmy').time().'.'.$request->gambar->extension();

            $request->gambar->move(public_path('images/barang'),$image_name);
        }

        if (auth()->user()->status == 1) {
            $id=auth()->user()->id;
            $bengkel=bengkel::where('id_pj','=',$id)->get();
            item::create([
                'kode'=>$kode,
                'nama'=>$request->nama,
                'id_bengkel'=>$bengkel[0]->id,
                'id_fund'=>$request->sumber_dana,
                'kondisi'=>"baik",
                'tanggal_cek'=>date('Y-m-d'),
                'status'=>"ada",
                'gambar'=>$image_name,
            ]);
        } else {
            item::create([
                'kode'=>$kode,
                'nama'=>$request->nama,
                'id_bengkel'=>$request->bengkel,
                'id_fund'=>$request->sumber_dana,
                'kondisi'=>"baik",
                'tanggal_cek'=>date('Y-m-d'),
                'status'=>"ada",
                'gambar'=>$image_name,
            ]);
        }
        $barang=item::where('kode','=',$kode)->get();
        masuk::create([
            'id_barang'=>$barang[0]->id,
            'kode_barang'=>$kode,
            'tanggal'=>$tanggal,
            'keterangan'=>"Barang Baru",
        ]);
        Alert::toast('Tambah Barang Berhasil', 'success');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (auth()->user()->status == 1) {
            $validator=Validator::make($request->all(),[
                'nama'=>'required',
                'sumber_dana'=>'required',
                'gambar'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],[
                'nama.required'=>'Nama tidak boleh kosong',
                'bengkel.required'=>'Bengkel Tidak boleh kosong',
                'sumber_dana.required'=>'Sumber Dana Tidak boleh kosong',
                'gambar.max'=>'Gambar Melebihi 2 Mb',
            ]);
        } else {
            $validator=Validator::make($request->all(),[
                'nama'=>'required',
                'bengkel'=>'required',
                'sumber_dana'=>'required',
                'gambar'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],[
                'nama.required'=>'Nama tidak boleh kosong',
                'bengkel.required'=>'Bengkel Tidak boleh kosong',
                'sumber_dana.required'=>'Sumber Dana Tidak boleh kosong',
                'gambar.max'=>'Gambar Melebihi 2 Mb',
            ]);
        }
        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back();
        }

        $data=item::find($id);

        if ($request->gambar=="") {
            if (auth()->user()->status == 1) {
                $data->update([
                    'nama'=>$request->nama,
                    'id_fund'=>$request->sumber_dana,
                ]);
            } else {
                $data->update([
                    'nama'=>$request->nama,
                    'id_bengkel'=>$request->bengkel,
                    'id_fund'=>$request->sumber_dana,
                ]);
            }
            
        }else {
            if ($data->gambar!="barang.png") {
                File::delete('images/barang/'.$data->gambar);
            }

            date_default_timezone_set("Asia/Jakarta");
            $image_name=date('dmy').time().'.'.$request->gambar->extension();

            $request->gambar->move(public_path('images/barang'),$image_name);
            if (auth()->user()->status == 1) {
                $data->update([
                    'nama'=>$request->nama,
                    'id_fund'=>$request->sumber_dana,
                    'gambar'=>$image_name,
                ]);
            } else {
                $data->update([
                    'nama'=>$request->nama,
                    'id_bengkel'=>$request->bengkel,
                    'id_fund'=>$request->sumber_dana,
                    'gambar'=>$image_name,
                ]);
            }
            
        }
        Alert::toast('Edit Barang Berhasil', 'success');
        return redirect()->back();
    }
    public function exportExcel(){
        return Excel::download(new ItemExport, 'Laporan_Data_Barang_'.date('d_m_Y').'.xlsx');
    }
    public function exportExcelBarang($id){
        $bengkel=bengkel::find($id);
        return Excel::download(new ItemExportBengkel($id), 'Laporan_Data_Barang_'.$bengkel->bengkel.'_'.date('d_m_Y').'.xlsx');
    }
    public function exportPDFdetailbarang($id){
        $data=item::find($id);
        
        $pdf = \PDF::loadview('pdf.detailbarang',compact('data'))->setPaper('a4', 'potrait');
        return $pdf->download('Detail_Barang_'.$data->kode.'.pdf');
    }
    public function exportPDF()
    {
        if (auth()->user()->status == 1) {
            $id=auth()->user()->id;
            $bengkel=bengkel::where('id_pj','=',$id)->get();
            $data=item::where('id_bengkel','=',$bengkel[0]->id)->get();
            // $data=item::join('bengkels','bengkels.id','=','items.id_bengkel')
            // dd($bengkel[0]->id);
        } else {
            $data=item::select('*')
                        ->orderBy('id_bengkel','asc')->get();
        }
        // set_time_limit(600);
        $pdf = \PDF::loadview('pdf.barang',compact('data'))->setPaper('a4', 'landscape');
        return $pdf->download('Laporan_Data_Barang_'.date('d_m_Y').'.pdf');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // public function exportExcel(){
        // $pp=item::join('bengkels','bengkels.id','=','items.id_bengkel')
        // ->join('funds','funds.id','=','items.id_fund')
        // ->select('kode','items.nama','bengkel','funds.nama','tanggal_cek','kondisi','status')
        // ->orderBy('id_bengkel','asc')
        // ->orderBy('id_fund','asc')->get();
        // dd($pp);
        // Alert::toast('Export Data Berhasil', 'success');
        // return Excel::download(new ItemExport, 'Laporan_Data_Barang_'.date('d-m-Y').'.xlsx');
        // return redirect('/barang');
    // }
}
