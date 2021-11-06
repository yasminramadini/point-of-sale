<html>
  <head>
    <title>Print Data Pengeluaran</title>
    <style>
      h2 {
        text-align: center;
        margin: 40px 0 20px;
      }
      
      table {
        border-collapse: collapse;
        margin: 30px auto;
      }
      
      table th, table td {
        border: 1px solid #3c3c3c;
        padding: 3px 8px;
      }
    </style>
  </head>
  <body>
    
  <?php
  	header("Content-type: application/vnd-ms-excel");
  	header("Content-Disposition: attachment; filename=data_pengeluaran.xls");
	?>
	
    <h2>Data Pengeluaran</h2>
    <table>
      <tr>
        <th>No</th>
        <th style="width: 20%">Tanggal</th>
        <th style="width: 50%">Deskripsi</th>
        <th style="width: 10%">Nominal</th>
      </tr>
      @foreach($expenses as $expense)
      <tr>
        <td>{{ $no++ }}</td>
        <td>{{ $expense->created_at->locale('id_ID')->isoFormat('Do MMMM YYYY') }}</td>
        <td>{{ $expense->description }}</td>
        <td>Rp {{ number_format($expense->nominal, 0, ',', '.') }}</td>
      </tr>
      @endforeach
    </table>
  </body>
</html>