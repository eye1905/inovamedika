@extends("template.layout")
@section("content")
<div class="card">
  <div class="card-body">
    @include("template.page-name")
    @include("template.notif")
    <form method="POST" enctype="multipart/form-data" action="@if(Request::segment(2)=='create'){{ url(Request::segment(1)) }}@else{{ url(Request::segment(1), $data->role_permission_id) }}@endif">

      @csrf
      @if(Request::segment(3)=="edit")
      {{ method_field("PUT") }}
      @endif

      <div class="row">

        <div class="col-md-3">
          <label class="col-form-label">
            Role <span class="text-danger"> *</span>
          </label>

          <select class="js-example-basic-single" required id="role_id" name="role_id">
            <option value="">-- Pilih Role --</option>
            @foreach($role as $key => $value)
            <option value="{{ $value->role_id }}">{{ ucfirst($value->name) }}</option>
            @endforeach
          </select>

          @if($errors->has('role_id'))
          <label class="text-danger">
            {{ $errors->first('role_id') }}
          </label>
          @endif
        </div>

        <div class="col-md-4">
          <label class="col-form-label">
            Menu <span class="text-danger"> *</span>
          </label>
          
          <select class="js-example-basic-single" required id="navigation_id" name="navigation_id">
            <option value="">-- Pilih Menu --</option>
            @foreach($menu as $key => $value)
            <option value="{{ $value->navigation_id }}">{{ ucfirst($value->name) }}</option>
            @endforeach
          </select>

          @if($errors->has('navigation_id'))
          <label class="text-danger">
            {{ $errors->first('navigation_id') }}
          </label>
          @endif
        </div>

        <div class="col-md-5 mt-2">
          <label class="col-form-label">
            {{ StringHelper::getNameMenu() }} 
          </label>
          <br>

          <label style="margin-left: 10px">
            <input type="checkbox" id="c_all" name="c_all" value="1"> <b>Semua</b>
          </label>

          <label style="margin-left: 10px">
            <input type="checkbox" id="read" name="read" value="1"> read
          </label>

          <label style="margin-left: 10px">
            <input type="checkbox" id="create" name="create" value="1"> create
          </label>

          <label style="margin-left: 10px">
            <input type="checkbox" id="update" name="update" value="1"> update
          </label>

          <label style="margin-left: 10px">
            <input type="checkbox" id="delete" name="delete" value="1"> delete
          </label>

          <label style="margin-left: 10px">
            <input type="checkbox" id="detail" name="detail" value="1"> detail
          </label>

          <label style="margin-left: 10px">
            <input type="checkbox" id="import" name="import" value="1"> import
          </label>

          <label style="margin-left: 10px">
            <input type="checkbox" id="export" name="export" value="1"> export
          </label>

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
<script src="{{ URL::asset('js/select2/select2.full.min.js') }}"></script>
<script src="{{ URL::asset('js/select2/select2-custom.js') }}"></script>
<script type="text/javascript">
  $(function(){
    $('#c_all').change(function()
    {
      if($(this).is(':checked')) {
        $("#read").prop("checked", true);
        $("#create").prop("checked", true);
        $("#update").prop("checked", true);
        $("#delete").prop("checked", true);
        $("#detail").prop("checked", true);
        $("#import").prop("checked", true);
        $("#export").prop("checked", true);

        $("#read").val(1);
        $("#create").val(1);
        $("#update").val(1);
        $("#delete").val(1);
        $("#detail").val(1);
        $("#import").val(1);
        $("#export").val(1);

      }else{
        $("#read").prop("checked", false);
        $("#create").prop("checked", false);
        $("#update").prop("checked", false);
        $("#delete").prop("checked", false);
        $("#detail").prop("checked", false);
        $("#import").prop("checked", false);
        $("#export").prop("checked", false);

        $("#read").val(null);
        $("#create").val(null);
        $("#update").val(null);
        $("#delete").val(null);
        $("#detail").val(null);
        $("#import").val(null);
        $("#export").val(null);
      }
    });
  });

  $('#read').change(function() {
    if(this.checked) {
      $(this).val("1");
    }else{
      $(this).val(null);
    }       
  });

  $('#create').change(function() {
    if(this.checked) {
      $(this).val("1");
    }else{
      $(this).val(null);
    }       
  });

  $('#update').change(function() {
    if(this.checked) {
      $(this).val("1");
    }else{
      $(this).val(null);
    }       
  });

  $('#delete').change(function() {
    if(this.checked) {
      $(this).val("1");
    }else{
      $(this).val(null);
    }       
  });

  $('#detail').change(function() {
    if(this.checked) {
      $(this).val("1");
    }else{
      $(this).val(null);
    }       
  });

  $('#import').change(function() {
    if(this.checked) {
      $(this).val("1");
    }else{
      $(this).val(null);
    }       
  });

  $('#export').change(function() {
    if(this.checked) {
      $(this).val("1");
    }else{
      $(this).val(null);
    }       
  });

  @if(isset($data->role_id))
  $("#role_id").val('{{ $data->role_id }}');
  @else
  $("#role_id").val('{{ old("role_id") }}');
  @endif

  @if(isset($data->navigation_id))
  $("#navigation_id").val('{{ $data->navigation_id }}');
  @else
  $("#navigation_id").val('{{ old("navigation_id") }}');
  @endif

  @if(isset($data->read_permission) and $data->read_permission == 1)
  $("#read").attr("checked", true);
  @else
  $("#read").val('{{ old("read") }}');
  @endif

  @if(isset($data->create_permission) and $data->create_permission == 1)
  $("#create").attr("checked", true);
  @else
  $("#create").val('{{ old("create") }}');
  @endif

  @if(isset($data->update_permission) and $data->update_permission == 1)
  $("#update").attr("checked", true);
  @else
  $("#update").val('{{ old("update") }}');
  @endif

  @if(isset($data->detail_permission) and $data->detail_permission == 1)
  $("#detail").attr("checked", true);
  @else
  $("#detail").val('{{ old("detail") }}');
  @endif

  @if(isset($data->delete_permission) and $data->delete_permission == 1)
  $("#delete").attr("checked", true);
  @else
  $("#delete").val('{{ old("delete") }}');
  @endif
  
  @if(isset($data->import_permission) and $data->import_permission == 1)
  $("#import").attr("checked", true);
  @else
  $("#import").val('{{ old("import") }}');
  @endif

  @if(isset($data->export_permission) and $data->export_permission == 1)
  $("#export").attr("checked", true);
  @else
  $("#export").val('{{ old("export") }}');
  @endif
  
  @if(Request::segment(3)==null and  Request::segment(2)!='create')
  $(".form-control").attr("readonly", true);
  $(".form-control").attr("disabled",  true);
  $("input").attr("readonly", true);
  $("input").attr("disabled",  true);
  $("select").attr("readonly", true);
  $("select").attr("disabled",  true);
  @else
  $(".form-control").removeAttr("readonly");
  $(".form-control").removeAttr("disabled");
  $("input").removeAttr("readonly");
  $("input").removeAttr("disabled");
  @endif

</script>
@endsection