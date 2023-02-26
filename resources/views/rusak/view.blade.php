@extends('layouts.utama')

@section('content')
          <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Data Barang Rusak</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th width="5%">No</th>
                  <th>Kode Barang</th>
                  <th>Nama Barang</th>
                  <th>Detail Kerusakan</th>
                  <th>Status</th>
                  <th width="5%">Ajukan Perbaikan</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($data as $i => $item)
                <tr>
                  <td>{{ ++$i }}</td>
                  <td>{{ $item->kode_barang }}</td>
                  <td>{{ $item->nama }}</td>
                  <td>{{ $item->detail }}</td>
                  <td>{{ $item->rs }}</td>
                  <td>
                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#satu{{ $item->rid }}"><i class="fas fa-check"></i></button>
                  </td>
                </tr>

                <div class="modal fade" id="satu{{ $item->rid }}">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Masukan Sumber Dana Perbaikan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form action="/rusak/{{ $item->rid }}" method="post" enctype="multipart/form-data">
                          @csrf
                          <label for="exampleInputEmail1">Sumber Dana</label>
                          <select class="form-control select2bs4" name="sd" style="width: 100%;">
                            <option selected="selected"></option>
                            @foreach ($data2 as $sd)
                              <option value="{{ $sd->id }}">{{ $sd->nama }}</option>
                            @endforeach
                          </select>
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
                @endforeach
                </tbody>
              </table>
              {{-- <div class="text-center">
                <a href="#" class="btn btn-dark"  data-toggle="modal" data-target="#input">Ajukan Semua</a>
                </div>
                <br>
                 <b class="text-secondary">*Mohon untuk langsung klik Ajukan Semua untuk mengajukan semua barang untuk diperbaiki</b>
              </div> --}}
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          <div class="modal fade" id="input">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Masukan Sumber Dana Perbaikan</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="/rusak/semua" method="post" enctype="multipart/form-data">
                    @csrf
                    <label for="exampleInputEmail1">Sumber Dana</label>
                    <select class="form-control select2bs4" name="sumber_dana" style="width: 100%;">
                      <option selected="selected"></option>
                      @foreach ($data2 as $sd)
                        <option value="{{ $sd->id }}">{{ $sd->nama }}</option>
                      @endforeach
                    </select>
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