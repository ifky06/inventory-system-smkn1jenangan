<?php

namespace App\Http\Controllers;

use App\Models\keluar;
use App\Models\masuk;
use App\Models\bengkel;
use Illuminate\Http\Request;
use App\Exports\KeluarExport;
use App\Exports\KeluarSemuaExport;
use App\Exports\MasukExport;
use App\Exports\MasukSemuaExport;
use Excel;
use PDF;

class KeluarMasukController extends Controller
{
    public function masuk()
    {
        if (auth()->user()->status==1) {
            $id=auth()->user()->id;
            $bengkel=bengkel::where('id_pj','=',$id)->get();
            $data=masuk::join('items','items.id','=','masuks.id_barang')
                            ->select('kode_barang','id_barang','tanggal','keterangan')
                            ->where('id_bengkel','=',$bengkel[0]->id)
                            ->orderBy('tanggal','desc')->get();
        } else {
            $data=masuk::select('*')->orderBy('tanggal','desc')->get();
        }
        return view('masuk.view',compact('data'));
    }
    public function exportExcelMasuk(Request $request){
        // dd($request->awal,$request->akhir);
        $awal=$request->awal;
        $akhir=$request->akhir;
        if ($awal==""||$akhir=="") {
            $excel=Excel::download(new MasukSemuaExport, 'Laporan_Barang_Masuk.xlsx');
        } else {
            $excel=Excel::download(new MasukExport($awal,$akhir), 'Laporan_Barang_Masuk_'.$awal.'_'.$akhir.'.xlsx');
        }
        return $excel;
    }
    public function exportPDFmasuk(Request $request){
        // dd($request->awal,$request->akhir);
        $awal=$request->awal;
        $akhir=$request->akhir;
        if ($awal==""||$akhir=="") {
            $nama='Laporan_Barang_Masuk.pdf';
            if (auth()->user()->status==1) {
                $id=auth()->user()->id;
                $bengkel=bengkel::where('id_pj','=',$id)->get();
                $data=masuk::join('items','items.id','=','masuks.id_barang')
                            ->select('kode_barang','items.nama','tanggal','keterangan')
                            ->where('id_bengkel','=',$bengkel[0]->id)
                            ->orderBy('tanggal','desc')->get();
            } else {
                $data=masuk::join('items','items.id','=','masuks.id_barang')
                            ->select('kode_barang','items.nama','tanggal','keterangan')
                            ->orderBy('tanggal','desc')->get();
            }
        } else {
            $nama='Laporan_Barang_Masuk_'.$awal.'_'.$akhir.'.pdf';
            if (auth()->user()->status==1) {
                $id=auth()->user()->id;
                $bengkel=bengkel::where('id_pj','=',$id)->get();
                $data=masuk::join('items','items.id','=','masuks.id_barang')
                            ->select('kode_barang','items.nama','tanggal','keterangan')
                            ->where('id_bengkel','=',$bengkel[0]->id)
                            ->whereBetween('tanggal', [$awal, $akhir])
                            ->orderBy('tanggal','desc')->get();
            } else {
                $data=masuk::join('items','items.id','=','masuks.id_barang')
                            ->select('kode_barang','items.nama','tanggal','keterangan')
                            ->whereBetween('tanggal', [$awal, $akhir])
                            ->orderBy('tanggal','desc')->get();
            }
        }
        set_time_limit(600);
        $pdf = \PDF::loadview('pdf.masuk',compact('data','awal','akhir'))->setPaper('a4', 'portrait');
        return $pdf->download($nama);
    }





    public function keluar()
    {
        if (auth()->user()->status==1) {
            $id=auth()->user()->id;
            $bengkel=bengkel::where('id_pj','=',$id)->get();
            $data=keluar::join('items','items.id','=','keluars.id_barang')
                            ->select('kode_barang','id_barang','tanggal','keterangan')
                            ->where('id_bengkel','=',$bengkel[0]->id)
                            ->orderBy('tanggal','desc')->get();
        } else {
            $data=keluar::select('*')->orderBy('tanggal','desc')->get();
        }
        return view('keluar.view',compact('data'));
    }
    public function exportExcelKeluar(Request $request){
        // dd($request->awal,$request->akhir);
        $awal=$request->awal;
        $akhir=$request->akhir;
        if ($awal==""||$akhir=="") {
            $excel=Excel::download(new KeluarSemuaExport, 'Laporan_Barang_Keluar.xlsx');
        } else {
            $excel=Excel::download(new KeluarExport($awal,$akhir), 'Laporan_Barang_Keluar_'.$awal.'_'.$akhir.'.xlsx');
        }
        return $excel;
    }
    public function exportPDFKeluar(Request $request){
        // dd($request->awal,$request->akhir);
        $awal=$request->awal;
        $akhir=$request->akhir;
        if ($awal==""||$akhir=="") {
            $nama='Laporan_Barang_Keluar.pdf';
            if (auth()->user()->status==1) {
                $id=auth()->user()->id;
                $bengkel=bengkel::where('id_pj','=',$id)->get();
                $data=keluar::join('items','items.id','=','keluars.id_barang')
                            ->select('kode_barang','items.nama','tanggal','keterangan')
                            ->where('id_bengkel','=',$bengkel[0]->id)
                            ->orderBy('tanggal','desc')->get();
            } else {
                $data=keluar::join('items','items.id','=','keluars.id_barang')
                            ->select('kode_barang','items.nama','tanggal','keterangan')
                            ->orderBy('tanggal','desc')->get();
            }
        } else {
            $nama='Laporan_Barang_Keluar_'.$awal.'_'.$akhir.'.pdf';
            if (auth()->user()->status==1) {
                $id=auth()->user()->id;
                $bengkel=bengkel::where('id_pj','=',$id)->get();
                $data=keluar::join('items','items.id','=','keluars.id_barang')
                            ->select('kode_barang','items.nama','tanggal','keterangan')
                            ->where('id_bengkel','=',$bengkel[0]->id)
                            ->whereBetween('tanggal', [$awal, $akhir])
                            ->orderBy('tanggal','desc')->get();
            } else {
                $data=keluar::join('items','items.id','=','keluars.id_barang')
                            ->select('kode_barang','items.nama','tanggal','keterangan')
                            ->whereBetween('tanggal', [$awal, $akhir])
                            ->orderBy('tanggal','desc')->get();
            }
        }
        memory_limit(2000);
        set_time_limit(600);
        $pdf = \PDF::loadview('pdf.keluar',compact('data','awal','akhir'))->setPaper('a4', 'portrait');
        return $pdf->download($nama);
    }
}
