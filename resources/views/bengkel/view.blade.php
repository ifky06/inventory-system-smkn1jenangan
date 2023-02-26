@extends('layouts.utama')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
      <h3 class="card-title">Data Bengkel</h3>
      <button type="button" class="btn btn-primary btn-sm float-right"  data-toggle="modal" data-target="#tambah">+ Tambah</button>
    </div>

    <div class="modal fade" id="tambah">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Tambah Bengkel</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="/bengkel" method="post" enctype="multipart/form-data">
              @csrf
              <div class="form-group">
                <label for="exampleInputEmail1">Bengkel</label>
                <input type="text" class="form-control" name="bengkel" placeholder="Bengkel">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Penanggung Jawab</label>
                <select class="form-control select2bs4" name="pj" style="width: 100%;">
                  <option selected="selected"></option>
                  @foreach ($data2 as $b)
                    <option value="{{ $b->id }}">{{ $b->name }}</option>
                  @endforeach
                </select>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Tambah</button>
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
          <th>Bengkel</th>
          <th width="30%">Penanggung Jawab</th>
          <th width="5%">Tools</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($data as $i => $item)
        <tr>
          <td class="align-middle text-center">{{ ++$i }}</td>
          <td class="align-middle">{{ $item->bengkel }}</td>
          <td class="align-middle">{{ $item->pj->name }}</td>
          <td class="align-middle text-center">
            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit{{ $item->id }}"><i class="fas fa-edit"></i></button>
            {{-- <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus{{ $item->id }}"><i class="far fa-trash-alt"></i></button> --}}
          </td>
        </tr>

        <div class="modal fade" id="edit{{ $item->id }}">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Edit Bengkel</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="/bengkel/{{ $item->id }}" method="post" enctype="multipart/form-data">
                  @method('put')
                  @csrf
                  <div class="form-group">
                    <label for="exampleInputEmail1">Bengkel</label>
                    <input type="text" class="form-control" name="bengkel" value="{{ $item->bengkel }}" placeholder="Bengkel">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Penanggung Jawab</label>
                    <select class="form-control select2bs4" name="pj" style="width: 100%;">
                      <option selected="selected" value="{{ $item->id_pj }}">{{ $item->pj->name }}</option>
                      @foreach ($data2 as $b)
                        <option value="{{ $b->id }}">{{ $b->name }}</option>
                      @endforeach
                    </select>
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

        <div class="modal fade" id="hapus{{ $item->id }}">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Hapus Bengkel</h4>
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