<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\listPinjam;
use App\Models\dataPinjam;
use App\Models\item;
use App\Models\bengkel;
use App\Models\masuk;
use App\Models\keluar;
use Illuminate\Support\Facades\Validator;
use App\Exports\DataPinjamExport;
use App\Exports\DataPinjamSemuaExport;
use Alert;
use Excel;
use PDF;

class PinjamController extends Controller
{
    public function input(Request $request){
        $validator=Validator::make($request->all(),[
            // $this->validate($request,[
                'nama'=>'required',
            ],[
                'nama.required'=>'Nama harus diisi',
            ]);
            if ($validator->fails()) {
                Alert::toast($validator->messages()->all(), 'error');
                return back();
            }

        $nama=$request->nama;

        return redirect('/peminjaman/'.$nama);
    }
    public function index($nama){
        $data=ListPinjam::where('nama','=',$nama)->get();
        if (auth()->user()->status==1) {
            $id=auth()->user()->id;
            $bengkel=bengkel::where('id_pj','=',$id)->get();
            $data2=item::where('id_bengkel','=',$bengkel[0]->id)
                        ->where('status','=','ada')->where('kondisi','=',"baik")->get();
        } else {
            $data2=item::where('status','=','ada')->where('kondisi','=',"baik")->get();
        }
        // dd($nama);
        return view('peminjaman.input',compact('data','data2','nama'));
    }
    public function store(Request $request,$nama){
        $validator=Validator::make($request->all(),[
            // $this->validate($request,[
                'barang'=>'required',
            ],[
                'barang.required'=>'Barang harus diisi',
            ]);
            if ($validator->fails()) {
                Alert::toast($validator->messages()->all(), 'error');
                return back();
            }

        $id=$request->barang;

        $barang=item::find($id);

        listPinjam::create([
            'nama'=>$nama,
            'id_barang'=>$request->barang,
            'kode_barang'=>$barang->kode,
        ]);
        $barang->update([
            'status'=>"akan dipinjam",
        ]);
        return redirect()->back();
    }
    public function delete($id){
        // dd($nama,$id);
        $pinjam=listPinjam::find($id);
        $idb=$pinjam->id_barang;
        // dd($idb);
        $barang=item::find($idb);
        $barang->update([
            'status'=>"ada",
        ]);
        $pinjam->delete();
        return redirect()->back();
    }
    public function inputPinjam(Request $request,$nama){
        $validator=Validator::make($request->all(),[
            // $this->validate($request,[
                'lama'=>'required',
                'satuan'=>'required',
            ],[
                'lama.required'=>'Lama Peminjaman harus diisi',
            ]);
            if ($validator->fails()) {
                Alert::toast($validator->messages()->all(), 'error');
                return back();
            }
        date_default_timezone_set("Asia/Jakarta");
        $tanggal=date('Y-m-d');
        $jumlah=dataPinjam::where('tanggal_pinjam','=',$tanggal)->count();
        $huruf="PJM";
        $satuan=$request->satuan;
        $lama=$request->lama;

        $angka=++$jumlah;
        $kode=$huruf.date('dmy').sprintf('%04d',$angka);

        if ($satuan == 0) {
            $tenggat=date('Y-m-d', strtotime('+'.$lama.' days',strtotime($tanggal)));
        } else {
            $tenggat=date('Y-m-d', strtotime('+'.$lama.' month',strtotime($tanggal)));
        }

        $data=listPinjam::where('nama','=',$nama)->get();

        // dd($test);

        foreach ($data as $item) {
            $barang=item::find($item->id_barang);
            dataPinjam::create([
                'kode_peminjaman'=>$kode,
                'nama'=>$item->nama,
                'id_barang'=>$item->id_barang,
                'kode_barang'=>$item->kode_barang,
                'tanggal_pinjam'=>$tanggal,
                'tenggat'=>$tenggat,
            ]);
            keluar::create([
                'id_barang'=>$item->id_barang,
                'kode_barang'=>$item->kode_barang,
                'tanggal'=>date('Y-m-d'),
                'keterangan'=>"Dipinjam",
            ]);
            $barang->update([
                'status'=>"dipinjam",
            ]);
        }

        listPinjam::where('nama','=',$nama)->delete();
        Alert::toast('Input Data Berhasil', 'success');
        return redirect('/datapeminjaman/'.$kode);
    }

