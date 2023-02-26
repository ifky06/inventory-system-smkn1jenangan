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
    <h5>Laporan Data Perbaikan</h5>
        @if ($awal!=""||$akhir!="")
            <h6>{{ $awal }} ~ {{ $akhir }}</h6>
        @endif
    </center>

    <!-- Main content -->
            <table id="" class="table table-bordered">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Kode Perbaikan</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Detail Kerusakan</th>
                        <th>Sumber Dana Perbaikan</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Tanggal Disetujui</th>
                        <th>Tanggal Selesai</th>
                      </tr>
                      </thead>
                      <tbody>
                      @foreach ($data as $i => $item)
                      <tr>
                        <td class="align-middle">{{ ++$i }}</td>
                        <td class="align-middle">
                          <div class="col">
                            {!! DNS1D::getBarcodeHTML($item->kode_perbaikan, 'C128',1,33) !!}
                            <p>{{ $item->kode_perbaikan }}</p>
                          </div>
                        </td>
                        <td class="align-middle">
                          <div class="col">
                            {!! DNS1D::getBarcodeHTML($item->kb, 'C128',1,33) !!}
                            <p>{{ $item->kb }}</p>
                          </div>
                        </td>
                        <td class="align-middle">{{ $item->nb}}</td>
                        <td class="align-middle">{{ $item->detail}}</td>
                        <td class="align-middle">{{ $item->sd}}</td>
                        <td class="align-middle">{{ $item->tanggal_pengajuan}}</td>
                        <td class="align-middle">{{ $item->tanggal_persetujuan}}</td>
                        <td class="align-middle">{{ $item->tanggal_selesai}}</td>
                    </tr>
            
                    @endforeach
            
                    </tbody>
            </table>
    <!-- /.content -->

</body>
</html>