@extends('layouts.utama')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
      <h3 class="card-title">Data Barang</h3>
      <button type="button" class="btn btn-primary btn-sm float-right"  data-toggle="modal" data-target="#tambah">+ Tambah</button>
    </div>

    <!-- /.card-header -->
    <div class="card-body">
      <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th width="5%">No</th>
          <th width="30%">Kode</th>
          <th>Nama</th>
          <th width="20%">Terakhir Dicek</th>
          <th width="8%">Baik</th>
          <th width="7%">Rusak</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($data as $i => $item)
        <tr>
          <td class="align-middle">{{ ++$i }}</td>
          <td class="align-middle">
            <div class="col">
              {!! DNS1D::getBarcodeHTML($item->kode, 'C128') !!}
              <p>{{ $item->kode }}</p>
            </div>
          </td>
          <td class="align-middle">{{ $item->nama }}</td>
          @php
              $a=Carbon\Carbon::now()->isoformat(' D MMM Y');
          @endphp
          @if ($item->tanggal_cek == $a)
          <td class="align-middle">Hari Ini</td>
          @else
            <td class="align-middle">
              <div class="col">
                <b>{{ $item->tanggal_cek }}</b>
                <p>{{ Carbon\Carbon::today()->diffForHumans($item->tanggal_cek,true)}} yang lalu</p>
              </div>
            </td>
          @endif
          <td class="align-middle text-center">
              <form action="/kondisi/{{ $item->id }}" method="post">
                  @csrf
                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#baik{{ $item->id }}"><i class="fas fa-check"></i></button>
              </form>
          </td>
          <td class="align-middle text-center">
            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#rusak{{ $item->id }}"><i class="fas fa-times"></i></button>
            {{-- <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus{{ $item->id }}"><i class="far fa-trash-alt"></i></button> --}}
          </td>
        </tr>

        <div class="modal fade" id="rusak{{ $item->id }}">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Barang Rusak</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="/kondisi/{{ $item->id }}" method="post">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="exampleInputEmail1">Detail Kerusakan</label>
                        <textarea name="detail" class="form-control" cols="30" rows="10"></textarea>
                    </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger" >Input</button>
            </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

        @endforeach

        </tbody>
        {{-- <tfoot>
        <tr>
          <th>Rendering engine</th>
          <th>Browser</th>
          <th>Platform(s)</th>
          <th>Engine version</th>
          <th>CSS grade</th>
        </tr>
        </tfoot> --}}
      </table>
    </div>
    <!-- /.card-body -->
</div>


@endsection