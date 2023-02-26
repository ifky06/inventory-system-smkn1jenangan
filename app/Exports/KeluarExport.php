<?php

namespace App\Exports;

use App\Models\keluar;
use App\Models\bengkel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KeluarExport implements FromQuery, WithHeadings
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(string $awal, string $akhir)
    {
        $this->awal = $awal;
        $this->akhir = $akhir;
    }

    public function query()
    {
        if (auth()->user()->status==1) {
            $id=auth()->user()->id;
            $bengkel=bengkel::where('id_pj','=',$id)->get();
            $data=keluar::query()->join('items','items.id','=','keluars.id_barang')
                        ->select('kode_barang','items.nama','tanggal','keterangan')
                        ->where('id_bengkel','=',$bengkel[0]->id)
                        ->whereBetween('tanggal', [$this->awal, $this->akhir])
                        ->orderBy('tanggal','desc');
        } else {
            $data=keluar::query()->join('items','items.id','=','keluars.id_barang')
                        ->select('kode_barang','items.nama','tanggal','keterangan')
                        ->whereBetween('tanggal', [$this->awal, $this->akhir])
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
