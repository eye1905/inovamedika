@extends("template.layout")
@section("content")
<div class="card">
  <div class="card-body">
    @include("template.page-name")
    @include("template.notif")
    <form method="POST" enctype="multipart/form-data" action="@if(Request::segment(2)=='create'){{ url(Request::segment(1)) }}@else{{ url(Request::segment(1), $data->announcement_id) }}@endif">
      @csrf
      @if(Request::segment(3)=="edit")
      {{ method_field("PUT") }}
      @endif
      <div class="row">

        <div class="col-md-12 mt-2">
          <label class="col-form-label">
            Isi {{ StringHelper::getNameMenu() }} <span class="text-danger"> *</span>
          </label>
          <textarea class="form-control" id="address" minlength="5" maxlength="1000" name="announcement" placeholder="Masukan {{ StringHelper::getNameMenu() }}" required style="min-height: 150px">@if(isset($data->announcement)){{ $data->announcement }}@else{{ old('announcement') }}@endif</textarea>
          @if($errors->has('announcement'))
          <label class="text-danger">
            {{ $errors->first('announcement') }}
          </label>
          @else
          <label class="text-notif">
            Isi {{ StringHelper::getNameMenu() }} berisi 5 - 1000 karakter
          </label>
          @endif
        </div>

        <div class="col-md-4">
          <label class="col-form-label">
            Tanggal {{ StringHelper::getNameMenu() }} <span class="text-danger"> *</span>
          </label>

          <input type="date" class="form-control" id="date" name="date" value="@if(isset($data->date)){{ $data->date }}@else{{ old('date') }}@endif" placeholder="Masukan Tgl {{ StringHelper::getNameMenu() }}">

          @if($errors->has('date'))
          <label class="text-danger">
            {{ $errors->first('date') }}
          </label>
          @else
          <label class="text-notif">
            Tgl {{ StringHelper::getNameMenu() }} berisi format tanggal (dd-mm-yy)
          </label>
          @endif
        </div>

        <div class="col-md-4">
          <label class="col-form-label">
            Penerima
          </label>
          <br>
          <label style="margin-left: 10px">
            <input type="checkbox" id="c_all" name="c_all" value="1"> <b>Semua</b>
          </label>
          <label style="margin-left: 10px">
            <input type="checkbox" id="is_doctor" name="is_doctor" value="1"> Dokter
          </label>
          <label style="margin-left: 10px">
            <input type="checkbox" id="is_staff" name="is_staff" value="1"> Staff
          </label>
          <label style="margin-left: 10px">
            <input type="checkbox" id="is_patient" name="is_patient" value="1"> Pasien
          </label>
        </div>
        
        <div class="col-md-4 mt-2">
          <label class="col-form-label">
            Status
          </label>
          <br>
          <label style="margin-left: 10px">
            <input type="radio" id="status" name="status" value="draft" > Draft
          </label>
          <label style="margin-left: 10px">
            <input type="radio" id="status" name="status" value="publish" > Publish
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

  $(function(){
    $('#c_all').change(function()
    {
      if($(this).is(':checked')) {
        $("#is_doctor").prop("checked", true);
        $("#is_doctor").val(1);
        $("#is_staff").prop("checked", true);
        $("#is_staff").val(1);
        $("#is_patient").prop("checked", true);
        $("#is_patient").val(1);
      }else{
        $("#is_doctor").prop("checked", false);
        $("#is_doctor").val(null);
        $("#is_staff").prop("checked", false);
        $("#is_staff").val(null);
        $("#is_patient").prop("checked", false);
        $("#is_patient").val(null);
      }
    });
  });

  $("#status[value=draft]").prop('checked', true);

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

  @if(isset($data->is_patient) and $data->is_patient==1)
  $("#is_patient").prop("checked", true);
  $("#is_patient").val(1);
  @endif

  @if(isset($data->is_doctor) and $data->is_doctor==1)
  $("#is_doctor").prop("checked", true);
  $("#is_doctor").val(1);
  @endif

  @if(isset($data->is_staff) and $data->is_staff==1)
  $("#is_staff").prop("checked", true);
  $("#is_staff").val(1);
  @endif
  
  @if(isset($data->status) and $data->is_doctor!=null)
  $("#status").prop("checked", true);
  $("#is_doctor").val(1);
  @endif
  
</script>
@endsection