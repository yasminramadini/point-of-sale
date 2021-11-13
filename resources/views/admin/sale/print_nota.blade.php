<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Struk Belanja</title>
    <style>
      body {
        padding: 5px;
      }
      
      * {
        padding: 0; margin: 0;
      }
      
      .text-center {
        text-align: center;
      }
      
      .clear {
        clear: both;
      }
      
      @media print {
        @page {
          margin: 0;
          size: 75mm;
        }
      }
      
    </style>
  </head>
  <body>
    
    <div style="margin: 0 auto">
    <div class="text-center" style="margin-top: 10px; font-size: 6pt">
      <h2 style="margin-bottom: 7px; font-size: 10pt"><img src="{{ public_path($setting->logo) }}" style="display: inline-block; margin-right: 5px" width="20px">{{ $setting->company_name }}</h2>
      <p>{{ $setting->company_address }}</p>
      <p>Telp: {{ $setting->company_phone }}</p>
      <p style="margin: 10px 0">No: {{ strtotime($sale->created_at) }} - {{ $sale->id }}</p>
      <p style="float: left;">Tanggal:</p>
      <p style="float: right;">{{ $sale->created_at->locale('ID_id')->isoFormat('Do MMMM YYYY') }}</p>
      <div class="clear"></div>
    </div>
    <div class="text-center" style="margin: 4px 0;">==========================================</div>
    
    <table style="width: 100%; font-size: 6pt">
      @foreach($sale_detail as $row)
      <tr>
        <td>{{ $row->product->name }}</td>
      </tr>
      <tr>
        <td>Rp {{ number_format($row->product->selling_price, 0, ',', '.') }} x {{ $row->qty }}</td>
        <td style="text-align: right;">Rp {{ number_format($row->subtotal, 0, ',', '.') }} @if($row->discount > 0) ({{ $row->discount }}%) @endif</td>
      </tr>
      @endforeach
      <tr>
        <td><b>Diskon member:</b></td>
        <td style="text-align:right;"><b>@if($sale->member_id !== 0) {{ $setting->discount }} @else {{ 0 }} @endif</b></td>
      </tr>
      <tr>
        <td><b>Subtotal:</b></td>
        <td style="text-align: right;"><b>Rp {{ number_format($sale->paid, 0, ',', '.') }}</b></td>
      </tr>
    </table>
    
    <div class="text-center" style="margin: 4px 0;">===========================================</div>
    
    <p class="text-center" style="font-size: 6pt;">-- Terima Kasih --</p>
    </div>
    
    <script>
      window.print()
    </script>
    
  </body>
</html>