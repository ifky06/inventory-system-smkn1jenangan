<?php

namespace App\Exports;

use App\Models\item;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;


class ItemExportBengkel implements FromQuery, WithHeadings
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(int $id)
    {
        $this->bengkel = $id;
    }
    public function query()
    {
        $item=item::query()->join('bengkels','bengkels.id','=','items.id_bengkel')
                    ->join('funds','funds.id','=','items.id_fund')
                    ->where('id_bengkel','=',$this->bengkel)
                    ->select('kode','items.nama','bengkel','funds.nama as sumber_dana','tanggal_cek','kondisi','status')
                    ->orderBy('id_bengkel','asc')
                    ->orderBy('id_fund','asc');

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
