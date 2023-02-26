@extends('layouts.utama')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
<!-- Profile Image -->
    <div class="card card-primary card-outline">
    <div class="card-body box-profile">
        <div class="text-center">
             <img class="profile-user-img img-fluid img-circle" src="{{ asset('images/profile/'.Auth::user()->foto) }}" alt="User profile picture">
        </div>
        <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>
        <p class="text-muted text-center">
            @if (Auth::user()->status == 0)
            Admin
        @else
            Penanggung jawab {{ Auth::user()->pj }}
        @endif
        </p>
            <a href="/profile/edit" class="btn btn-primary btn-block"><b>Edit Profile</b></a>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->

    <div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">Pengaturan Akun</h3>
    </div>
    <div class="card-body">
        <table class="table" style="margin-top: -21px;">
        <tr>
            <td width="50"><i class="nav-icon fas fa-user"></i></td>
            <td>Ubah Username</td>
            <td width="50"><a href="/profile/username" class="btn btn-default btn-sm">Edit</a></td>
        </tr>
        <tr>
            <td width="50"><i class="nav-icon fas fa-key"></i></td>
            <td>Ubah Password</td>
            <td width="50"><a href="/profile/password" class="btn btn-default btn-sm">Edit</a></td>
        </tr>
        </table>
    </div>
    </div>
</div>
<!-- /.col -->

<!-- /.row -->
</div>
    </div> <!-- end of class row -->
</div>
@endsection