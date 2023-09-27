<?php

namespace App\Http\Livewire\PurchaseOrder;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MainForm extends Component
{
    public $po = [];

    public $supplier = [];

    public $state = [];
    public $params = [
        'FNO_PO' => null,
        'FTGL_PO' => null,
        'FK_SUP' => null,
        'TEXT_SUP' => null,
        'FKET' => null,

        'PO_BRG' => [],
        'TOTAL_PO' => 0
    ];

    protected $listeners = [
        'selectedSupplier',
        'selectedBarang',
    ];

    public function updatedState($value, $key)
    {
        $ex = explode('.', $key);
        if (isset($ex[2]) && $ex[2] == 'FQ_PO') {
            $this->state[$ex[0]][$ex[1]][$ex[2]] = max($this->state[$ex[0]][$ex[1]][$ex[2]], 1);
            $this->calcSubTotal($ex[1]);
        }

        if (isset($ex[2]) && $ex[2] == 'FHARGA') {
            $this->state[$ex[0]][$ex[1]][$ex[2]] = max($this->state[$ex[0]][$ex[1]][$ex[2]], 0);
            $this->calcSubTotal($ex[1]);
        }

        if ($key == 'FNO_PO') {
            $this->state[$key] = str_replace(' ', '', $value); 
        }
    }

    public function calcSubTotal($key)
    {
        $qty = (double) $this->state['PO_BRG'][$key]['FQ_PO'];
        $harga = (double) $this->state['PO_BRG'][$key]['FHARGA'];

        $this->state['PO_BRG'][$key]['FSUB_TOTAL'] = (double) $qty * (double) $harga;
        $this->calcTotal();
    }

    public function calcTotal()
    {
        $this->state['TOTAL_PO'] = array_sum(array_column($this->state['PO_BRG'], 'FSUB_TOTAL'));
    }

    public function mount($id = null)
    {
        $this->state = $this->params;
        if ($id != null) {
            try {
                $getData = PurchaseOrder::with([
                    'detail',
                    'supplier',
                    'detail.relasi_supplier',
                    'detail.relasi_supplier.barang',
                    'detail.relasi_supplier.barang.satuan'
                ])->where('FNO_PO', '=', $id)->firstOrFail();

                $this->po = $getData->toArray();
                $this->supplier = $getData->supplier->toArray();

                $this->state['FNO_PO'] = $getData->FNO_PO;
                $this->state['FTGL_PO'] = date('Y-m-d', strtotime($getData->FTGL_PO));
                $this->state['FK_SUP'] = $getData->FK_SUP;
                $this->state['TEXT_SUP'] = $getData->FK_SUP . ' - ' . $getData->FNA_SUP . ' | ' . ($getData->FNOTELP != null ? $getData->FNOTELP:'-') . ' | ' . ($getData->FCONTACT != null ? $getData->FCONTACT:'-');
                $this->state['FKET'] = $getData->FKET;
                $this->state['TOTAL_PO'] = 0;

                foreach ($getData->detail as $key => $value) {
                    $subTotal = (double) $value->FHARGA * (double) $value->FQ_PO;
                    $this->state['TOTAL_PO'] += $subTotal;

                    $this->state['PO_BRG'][$value->FKD_RLS] = [
                        'FKD_RLS' => $value->relasi_supplier->FKD_RLS,
                        'FN_BRG' => $value->relasi_supplier->barang->FN_BRG,
                        'FN_BRG_SUP' => $value->relasi_supplier->FN_BRG_SUP,
                        'FN_SAT' => $value->relasi_supplier->barang->satuan->FN_SAT,

                        'FQ_PO' => $value->FQ_PO,
                        'FHARGA' => $value->FHARGA,
                        'FSUB_TOTAL' => $subTotal,
                    ];
                }
            } catch (\Exception $e) {
                abort(404);
                dd($e);
            }
        }
    }

    public function render()
    {
        return view('livewire.purchase-order.main-form');
    }

    public function openModalSupplier()
    {
        $this->emitTo('master-data.supplier-modal-data', 'openModalSupplier', [
            'showProps' => 'show',
            'source' => 'purchase-order.main-form'
        ]);
    }

    public function selectedSupplier($data)
    {
        if ($data != null) {
            $this->reset('supplier');

            $this->supplier = $data;
            $this->state['FK_SUP'] = $data['FK_SUP'];
            $this->state['TEXT_SUP'] = $data['FK_SUP'] . ' - ' . $data['FNA_SUP'] . ' | ' . ($data['FNOTELP'] != null ? $data['FNOTELP']:'-') . ' | ' . ($data['FCONTACT'] != null ? $data['FCONTACT']:'-');

            $this->state['PO_BRG'] = [];
        }
    }

    public function resetSupplier()
    {
        $this->reset('supplier');
        $this->state['FK_SUP'] = null;
        $this->state['TEXT_SUP'] = null;
    }
    
    
    public function openModalBarang()
    {
        if ($this->supplier != null) {
            $this->emitTo('master-data.barang-modal-data', 'openModalBarang', [
                'showProps' => 'show',
                'source' => 'purchase-order.main-form',
                'FK_SUP' => $this->supplier['FK_SUP'],
            ]);
        } else {
            $this->emit('error', 'Silahkan Pilih Supplier Terlebih Dahulu Untuk Menambahkan Data Barang Pemesanan !');
        }
    }

