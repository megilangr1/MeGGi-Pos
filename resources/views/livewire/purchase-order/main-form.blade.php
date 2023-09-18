<div>
  <div class="row">
    <div class="col-12">
      <div class="card card-outline card-primary">
        <div class="card-header">
          <h4 class="card-title">
            <span class="fa fa-truck mr-3 text-sm text-primary"></span>
            Buat Data Pemesanan
          </h4>

          <div class="card-tools">
            <a href="{{ route('backend.purchase-order.index') }}" class="btn btn-xs btn-danger px-3">
              <span class="fa fa-arrow-left mr-2"></span>
              Kembali Ke Halaman Index
            </a>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="row">
            <div class="col-12">
              <div class="row px-3 py-2">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nomor_po">Nomor Pemesanan :</label>
                    <input type="text" wire:model="state.FNO_PO" name="nomor_po" id="nomor_po" class="form-control form-control-sm {{ $errors->has('state.FNO_PO') ? 'is-invalid':'' }}" placeholder="Masukan Nomor Pemesanan..." required>
                    <div class="invalid-feedback">
                      {{ $errors->first('state.FNO_PO') }}
                    </div>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="tanggal_po">Tanggal :</label>
                    <input type="date" wire:model="state.FTGL_PO" name="tanggal_po" id="tanggal_po" class="form-control form-control-sm {{ $errors->has('state.FTGL_PO') ? 'is-invalid':'' }}" required>
                    <div class="invalid-feedback">
                      {{ $errors->first('state.FTGL_PO') }}
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="supplier">Supplier : </label>
                    <div class="input-group input-group-sm">
                      <input type="text" wire:model="state.TEXT_SUP" name="supplier" id="supplier" class="form-control form-control-sm {{ $errors->has('state.FK_SUP') ? 'is-invalid':'' }} borad" placeholder=" - Silahkan Pilih Data Supplier - " disabled>
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
                <div class="col-12">
                  <div class="form-group">
                    <label for="keterangan">Keterangan : </label>
                    <textarea wire:model="state.FKET" name="keterangan" id="keterangan" cols="1" rows="1" class="form-control form-control-sm {{ $errors->has('state.FKET') ? 'is-invalid':'' }}" placeholder="Silahkan Masukan Keterangan..."></textarea>
                    <div class="invalid-feedback">
                      {{ $errors->first('state.FKET') }}
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12">
              <h6 class="font-weight-bold bg-info text-white py-2 px-4 mb-1" wire:click="$refresh">
                <span class="fa fa-boxes mr-3"></span>
                Barang Pemesanan 
              </h6>
            </div>

            <div class="col-12 table-responsive">
              <table class="table table-bordered m-0">
                <thead>
                  @if ($errors->has('state.PO_BRG'))
                    <tr>
                      <td colspan="6" class="bg-danger py-1 px-3 text-xs">Data Barang Tidak Boleh Kosong !</td>
                    </tr>
                  @endif
                  <tr>
                    <th class="align-middle px-2 py-2 text-center" width="5%">No.</th>
                    <th class="align-middle px-2 py-2 text-center" width="35%">Nama Barang</th>
                    <th class="align-middle px-2 py-2 text-center" width="15%">Jumlah</th>
                    <th class="align-middle px-2 py-2 text-center" width="15%">Harga</th>
                    <th class="align-middle px-2 py-2 text-center">Sub Total</th>
                    <th class="align-middle px-2 py-2 text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($state['PO_BRG'] as $key => $item)
                    <tr>
                      <td class="align-middle px-2 py-2 text-center">{{ $loop->iteration }}</td>
                      <td class="align-middle px-2 py-2 text-center">{{ $item['FN_BRG'] }}</td>
                      <td class="align-middle px-2 py-2 text-center">
                        <div class="input-group input-group-sm">
                          <input type="number" wire:model="state.PO_BRG.{{ $key }}.FQ_PO" name="qty_{{ $key }}" id="qty_{{ $key }}" class="form-control form-control-sm text-center {{ $errors->has('state.PO_BRG.'. $key .'.FQ_PO') ? 'is-invalid':'' }}" required placeholder="0" style="border-radius: 0px !important;">
                          <div class="input-group-append">
                            <span class="input-group-text">{{ $item['FN_SAT'] }}</span>
                          </div>
                          <div class="invalid-feedback">
                            {{ $errors->first('state.PO_BRG.'. $key .'.FQ_PO') }}
                          </div>
                        </div>
                      </td>
                      <td class="align-middle px-2 py-2 text-center">
                        <div class="input-group input-group-sm">
                          <div class="input-group-prepend">
                            <span class="input-group-text">Rp.</span>
                          </div>
                          <input type="number" wire:model="state.PO_BRG.{{ $key }}.FHARGA" name="qty_{{ $key }}" id="qty_{{ $key }}" class="form-control form-control-sm text-center {{ $errors->has('state.PO_BRG.'. $key .'.FHARGA') ? 'is-invalid':'' }}" required placeholder="0">
                          <div class="invalid-feedback">
                            {{ $errors->first('state.PO_BRG.'. $key .'.FHARGA') }}
                          </div>
                        </div>
                      </td>
                      <td class="align-middle px-2 py-2 text-center">Rp. {{ number_format($item['FSUB_TOTAL'], 0, ',', '.') }}</td>
                      <td class="align-middle px-2 py-2 text-center">
                        <button class="btn btn-xs btn-danger px-3" wire:click="removeBarang('{{ $key }}')">
                          <span class="fa fa-trash"></span>
                        </button>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="6">Belum Ada Data Barang</td>
                    </tr>
                  @endforelse
                  @if (count($state['PO_BRG']) > 0)
                    <tr>
                      <td class="align-middle px-2 py-2 text-right font-weight-bold" colspan="4">
                        Total :
                      </td>
                      <td class="align-middle px-2 py-2 text-center font-weight-bold">Rp. {{ number_format($state['TOTAL_PO'], 0, ',', '.') }}</td>
                    </tr>
                  @endif
                  <tr>
                    <td colspan="6" class="align-middle p-0 text-center">
                      <button class="btn btn-info btn-xs btn-block px-3 py-1 borad" wire:click="openModalBarang">
                        <i class="fas fa-plus"></i> &ensp; Klik Untuk Menambah Data Barang Pemesanan
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="col-md-4">
              <button class="btn btn-sm btn-block btn-success" wire:click="dummy">
                <span class="fa fa-check mr-2"></span>
                Buat Data Pemesanan
              </button>
            </div>
            <div class="col-md-4">
              <button class="btn btn-sm btn-block btn-danger">
                <span class="fa fa-times mr-2"></span>
                Batalkan Pembuatan Data
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @livewire('master-data.supplier-modal-data')
  @livewire('master-data.barang-modal-data')
</div>
