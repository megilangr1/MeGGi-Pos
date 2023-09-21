<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Pemesanan - {{ $data['FNO_PO'] ?? '-' }}</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
      }

      .table {
        width: 100%;
      }

      .text-center {
        text-align: center !important;
      }
      
      .double-line {
        border-bottom: solid 3px #000 !important;
        padding-bottom: 1px !important;
      }

      .logo {
        max-width: 100% !important;
      }

      .kop-surat {
        font-family: 'Times New Roman', Times, serif;
      }
      
      .main-title {
        margin: 4px 0px 8px 0px;
        word-spacing: 2px;
      }
      
      .main-content {
        padding: 0px 20px !important;
      }

      .fw-bold {
        font-weight: bold !important;
      }

      .td-all {
        border: solid 1px #000;
      }

      .td-t {
        border-top-width: 1px !important;
        border-top-style: solid !important;
        border-top-color: rgb(0, 0, 0) !important;
      }

      .td-r {
        border-right-width: 1px !important;
        border-right-style: solid !important;
        border-right-color: rgb(0, 0, 0) !important;
      }

      .td-b {
        border-bottom-width: 1px !important;
        border-bottom-style: solid !important;
        border-bottom-color: rgb(0, 0, 0) !important;
      }

      .td-l {
        border-left-width: 1px !important;
        border-left-style: solid !important;
        border-left-color: rgb(0, 0, 0) !important;
      }

      .py-3 {
        padding-top: 12px !important;
        padding-bottom: 12px !important;
      }

      .py-2 {
        padding-top: 8px !important;
        padding-bottom: 8px !important;
      }

      .py-1 {
        padding-top: 4px !important;
        padding-bottom: 4px !important;
      }

      .px-1 {
        padding-left: 6px !important;
        padding-right: 6px !important;
      }

      .text-sm {
        font-size: 12px !important;
      }

      .text-ss {
        font-size: 11px !important;
      }

      .text-xs {
        font-size: 8px !important;
      }

      .align-top {
        vertical-align: top!important;
      }

      .align-middle {
        vertical-align: middle!important;
      }

      .text-right {
        text-align: right !important;
      }
    </style>
  </head>
  <body>
    <table class="table">
      <tr>
        <td class="text-center" width="15%"><img src="{{ asset('images/logo-removebg-preview.png') }}" alt="Logo Universal" class="logo"></td>
        <td class="kop-surat" style="padding-left: 14px !important;">
          <b style="font-size: 16px !important;">
            PT. Universal
            <br>
            Indo Gemilang
          </b>
        </td>
      </tr>
      <tr>
        <td class="text-center" colspan="2">
          <hr class="double-line">
        </td>
      </tr>
    </table>

    <h4 class="text-center main-title">Purchase Order / Pemesanan</h4>

    <div class="main-content">
      <table class="table text-ss" style="border-spacing: 0px !important; margin-bottom: 10px !important;">
        <tr>
          <td width="40%">
            <b>Sukabumi</b>, {{ $data['FTGL_PO'] ?? '-' }}
            <br><br>
            <b>{{ $data['FNO_PO'] ?? '-' }}</b>
            <hr style="margin-bottom: 12px !important;">
          </td>
          <td width="60%"></td>
        </tr>
        <tr>
          <td colspan="2">
            <b>Kepada Yth,</b>
            <br><br>
            {{ $data['FN_SUP'] }}
            <br>
            <b>Up :</b> {{ $data['FCONTACT'] }}
            
            <br><br>
            Dengan Hormat, <br>
            Berikut ini daftar pesanan kami berdasarkan konfirmasi via telepon :
          </td>
        </tr>
      </table>

      <table class="table text-ss" style="border-collapse: collapse;">
        <thead>
          <tr>
            <th class="py-2 td-b td-t td-l">No</th>
            <th class="py-2 td-b td-t">Deskripsi</th>
            <th class="py-2 td-b td-t">QTY</th>
            <th class="py-2 td-b td-t">Satuan</th>
            <th class="py-2 td-b td-t">Unit Price</th>
            <th class="py-2 td-b td-t td-r">Total</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($data['PO_BRG'] as $key => $item)
            <tr>
              <td class="py-2 td-b text-center">{{ $loop->iteration }}</td>
              <td class="py-2 td-b text-center">{{ $item['FN_BRG_SUP'] }}</td>
              <td class="py-2 td-b text-right">{{ $item['FQ_PO'] }}</td>
              <td class="py-2 td-b text-center">{{ $item['FN_SAT'] }}</td>
              <td class="py-2 td-b text-center">Rp. {{ number_format($item['FHARGA'], 0, ',', '.') }}</td>
              <td class="py-2 td-b text-center">Rp. {{ number_format($item['FSUB_TOTAL'], 0, ',', '.') }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="6">Tidak Ada Data Barang</td>
            </tr>
          @endforelse
          <tr>
            <td colspan="4"></td>
            <td class="py-2 text-center"><b>TOTAL</b></td>
            <td class="py-2 text-center">Rp. {{ number_format($data['TOTAL_PO'], 0, ',', '.') }}</td>
          </tr>
        </tbody>
      </table>

      <table class="table text-ss" style="border-spacing: 0px !important; margin-bottom: 10px !important;">
        <tr>
          <td colspan="2">
            <b>NOTE : </b>
            <br><br>
            {!! $data['FKET'] !!}
          </td>
        </tr>
        <tr>
          <td width="40%">
            PT Universal Indo Gemilang <br>
            Jl. R.H. Didi Sukardi No. 199 - 201 <br>
            Sukabumi - Indonesia <br>
            Telp : (0266) 6253401, 211521, 224519, 222398 <br>
            NPWP : 01.477.334.5-441.000 <br><br>
            Atas kerjasama yang baik, kami ucapkan terima kasih <br><br><br><br>


            Admin Administrasi Universal <br><br>

            <div class="text-xs">
              <b>
                Factory <br>
                Jl. R.H. Didi Sukardi No. 201 Sukabumi, Indonesia <br>
                Phone (0266) 6253401, 211521, 224519, 222398
              </b>
            </div>
          </td>
          <td width="60%"></td>
        </tr>
      </table>

    </div>

    <div class="footer text-ss text-center" style="margin-top: 12px !important;">
      <i>Dicetak Menggunakan Aplikasi Inventory Management Pada Tanggal {{ $data['printDate'] ?? '-' }} - PT. Universal Indo Gemilang</i>
    </div>
</body>
</html>