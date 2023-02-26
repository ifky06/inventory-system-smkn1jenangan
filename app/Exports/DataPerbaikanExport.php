<?php

namespace App\Exports;

use App\Models\perbaikan;
use App\Models\bengkel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DataPerbaikanExport implements FromQuery, WithHeadings
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
        if (auth()->user()->status == 1) {
            $id=auth()->user()->id;
            $bengkel=bengkel::where('id_pj','=',$id)->get();
            $data=perbaikan::query()->join('items','items.id','=','perbaikans.id_barang')
                ->join('funds','funds.id','=','perbaikans.id_fund')
                ->join('rusaks','rusaks.id','=','perbaikans.id_rusak')
                ->whereBetween('perbaikans.tanggal_pengajuan', [$this->awal, $this->akhir])
                ->where('items.id_bengkel','=',$bengkel[0]->id)
                ->select('kode_perbaikan','perbaikans.kode_barang as kb','items.nama as nb','detail','funds.nama as sd','tanggal_pengajuan','tanggal_persetujuan','tanggal_selesai')
                ->orderBy('perbaikans.tanggal_pengajuan','desc');
        } else {
            $data=perbaikan::query()->join('items','items.id','=','perbaikans.id_barang')
                ->join('funds','funds.id','=','perbaikans.id_fund')
                ->join('rusaks','rusaks.id','=','perbaikans.id_rusak')
                ->whereBetween('perbaikans.tanggal_pengajuan', [$this->awal, $this->akhir])
                ->select('kode_perbaikan','perbaikans.kode_barang as kb','items.nama as nb','detail','funds.nama as sd','tanggal_pengajuan','tanggal_persetujuan','tanggal_selesai')
                ->orderBy('perbaikans.tanggal_pengajuan','desc');
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
