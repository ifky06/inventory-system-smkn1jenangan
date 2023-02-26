<?php

namespace App\Exports;

use App\Models\dataPinjam;
use App\Models\bengkel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DataPinjamSemuaExport implements FromQuery, WithHeadings
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        if (auth()->user()->status==1) {
            $id=auth()->user()->id;
            $bengkel=bengkel::where('id_pj','=',$id)->get();
            $data=dataPinjam::query()->join('items','items.id','=','data_pinjams.id_barang')
            ->select('kode_peminjaman','data_pinjams.nama','tanggal_pinjam','tenggat','tanggal_kembali')
            ->where('id_bengkel','=',$bengkel[0]->id)
            ->orderBy('tanggal_pinjam','desc')
            ->distinct();
        } else {
            $data=dataPinjam::query()->join('items','items.id','=','data_pinjams.id_barang')
            ->select('kode_peminjaman','data_pinjams.nama','tanggal_pinjam','tenggat','tanggal_kembali')
            ->orderBy('tanggal_pinjam','desc')
            ->distinct();
        }
        return $data;
    }
    public function headings(): array
    {
        return [
            'Kode Peminjaman',
            'Nama Peminjam',
            'Tanggal Peminjaman',
            'Batas Pengembalian',
            'Tanggal Pengembalian',
        ];
    }
}
