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


  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous"></head>
<body>
  <!-- Content Wrapper. Contains page content -->
  <center>
    <h5>Detail Perbaikan</h5>
    </center>
    <br>
    <br>
    <!-- Main content -->
                    <table>
                        <tr>
                            <td rowspan="8">
                                <img src="{{ public_path().'/images/barang/'.$data->item->gambar }}" width="250px" alt="...">
                                {{-- <img src="{{ asset('images/barang/'.$data->item->gambar) }}" class="card-img img-details" alt="..."> --}}
                            </td>
                            <td class="align-top"><h5>Kode Perbaikan </h5></td>
                            <td>
                                <div class="col">
                                    {!! DNS1D::getBarcodeHTML($data->kode_perbaikan, 'C128') !!}
                                    <p>{{ $data->kode_perbaikan }}</p>
                                  </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="align-top"><h5>Kode Barang </h5></td>
                            <td>
                                <div class="col">
                                    {!! DNS1D::getBarcodeHTML($data->kode_barang, 'C128') !!}
                                    <p>{{ $data->kode_barang }}</p>
                                  </div>
                            </td>
                        </tr>
                        <tr>
                            <td><h5>Nama Barang </h5></td>
                            <td><h5> : {{ $data->item->nama }}</h5></td>
                        </tr>
                        <tr>
                            <td><h5>Detail Kerusakan </h5></td>
                            <td><h5> : {{ $data->rusak->detail }}</h5></td>
                        </tr>
                        <tr>
                            <td><h5>Sumber Dana Perbaikan</h5></td>
                            <td><h5> : {{ $data->sumber_dana->nama }}</h5></td>
                        </tr>
                        <tr>
                            <td><h5>Tanggal Pengajuan </h5></td>
                            <td><h5> : {{ $data->tanggal_pengajuan }}</h5></td>
                        </tr>
                        <tr>
                            <td><h5>Tanggal Disetujui</h5></td>
                            <td><h5> : {{ $data->tanggal_persetujuan }}</h5></td>
                        </tr>
                        <tr>
                            <td><h5>Tanggal Selesai</h5></td>
                            <td><h5> : {{ $data->tanggal_selesai }}</h5></td>
                        </tr>
                    </table>
    <!-- /.content -->

</body>
</html>