    public function selectedBarang($data)
    {
        if ($data != null) {
            if (isset($data['relasi_supplier'])) {
                $this->state['PO_BRG'][$data['relasi_supplier']['FKD_RLS']] = [
                    'FKD_RLS' => $data['relasi_supplier']['FKD_RLS'],
                    'FN_BRG' => $data['FN_BRG'],
                    'FN_BRG_SUP' => $data['relasi_supplier']['FN_BRG_SUP'],
                    'FN_SAT' => $data['satuan']['FN_SAT'],

                    'FQ_PO' => 1,
                    'FHARGA' => $data['relasi_supplier']['FHARGA_AKHIR'],
                    'FSUB_TOTAL' => $data['relasi_supplier']['FHARGA_AKHIR'],
                    'data' => $data,
                ];

                $this->calcTotal();
            }
        }
    }

    public function removeBarang($key)
    {
        if (isset($this->state['PO_BRG'][$key])) {
            unset($this->state['PO_BRG'][$key]);
        }
    }

    public function createData()
    {
        $this->validate([
            'state.FNO_PO' => 'required|string|unique:purchase_orders,FNO_PO',
            'state.FTGL_PO' => 'required|date',
            'state.FK_SUP' => 'required|exists:suppliers,FK_SUP',
            'state.FKET' => 'nullable|string',

            'state.PO_BRG' => 'required|array',
        ], [
            'required' => 'Data / Input Tidak Boleh Kosong !',
            'string' => 'Input Harus Berupa Alphanumerik !',
            'exists' => 'Data Tidak Valid ! Silahkan Pilih Ulang Data !',
            'array' => 'Data Tidak Valid ! Silahkan Refresh Ulang Halaman !',
            'unique' => 'Kode Dengan Input Tersebut Sudah Ada !',
        ]);

        DB::beginTransaction();
        try {
            $getSupplier = Supplier::where('FK_SUP', '=', $this->state['FK_SUP'])->firstOrFail();

            $createHeader = PurchaseOrder::create([
                'FNO_PO' => $this->state['FNO_PO'],
                'FTGL_PO' => $this->state['FTGL_PO'],
                'FK_SUP' => $this->state['FK_SUP'],
                'FKET' => $this->state['FKET'],
            ]);

            foreach ($this->state['PO_BRG'] as $key => $value) {
                $createDetail = PurchaseOrderDetail::create([
                    'FNO_REF' => $createHeader->FNO_PO . '-' . $key,
                    'FNO_PO' => $createHeader->FNO_PO,
                    'FKD_RLS' => $key,
                    'FHARGA' => $value['FHARGA'],
                    'FQ_PO' => $value['FQ_PO'],
                ]);
            }

            DB::commit();
            // $this->emit('success', 'Data Pemesanan Barang di-Buat !');
            session()->flash('success', 'Data Pemesanan Barang di-Buat !');
            return redirect(route('backend.purchase-order.index'));
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }
    }

    public function updateData()
    {
        $this->validate([
            'state.FNO_PO' => 'required|string|unique:purchase_orders,FNO_PO,' . $this->po['FNO_PO'] . ',FNO_PO',
            'state.FTGL_PO' => 'required|date',
            'state.FK_SUP' => 'required|exists:suppliers,FK_SUP',
            'state.FKET' => 'nullable|string',

            'state.PO_BRG' => 'required|array',
        ], [
            'required' => 'Data / Input Tidak Boleh Kosong !',
            'string' => 'Input Harus Berupa Alphanumerik !',
            'exists' => 'Data Tidak Valid ! Silahkan Pilih Ulang Data !',
            'array' => 'Data Tidak Valid ! Silahkan Refresh Ulang Halaman !',
            'unique' => 'Kode Dengan Input Tersebut Sudah Ada !',
        ]);

        DB::beginTransaction();
        try {
            $getSupplier = Supplier::where('FK_SUP', '=', $this->state['FK_SUP'])->firstOrFail();
            $getPo = PurchaseOrder::where('FNO_PO', '=', $this->po['FNO_PO'])->firstOrFail();

            $updateHeader = $getPo->update([
                'FNO_PO' => $this->state['FNO_PO'],
                'FTGL_PO' => $this->state['FTGL_PO'],
                'FK_SUP' => $this->state['FK_SUP'],
                'FKET' => $this->state['FKET'],
            ]);

            $deleteDetail = $getPo->detail()->delete();
            foreach ($this->state['PO_BRG'] as $key => $value) {
                $checkDetail = PurchaseOrderDetail::onlyTrashed()->where('FNO_REF', '=', $getPo->FNO_PO . '-' . $key)->first();
                if ($checkDetail != null) {
                    $restoreDeleted = $checkDetail->restore();
                    $updateDetail = $checkDetail->update([
                        'FNO_PO' => $getPo->FNO_PO,
                        'FKD_RLS' => $key,
                        'FHARGA' => $value['FHARGA'],
                        'FQ_PO' => $value['FQ_PO'],
                    ]);
                } else {
                    $createDetail = PurchaseOrderDetail::create([
                        'FNO_REF' => $getPo->FNO_PO . '-' . $key,
                        'FNO_PO' => $getPo->FNO_PO,
                        'FKD_RLS' => $key,
                        'FHARGA' => $value['FHARGA'],
                        'FQ_PO' => $value['FQ_PO'],
                    ]);
                }
            }

            DB::commit();
            // $this->emit('success', 'Data Pemesanan Barang di-Buat !');
            session()->flash('info', 'Data Pemesanan Barang di-Ubah !');
            return redirect(route('backend.purchase-order.index'));
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }
    }
}
