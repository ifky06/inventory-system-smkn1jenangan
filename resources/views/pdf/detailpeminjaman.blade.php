<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">


  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <style>
    .float{
        float: right;
    }
    </style>
  <!-- Content Wrapper. Contains page content -->
    @foreach ($nama as $i)
    <div class="row">
    <div class="col">
      <p>Nama : {{ $i->nama }}</p>
      <p>Tanggal Peminajaman : {{ $i->tanggal_pinjam }}</p>
      <p>Kembalikan Sebelum  : {{ $i->tenggat }}</p>
    </div>
    <div class="float-right col-5">
        <div class="col">
            {!! DNS1D::getBarcodeHTML($i->kode_peminjaman, 'C128') !!}
            <p>{{ $i->kode_peminjaman }}</p>
        </div>
    </div>
</div>
    @endforeach
    <!-- Main content -->
    <table id="example2" class="table table-bordered table-hover">
        <thead>
        <tr>
          <th width="5%">No</th>
          <th>Kode Barang</th>
          <th>Nama Barang</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($data as $i => $item)
        <tr>
          <td class="align-middle">{{ ++$i }}</td>
          <td class="align-middle">
            <div class="col">
            {!! DNS1D::getBarcodeHTML($item->kode_barang, 'C128') !!}
            <p>{{ $item->kode_barang }}</p>
            </div>
          </td>
          <td class="align-middle">{{ $item->item->nama }}</td>
        </tr>
        @endforeach
        </tbody>
      </table>
    <!-- /.content -->

</body>
</html>