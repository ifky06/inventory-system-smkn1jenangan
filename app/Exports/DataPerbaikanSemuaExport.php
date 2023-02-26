<?php

namespace App\Exports;

use App\Models\perbaikan;
use App\Models\bengkel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DataPerbaikanSemuaExport implements FromCollection, WithHeadings
{
use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        if (auth()->user()->status == 1) {
            $id=auth()->user()->id;
            $bengkel=bengkel::where('id_pj','=',$id)->get();
            $data=perbaikan::join('items','items.id','=','perbaikans.id_barang')
                ->join('funds','funds.id','=','perbaikans.id_fund')
                ->join('rusaks','rusaks.id','=','perbaikans.id_rusak')
                ->select('kode_perbaikan','perbaikans.kode_barang as kb','items.nama as nb','detail','funds.nama as sd','tanggal_pengajuan','tanggal_persetujuan','tanggal_selesai')
                ->where('items.id_bengkel','=',$bengkel[0]->id)
                ->orderBy('tanggal_pengajuan','desc')
                ->get();
        } else {
            $data=perbaikan::join('items','items.id','=','perbaikans.id_barang')
                ->join('funds','funds.id','=','perbaikans.id_fund')
                ->join('rusaks','rusaks.id','=','perbaikans.id_rusak')
                ->select('kode_perbaikan','perbaikans.kode_barang as kb','items.nama as nb','detail','funds.nama as sd','tanggal_pengajuan','tanggal_persetujuan','tanggal_selesai')
                ->orderBy('tanggal_pengajuan','desc')
                ->get();
        }
        return $data;
    }
    public function headings(): array
    {
        return [
            'Kode Perbaikan',
            'Kode Barang',
            'Nama Barang',
            'Detail Kerusakan',
            'Sumber Dana Perbaikan',
            'Tanggal Pengajuan',
            'Tanggal Disetujui',
            'Tanggal Selesai',
        ];
    }
}
