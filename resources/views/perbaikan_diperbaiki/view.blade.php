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
                        <th width="30%">Kode Perbaikan</th>
                        <th>Kode Barang</th>
                        <th width="20%">Tanggal Pengajuan</th>
                        <th width="20%">Tanggal Disetujui</th>
                        <th>Aksi</th>
                      </tr>
                      </thead>
                      <tbody>
                      @foreach ($data as $i => $item)
                      <tr>
                        <td class="align-middle">{{ ++$i }}</td>
                        <td class="align-middle">
                          <div class="col">
                            {!! DNS1D::getBarcodeHTML($item->kode_perbaikan, 'C128') !!}
                            <p>{{ $item->kode_perbaikan }}</p>
                          </div>
                        </td>
                        <td class="align-middle">
                          <div class="col">
                            {!! DNS1D::getBarcodeHTML($item->kode_barang, 'C128') !!}
                            <p>{{ $item->kode_barang }}</p>
                          </div>
                        </td>
                        <td class="align-middle">{{ $item->tanggal_pengajuan}}</td>
                        <td class="align-middle">{{ $item->tanggal_persetujuan}}</td>
                        @php
                            if(Auth::user()->status==1){
                              $id=$item->pid;
                            }else{
                              $id=$item->id;
                            }
                        @endphp
                        <td class="align-middle"><a href="/diperbaiki/detail/{{ $id }}" class="btn btn-primary">detail</a></td>
                      </tr>
                @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
@endsection