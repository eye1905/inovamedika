@extends("template.layout")
@section("content")
<div class="card">
  <div class="card-body">
    @include("template.page-name")
    @include("template.notif")
    <div class="row">
      <div class="col-md-2">
        <div class="col-md-12">
          <label class="col-form-label">
            <b>
              Gambar Paket
            </b>
          </label>
          <br>
          <img class="img-thumbnail" src="@if(isset($data->pictures) and $data->pictures != null){{ $data->pictures }}@else{{ asset("images/no-image.png") }}@endif" name="img1" id="img1" width="100%">
        </div>
      </div>
      <div class="col-md-10 row">
        <div class="col-md-6">
          <label class="col-form-label">
            Nama {{ StringHelper::getNameMenu() }}
          </label>
          <input type="text" class="form-control form-edit" value="@if(isset($data->name)){{ $data->name }} @endif">
        </div>
        <div class="col-md-6">
          <label class="col-form-label">
            Jumlah Pertemuan
          </label>
          <input type="text" class="form-control form-edit" value="@if(isset($data->total_meet)){{ $data->total_meet }} @endif">
        </div>
        <div class="col-md-6">
          <label class="col-form-label">
            Harga {{ StringHelper::getNameMenu() }}
          </label>
          <input type="text" class="form-control form-edit" value="@if(isset($data->price)){{ StringHelper::toRupiah($data->price) }} @endif">
        </div>

        <div class="col-md-6">
          <label class="col-form-label">
            Diskon {{ StringHelper::getNameMenu() }}
          </label>
          <input type="text" class="form-control form-edit" value="@if(isset($data->discount_price)){{ StringHelper::toRupiah($data->discount_price) }} @endif">
        </div>

        <div class="col-md-12">
          <label class="col-form-label">
            Deksripsi {{ StringHelper::getNameMenu() }}
          </label>
          <textarea class="form-control form-edit">@if(isset($data->description)){{ $data->description }}@endif</textarea>
        </div>
      </div>
    </div>
    <br>
    @if(Request::segment(3)!="edit" or  Request::segment(2)!="create")
    <div class="row">
      <div class="col-md-6">
        <h4>
          <i class="fa fa-stethoscope"></i> Penggunaan Alat Medis
        </h4>
      </div>
      <div class="col-md-6 text-end">
        <button type="button" onclick="goPopUp()" class="btn btn-sm btn-primary">
          <i class="fa fa-plus"></i> Tambah Alat
        </button>
      </div>
      <div class="col-md-12 table-responsive">
        <table class="table table-hover mt-2">
          <thead class="table-dark">
            <tr>
              <th>
                No
              </th>
              <th>
                Alat
              </th>
              <th>
                Penggunaan
              </th>
              <th>
                Harga
              </th>
              <th>
                Aksi
              </th>
            </tr>
          </thead>
          <tbody>
            <form method="GET" action="#" enctype="multipart/form-data" id="form-select">
              @csrf
              <input type="hidden" name="_method" value="GET">
              @foreach($detail as $key => $value)
              <tr>
                <td>
                  {{ $key+1 }}
                </td>
                <td>
                  @if(isset($value->alat)) {{ ucfirst($value->alat) }} @endif
                </td>
                <td>
                  {{ $value->quantity }} x
                  @if(isset($value->type)) {{ ucfirst($value->type) }} @endif
                </td>
                <td>
                  {{ StringHelper::torupiah($value->price) }}
                </td>
                <td>
                  <button type="button" onclick="CheckDelete('{{ url(Request::segment(1)."/".$value->package_medical_utility."/deletedetail") }}')" class="btn btn-danger btn-sm">
                    <i class="fa fa-times"></i> Hapus
                  </button>
                </td>
              </tr>
              @endforeach
            </tbody>
          </form>
        </table>
      </div>
    </div>

    <div class="modal fade bd-example-modal-sm" id="modal-alat" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="mySmallModalLabel">
              Form Input Alat Paket
            </h4>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="POST" action="{{ url(Request::segment(1)."/".Request::segment(2)."/savedetail") }}" enctype="multipart/form-data" id="form-alat">
            @csrf
            <input type="hidden" name="_method" id="method_desc" value="POST">
            <div class="modal-body">
              <div class="col-md-12 mt-2">
                <label class="col-form-label">
                  Alat Medis <span class="text-danger"> *</span>
                </label>

                <select class="form-control" id="medical_utilities_detail_id" name="medical_utilities_detail_id" required>
                  <option value="">-- Pilih Alat --</option>
                  @foreach($alat as $key => $value)
                  <option value="{{ $value->medical_utilities_detail_id }}">{{ ucfirst($value->alat)." ( ".$value->type." - ".$value->quantity." ) ".StringHelper::toRupiah($value->price) }}</option>
                  @endforeach
                </select>

                @if($errors->has('medical_utilities_detail_id'))
                <label class="text-danger">
                  {{ $errors->first('medical_utilities_detail_id') }}
                </label>
                @endif

              </div>
            </div>
            <div class="modal-footer">
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

    @endif
  </div>
</div>
@endsection

@section("script")
<script type="text/javascript">
  $(".form-edit").attr("readonly", true);
  $(".form-edit").attr("disabled",  true);
  $(".form-edit").css("background-color", "#FFFF");

  function goPopUp() {
    $("#form-alat").attr("action", "{{ url(Request::segment(1)."/".Request::segment(2)."/savedetail") }}");
    $("#modal-alat").modal("show");
    $("#method_desc").val("POST");
  }
</script>
@endsection