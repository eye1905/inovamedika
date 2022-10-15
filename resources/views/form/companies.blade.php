@extends("template.layout")
@section("content")
<div class="card">
  <div class="card-body">
    @include("template.page-name")
    @include("template.notif")
    <form method="POST" enctype="multipart/form-data" action="@if(Request::segment(2)=='create'){{ url(Request::segment(1)) }}@else{{ url(Request::segment(1), $data->company_id) }}@endif">

      @csrf
      @if(Request::segment(3)=="edit")
      {{ method_field("PUT") }}
      @endif

      <div class="row">

        @if(Request::segment(2) != "create" or Request::segment(3)=="edit")
        <div class="col-md-12 text-center">
          <label class="col-form-label">
            Foto NPWP {{ StringHelper::getNameMenu() }}
          </label>
          <br>
          <img class="img-thumbnail" src="@if(isset($data->npwp_picture) and $data->npwp_picture != null){{ $data->npwp_picture }}@else{{ asset("images/no-image.png") }}@endif" style="height: 180px; width: 260px">
        </div>
        @endif

        <div class="col-md-4 mt-2">
          <label class="col-form-label">
            Nama {{ StringHelper::getNameMenu() }} <span class="text-danger"> *</span>
          </label>
          <input type="text" value="@if(isset($data->name)){{ $data->name }}@else{{ old('name') }}@endif" class="form-control" minlength="3" maxlength="50" required id="name" name="name" placeholder="Masukan {{ StringHelper::getNameMenu() }} ...">
          @if($errors->has('name'))
          <label class="text-danger">
            {{ $errors->first('name') }}
          </label>
          @else
          <label class="text-notif">
            Nama {{ StringHelper::getNameMenu() }} di isi huruf, titik, koma, angka dan spasi (3 - 50 Karakter)
          </label>
          @endif
        </div>

        <div class="col-md-4 mt-2">
          <label class="col-form-label">
            Sector
          </label>
          <select class="form-control" id="sector" name="sector">
            <option value="">-- Pilih Sector --</option>
            @foreach($sectors as $key => $value)
            <option value="{{ $value->company_sector_id }}">{{ ucfirst($value->name) }}</option>
            @endforeach
          </select>
          @if($errors->has('sector'))
          <label class="text-danger">
            {{ $errors->first('sector') }}
          </label>
          @endif
        </div>

        <div class="col-md-4 mt-2">
          <label class="col-form-label">
            Email {{ StringHelper::getNameMenu() }}<span class="text-danger"> *</span>
          </label>
          <input type="email" value="@if(isset($data->email)){{ $data->email }}@else{{ old('email') }}@endif" class="form-control" minlength="10" maxlength="100" required id="email" name="email" placeholder="Masukan Email {{ StringHelper::getNameMenu() }} ...">

          @if($errors->has('email'))
          <label class="text-danger">
            {{ $errors->first('email') }}
          </label>
          @else
          <label class="text-notif">
            Email {{ StringHelper::getNameMenu() }} berisi Email Valid (10 - 100 Karakter)
          </label>
          @endif
        </div>

        <div class="col-md-4 mt-2">
          <label class="col-form-label">
            Telp / Hp / WA {{ StringHelper::getNameMenu() }}<span class="text-danger"> *</span>
          </label>
          <input type="number" step="any" value="@if(isset($data->phone)){{ $data->phone }}@else{{ old('phone') }}@endif" class="form-control" minlength="6" maxlength="13" onKeyPress="if(this.value.length==13) return false;" required id="phone" name="phone" placeholder="Masukan Telp / Hp / WA {{ StringHelper::getNameMenu() }} ...">

          @if($errors->has('phone'))
          <label class="text-danger">
            {{ $errors->first('phone') }}
          </label>
          @else
          <label class="text-notif">
            Telp / HP / WA {{ StringHelper::getNameMenu() }} berisi angka (6 - 13 Karakter)
          </label>
          @endif
        </div>

        <div class="col-md-4 mt-2">
          <label class="col-form-label">
            Alamat {{ StringHelper::getNameMenu() }} <span class="text-danger"> *</span>
          </label>

          <textarea class="form-control" id="address" minlength="5" maxlength="100" name="address" placeholder="Masukan Alamat {{ StringHelper::getNameMenu() }}" required>@if(isset($data->address)){{ $data->address }}@else{{ old('address') }}@endif</textarea>

          @if($errors->has('address'))
          <label class="text-danger">
            {{ $errors->first('address') }}
          </label>
          @else
          <label class="text-notif">
            Alamat {{ StringHelper::getNameMenu() }} berisi 5 - 100 karakter
          </label>
          @endif
        </div>

        <div class="col-md-4 mt-2">
          <label class="col-form-label">
            Estimasi Total Pegawai <span class="text-danger"> *</span>
          </label>
          <select class="form-control" id="estimasi" name="estimasi" required>
            <option value="">-- Pilih Etimasi --</option>
            @foreach($employee as $key => $value)
            <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
          </select>
          @if($errors->has('sector'))
          <label class="text-danger">
            {{ $errors->first('sector') }}
          </label>
          @endif
        </div>

        <div class="col-md-4 mt-2">
          <label class="col-form-label">
            NPWP {{ StringHelper::getNameMenu() }}
          </label>

          <input type="number" step="any" value="@if(isset($data->npwp_number)){{ $data->npwp_number }}@else{{ old('npwp_number') }}@endif" class="form-control" id="npwp_number" onKeyPress="if(this.value.length==16) return false;" name="npwp_number" placeholder="Masukan Npwp  {{ StringHelper::getNameMenu() }} ...">

          @if($errors->has('npwp_number'))
          <label class="text-danger">
            {{ $errors->first('npwp_number') }}
          </label>
          @else
          <label class="text-notif">
            NPWP {{ StringHelper::getNameMenu() }} berisi angka (16 Karakter)
          </label>
          @endif
        </div>

        <div class="col-md-4 mt-2">
          <label class="col-form-label">
            Foto NPWP {{ StringHelper::getNameMenu() }}
          </label>

          <input type="file" value="{{ old('npwp_picture') }}" class="form-control" id="npwp" name="npwp">

          @if($errors->has('npwp'))
          <label class="text-danger">
            {{ $errors->first('npwp') }}
          </label>
          @else
          <label class="text-notif">
            Foto Npwp(Maksimal 2 Mb | Format: jpg, jpeg, png, svg)
          </label>
          @endif
        </div>

        <div class="col-md-4 mt-2">
          <label class="col-form-label">
            Status
          </label>

          <br>
          <label style="margin-left: 10px">
           <input type="radio" id="status" name="status" value="active" > Active
         </label>

         <label style="margin-left: 10px">
           <input type="radio" id="status" name="status" value="deactive" > Deactive
         </label>
         <br>
         @if($errors->has('status'))
         <label class="text-danger">
          {{ $errors->first('status') }}
        </label>
        @endif
      </div>

      @if(Request::segment(3)=="edit" or  Request::segment(2)=="create")
      <div class="col-md-12 mt-2 text-end">
        @include("template.action")
      </div>
      @endif
    </div>

  </form>
