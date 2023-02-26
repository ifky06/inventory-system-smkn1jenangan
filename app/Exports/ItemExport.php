<?php

namespace App\Exports;

use App\Models\item;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ItemExport implements FromCollection, WithHeadings
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        if (auth()->user()->status == 1) {
            $id=auth()->user()->id;
            $item=item::join('bengkels','bengkels.id','=','items.id_bengkel')
                        ->join('funds','funds.id','=','items.id_fund')
                        ->select('kode','items.nama','bengkel','funds.nama as sumber_dana','tanggal_cek','kondisi','status')
                        ->where('bengkels.id_pj','=',$id)
                        ->orderBy('id_bengkel','asc')
                        ->orderBy('id_fund','asc')->get();
        } else {
            $item=item::join('bengkels','bengkels.id','=','items.id_bengkel')
                        ->join('funds','funds.id','=','items.id_fund')
                        ->select('kode','items.nama','bengkel','funds.nama as sumber_dana','tanggal_cek','kondisi','status')
                        ->orderBy('id_bengkel','asc')
                        ->orderBy('id_fund','asc')->get();
        }
        return $item;
    }
    public function headings(): array
    {
        return [
            'Kode',
            'Nama Barang',
            'Bengkel',
            'Sumber Dana',
            'Tanggal Pengecekan',
            'Kondisi',
            'Status',
        ];
    }
}
