<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\bengkel;
use App\Models\item;
use App\Models\fund;
use App\Models\rusak;
use App\Models\masuk;
use App\Models\keluar;
use App\Models\perbaikan;
use Illuminate\Support\Facades\Validator;
use App\Exports\DataPerbaikanExport;
use App\Exports\DataPerbaikanSemuaExport;
use Alert;
use Excel;
use PDF;

class RusakController extends Controller
{
    public function index()
    {
        $id=auth()->user()->id;
        $bengkel=bengkel::where('id_pj','=',$id)->get();
        // $data=rusak::where('id_bengkel','=',$bengkel[0]->id)
        //             ->where('kondisi','=',"baik")
        //             ->orderBy('tanggal_cek','asc')->get();
        // dd($bengkel[0]->id);
        $data=rusak::join('items','items.id','=','rusaks.id_barang')
                    ->select('*','rusaks.status as rs','rusaks.id as rid')
                    ->where('rusaks.status','=',"Menunggu Perbaikan")
                    ->where('items.id_bengkel','=',$bengkel[0]->id)->get();
        $data2=fund::all();
        return view('rusak.view',compact('data','data2'));
    }
    public function store(Request $request,$id){
        $validator=Validator::make($request->all(),[
            // $this->validate($request,[
                'sd'=>'required',
            ],[
                'sd.required'=>'Sumber Dana harus diisi',
            ]);
            if ($validator->fails()) {
                Alert::toast($validator->messages()->all(), 'error');
                return back();
            }
        $data=rusak::find($id);
        $jumlah=perbaikan::select('*')->count();
        $angka=++$jumlah;
        $huruf="PBK";
        $kode=$huruf.sprintf('%04d',$angka);

        // dd($data);

        perbaikan::create([
            'kode_perbaikan'=>$kode,
            'id_rusak'=>$data->id,
            'id_barang'=>$data->id_barang,
            'kode_barang'=>$data->kode_barang,
            'id_fund'=>$request->sd,
            'tanggal_pengajuan'=>date('Y-m-d'),
        ]);
        $data->update([
            'status'=>"Menunggu Persetujuan"
        ]);
        Alert::toast('Pengajuan Perbaikan Berhasil', 'success');
        return back();
    }
    public function storeAll(Request $request,$id){
        $validator=Validator::make($request->all(),[
            // $this->validate($request,[
                'sd'=>'required',
            ],[
                'sd.required'=>'Sumber Dana harus diisi',
            ]);
            if ($validator->fails()) {
                Alert::toast($validator->messages()->all(), 'error');
                return back();
            }
        $item=rusak::join('items','items.id','=','rusaks.id_barang')
                    ->select('*','rusaks.status as rs')
                    ->where('rusaks.status','=',"Menunggu Perbaikan")
                    ->where('items.id_bengkel','=',$bengkel[0]->id)->get();
        foreach ($item as $data) {
            $jumlah=perbaikan::select('*')->count();
            $angka=++$jumlah;
            $huruf="PBK";
            $kode=$huruf.sprintf('%04d',$angka);
    
            perbaikan::create([
                'kode_perbaikan'=>$kode,
                'id_rusak'=>$data->id,
                'id_barang'=>$data->id_barang,
                'kode_barang'=>$data->kode_barang,
                'id_fund'=>$request->sd,
                'tanggal_pengajuan'=>date('Y-m-d'),
            ]);
            $data->update([
                'status'=>"Menunggu Persetujuan"
            ]);
        }
        Alert::toast('Pengajuan Perbaikan Berhasil', 'success');
        return back();
    }
    public function tunggu(){
        if (auth()->user()->status==1) {
            $id=auth()->user()->id;
            $bengkel=bengkel::where('id_pj','=',$id)->get();
            $data=perbaikan::join('items','items.id','=','perbaikans.id_barang')
                        ->select('*','perbaikans.id as pid')
                        ->whereNull('tanggal_persetujuan')
                        ->where('items.id_bengkel','=',$bengkel[0]->id)
                        ->orderBy('tanggal_pengajuan','asc')->get();
        } else {
            $data=perbaikan::whereNull('tanggal_persetujuan')
                        ->orderBy('tanggal_pengajuan','asc')
                        ->get();
        }
        return view('perbaikan_tunggu.view',compact('data'));
    }
    public function detail($id){
        $data=perbaikan::find($id);
        
        return view('perbaikan_tunggu.detail',compact('data'));
    }
    public function setuju($id){
        $data=perbaikan::find($id);
        $rusak=rusak::find($data->id_rusak);
        $item=item::find($data->id_barang);

        $data->update([
            'tanggal_persetujuan'=>date('Y-m-d'),
        ]);
        $rusak->update([
            'status'=>"Sedang Diperbaiki"
        ]);
        $item->update([
            'status'=>"Sedang Diperbaiki"
        ]);
        keluar::create([
            'id_barang'=>$data->id_barang,
            'kode_barang'=>$data->kode_barang,
            'tanggal'=>date('Y-m-d'),
            'keterangan'=>"Sedang Diperbaiki",
        ]);

        Alert::toast('Pengajuan Perbaikan Telah Disetujui', 'success');
        return redirect('/perbaikan');
    }
    public function diperbaiki(){
        if (auth()->user()->status==1) {
            $id=auth()->user()->id;
            $bengkel=bengkel::where('id_pj','=',$id)->get();
            $data=perbaikan::join('items','items.id','=','perbaikans.id_barang')
                        ->select('*','perbaikans.id as pid')
                        ->whereNull('tanggal_selesai')
                        ->whereNotNull('tanggal_persetujuan')
                        ->where('items.id_bengkel','=',$bengkel[0]->id)
                        ->orderBy('tanggal_pengajuan','asc')->get();
        } else {
            $data=perbaikan::whereNull('tanggal_selesai')
                        ->whereNotNull('tanggal_persetujuan')
                        ->orderBy('tanggal_pengajuan','asc')
                        ->get();
        }
        return view('perbaikan_diperbaiki.view',compact('data'));
    }
    public function detail2($id){
        $data=perbaikan::find($id);
        
        return view('perbaikan_diperbaiki.detail',compact('data'));
    }
    public function selesai($id){
        $data=perbaikan::find($id);
        $rusak=rusak::find($data->id_rusak);
        $item=item::find($data->id_barang);

        $data->update([
            'tanggal_selesai'=>date('Y-m-d'),
        ]);
        $rusak->update([
            'status'=>"Sudah Diperbaiki"
        ]);
        $item->update([
            'status'=>"ada",
            'kondisi'=>"baik",
        ]);

        keluar::create([
            'id_barang'=>$data->id_barang,
            'kode_barang'=>$data->kode_barang,
            'tanggal'=>date('Y-m-d'),
            'keterangan'=>"Selesai Diperbaiki",
        ]);

        Alert::toast('Perbaikan Telah Selesai', 'success');
        return redirect('/diperbaiki');
    }
    public function dataIndex(){
        if (auth()->user()->status==1) {
            $id=auth()->user()->id;
            $bengkel=bengkel::where('id_pj','=',$id)->get();
            $data=perbaikan::join('items','items.id','=','perbaikans.id_barang')
                        ->select('*','perbaikans.id as pid')
                        ->where('items.id_bengkel','=',$bengkel[0]->id)
                        ->orderBy('tanggal_selesai','asc')
                        ->orderBy('tanggal_persetujuan','asc')
                        ->orderBy('tanggal_pengajuan','asc')
                        ->get();
        } else {
            $data=perbaikan::select('*')
                        ->orderBy('tanggal_selesai','asc')
                        ->orderBy('tanggal_persetujuan','asc')
                        ->orderBy('tanggal_pengajuan','asc')
                        ->get();
        }
        return view('data_perbaikan.view',compact('data'));
    }
    public function detail3($id){
        $data=perbaikan::find($id);
        
        return view('data_perbaikan.detail',compact('data'));
    }
    public function exportPDFdetail($id){
        $data=perbaikan::find($id);
        
        $pdf = \PDF::loadview('pdf.detailperbaikan',compact('data'))->setPaper('a4', 'potrait');
        return $pdf->download('Detail_Perbaikan_'.$data->kode_perbaikan.'.pdf');
        // return view('pdf.detailperbaikan',compact('data'));
    }
    public function exportExcel(Request $request){
        $awal=$request->awal;
        $akhir=$request->akhir;
        // return Excel::download(new DataPeminjamanExport($awal,$akhir), 'Laporan_Perbaikan_Barang_'.date('d_m_Y').'.xlsx');
        if ($awal==""||$akhir=="") {
            $excel=Excel::download(new DataPerbaikanSemuaExport, 'Laporan_Perbaikan_Barang_'.date('d_m_Y').'.xlsx');
        } else {
            $excel=Excel::download(new DataPerbaikanExport($awal,$akhir), 'Laporan_Perbaikan_Barang_'.$awal.'_'.$akhir.'.xlsx');
        }
        return $excel;
    }
    
