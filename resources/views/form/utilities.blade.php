@extends("template.layout")
@section("content")
<div class="card">
  <div class="card-body">
    @include("template.page-name")
    @include("template.notif")
    <form method="POST" enctype="multipart/form-data" action="@if(Request::segment(2)=='create'){{ url(Request::segment(1)) }}@else{{ url(Request::segment(1), $data->medical_utility_id) }}@endif">
      @csrf
      @if(Request::segment(3)=="edit")
      {{ method_field("PUT") }}
      @endif
      <div class="row">
        <div class="col-md-4 row">
          <div class="col-md-12 text-center">
            <label class="col-form-label">
              Gambar {{ StringHelper::getNameMenu() }}  (Maksimal 1 Mb | Format: jpg, jpeg, png, svg)
            </label>
            <br>
            <img class="img-thumbnail" src="@if(isset($data->picture) and $data->picture != null){{ $data->picture }}@else{{ asset("images/no-image.png") }}@endif" name="img1" id="img1" style="height: 180px; width: 180px" onclick="$('#gambar').trigger('click'); return false;">
            <input type="file" class="form-edit" id="gambar" name="gambar"/>
            @if($errors->has('gambar'))
            <label class="text-danger">
              {{ $errors->first('gambar') }}
            </label>
            @endif
          </div>
        </div>

        <div class="col-md-8 row">
          <div class="col-md-6">
            <label class="col-form-label">
              Kode {{ StringHelper::getNameMenu() }}<span class="text-danger"> *</span>
            </label>
            <input type="text" value="@if(isset($data->code)){{ $data->code }}@else{{ old('code') }}@endif" class="form-control form-edit" minlength="3" maxlength="50" required id="code" name="code" placeholder="Masukan Kode {{ StringHelper::getNameMenu() }} ...">
            @if($errors->has('code'))
            <label class="text-danger">
              {{ $errors->first('code') }}
            </label>
            @else
            <label class="text-notif">
              Kode {{ StringHelper::getNameMenu() }} berisi huruf, angka dan spasi 3 - 50 Karakter
            </label>
            @endif
          </div>

          <div class="col-md-6">
            <label class="col-form-label">
              Nama {{ StringHelper::getNameMenu() }}<span class="text-danger"> *</span>
            </label>
            <input type="text" value="@if(isset($data->name)){{ $data->name }}@else{{ old('name') }}@endif" class="form-control form-edit" minlength="3" maxlength="50" required id="name" name="name" placeholder="Masukan Nama {{ StringHelper::getNameMenu() }} ...">
            @if($errors->has('name'))
            <label class="text-danger">
              {{ $errors->first('name') }}
            </label>
            @else
            <label class="text-notif">
              Nama {{ StringHelper::getNameMenu() }} berisi huruf, angka dan spasi 3 - 50 Karakter
            </label>
            @endif
          </div>

          <div class="col-md-6">
            <label class="col-form-label">
              Deskripsi
            </label>
            <textarea class="form-control form-edit" id="description" minlength="5" maxlength="100" name="description" placeholder="Masukan Deskripsi">@if(isset($data->description)){{ $data->description }}@else{{ old('description') }}@endif</textarea>
            @if($errors->has('description'))
            <label class="text-danger">
              {{ $errors->first('description') }}
            </label>
            @else
            <label class="text-notif">
              Deskripsi berisi 5 - 100 karakter
            </label>
            @endif
          </div>

           <div class="col-md-6">
            <label class="col-form-label">
              Mitra
            </label>

            <select class="js-example-basic-single col-sm-12" id="partner_id" name="partner_id" required>
              <option value="">-- Pilih Mitra --</option>
              @foreach($mitra as $key => $value)
              <option value="{{ $value->partner_id }}">{{ StringHelper::ucsplit($value->name) }}</option>
              @endforeach
            </select>

            @if($errors->has('partner_id'))
            <label class="text-danger">
              {{ $errors->first('partner_id') }}
            </label>
            @endif
          </div>

        </div>
        @if(Request::segment(3)=="edit" or  Request::segment(2)=="create")
        <div class="col-md-12 mt-2 text-end">
          @include("template.action")
        </div>
        @endif
      </div>
    </form>
    @if(Request::segment(3)!="edit" and  Request::segment(2)!="create")
    <div class="row">
      <hr>
      <div class="col-md-6">
        <h4>
          <i class="fa fa-eye"></i> Satuan Penggunaan Alat
        </h4>
      </div>
      <div class="col-md-12 table-responsive">
        <table class="table table-hover mt-2">
          <thead class="table-dark">
            <tr>
              <th>
                No
              </th>
              <th>
                Satuan
              </th>
              <th>
                Jumlah
              </th>
              <th>
                Harga
              </th>
              <th>
                Aksi
              </th>
            </tr>
          </thead>
          <form method="POST" action="{{ url(Request::segment(1)."/".Request::segment(2)."/savedetail") }}" enctype="multipart/form-data" id="form-detail">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <tbody>
              @foreach($detail as $key => $value)
              <tr>
                <td>
                  {{ $key+1 }}
                </td>
                <td>
                  @if(isset($value->type->name)) {{ ucfirst($value->type->name) }} @endif
                </td>
                <td>
                  {{ $value->quantity }}
                </td>
                <td>
                  {{ StringHelper::torupiah($value->price) }}
                </td>
                <td>
                  <button type="button" onclick="goEdit('{{ $value->medical_utilities_detail_id }}','{{ $value->medical_utilities_unit_id }}','{{ $value->quantity }}', '{{ $value->price }}')" class="btn btn-warning btn-sm">
                    <i class="fa fa-save"></i> Edit
                  </button>
                  <button type="button" onclick="goHapus('{{ $value->medical_utilities_detail_id }}')" class="btn btn-danger btn-sm">
                    <i class="fa fa-times"></i> Hapus
                  </button>
                </td>
              </tr>
              @endforeach
              <tr>
                <td>
                </td>
                <td>
                  <select  name="medical_utilities_unit_id" placeholder="Masukan jumlah" id="medical_utilities_unit_id" class="form-control" required>
                    <option value="">-- Pilih Satuan Penggunaan --</option>
                    @foreach($type as $key => $value)
                    <option value="{{ $value->medical_utilities_unit_id }}">{{ ucfirst($value->name) }}</option>
                    @endforeach
                  </select>
                  @if($errors->has('medical_utilities_unit_id'))
                  <label class="text-danger">
                    {{ $errors->first('medical_utilities_unit_id') }}
                  </label>
                  @endif
                </td>
                <td>
                  <input type="number" step="quantity" name="quantity" placeholder="Masukan jumlah" required onKeyPress="if(this.value.length==11) return false;" id="quantity" value="{{ old("quantity") }}" class="form-control">
                  @if($errors->has('quantity'))
                  <label class="text-danger">
                    {{ $errors->first('quantity') }}
                  </label>
                  @endif
                </td>
                <td>
                  <input type="number" step="any" name="price" placeholder="Masukan harga" value="{{ old("price") }}" required onKeyPress="if(this.value.length==20) return false;" id="price" class="form-control">
                  @if($errors->has('price'))
                  <label class="text-danger">
                    {{ $errors->first('price') }}
                  </label>
                  @endif
                </td>
                <td>
                  <button type="button" onclick="goSave()" class="btn btn-success btn-sm">
                    <i class="fa fa-save"></i> Simpan
                  </button>
                  <button type="button" onclick="goBatal()" class="btn btn-warning btn-sm">
                    <i class="fa fa-save"></i> Batal
                  </button>
                </td>
              </tr>
            </tbody>
          </form>

        </table>
      </div>
    </div>
    @endif
  </div>
