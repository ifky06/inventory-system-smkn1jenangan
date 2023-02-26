@extends('layouts.utama')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h5><b>Masukkan Kode Peminjaman</b></h5>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <form action="\pengembalian" method="POST">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">Kode Peminjaman</label>
                <input type="text" class="form-control" name="kode" placeholder="Kode Peminjaman">
            </div>
            <button type="submit" class="btn btn-primary">Input</button>
        </form>
    </div>
    <!-- /.card-body -->
  </div>
@endsection