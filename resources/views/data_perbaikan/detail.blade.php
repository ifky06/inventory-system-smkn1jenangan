@extends('layouts.utama')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <div class="form-row float-left">
            <a href="/dataperbaikan" class="btn btn-primary"><i class="fas fa-arrow-left"></i></a>
            <div class="ml-2 mt-2">
                <h5><b>Detail Perbaikan</b></h5>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row no-gutters ml-2 mb-2 mr-2">
            <div class="col-md-4">
                <img src="{{ asset('images/barang/'.$data->item->gambar) }}" class="card-img img-details" alt="...">
            </div>
            <div class="col-md-1 mb-4"></div>
            <div class="col-md-7">
                <table>
                    <tr>
                        <td class="align-top"><h5>Kode Perbaikan </h5></td>
                        <td>
                            <div class="col">
                                {!! DNS1D::getBarcodeHTML($data->kode_perbaikan, 'C128') !!}
                                <p>{{ $data->kode_perbaikan }}</p>
                              </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="align-top"><h5>Kode Barang </h5></td>
                        <td>
                            <div class="col">
                                {!! DNS1D::getBarcodeHTML($data->kode_barang, 'C128') !!}
                                <p>{{ $data->kode_barang }}</p>
                              </div>
                        </td>
                    </tr>
                    <tr>
                        <td><h5>Nama Barang </h5></td>
                        <td><h5> : {{ $data->item->nama }}</h5></td>
                    </tr>
                    <tr>
                        <td><h5>Detail Kerusakan </h5></td>
                        <td><h5> : {{ $data->rusak->detail }}</h5></td>
                    </tr>
                    <tr>
                        <td><h5>Sumber Dana Perbaikan</h5></td>
                        <td><h5> : {{ $data->sumber_dana->nama }}</h5></td>
                    </tr>
                    <tr>
                        <td><h5>Tanggal Pengajuan </h5></td>
                        <td><h5> : {{ $data->tanggal_pengajuan }}</h5></td>
                    </tr>
                    <tr>
                        <td><h5>Tanggal Disetujui</h5></td>
                        <td><h5> : {{ $data->tanggal_persetujuan }}</h5></td>
                    </tr>
                    <tr>
                        <td><h5>Tanggal Selesai</h5></td>
                        <td><h5> : {{ $data->tanggal_selesai }}</h5></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center">
                            <a href="/export_pdf/detailperbaikan/{{ $data->id }}" class="btn btn-danger btn-sm"><i class="fas fa-file-export"></i> Export PDF</a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
