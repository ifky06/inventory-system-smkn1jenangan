@extends('layouts.utama')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <div class="form-row float-left">
            <a href="/datapeminjaman" class="btn btn-primary"><i class="fas fa-arrow-left"></i></a>
            <div class="ml-2 mt-2">
                @foreach ($nama as $i)
                <h5><b>Peminjam : {{ $i->nama }}</b></h5>
              </div>
              
        </div>
        <div class="float-right">
          <a href="/export_pdf/detailpeminjaman/{{ $i->kode_peminjaman }}" class="btn btn-danger"><i class="fas fa-file-export"></i> Export PDF</a>
        </div>
        @endforeach
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="example2" class="table table-bordered table-hover">
        <thead>
        <tr>
          <th width="5%">No</th>
          <th>Kode Barang</th>
          <th>Nama Barang</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($data as $i => $item)
        <tr>
          <td class="align-middle">{{ ++$i }}</td>
          <td class="align-middle">
            <div class="col">
            {!! DNS1D::getBarcodeHTML($item->kode_barang, 'C128') !!}
            <p>{{ $item->kode_barang }}</p>
            </div>
          </td>
          <td class="align-middle">{{ $item->item->nama }}</td>
        </tr>
        @endforeach
        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
  </div>
@endsection