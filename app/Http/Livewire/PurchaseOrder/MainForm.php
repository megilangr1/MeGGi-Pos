<?php

namespace App\Http\Livewire\PurchaseOrder;

use Livewire\Component;

class MainForm extends Component
{
    public $supplier = [];
    public $barang = [];

    public $state = [];
    public $params = [
        'FNO_PO' => null,
        'FTGL_PO' => null,
        'FK_SUP' => null,
        'TEXT_SUP' => null,
        'FKET' => null,
    ];

    protected $listeners = [
        'selectedSupplier',
        'selectedBarang',
    ];

    public function mount()
    {
        $this->state = $this->params;
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
        dd($data);

        if ($data != null) {
            $this->reset('barang');
            $this->barang = $data;
            $this->state['FKD_RLS'] = null;
            $this->state['FN_BRG_SUP'] = null;
            $this->state['FHARGA_AKHIR'] = null;

            $this->state['FK_BRG'] = $data['FK_BRG'];
            $this->state['TEXT_BRG'] = $data['FK_BRG'] . ' - ' . $data['FN_BRG'];

            $this->checkRelasiBarang($data['FK_BRG']);
        }
    }

    public function dummy()
    {
        dd($this->state);
    }
}
