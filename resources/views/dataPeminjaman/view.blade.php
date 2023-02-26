@extends('layouts.utama')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
      <h3 class="card-title">Data Peminjaman</h3>
      <div class="float-right">
        {{-- <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#pdf"><i class="fas fa-file-export"></i> Export PDF</button> --}}
        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#excel"><i class="fas fa-file-export"></i> Export Excel</button>
      </div>
    </div>

    <div class="modal fade" id="pdf">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Export PDF</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="/export_pdf/datapeminjaman" method="post">
              @csrf
              {{-- <div class="form-group">
                <label>Pengelompokan Data</label>
                <select class="form-control custom-select" name="data">
                  <option value="0" selected>Semua Data</option>
                  <option value="1">Belum Dikembalikan</option>
                  <option value="2">Sudah Dikembalikan</option>
                </select>
              </div> --}}
              <label>Selang Waktu</label>
              <div class="form-row">
                <div class="form-group col">
                  <input type="date" class="form-control" name="awal" placeholder="nama">
              </div>
              <div class="form-group col-1 mt-1 text-center">
                <label>-----</label>
            </div>
                <div class="form-group col">
                  <input type="date" class="form-control" name="akhir" placeholder="nama">
              </div>
            </div>
            <div class="form-group">
              <span>*Kosongkan Selang Waktu Jika Ingin Mengekspor Semua</span>
          </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Export</button>
          </div>
        </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="excel">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Export Excel</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="/export_excel/datapeminjaman" method="post">
              @csrf
              {{-- <div class="form-group">
                <label>Pengelompokan Data</label>
                <select class="form-control custom-select" name="data">
                  <option value="0" selected>Semua Data</option>
                  <option value="1">Belum Dikembalikan</option>
                  <option value="2">Sudah Dikembalikan</option>
                </select>
              </div> --}}
              <label>Selang Waktu</label>
              <div class="form-row">
                <div class="form-group col">
                  <input type="date" class="form-control" name="awal" placeholder="nama">
              </div>
              <div class="form-group col-1 mt-1 text-center">
                <label>-----</label>
            </div>
                <div class="form-group col">
                  <input type="date" class="form-control" name="akhir" placeholder="nama">
              </div>
            </div>
            <div class="form-group">
              <span>*Kosongkan Selang Waktu Jika Ingin Mengekspor Semua</span>
          </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Export</button>
          </div>
        </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

    <!-- /.card-header -->
    <div class="card-body">
      <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th width="5%">No</th>
          <th>Kode</th>
          <th>Tanggal Peminjam</th>
          <th>Tanggal Peminjam</th>
          <th>Batas Pengembalian</th>
          <th>Dikembalikan</th>
          <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($data as $i => $item)
        <tr>
          <td class="align-middle text-center">{{ ++$i }}</td>
          <td class="align-middle">
            <div class="col">
              {!! DNS1D::getBarcodeHTML($item->kode_peminjaman, 'C128') !!}
              <p>{{ $item->kode_peminjaman }}</p>
            </div>
          </td>
          <td class="align-middle">{{ $item->nama}}</td>
          <td class="align-middle">{{ $item->tanggal_pinjam}}</td>
          <td class="align-middle">{{ $item->tenggat}}</td>
          <td class="align-middle">{{ $item->tanggal_kembali}}</td>
          <td class="align-middle"><a href="/datapeminjaman/{{ $item->kode_peminjaman }}" class="btn btn-primary btn-sm"><i class="fas fa-info-circle"></i></a></td>
        </tr>

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