</div>
</div>

@endsection
@section("script")
<script type="text/javascript">
  $("#status[value=active]").prop('checked', true);
  
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

  @if(isset($data->company_sector_id))
  $("#sector").val('{{ $data->company_sector_id }}');
  @else
  $("#sector").val('{{ old("sector") }}');
  @endif

  @if(isset($data->total_estimation_employee))
  $("#estimasi").val('{{ $data->total_estimation_employee }}');
  @else
  $("#estimasi").val('{{ old("estimasi") }}');
  @endif

  @if(isset($data->usage_status) and $data->usage_status=="active")
  $("#status[value=active]").prop('checked', true);
  @elseif(isset($data->usage_status) and $data->usage_status=="deactive")
  $("#status[value=deactive]").prop('checked', true);
  @else
  $("#status[value={{ old("status") }}]").prop('checked', true);
  @endif

  @if(Request::segment(3)==null and  Request::segment(2)!='create')
  $(".form-control").attr("readonly", true);
  $(".form-control").attr("disabled",  true);
  $("input").attr("disabled",  true);
  $("input").attr("readonly", true);
  $(".form-control").css("background-color", "#FFFF");
  @else
  $(".form-control").removeAttr("readonly");
  $(".form-control").removeAttr("disabled");
  $("input").removeAttr("disabled");
  $("input").removeAttr("readonly");
  @endif

</script>
@endsection