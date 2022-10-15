@extends("template.layout")
@section("content")
<div class="card">
  <div class="card-body">
    @include("template.page-name")
    @include("template.notif")
    <form method="POST" enctype="multipart/form-data" action="{{ url(Request::url()) }}">
      @csrf

      <div class="row">
        <div class="col-md-12 text-center">
          <label class="col-form-label">
            Foto Profile  (Maksimal 1 Mb | Format: jpg, jpeg, png, svg)
          </label>
          <br>
          <img class="img-thumbnail" src="{{ asset("images/no-image.png") }}" name="img1" id="img1" style="height: 180px; width: 180px" onclick="$('#gambar').trigger('click'); return false;">
          <input type="file" id="gambar" name="gambar"/>
          @if($errors->has('gambar'))
          <label class="text-danger">
            {{ $errors->first('gambar') }}
          </label>
          @endif
        </div>
        <div class="col-md-4 mt-2">
          <label class="col-form-label">
            Staf
          </label>
          <select class="form-control" id="staff_id" name="staff_id">
            <option value="{{ $staff->staff_id }}">{{ ucfirst($staff->name) }}</option>
          </select>
          @if($errors->has('staff_id'))
          <label class="text-danger">
            {{ $errors->first('staff_id') }}
          </label>
          @endif
        </div>
        <div class="col-md-4 mt-2">
          <label class="col-form-label">
            Role <span class="text-danger"> *</span>
          </label>
          <select class="form-control" required id="role_id" name="role_id">
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
        <div class="col-md-4 mt-2">
          <label class="col-form-label">
            Username <span class="text-danger"> *</span>
          </label>
          <input type="text" class="form-control @if($errors->has('username')) is-invalid @endif" required id="username" name="username" value="{{ old('username') }}" minlength="5" maxlength="20" placeholder="Masukan username  ...">
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
        <div class="col-md-4 mt-2">
          <label class="col-form-label">
            Password <span class="text-danger"> *</span>
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
        <div class="col-md-4 mt-2">
          <label class="col-form-label">
            Status User
          </label>
          <br>
          <label style="margin-left: 10px">
            <input type="radio" id="status" name="status" value="active"> Active
          </label>
          <label style="margin-left: 10px">
            <input type="radio" id="status" name="status" value="inactive"> Inactive
          </label>
          @if($errors->has('status'))
          <label class="text-danger">
            {{ $errors->first('status') }}
          </label>
          @endif
        </div>
        <div class="col-md-4 mt-2 text-end">
          @include("template.action")
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

  $("#staff_id").val('{{ $staff->staff_id }}');
  $("#username").val('{{ old("username") }}');
  $("#status[value={{ old("status") }}]").prop('checked', true);
  $("#role_id").val('{{ old("role_id") }}');

</script>
@endsection