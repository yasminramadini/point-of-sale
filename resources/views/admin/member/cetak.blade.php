<!DOCTYPE html>
<html>
  <head>
    <title>Cetak Barcode</title>
  </head>
  <body>
    
    <table style="width: 100%;">
      <tr>
        @foreach($products as $product)
        <td style="text-align: center; border: 1px solid #7C7C7C">
          <p>{{ $product->name }} - Rp {{ Format_uang::angka($product->selling_price) }}</p>
          <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($product->code, 'C39')}}" width="180" height="60"> 
          <p>{{ $product->code }}</p>
        </td>
        @if($no++ % 3 === 0)
        </tr><tr>
        @endif
        @endforeach
      </tr>
    </table>
    
  </body>
</html>