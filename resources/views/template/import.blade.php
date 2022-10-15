<div class="modal fade" id="modal-import" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" style="margin-left: 7%; font-weight: bold;">Silahkan Pilih File Yang Di import</h4>
        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <form method="POST" action="{{ url("import/".Request::segment(1)) }}" enctype="multipart/form-data">
        <div class="modal-body row">
          @csrf

          <div class="col-md-12">
            <label class="col-form-label">
              File Import <span class="text-danger"> *</span>
            </label>

            <input type="file" name="files" id="files" class="form-control" >

            @if($errors->has('files'))
            <label class="text-danger mt-2">
              {{ $errors->first('files') }}
            </label>
            @else
            <label class="text-muted mt-2">
              File harus file bertype (xls, xlsx, csv)
            </label>
            @endif
          </div>
          <a href="{{ url("import/".Request::segment(1)."/download") }}"><i class="fa fa-download"></i> Download Template</a>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success" id="modal-btn-si">Import</button>
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><i class="fa fa-times"></i> Batal</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
