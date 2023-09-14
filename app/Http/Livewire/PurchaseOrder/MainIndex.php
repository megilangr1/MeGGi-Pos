<?php

namespace App\Http\Livewire\PurchaseOrder;

use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class MainIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $getData = PurchaseOrder::orderBy('FNO_PO', 'ASC')->paginate(10);

        return view('livewire.purchase-order.main-index', [
            'dataPo' => $getData
        ]);
    }

    public function deleteData($id)
    {
        DB::beginTransaction();
        try {
            $getData = PurchaseOrder::where('FK_JENIS', '=', $id)->firstOrFail();
            $deleteData = $getData->delete();

            DB::commit();
            $this->emit('warning', 'Data di-Hapus !');
            $this->showForm(false);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->emit('error', 'Terjadi Kesalahan ! <br> Silahkan Hubungi Administrator !');
            dd($e);
        }
    }

    public function dummy()
    {
        dd($this->state);
    }

}
