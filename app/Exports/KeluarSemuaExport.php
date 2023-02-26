<?php

namespace App\Exports;

use App\Models\keluar;
use App\Models\bengkel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KeluarSemuaExport implements FromQuery, WithHeadings
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
            $data=keluar::query()->join('items','items.id','=','keluars.id_barang')
                        ->select('kode_barang','items.nama','tanggal','keterangan')
                        ->where('id_bengkel','=',$bengkel[0]->id)
                        ->orderBy('tanggal','desc');
        } else {
            $data=keluar::query()->join('items','items.id','=','keluars.id_barang')
                        ->select('kode_barang','items.nama','tanggal','keterangan')
                        ->orderBy('tanggal','desc');
        }
        
        return $data;
    }
    public function headings(): array
    {
        return [
            'Kode Barang',
            'Nama Barang',
            'Tanggal',
            'Keterangan',
        ];
    }
}