</div>
@endsection
@section("script")
<script src="{{ URL::asset('js/select2/select2.full.min.js') }}"></script>
<script src="{{ URL::asset('js/select2/select2-custom.js') }}"></script>
<script type="text/javascript">
  $("#gambar").hide();
  $("#gambar").on("change",function(e){
    if (this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#img1').attr('src', e.target.result);
      }
      reader.readAsDataURL(this.files[0]);
      $("#img1").css({ 'height': '180px', 'width': '180px' });
    }
  });

  @if(Request::segment(3)==null and  Request::segment(2)!='create')
  $(".form-edit").attr("readonly", true);
  $(".form-edit").attr("disabled",  true);
  $(".form-edit").css("background-color", "#FFFF");
  @else
  $(".form-edit").removeAttr("readonly");
  $(".form-edit").removeAttr("disabled");
  @endif

  @if(old("partner_id")!=null)
  $("#partner_id").val('{{ old("partner_id") }}');
  @elseif(isset($data->partner_id))
  $("#partner_id").val('{{ $data->partner_id }}');
  @endif
  
  function goEdit(id, jenis, jumlah, price) {
    $("#price").val(price);
    $("#quantity").val(jumlah);
    $("#medical_utilities_unit_id").val(jenis);
    $("#form-detail").attr("action", "{{ url(Request::segment(1)) }}/"+id+"/updatedetail");
  }

  function goBatal() {
    $("#price").val('');
    $("#quantity").val('');
    $("#medical_utilities_unit_id").val('');
    $("#form-detail").attr("action", "{{ url(Request::segment(1)."/".Request::segment(2)."/savedetail") }}");
  }

  function goSave() {
    $("#form-detail").submit();
  }

  function goHapus(id) {
    $("#form-detail").attr("action", "{{ url(Request::segment(1)) }}/"+id+"/deletedetail");
    $("#form-detail").submit();
  }

</script>
@endsection