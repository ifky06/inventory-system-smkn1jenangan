@extends('layouts.utama')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
      <div class="float-left">
      <a href="/barang" class="btn btn-primary"><i class="fas fa-arrow-left"></i></a>
        @foreach ($data4 as $item)
            
        <h3 class="card-title float-right mt-2 ml-2"><b> Data Barang {{ $item->bengkel }}</b></h3>
        
    </div>
    <div class="float-right">
      {{-- <a href="export_pdf/barang" class="btn btn-danger btn-sm"><i class="fas fa-file-export"></i> Export PDF</a> --}}
      <a href="/export_excel/barang/{{ $item->id }}" class="btn btn-success btn-sm"><i class="fas fa-file-export"></i> Export Excel</a>
      @endforeach
      {{-- <button type="button" class="btn btn-primary btn-sm"  data-toggle="modal" data-target="#tambah">+ Tambah</button> --}}
    </div>
    </div>


    <!-- /.card-header -->
    <div class="card-body">
      <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>No</th>
          <th width="20%">Kode</th>
          <th width="20%">Nama</th>
          <th width="10%">Bengkel</th>
          <th width="10%">Sumber Dana</th>
          <th width="5%">Kondisi</th>
          <th width="5%">Status</th>
          <th>Gambar</th>
          <th>Tools</th>
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
          <td class="align-middle">{{ $item->bengkel->bengkel }}</td>
          <td class="align-middle">{{ $item->sumber_dana->nama }}</td>
          @php
              if($item->kondisi=="baik"){
                $badge="badge-success";
              }else {
                $badge="badge-danger";
              }

              if ($item->status=="ada") {
                $badge2="badge-primary";
              } else {
                $badge2="badge-secondary";
              }
          @endphp
          <td class="align-middle text-center"><span class="badge {{ $badge }}">{{ $item->kondisi }}</span></td>
          <td class="align-middle text-center"><span class="badge {{ $badge2 }}">{{ $item->status }}</span></td>
          <td class="text-center">
            <a href="" data-toggle="modal" data-target="#gambar{{ $item->id }}">
              <img width="100px" src="{{ asset('images/barang/'.$item->gambar) }}" alt="">
            </a>
          </td>
          <td class="align-middle text-center">
            <a href="/barang/detail_barang/{{ $item->id }}" class="btn btn-primary btn-sm mb-2"><i class="fas fa-info-circle"></i></a>
            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit{{ $item->id }}"><i class="fas fa-edit"></i></button>
            {{-- <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus{{ $item->id }}"><i class="far fa-trash-alt"></i></button> --}}
          </td>
        </tr>

        <div class="modal fade" id="edit{{ $item->id }}">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Edit Barang</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="/barang/{{ $item->id }}" method="post" enctype="multipart/form-data">
                  @method('put')
                  @csrf
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nama</label>
                    <input type="text" class="form-control" name="nama" value="{{ $item->nama }}" placeholder="nama">
                </div>
                @if (Auth::user()->status==0)
                <div class="form-group">
                  <label>Bengkel</label>
                  <select class="form-control select2bs4" name="bengkel" style="width: 100%;">
                    <option selected="selected" value="{{ $item->id_bengkel }}">{{ $item->bengkel->bengkel }}</option>
                    @foreach ($data2 as $b)
                      <option value="{{ $b->id }}">{{ $b->bengkel }}</option>
                    @endforeach
                  </select>
                </div>
                @endif
                <div class="form-group">
                  <label>Sumber Dana</label>
                  <select class="form-control select2bs4" name="sumber_dana" style="width: 100%;">
                    <option selected="selected" value="{{ $item->id_fund}}">{{ $item->sumber_dana->nama}}</option>
                    @foreach ($data3 as $sd)
                      <option value="{{ $sd->id }}">{{ $sd->nama }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Gambar</label>
                    <input type="file" class="form-control" name="gambar" accept="image/*">
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Edit</button>
              </div>
            </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

        {{-- <div class="modal fade" id="hapus{{ $item->id }}">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Hapus Barang</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <h5>Yakin?</h5>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Hapus</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div> --}}

        <div class="modal fade" id="gambar{{ $item->id }}">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <img width="100%" src="{{ asset('images/barang/'.$item->gambar) }}" alt="">
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

        <script>
              function previewFile2(input){
      var file=$("input[type=file]").get(0).files[0];
      if(file){
        var reader = new FileReader();
        reader.onload=function(){
          $('#previewImg').attr("src",reader.result);
        }
        reader.readAsDataURL(file);
      }
    }
        </script>

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