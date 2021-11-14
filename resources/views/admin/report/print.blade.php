  <?php
  	header("Content-type: application/vnd-ms-excel");
  	header("Content-Disposition: attachment; filename=data_laporan_$startdate-$enddate.xls");
	?>
	
    <table>
      <thead>
      <tr>
        <th>Tanggal</th>
        <th>Penjualan</th>
        <th>Pembelian</th>
        <th>Pengeluaran</th>
        <th></th>
      </tr>
      </thead>
      <tbody>
      @foreach($data as $row)
      <tr>
        <td>{{ $row['date'] }}</td>
        <td>{{ $row['sale'] }}</td>
        <td>{{ $row['purchase'] }}</td>
        <td>{{ $row['expense'] }}</td>
      </tr>
      @endforeach
      </tbody>
    </table>