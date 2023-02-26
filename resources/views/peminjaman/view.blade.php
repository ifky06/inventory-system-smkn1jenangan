@extends('layouts.utama')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h5><b>Masukkan Nama Peminjam</b></h5>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <form action="\peminjaman" method="POST">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">Nama Peminjam</label>
                <input type="text" class="form-control" name="nama" placeholder="Nama Peminjam">
            </div>
            <button type="submit" class="btn btn-primary">Input</button>
        </form>
    </div>
    <!-- /.card-body -->
  </div>
@endsection