    public function cariKode(Request $request){
        $validator=Validator::make($request->all(),[
            // $this->validate($request,[
                'kode'=>'required',
            ],[
                'kode.required'=>'Kode Peminjaman harus diisi',
            ]);
            if ($validator->fails()) {
                Alert::toast($validator->messages()->all(), 'error');
                return back();
            }
        $kode=$request->kode;

        return redirect('/pengembalian/'.$kode);
    }
    public function kembaliIndex($kode){
        $nama=dataPinjam::select('nama')->where('kode_peminjaman','=',$kode)->distinct()->get();
        $data=dataPinjam::where('kode_peminjaman','=',$kode)->whereNull('tanggal_kembali')->get();
        // $data2=item::where('status','=','ada')->get();
        // dd($nama);
        return view('pengembalian.view',compact('data','kode','nama'));
    }
    public function kembali($id){
        date_default_timezone_set("Asia/Jakarta");
        $tanggal=date('Y-m-d');
        $pinjam=dataPinjam::find($id);
        $idb=$pinjam->id_barang;
        // dd($idb);
        $barang=item::find($idb);
        $barang->update([
            'status'=>"ada",
        ]);
        masuk::create([
            'id_barang'=>$pinjam->id_barang,
            'kode_barang'=>$pinjam->kode_barang,
            'tanggal'=>date('Y-m-d'),
            'keterangan'=>"Dikembalikan",
        ]);
        $pinjam->update([
            'tanggal_kembali'=>$tanggal,
        ]);
        return redirect()->back();
    }

    public function dataIndex(){
        if (auth()->user()->status==1) {
            $id=auth()->user()->id;
            $bengkel=bengkel::where('id_pj','=',$id)->get();
            $data=dataPinjam::join('items','items.id','=','data_pinjams.id_barang')
                            ->select('kode_peminjaman','data_pinjams.nama','tanggal_pinjam','tenggat','tanggal_kembali')
                            ->where('id_bengkel','=',$bengkel[0]->id)
                            ->orderBy('tanggal_pinjam','desc')
                            ->distinct()->get();
                            // dd($data);
        } else {
            $data=dataPinjam::select('kode_peminjaman','data_pinjams.nama','tanggal_pinjam','tenggat','tanggal_kembali')
                            ->orderBy('tanggal_pinjam','desc')
                            ->distinct()->get();
        }
        
        // dd($data);
        return view('dataPeminjaman.view',compact('data'));
    }
    public function dataDetail($kode){
        if (auth()->user()->status==1) {
            $id=auth()->user()->id;
            $bengkel=bengkel::where('id_pj','=',$id)->get();
            $data=dataPinjam::join('items','items.id','=','data_pinjams.id_barang')
                            ->select('kode_barang','id_barang')
                            ->where('id_bengkel','=',$bengkel[0]->id)
                            ->where('kode_peminjaman','=',$kode)->get();
        } else {
            $data=dataPinjam::where('kode_peminjaman','=',$kode)->get();
        }
        
        $nama=dataPinjam::select('nama','kode_peminjaman')->where('kode_peminjaman','=',$kode)->distinct()->get();
        // dd($nama);
        return view('dataPeminjaman.detail',compact('nama','data'));
    }
    public function exportPDFdetail($kode){
        if (auth()->user()->status==1) {
            $id=auth()->user()->id;
            $bengkel=bengkel::where('id_pj','=',$id)->get();
            $data=dataPinjam::join('items','items.id','=','data_pinjams.id_barang')
                            ->select('kode_barang','id_barang')
                            ->where('id_bengkel','=',$bengkel[0]->id)
                            ->where('kode_peminjaman','=',$kode)->get();
        } else {
            $data=dataPinjam::where('kode_peminjaman','=',$kode)->get();
        }
        
        $nama=dataPinjam::select('nama','kode_peminjaman','tanggal_pinjam','tenggat')->where('kode_peminjaman','=',$kode)->distinct()->get();
        // dd($nama);
        // return view('pdf.detailpeminjaman',compact('nama','data'));
        $pdf = \PDF::loadview('pdf.detailpeminjaman',compact('nama','data'))->setPaper('a4', 'portrait');
        return $pdf->download('Detail_Peminjaman_'.$kode.'.pdf');
    }

