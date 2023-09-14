<?php

namespace App\Http\Livewire\MasterData;

use App\Models\Barang;
use Livewire\Component;
use Livewire\WithPagination;

class BarangModalData extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $source = null;
    public $supplier = null;

    protected $listeners = [
        'openModalBarang'
    ];

    public function render()
    {
        $getData = new Barang();

        if ($this->supplier != null) {
            $getData = $getData->with('relasiSupplier');
            $getData = $getData->whereHas('relasiSupplier', function($q) {
                $q->where('FK_SUP', '=', $this->supplier);
            });
        }

        $getData = $getData->orderBy('FK_BRG', 'ASC')->paginate(10);

        return view('livewire.master-data.barang-modal-data', [
            'dataBarang' => $getData
        ]);
    }

    public function openModalBarang($data)
    {
        $this->reset('source');

        $this->source = $data['source'] ?? null;
        $showProps = $data['showProps'] ?? 'hide';

        $this->supplier = $data['FK_SUP'] ?? null;

        $this->emit('modal-barang', $showProps);
    }

    public function pilihSupplier($id)
    {
        try {
            $getData = Barang::where('FK_BRG', '=', $id)->firstOrFail();

            if ($this->source != null) {
                $this->emitTo($this->source, 'selectedBarang', $getData->toArray());
            }

            $this->emit('modal-barang', 'hide');
        } catch (\Exception $e) {
            $this->emit('error', 'Terjadi Kesalahan ! <br> Silahkan Hubungi Administrator !');
            dd($e);
        }
    }
}
