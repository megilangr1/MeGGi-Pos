<div>
  <div class="row">
    <div class="col-12">
      <div class="card card-outline card-primary">
        <div class="card-header">
          <h4 class="card-title">
            <span class="fa fa-truck mr-3"></span>
            Daftar Data Pemesanan
          </h4>

          <div class="card-tools">
            <a href="{{ route('backend.purchase-order.create') }}" class="btn btn-xs btn-success px-3">
              <span class="fa fa-plus mr-2"></span>
              Buat Data Pemesanan
            </a>
          </div>
        </div>

        <div class="card-body p-0 table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="align-middle px-2 py-2 text-center">No.</th>
                <th class="align-middle px-2 py-2 text-center">Kode Jenis</th>
                <th class="align-middle px-2 py-2 text-center">Nama Jenis</th>
                <th class="align-middle px-2 py-2 text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($dataPo as $item)
                <tr>
                  <td class="align-middle px-2 py-1 text-center">
                    {{ ($dataPo->currentpage()-1) * $dataPo->perpage() + $loop->index + 1 }}.
                  </td>
                  <td class="align-middle px-2 py-1 text-center">{{ $item->FK_JENIS }}</td>
                  <td class="align-middle px-2 py-1 text-center">{{ $item->FN_JENIS }}</td>
                  <td class="align-middle px-2 py-1 text-center">
                    <div class="btn-group">
                      <button class="btn btn-xs btn-warning px-3" wire:click="editData('{{ $item->FK_JENIS }}')">
                        <span class="fa fa-edit"></span>
                      </button>
                      <button class="btn btn-xs btn-danger px-3" wire:click="deleteData('{{ $item->FK_JENIS }}')">
                        <span class="fa fa-trash"></span>
                      </button>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td class="align-middle text-center" colspan="4">Belum Ada Data Jenis</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="card-footer">
          <div class="float-right">
            {{ $dataPo->links() }}
          </div>
        </div>

      </div>
    </div>
  </div>
</div>