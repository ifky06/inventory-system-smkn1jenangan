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
        <h3 class="card-title text-capitalize float-right mt-2 ml-2">Ubah Username {{ Auth::user()->username }}</h3>
      </div>
    </div>
<!-- /.card-header -->
<!-- form start -->
<form action="/profile/username" method="post">
@csrf
<div class="card-body">
<div class="row">
<div class="col-md-12">
    <div class="form-group">
        <label for="email-old">Username Lama</label>
        <input id="email-old" type="text" class="form-control" value="{{ Auth::user()->username }}" readonly>
    </div> 
    <div class="form-group">
        <label for="email">Username Baru</label>
        <input id="email" type="text" class="form-control " name="username" autofocus autocomplete="off">
    </div> 
</div>
</div>
</div>
<!-- /.card-body -->

<div class="card-footer">
{{-- <a href="/profile" class="btn btn-default"><i class='nav-icon fas fa-arrow-left'></i> &nbsp; Kembali</a> &nbsp; --}}
<button name="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Update</button>
</div>
</form>
</div>
<!-- /.card -->
</div>
    </div> <!-- end of class row -->
</div>
@endsection