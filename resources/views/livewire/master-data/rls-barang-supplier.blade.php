<div>
  <div class="row">
    <div class="col-12">
      <div class="card card-outline card-primary">
        <div class="card-header">
          <h4 class="card-title" wire:click="$refresh">
            <span class="fa fa-link text-primary mr-3"></span>
            Relasi Barang Supplier
          </h4>
        </div>

        <div class="card-body py-2">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label for="supplier">Supplier : </label>
                <div class="input-group">
                  <input type="text" wire:model="state.TEXT_SUP" name="supplier" id="supplier" class="form-control {{ $errors->has('state.FK_SUP') ? 'is-invalid':'' }} borad" placeholder=" - Silahkan Pilih Data Supplier - " disabled>
                  <span class="input-group-append">
                    <button type="button" class="btn btn-danger btn-flat" wire:click="resetSupplier">
                      <span class="fa fa-undo"></span>
                    </button>
                    <button type="button" class="btn btn-secondary btn-flat" wire:click="openModalSupplier">Pilih Data Supplier</button>
                  </span>

                  <div class="invalid-feedback">
                    {{ $errors->first('state.FK_SUP') }}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-5">
              <div class="form-group">
                <label for="barang">Kode Barang : </label>
                <div class="input-group input-group-sm">
                  <input type="text" wire:model="state.TEXT_BRG" name="barang" id="barang" class="form-control form-control-sm {{ $errors->has('state.FK_BRG') ? 'is-invalid':'' }}" placeholder=" - Silahkan Pilih Data Barang - " disabled>
                  <span class="input-group-append">
                    @if ($supplier != null)
                      <button type="button" class="btn btn-danger btn-flat" wire:click="resetBarang">
                        <span class="fa fa-undo"></span>
                      </button>
                      <button type="button" class="btn btn-secondary btn-flat" wire:click="openModalBarang">Pilih Data Barang</button>
                    @endif
                  </span>
                  
                  <div class="invalid-feedback">
                    {{ $errors->first('state.FK_BRG') }}
                  </div>
                </div>
                
                @if ($state['FKD_RLS'])
                  <div class="text-xs text-secondary pt-1">
                    * Supplier dan Barang Memiliki Relasi
                  </div>
                @endif
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label for="nama_barang_supplier">Nama Barang Pada Supplier : </label>
                <input type="text" wire:model="state.FN_BRG_SUP" name="nama_barang_supplier" id="nama_barang_supplier" class="form-control form-control-sm {{ $errors->has('state.FN_BRG_SUP') ? 'is-invalid' : '' }}" placeholder="Masukan Nama Barang Supplier..." {{ $supplier != null && $barang != null ? '':'disabled' }} required>

                <div class="invalid-feedback">
                  {{ $errors->first('state.FN_BRG_SUP') }}
                </div>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label for="harga_supplier">Harga Barang Pada Supplier : </label>
                <div class="input-group input-group-sm">
                  <div class="input-group-prepend">
                    <span class="input-group-text font-weight-bold">Rp.</span>
                  </div>
                  <input type="number" wire:model="state.FHARGA_AKHIR" name="harga_supplier" id="harga_supplier" class="form-control form-control-sm {{ $errors->has('state.FHARGA_AKHIR') ? 'is-invalid' : '' }}" placeholder="Masukan Harga Barang Pada Supplier..." {{ $supplier != null && $barang != null ? '':'disabled' }} required>
                  
                  <div class="invalid-feedback">
                    {{ $errors->first('state.FHARGA_AKHIR') }}
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <hr class="mt-0 mb-3">
            </div>

            <div class="col-md-3">
              @if ($state['FKD_RLS'] != null)
                <button class="btn btn-sm btn-success btn-block" wire:click="updateData">
                  <span class="fa fa-check mr-2"></span>
                  Simpan Perubahan Data Relasi
                </button>
              @else
                <button class="btn btn-sm btn-success btn-block" wire:click="createData">
                  <span class="fa fa-check mr-2"></span>
                  Buat Data Relasi
                </button>
              @endif
            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="col-12">
      <div class="card card-outline card-primary">
        <div class="card-header">
          <h4 class="card-title">
            <span class="fa fa-table mr-3"></span>
            Daftar Barang Relasi Supplier
          </h4>
        </div>
        <div class="card-body p-0 table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="align-middle px-2 py-2 text-center">No.</th>
                <th class="align-middle px-2 py-2 text-center">Kode Barang</th>
                <th class="align-middle px-2 py-2 text-center">Nama Barang Pada Supplier</th>
                <th class="align-middle px-2 py-2 text-center">Harga Barang Pada Supplier</th>
                <th class="align-middle px-2 py-2 text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($dataRelasi as $item)
                <tr>
                  <td class="align-middle px-2 py-1 text-center">
                    {{ ($dataRelasi->currentpage()-1) * $dataRelasi->perpage() + $loop->index + 1 }}.
                  </td>
                  <td class="align-middle px-2 py-1 text-center">{{ $item->FK_BRG }}</td>
                  <td class="align-middle px-2 py-1 text-center">{{ $item->FN_BRG_SUP }}</td>
                  <td class="align-middle px-2 py-1 text-center">{{ $item->FHARGA_AKHIR }}</td>
                  <td class="align-middle px-2 py-1 text-center">
                    <div class="btn-group">
                      <button class="btn btn-xs btn-warning px-3" wire:click="editRelasi('{{ $item->FKD_RLS }}')">
                        <span class="fa fa-edit"></span>
                      </button>
                      <button class="btn btn-xs btn-danger px-3" wire:click="deleteRelasi('{{ $item->FKD_RLS }}')">
                        <span class="fa fa-trash"></span>
                      </button>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5">Belum Ada Data Barang</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="card-footer">
          <div class="float-right">
            @if ($dataRelasi != null)
              {{ $dataRelasi->links() }}
            @endif
          </div>
        </div>
      </div>
    </div>

  </div>

  @livewire('master-data.supplier-modal-data')
  @livewire('master-data.barang-modal-data')
</div>