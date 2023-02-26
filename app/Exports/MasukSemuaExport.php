<?php

namespace App\Exports;

use App\Models\masuk;
use App\Models\bengkel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MasukSemuaExport implements FromQuery, WithHeadings
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
            $data=masuk::query()->join('items','items.id','=','masuks.id_barang')
                        ->select('kode_barang','items.nama','tanggal','keterangan')
                        ->where('id_bengkel','=',$bengkel[0]->id)
                        ->orderBy('tanggal','desc');
        } else {
            $data=masuk::query()->join('items','items.id','=','masuks.id_barang')
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
