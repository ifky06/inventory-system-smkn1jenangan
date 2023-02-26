@extends('layouts.utama')

@section('content')
          <div class="card">
            <div class="card-header">
                <form action="/peminjaman/{{ $nama }}" method="post">
                    @csrf
                    
                    <div class="form-row float-left">
                      <a href="/peminjaman" class="btn btn-primary"><i class="fas fa-arrow-left"></i></a>
                      <div class="ml-2 mt-2">
                        <h5><b>Peminjam : {{ $nama }}</b></h5>
                      </div>
                    </div>
                    <div class="form-row float-right">
                      <label for="exampleInputEmail1">Pinjam Barang</label>
                        <div class="ml-2">
                          {{-- <input type="text" class="form-control w-50 float-right" name="nama" value="{{ old('nama') }}" placeholder="Nama Peminjam"> --}}
                          <select class="form-control select2bs4 " name="barang">
                            <option selected="selected"></option>
                            @foreach ($data2 as $sd)
                            <option value="{{ $sd->id }}">{{ $sd->kode }} - {{ $sd->nama }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="ml-2">
                            <button type="submit" class="btn btn-primary">Input</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th width="5%">No</th>
                  <th>Kode Barang</th>
                  <th>Nama Barang</th>
                  <th width="5%">Tools</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($data as $i => $item)
                <tr>
                  <td>{{ ++$i }}</td>
                  <td>{{ $item->kode_barang }}</td>
                  <td>{{ $item->item->nama }}</td>
                  <td>
                    <form action="/peminjaman/{{ $item->id }}" method="post">
                      @csrf
                      @method('delete')
                      <button class="btn btn-danger btn-sm" type="submit"><i class="far fa-trash-alt"></i></button>
                    </form>
                  </td>
                </tr>
                @endforeach
                </tbody>
              </table>
              <div class="text-center">
                <a href="#" class="btn btn-dark"  data-toggle="modal" data-target="#input">Masukan Data Peminjaman</a>
                </div>
                <br>
                 <b class="text-secondary">*Mohon untuk langsung klik masukkan data untuk memasukan ke dalam data peminjaman</b>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          <div class="modal fade" id="input">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Masukan Data Peminjaman</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="/inputpeminjaman/{{ $nama }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <label for="exampleInputEmail1">Lama Peminjaman</label>
                  <div class="form-row">
                    <div class="form-group col">
                      <input type="number" class="form-control" name="lama">
                    </div>
                    <div class="form-group col-3">
                      <select class="form-control custom-select" name="satuan">
                        <option value="0">Hari</option>
                        <option value="1">Bulan</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Input</button>
                </div>
              </form>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>

@endsection