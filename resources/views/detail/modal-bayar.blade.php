<div class="modal fade bd-example-modal-sm" id="modal-bayar" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="mySmallModalLabel">Form Input pembayaran tagihan</h4>
            </div>
            <form method="POST" action="" enctype="multipart/form-data" id="form-bayar">
                @csrf
                <div class="modal-body row">

                    <div class="col-md-12 mt-2">
                        <label class="col-form-label">
                            Nominal Bayar <span class="text-danger"> *</span>
                        </label>
                        <input type="number" step="any" class="form-control" id="nominal" name="nominal" placeholder="Masukan Nominal bayar" readonly required>
                        @if($errors->has('nominal'))
                        <label class="text-danger">
                            {{ $errors->first('nominal') }}
                        </label>
                        @else
                        <label class="text-notif">
                            Nominal Bayar {{ StringHelper::getNameMenu() }} berisi nominal uang 
                        </label>
                        @endif
                    </div>

                    <div class="col-md-12 mt-2">
                        <label class="col-form-label">
                            Tanggal Bayar <span class="text-danger"> *</span>
                        </label>

                        <input type="date" class="form-control" id="date" name="date" placeholder="Masukan Nominal bayar" required value="{{ date("Y-m-d") }}">

                        @if($errors->has('date'))
                        <label class="text-danger">
                            {{ $errors->first('date') }}
                        </label>
                        @endif
                    </div>

                    <div class="col-md-12 mt-2">
                        <label class="col-form-label">
                            Metode Bayar <span class="text-danger"> *</span>
                        </label>

                        <select class="form-control" required id="method" name="method" required>
                            <option value="">-- Pilih Metode --</option>
                            @foreach($metode as $key => $value)
                            <option value="{{ $key }}">{{ ucfirst($value) }}</option>
                            @endforeach
                        </select>

                        @if($errors->has('method'))
                        <label class="text-danger">
                            {{ $errors->first('method') }}
                        </label>
                        @endif
                    </div>

                    <div class="col-md-12 mt-2">
                        <label class="col-form-label">
                            Nama Bayar
                        </label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukan nama bayar" maxlength="100">
                        @if($errors->has('name'))
                        <label class="text-danger">
                            {{ $errors->first('name') }}
                        </label>
                        @endif
                    </div>

                    <div class="col-md-12 mt-2">
                        <label class="col-form-label">
                            Nomor Referensi 
                        </label>
                        <input type="text" class="form-control" id="number" name="number" placeholder="Masukan no referensi bayar" maxlength="100">
                        @if($errors->has('number'))
                        <label class="text-danger">
                            {{ $errors->first('number') }}
                        </label>
                        @endif
                    </div>

                </div>
                <div class="modal-footer mt-2">
                    <button type="submit" class="btn btn-sm btn-success">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i> Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>