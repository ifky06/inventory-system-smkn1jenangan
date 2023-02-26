@extends('layouts.utama')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="form-row float-left">
          <a href="/peminjaman" class="btn btn-primary"><i class="fas fa-arrow-left"></i></a>
          <div class="ml-2 mt-2 row">
            @foreach ($nama as $item)
            <h5><b>Kode/Peminjam : {{ $kode }}/{{ $item->nama }}</b></h5>
            {{-- <h5 class="ml-2"><b>Peminjam : {{ $item->nama }}</b></h5> --}}
            @endforeach
          </div>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="example1" class="table table-bordered table-hover">
        <thead>
        <tr>
          <th width="5%">No</th>
          <th>Kode Barang</th>
          <th>Nama Barang</th>
          <th width="5%">Kembali</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($data as $i => $item)
        <tr>
          <td class="align-middle text-center">{{ ++$i }}</td>
          <td class="align-middle">
            <div class="col">
              {!! DNS1D::getBarcodeHTML($item->kode_barang, 'C128') !!}
              <p>{{ $item->kode_barang }}</p>
            </div>
          </td>
          <td class="align-middle">{{ $item->item->nama }}</td>
          <td class="align-middle text-center">
            <a class="btn btn-success btn-sm" href="/kembali/{{ $item->id }}"><i class="fas fa-check"></i></a>
          </td>
        </tr>
        @endforeach
        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
</div>
@endsection