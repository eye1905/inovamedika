@extends("template.layout")
@section("content")
<div class="card">
  <div class="card-body">
    @include("template.page-name")
    @include("template.notif")
    <form method="POST" enctype="multipart/form-data" action="@if(Request::segment(2)=='create'){{ url(Request::segment(1)) }}@else{{ url(Request::segment(1), $data->navigation_id) }}@endif">
      @csrf
      @if(Request::segment(3)=="edit")
      {{ method_field("PUT") }}
      @endif
      <div class="row">
        @csrf
        <div class="form-group col-md-4">
          <label for="name">
            <b>Nama {{ StringHelper::getNameMenu() }}
             <span class="text-danger"> * </span>
           </b>
         </label>
         <input type="text" class="form-control m-input m-input--square" name="name" id="name" value="@if(isset($data->name)){{$data->name}}@else{{ old('name') }}@endif" required="required" minlength="1" maxlength="100" placeholder="Nama {{ StringHelper::getNameMenu() }} ...">
         @if ($errors->has('name'))
         <label class="text-danger">
          {{ $errors->first('name') }}
        </label>
        @endif
      </div>
      <div class="form-group col-md-4">
        <label for="icon">
          <b>Icon <span class="text-danger"> * </span> </b>
        </label>
        <input type="text" class="form-control m-input m-input--square" name="icon" id="icon" minlength="1" maxlength="50" value="@if(isset($data->icon)){{$data->icon}}@else{{ old('icon') }}@endif" required>
        @if ($errors->has('icon'))
        <label class="text-danger">
          {{ $errors->first('icon') }}
        </label>
        @endif
      </div>
      <div class="form-group col-md-4">
        <label for="level">
          <b>Level <span class="text-danger"> * </span> </b>
        </label>
        <select class="form-control m-input m-input--square" name="level" id="level" required>
          <option value="1">1</option>
          <option value="2">2</option>
        </select>
        @if ($errors->has('level'))
        <label class="text-danger">
          {{ $errors->first('level') }}
        </label>
        @endif
      </div>
      <div class="form-group col-md-4 mt-2">
        <label for="parent">
          <b>Parent {{ StringHelper::getNameMenu() }} </b>
        </label>
        <select class="form-control m-input m-input--square" name="parent" id="parent">
          <option value="">
            -- Pilih Parent {{ StringHelper::getNameMenu() }} --
          </option>
          @foreach($parent as $key => $value)
          <option value="{{ $value->navigation_id }}">{{ strtoupper($value->name) }}</option>
          @endforeach
        </select>
        @if ($errors->has('parent'))
        <label class="text-danger">
          {{ $errors->first('parent') }}
        </label>
        @endif
      </div>
      <div class="form-group col-md-4 mt-2">
        <label for="uri">
          <b>Nama uri </b>
        </label>
        <input type="text" class="form-control m-input m-input--square" name="uri" id="uri" value="@if(isset($data->uri)){{$data->uri}}@else{{ old('uri') }}@endif" minlength="1" maxlength="100" placeholder="Nama uri ...">
        @if ($errors->has('uri'))
        <label class="text-danger">
          {{ $errors->first('uri') }}
        </label>
        @endif
      </div>
      <div class="form-group col-md-4 mt-2">
        <label for="controller">
          <b>Nama controller</b>
        </label>
        <input type="text" class="form-control m-input m-input--square" name="controller" id="controller" value="@if(isset($data->controller)){{$data->controller}}@else{{ old('controller') }}@endif" minlength="1" maxlength="100" placeholder="Nama menu ...">
        @if ($errors->has('controller'))
        <label class="text-danger">
          {{ $errors->first('controller') }}
        </label>
        @endif
      </div>
      <div class="form-group col-md-4 mt-2">
        <label for="description">
          <b>Deskripsi</b>
        </label>
        <textarea class="form-control m-input m-input--square" maxlength="100" name="description" id="description" placeholder="Deskripsi menu...">@if(isset($data->description)){{$data->description}}@else{{old('description')}}@endif</textarea>
        @if ($errors->has('description'))
        <label class="text-danger">
          {{ $errors->first('description') }}
        </label>
        @endif
      </div>
      <div class="form-group col-md-4 mt-2">
        <label for="is_master">
          <b>Is Master </b>
        </label>
        <br>
        <input type="checkbox" name="is_master" id="is_master" value="1">
        @if ($errors->has('is_master'))
        <label class="text-danger">
          {{ $errors->first('is_master') }}
        </label>
        @endif
      </div>

      <div class="form-group col-md-4 mt-2">
        <label for="is_show">
          <b>Is Show </b>
        </label>
        <br>
        <input type="checkbox" name="is_show" id="is_show" value="1">
        @if ($errors->has('is_show'))
        <label class="text-danger">
          {{ $errors->first('is_show') }}
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
  $("#parent").attr("disabled", true);
  $('#level').on('change', function (e) {
    if(this.value == 1){
      $("#parent").attr("disabled", true);
    }else{
      $("#parent").removeAttr("disabled");
    }
  });

  @if(isset($data->is_master) and $data->is_master=="1")
  $("#is_master").attr("checked", true);
  @elseif(isset($data->is_master) and $data->is_master=="0")
  $("#is_master").attr("checked", false);
  @endif

  @if(isset($data->is_show) and $data->is_show=="1")
  $("#is_show").attr("checked", true);
  @elseif(isset($data->is_show) and $data->is_show=="0")
  $("#is_show").attr("checked", false);
  @endif
  
  @if(isset($data->level) and $data->level!= null)
  $("#level").val('{{ $data->level }}');
  @endif

  @if(Request::segment(3)==null and  Request::segment(2)!='create')
  $(".form-control").attr("readonly", true);
  $(".form-control").attr("disabled",  true);
  $(".form-control").css("background-color", "#FFFF");
  $("#is_master").attr("disabled", true);
  @else
  $(".form-control").removeAttr("readonly");
  $(".form-control").removeAttr("disabled");
  $("#parent").attr("disabled", true);
  $("#is_master").removeAttr("disabled");
  @if(isset($data->parent_navigation_id) and $data->parent_navigation_id!= null)
  $("#parent").removeAttr("disabled");
  $("#parent").removeAttr("readonly");
  $("#parent").val('{{ $data->parent_navigation_id }}');
  @endif

  @endif
</script>
@endsection