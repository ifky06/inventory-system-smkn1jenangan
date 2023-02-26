@extends('layouts.utama')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <div class="form-row float-left">
            @if (Auth::user()->status == 0)
            <a href="/barang/detail/{{ $data->id_bengkel }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i></a>
            @else
            <a href="/barang" class="btn btn-primary"><i class="fas fa-arrow-left"></i></a>
            @endif
            <div class="ml-2 mt-2">
                <h5><b>Detail Barang</b></h5>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row no-gutters ml-2 mb-2 mr-2">
            <div class="col-md-4">
                <img src="{{ asset('images/barang/'.$data->gambar) }}" class="card-img img-details" alt="...">
            </div>
            <div class="col-md-1 mb-4"></div>
            <div class="col-md-7">
                <table>
                    <tr>
                        <td class="align-top"><h5>Kode Barang </h5></td>
                        <td>
                            <div class="col">
                                {!! DNS1D::getBarcodeHTML($data->kode, 'C128') !!}
                                <p>{{ $data->kode }}</p>
                              </div>
                        </td>
                    </tr>
                    <tr>
                        <td><h5>Nama Barang </h5></td>
                        <td><h5> : {{ $data->nama }}</h5></td>
                    </tr>
                    <tr>
                        <td><h5>Bengkel</h5></td>
                        <td><h5> : {{ $data->bengkel->bengkel }}</h5></td>
                    </tr>
                    <tr>
                        <td><h5>Sumber Dana</h5></td>
                        <td><h5> : {{ $data->sumber_dana->nama }}</h5></td>
                    </tr>
                    <tr>
                        <td><h5>Tanggal Pengecekan Terakhir </h5></td>
                        <td><h5> : {{ $data->tanggal_cek }}</h5></td>
                    </tr>
                    <tr>
                        <td><h5>Kondisi</h5></td>
                        <td><h5> : {{ $data->kondisi }}</h5></td>
                    </tr>
                    <tr>
                        <td><h5>Status</h5></td>
                        <td><h5> : {{ $data->status }}</h5></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center">
                            <a href="/export_pdf/detail_barang/{{ $data->id }}" class="btn btn-danger btn-sm"><i class="fas fa-file-export"></i> Export PDF</a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
