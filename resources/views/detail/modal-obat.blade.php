<div class="modal fade bd-example-modal-sm" id="modal-obat" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="mySmallModalLabel">Form Input Obat</h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ url("medical/".$data->medical_id."/saveobat") }}" enctype="multipart/form-data" id="form-obat">
                @csrf
                <input type="hidden" name="_method" id="method_desc" value="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="col-form-label">
                                Nama Obat <span class="text-danger"> *</span>
                            </label>
                            <select class="js-example-basic-single form-control" id="medicine_id" name="medicine_id">
                                @foreach($obat as $key => $value)
                                <option value="{{ $value->medicine_id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label class="col-form-label">
                                Jumlah Obat <span class="text-danger"> *</span>
                            </label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Masukan jumlah obat">

                        </div>

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