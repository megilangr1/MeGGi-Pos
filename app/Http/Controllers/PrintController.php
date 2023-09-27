<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Pdf;

class PrintController extends Controller
{
    public function cetakPo($id)
    {
        try {
            $getData = PurchaseOrder::with([
                'detail',
                'detail.relasi_supplier',
                'detail.relasi_supplier.barang',
                'detail.relasi_supplier.barang.satuan',
                'supplier',
            ])->where('FNO_PO', '=', $id)->firstOrFail();

            $data = [
                'FNO_PO' => $getData->FNO_PO,
                'FTGL_PO' => date('d F Y', strtotime($getData->FTGL_PO)),
                'FN_SUP' => $getData->supplier->FNA_SUP,
                'FCONTACT' => $getData->supplier->FCONTACT,
                'FKET' => $getData->FKET != null ? $getData->FKET : '-',
                'TOTAL_PO' => 0,

                'PO_BRG' => [],

                'printDate' => Carbon::now()->format('d/m/Y H:i:s')
            ];
            foreach ($getData->detail as $key => $value) {
                $subTotal = (double) $value->FHARGA * (double) $value->FQ_PO;
                $data['TOTAL_PO'] += $subTotal;

                $data['PO_BRG'][$value->FKD_RLS] = [
                    'FKD_RLS' => $value->relasi_supplier->FKD_RLS,
                    'FN_BRG' => $value->relasi_supplier->barang->FN_BRG,
                    'FN_BRG_SUP' => $value->relasi_supplier->FN_BRG_SUP,
                    'FN_SAT' => $value->relasi_supplier->barang->satuan->FN_SAT,

                    'FQ_PO' => $value->FQ_PO,
                    'FHARGA' => $value->FHARGA,
                    'FSUB_TOTAL' => $subTotal,
                ];
            }

            $print = Pdf::loadview('backend.print.cetak-po', [
                'data' => $data 
            ]);
            return $print->stream('Pemesanan-' . $data['FNO_PO'] . '.pdf');
        } catch (\Exception $e) {
            dd($e);
            abort(404);
        }
    }
}
