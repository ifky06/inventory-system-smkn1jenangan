@extends('layouts.utama')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
<!-- general form elements -->
<div class="card card-outline card-primary">
<div class="card-header">
  <div class="float-left">
    <a href="/profile" class="btn btn-primary"><i class="fas fa-arrow-left"></i></a>
    <h3 class="card-title text-capitalize float-right mt-2 ml-2">Edit Profile {{ Auth::user()->username }}</h3>
  </div>
</div>
<!-- /.card-header -->
<!-- form start -->
<form action="/profile/edit" method="post" enctype="multipart/form-data">
    @csrf
<div class="card-body">
          <div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label for="name">Nama</label>
      <input id="name" type="text" value="{{ Auth::user()->name }}" class="form-control " name="nama">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Foto Profile</label>
        <input type="file" class="form-control" name="foto" accept="image/*">
        <img class="mt-2" id="previewImg" width="25%" alt="">
        <div class="custom-control custom-checkbox">
            <input class="custom-control-input" type="checkbox" id="customCheckbox1" name="kosong">
            <label for="customCheckbox1" class="custom-control-label">Kosongkan Foto Profile</label>
        </div>
    </div>
  </div>
</div>
      </div>
<!-- /.card-body -->

<div class="card-footer">
{{-- <a href="/profile" class="btn btn-default"><i class='nav-icon fas fa-arrow-left'></i> &nbsp; Kembali</a> &nbsp; --}}
<button name="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Simpan</button>
</div>
</form>
</div>
<!-- /.card -->
</div>
    </div> <!-- end of class row -->
</div>
@endsection