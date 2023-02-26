@extends('layouts.utama')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <div class="form-row float-left">
            <a href="/perbaikan" class="btn btn-primary"><i class="fas fa-arrow-left"></i></a>
            <div class="ml-2 mt-2">
                @if (Auth::user()->status==0)
                <h5><b>Setujui Perbaikan</b></h5>
                @else
                <h5><b>Menunggu Persetujuan</b></h5>
                @endif
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
                        <td colspan="2" class="text-center">
                            @if (Auth::user()->status==0)
                            <form action="/perbaikan/detail/{{ $data->id }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-success">Setujui</button>
                            </form>
                            @endif
                            <a href="/export_pdf/detailperbaikan/{{ $data->id }}" class="btn btn-danger mt-2"><i class="fas fa-file-export"></i> Export PDF</a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
