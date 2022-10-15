@extends("template.layout")
@section("content")
<div class="card">
  <div class="card-body">
    @include("template.page-name")
    @include("template.notif")
    <form method="POST" enctype="multipart/form-data" action="@if(Request::segment(2)=='create'){{ url(Request::segment(1)) }}@else{{ url(Request::segment(1), $data->medicine_id) }}@endif">

      @csrf
      @if(Request::segment(3)=="edit")
      {{ method_field("PUT") }}
      @endif

      <div class="row">
        
        <div class="col-md-4 mt-2">
          <label class="col-form-label">
            Kode {{ StringHelper::getNameMenu() }} <span class="text-danger"> *</span>
          </label>
          <input type="text" value="@if(isset($data->code)){{ $data->code }}@else{{ old('code') }}@endif" class="form-control" minlength="3" maxlength="50" required id="code" name="code" placeholder="Masukan Kode {{ StringHelper::getNameMenu() }} ..">
          @if($errors->has('code'))
          <label class="text-danger">
            {{ $errors->first('code') }}
          </label>
          @else
          <label class="text-notif">
            Kode {{ StringHelper::getNameMenu() }} berisi huruf dan angka 3 - 50 Karakter
          </label>
          @endif
        </div>

        <div class="col-md-4 mt-2">
          <label class="col-form-label">
            Nama {{ StringHelper::getNameMenu() }} <span class="text-danger"> *</span>
          </label>
          <input type="text" value="@if(isset($data->name)){{ $data->name }}@else{{ old('name') }}@endif" class="form-control" minlength="3" maxlength="50" required id="name" name="name" placeholder="Masukan Nama {{ StringHelper::getNameMenu() }} ..">
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

        <div class="col-md-4 mt-2">
          <label class="col-form-label">
            Harga {{ StringHelper::getNameMenu() }} <span class="text-danger"> *</span>
          </label>
          <input type="text" step="any" value="@if(isset($data->harga)){{ $data->harga }}@else{{ old('harga') }}@endif" class="form-control" required id="harga" name="harga" placeholder="Masukan harga {{ StringHelper::getNameMenu() }} ..">
          @if($errors->has('harga'))
          <label class="text-danger">
            {{ $errors->first('harga') }}
          </label>
          @else
          <label class="text-notif">
            harga {{ StringHelper::getNameMenu() }} berisi angka
          </label>
          @endif
        </div>

        <div class="col-md-4 mt-2">
          <label class="col-form-label">
            Indikasi
          </label>
          <textarea class="form-control" id="indikasi" minlength="5" maxlength="100" name="indikasi" placeholder="Masukan Indikasi">@if(isset($data->indikasi)){{ $data->indikasi }}@else{{ old('indikasi') }}@endif</textarea>
          @if($errors->has('indikasi'))
          <label class="text-danger">
            {{ $errors->first('indikasi') }}
          </label>
          @endif
        </div>

        <div class="col-md-4 mt-2">
          <label class="col-form-label">
            Dosis
          </label>
          <textarea class="form-control" id="dosis" minlength="5" maxlength="100" name="dosis" placeholder="Masukan Dosis">@if(isset($data->dosis)){{ $data->dosis }}@else{{ old('dosis') }}@endif</textarea>
          @if($errors->has('dosis'))
          <label class="text-danger">
            {{ $errors->first('dosis') }}
          </label>
          @endif
        </div>

        @if(Request::segment(3)=="edit" or  Request::segment(2)=="create")
        <div class="col-md-12 mt-2 text-end">
          @include("template.action")
        </div>
        @endif

      </div>
    </div>
  </form>
</div>
@endsection
@section("script")
<script type="text/javascript">
  
  @if(Request::segment(3)==null and  Request::segment(2)!='create')
  $(".form-control").attr("readonly", true);
  $(".form-control").attr("disabled",  true);
  @else
  $(".form-control").removeAttr("readonly");
  $(".form-control").removeAttr("disabled");
  @endif

</script>
@endsection