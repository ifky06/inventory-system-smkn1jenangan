@extends('layouts.utama')

@section('content')
    {{-- <div class="text-center">
        <img width="48%" src="{{ asset('images/hitler.png') }}" alt="">
    </div> --}}
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{ $item }}</h3>

              <p>Total Barang</p>
            </div>
            <div class="icon">
              <i class="fas fa-boxes"></i>
            </div>
            <a href="/barang" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>{{ $tunggu }}</h3>

              <p>Perbaikan Belum Disetujui</p>
            </div>
            <div class="icon">
              <i class="fas fa-tools"></i>
            </div>
            <a href="/perbaikan" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{ $perbaikan }}</h3>

              <p>Sedang Dalam Perbaikan</p>
            </div>
            <div class="icon">
              <i class="fas fa-tools"></i>
            </div>
            <a href="/diperbaiki" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3>{{ $pinjam }}</h3>

              <p>Barang Dipinjam</p>
            </div>
            <div class="icon">
              <i class="fas fa-briefcase"></i>
            </div>
            <a href="/datapeminjaman" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      {{-- RICK ROLL --}}
      {{-- <div class="text-center">
        <img width="43%" src="{{ asset('images/rickroll.gif') }}" alt="">
      </div> --}}
</div>
@endsection