<!DOCTYPE html>
<html>
  <head>
    <title>Cetak Kartu Member</title>
    <style>
      .box {
        position: relative;
        border: 1px solid #7C7C7C;
        text-align: center;
        width: 320px;
        margin: 7px;
        height: 180px;
      }
      
      #logo {
        position: absolute;
        top: 20px;
        left: 40px;
      }
      
      #name {
        position: absolute;
        top: 60px;
        font-weight: bold;
        font-size: 1.2rem;
        left: 10px;
        color: white;
      }
      
      #phone {
        position: absolute;
        top: 135px;
        left: 10px;
        color: white;
      }
      
      #qrcode {
        position: absolute;
        bottom: 10px;
        right: 10px;
      }
    </style>
  </head>
  <body style="padding: 10px">
    
    <table style="width: 100%; margin: 0 auto">
      <tr>
        @foreach($members as $member)
          <td>
            <div class="box">
              <img id="card" src="card.jpg" width="100%">
              <img id="logo" src="logo.png" width="40" height="40">
              <p id="phone">{{ $member->phone }}</p>
              <p id="name">{{ $member->name }}</p>
              <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG($member->code, 'QRCODE') }}" alt="qrcode" height="45" widht="45" id="qrcode">
            </div>
          </td>
          @if($no++ % 2 === 0)
          </tr><tr>
          @endif
        @endforeach
      </tr>
    </table>
    
  </body>
</html>