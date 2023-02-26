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
  <!-- Content Wrapper. Contains page content -->
  <center>
    <h5>Laporan Data Barang Keluar</h5>
        @if ($awal!=""||$akhir!="")
            <h6>{{ $awal }} ~ {{ $akhir }}</h6>
        @endif
    </center>

    <!-- Main content -->
            <table id="" class="table table-bordered">
                <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th>Kode</th>
                      <th>Nama</th>
                      <th>Tanggal</th>
                      <th>Keterangan</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $i => $item)
                    <tr>
                      <td class="align-middle text-center">{{ ++$i }}</td>
                      <td class="align-middle">
                        <div class="col">
                          {!! DNS1D::getBarcodeHTML($item->kode_barang, 'C128') !!}
                          <p>{{ $item->kode_barang }}</p>
                        </div>
                      </td>
                      <td class="align-middle">{{ $item->nama }}</td>
                      <td class="align-middle">{{ $item->tanggal }}</td>
                      <td class="align-middle">{{ $item->keterangan }}</td>
                    </tr>
            
                    @endforeach
            
                    </tbody>
            </table>
    <!-- /.content -->

</body>
</html>