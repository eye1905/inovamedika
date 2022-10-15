@extends("template.layout")
@section("content")
<div class="card">
  <div class="card-body">
    @include("template.page-name")
    @include("template.notif")
    <form method="POST" enctype="multipart/form-data" action="@if(Request::segment(2)=='create'){{ url(Request::segment(1)) }}@else{{ url(Request::segment(1), $data->partner_id) }}@endif">

      @csrf
      @if(Request::segment(3)=="edit")
      {{ method_field("PUT") }}
      @endif

      <div class="row">

        <div class="col-md-4 mt-2">
          <label class="col-form-label">
            Nama {{ StringHelper::getNameMenu() }} <span class="text-danger"> *</span>
          </label>
          <input type="text" value="@if(old('name')!= null){{ old('name') }}@elseif(isset($data->name)){{ $data->name }}@endif" class="form-control" minlength="3" maxlength="50" required id="name" name="name" placeholder="Masukan {{ StringHelper::getNameMenu() }} ...">
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
            Penanggung Jawab <span class="text-danger"> *</span>
          </label>
          <input type="text" value="@if(old('contact_person')!= null){{ old('contact_person') }}@elseif(isset($data->contact_person)){{ $data->contact_person }}@endif" class="form-control" minlength="3" maxlength="50" required id="contact_person" name="contact_person" placeholder="Masukan Penanggung Jawab ...">
          @if($errors->has('contact_person'))
          <label class="text-danger">
            {{ $errors->first('contact_person') }}
          </label>
          @else
          <label class="text-notif">
            Penanggung Jawab di isi huruf, titik, koma, angka dan spasi (3 - 50 Karakter)
          </label>
          @endif
        </div>

        <div class="col-md-4 mt-2">
          <label class="col-form-label">
            Telp / Hp / WA {{ StringHelper::getNameMenu() }}<span class="text-danger"> *</span>
          </label>
          <input type="number" step="any" value="@if(old('phone')!= null){{ old('phone') }}@elseif(isset($data->phone)){{ $data->phone }}@endif" class="form-control" minlength="6" maxlength="13" onKeyPress="if(this.value.length==13) return false;" required id="phone" name="phone" placeholder="Masukan Telp / Hp / WA {{ StringHelper::getNameMenu() }} ...">

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
            Email {{ StringHelper::getNameMenu() }}
          </label>
          <input type="email" value="@if(old('email')!= null){{ old('email') }}@elseif(isset($data->email)){{ $data->email }}@endif" class="form-control" maxlength="100" id="email" name="email" placeholder="Masukan Email {{ StringHelper::getNameMenu() }} ...">

          @if($errors->has('email'))
          <label class="text-danger">
            {{ $errors->first('email') }}
          </label>
          @else
          <label class="text-notif">
            Email {{ StringHelper::getNameMenu() }} berisi Email Valid (100 Karakter)
          </label>
          @endif
        </div>

        <div class="col-md-4 mt-2">
          <label class="col-form-label">
            Alamat {{ StringHelper::getNameMenu() }} <span class="text-danger"> *</span>
          </label>

          <textarea class="form-control" id="address" minlength="5" maxlength="100" name="address" placeholder="Masukan Alamat {{ StringHelper::getNameMenu() }}" required>@if(old('address')!= null){{ old('address') }}@elseif(isset($data->address)){{ $data->address }}@endif</textarea>

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

      @if(Request::segment(3)=="edit" or  Request::segment(2)=="create")
      <div class="col-md-4" style="margin-top:45px">
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
  @if(Request::segment(3)==null and  Request::segment(2)!='create')
  $(".form-control").attr("readonly", true);
  $(".form-control").attr("disabled",  true);
  $(".form-control").css("background-color", "#FFFF");
  @else
  $(".form-control").removeAttr("readonly");
  $(".form-control").removeAttr("disabled");
  @endif
</script>
@endsection