    public function exportExcel(Request $request){
        // dd($request->awal,$request->akhir);
        $awal=$request->awal;
        $akhir=$request->akhir;
        
        if ($awal==""||$akhir=="") {
            $excel=Excel::download(new DataPinjamSemuaExport, 'Laporan_Peminjaman.xlsx');
        } else {
            $excel=Excel::download(new DataPinjamExport($awal,$akhir), 'Laporan_Peminjaman_'.$awal.'_'.$akhir.'.xlsx');
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
            $nama='Laporan_Peminjaman';
            if ($awal==""||$akhir=="") {
                $tanggal='.pdf';
            $data=dataPinjam::join('items','items.id','=','data_pinjams.id_barang')
            ->select('kode_peminjaman','data_pinjams.nama','tanggal_pinjam','tenggat','tanggal_kembali')
            ->where('id_bengkel','=',$bengkel[0]->id)
            ->orderBy('tanggal_pinjam','desc')
            ->distinct()->get();
            } else {
                $tanggal='_'.$awal.'_'.$akhir.'.pdf';
                $data=dataPinjam::join('items','items.id','=','data_pinjams.id_barang')
                ->select('kode_peminjaman','data_pinjams.nama','tanggal_pinjam','tenggat','tanggal_kembali')
                ->where('id_bengkel','=',$bengkel[0]->id)
                ->whereBetween('tanggal_pinjam', [$awal, $akhir])
                ->orderBy('tanggal_pinjam','desc')
                ->distinct()->get();
            }
        } else {
            $nama='Laporan_Peminjaman';
            if ($awal==""||$akhir=="") {
                $tanggal='.pdf';
            $data=dataPinjam::join('items','items.id','=','data_pinjams.id_barang')
            ->select('kode_peminjaman','data_pinjams.nama','tanggal_pinjam','tenggat','tanggal_kembali')
            ->orderBy('tanggal_pinjam','desc')
            ->distinct()->get();
            } else {
                $tanggal='_'.$awal.'_'.$akhir.'.pdf';
                $data=dataPinjam::join('items','items.id','=','data_pinjams.id_barang')
                ->select('kode_peminjaman','data_pinjams.nama','tanggal_pinjam','tenggat','tanggal_kembali')
                ->whereBetween('tanggal_pinjam', [$awal, $akhir])
                ->orderBy('tanggal_pinjam','desc')
                ->distinct()->get();
            }
        }

        // if ($data==0) {
        //     $nama='Laporan_Peminjaman_Semua';
        // }elseif ($data==1) {
        //     $nama='Laporan_Peminjaman_Belum_Kembali';
        // } else {
        //     $nama='Laporan_Peminjaman_Sudah_kembali';
        // }
        // if ($awal==""||$akhir=="") {
        //     $tanggal='.pdf';
        // } else {
        //     $tanggal='_'.$awal.'_'.$akhir.'.pdf';
        // }

        $pdf = \PDF::loadview('pdf.datapeminjaman',compact('data','awal','akhir','nama'))->setPaper('a4', 'landscape');
        return $pdf->download($nama.$tanggal);
    }
}
