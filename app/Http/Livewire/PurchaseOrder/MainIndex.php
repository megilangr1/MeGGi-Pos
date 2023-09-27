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
        $getData = new PurchaseOrder();
        $getData = $getData->with([
            'supplier'
        ]);
        $getData = $getData->withCount('detail');

        $getData = $getData->orderBy('FNO_PO', 'ASC')->paginate(10);
        return view('livewire.purchase-order.main-index', [
            'dataPo' => $getData
        ]);
    }

    public function deleteData($id)
    {
        DB::beginTransaction();
        try {
            $getData = PurchaseOrder::where('FNO_PO', '=', $id)->firstOrFail();
            $deleteData = $getData->delete();

            DB::commit();
            $this->emit('warning', 'Data di-Hapus !');
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