    public function exportPDF(Request $request){
        // dd($request->awal,$request->akhir);
        $awal=$request->awal;
        $akhir=$request->akhir;
        if (auth()->user()->status==1) {
            $id=auth()->user()->id;
            $bengkel=bengkel::where('id_pj','=',$id)->get();
            $nama='Laporan_Perbaikan';
            if ($awal==""||$akhir=="") {
                $tanggal='.pdf';
                $data=perbaikan::join('items','items.id','=','perbaikans.id_barang')
                ->join('funds','funds.id','=','perbaikans.id_fund')
                ->join('rusaks','rusaks.id','=','perbaikans.id_rusak')
                ->select('kode_perbaikan','perbaikans.kode_barang as kb','items.nama as nb','detail','funds.nama as sd','tanggal_pengajuan','tanggal_persetujuan','tanggal_selesai')
                ->where('items.id_bengkel','=',$bengkel[0]->id)
                ->orderBy('tanggal_pengajuan','desc')
                ->get();
            } else {
                $tanggal='_'.$awal.'_'.$akhir.'.pdf';
                $data=perbaikan::join('items','items.id','=','perbaikans.id_barang')
                ->join('funds','funds.id','=','perbaikans.id_fund')
                ->join('rusaks','rusaks.id','=','perbaikans.id_rusak')
                ->select('kode_perbaikan','perbaikans.kode_barang as kb','items.nama as nb','detail','funds.nama as sd','tanggal_pengajuan','tanggal_persetujuan','tanggal_selesai')
                ->where('items.id_bengkel','=',$bengkel[0]->id)
                ->whereBetween('tanggal_pengajuan', [$awal, $akhir])
                ->orderBy('tanggal_pengajuan','desc')
                ->get();
            }
        } else {
            $nama='Laporan_Perbaikan';
            if ($awal==""||$akhir=="") {
                $tanggal='.pdf';
                $data=perbaikan::join('items','items.id','=','perbaikans.id_barang')
                ->join('funds','funds.id','=','perbaikans.id_fund')
                ->join('rusaks','rusaks.id','=','perbaikans.id_rusak')
                ->select('kode_perbaikan','perbaikans.kode_barang as kb','items.nama as nb','detail','funds.nama as sd','tanggal_pengajuan','tanggal_persetujuan','tanggal_selesai')
                ->orderBy('tanggal_pengajuan','desc')
                ->get();
            } else {
                $tanggal='_'.$awal.'_'.$akhir.'.pdf';
                $data=perbaikan::join('items','items.id','=','perbaikans.id_barang')
                ->join('funds','funds.id','=','perbaikans.id_fund')
                ->join('rusaks','rusaks.id','=','perbaikans.id_rusak')
                ->select('kode_perbaikan','perbaikans.kode_barang as kb','items.nama as nb','detail','funds.nama as sd','tanggal_pengajuan','tanggal_persetujuan','tanggal_selesai')
                        ->whereBetween('tanggal_pengajuan', [$awal, $akhir])
                        ->orderBy('tanggal_pengajuan','desc')
                        ->get();
            }
        }

        $pdf = \PDF::loadview('pdf.dataperbaikan',compact('data','awal','akhir'))->setPaper('hvs', 'landscape');
        return $pdf->download($nama.$tanggal);
    }
}
