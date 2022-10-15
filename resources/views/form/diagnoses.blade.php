@extends("template.layout")
@section("content")
<div class="card">
  <div class="card-body">
    @include("template.page-name")
    @include("template.notif")
    <form method="POST" enctype="multipart/form-data" action="@if(Request::segment(2)=='create'){{ url(Request::segment(1)) }}@else{{ url(Request::segment(1), $data->diagnose_id) }}@endif">

      @csrf
      @if(Request::segment(3)=="edit")
      {{ method_field("PUT") }}
      @endif

      <div class="row">
        <div class="col-md-12 text-center">
          <label class="col-form-label">
            Gambar {{ StringHelper::getNameMenu() }} (Maksimal 1 Mb | Format: jpg, jpeg, png, svg)
          </label>
          <br>
          <img class="img-thumbnail" src="@if(isset($data->picture) and $data->picture != null){{ $data->picture }}@else{{ asset("images/no-image.png") }}@endif" name="img1" id="img1" style="height: 180px; width: 180px" onclick="$('#gambar').trigger('click'); return false;">
          <input type="file" id="gambar" name="gambar"/>
          @if($errors->has('name'))
          <label class="text-danger">
            {{ $errors->first('name') }}
          </label>
          @endif
        </div>
        <div class="col-md-4 mt-2">
          <label class="col-form-label">
            Parent {{ StringHelper::getNameMenu() }}          </label>
          <select class="form-control" id="parent" name="parent">
            <option value="">-- Pilih Parent --</option>
            @foreach($parent as $key => $value)
            <option value="{{ $value->diagnose_id }}">{{ ucfirst($value->name) }}</option>
            @endforeach
          </select>
          @if($errors->has('parent'))
          <label class="text-danger">
            {{ $errors->first('parent') }}
          </label>
          @endif
        </div>
        <div class="col-md-4 mt-2">
          <label class="col-form-label">
            Nama {{ StringHelper::getNameMenu() }} <span class="text-danger"> *</span>
          </label>
          <input type="text" value="@if(isset($data->name)){{ $data->name }}@else{{ old('name') }}@endif" class="form-control" minlength="3" maxlength="50" required id="name" name="name" placeholder="Masukan {{ StringHelper::getNameMenu() }} ..">
          @if($errors->has('name'))
          <label class="text-danger">
            {{ $errors->first('name') }}
          </label>
          @else
          <label class="text-notif">
            Nama {{ StringHelper::getNameMenu() }} erisi huruf, angka dan spasi 3 - 50 Karakter
          </label>
          @endif
        </div>
        <div class="col-md-4 mt-2">
          <label class="col-form-label">
            Deskripsi
          </label>
          <textarea class="form-control" id="description" minlength="5" maxlength="100" name="description" placeholder="Masukan Deskripsi">@if(isset($data->description)){{ $data->description }}@else{{ old('description') }}@endif</textarea>
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
  
  @if(isset($data->parent_diagnose_id) and $data->parent_diagnose_id != null)
  $("#parent").val('{{ $data->parent_diagnose_id }}');
  @endif

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