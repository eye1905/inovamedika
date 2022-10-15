@extends("template.layout")
@section("content")
<div class="card">
  <div class="card-body">
    @include("template.page-name")
    @include("template.notif")
    <form method="POST" enctype="multipart/form-data" action="{{ url(Request::segment(1), $data->user_id) }}">
      @csrf

      {{ method_field("PUT") }}

      <div class="row">

        <div class="col-md-4 text-center">
          <img class="img-thumbnail" src="@if(isset($data->profile_picture) and $data->profile_picture != null){{ $data->profile_picture }}@else{{ asset("images/no-image.png") }}@endif" name="img1" id="img1" style="height: 180px; width: 180px" onclick="$('#gambar').trigger('click'); return false;">
          <input type="file" id="gambar" name="gambar"/>
          @if($errors->has('gambar'))
          <label class="text-danger">
            {{ $errors->first('gambar') }}
          </label>
          @endif
          <br>
          <label class="col-form-label">
            Foto Profile  (Maksimal 1 Mb | Format: jpg, jpeg, png, svg)
          </label>
        </div>

        <div class="col-md-8 row">
          <div class="col-md-6">
            <label class="col-form-label">
              Staf
            </label>
            <input disabled readonly type="text" class="form-control" value="{{ StringHelper::ucsplit($data->name) }}">
          </div>

          <div class="col-md-6">
            <label class="col-form-label">
              Role
            </label>

            <input disabled readonly type="text" class="form-control" value="{{ ucfirst($role->name) }}">
          </div>

          <div class="col-md-6">
            <label class="col-form-label">
              Username <span class="text-danger"> *</span>
            </label>

            <input type="text" class="form-control @if($errors->has('username')) is-invalid @endif" required id="username" name="username" value="@if(isset($data->username)){{ $data->username }}@else{{ old('username') }}@endif" minlength="5" maxlength="20" placeholder="Masukan username  ...">

            @if($errors->has('username'))
            <label class="text-danger">
              {{ $errors->first('username') }}
            </label>
            @else
            <label class="text-notif">
              Username berisi huruf dan angka 5 - 20 Karakter
            </label>
            @endif
          </div>

          <div class="col-md-6">
            <label class="col-form-label">
              Password @if(Request::segment(2)=="create") <span class="text-danger"> *</span> @endif
            </label>

            <input type="password" class="form-control @if($errors->has('password')) is-invalid @endif" id="password" name="password" value="{{ old('password') }}" minlength="5" maxlength="20" placeholder="Masukan Password  ..." @if(Request::segment(2)=="create") required @endif>

            <label class="form-check-label mt-1">
              <input type="checkbox" value="1" id="check"> Tampilkan Password
            </label>
            <br>
            @if($errors->has('password'))
            <label class="text-danger">
              {{ $errors->first('password') }}
            </label>
            @else
            <label class="text-notif">
              Password hanya berisi 5 - 20 Karakter
            </label>
            @endif
          </div>

          <div class="col-md-12 mt-2 text-end">
            <button type="submit" class="btn btn-success btn-sm">
              <i class="fa fa-save"></i> Simpan
            </button>
            <a href="{{ url("home") }}" class="btn btn-danger btn-sm">
              <i class="fa fa-times"></i> Batal
            </a>
          </div>
        </div>

      </div>
    </form>
  </div>
</div>

@endsection
@section("script")
<script type="text/javascript">

  $(function(){
    $('#check').change(function()
    {
      if($(this).is(':checked')) {
        $("#password").attr("type", "text");
      }else{
        $("#password").attr("type", "password");
      }
    });
  });

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

  @if(isset($data->staff_id))
  $("#staff_id").val('{{ $data->staff_id }}');
  @else
  $("#staff_id").val('{{ old("staff_id") }}');
  @endif

  @if(isset($data->username))
  $("#username").val('{{ $data->username }}');
  @else
  $("#username").val('{{ old("username") }}');
  @endif

  @if(isset($data->status) and $data->status=="active")
  $("#status[value=active]").prop('checked', true);
  @elseif(isset($data->status) and $data->status=="inactive")
  $("#status[value=inactive]").prop('checked', true);
  @else
  $("#status[value={{ old("status") }}]").prop('checked', true);
  @endif

  @if(isset($data->role_id))
  $("#role_id").val('{{ $data->role_id }}');
  @else
  $("#role_id").val('{{ old("role_id") }}');
  @endif

</script>
@endsection