@extends("template.layout")

@section("content")
<div class="card">
  <div class="card-body">
    @include("template.page-name")
    @include("template.notif")

    <form method="POST" enctype="multipart/form-data" action="@if(Request::segment(2)=='create'){{ url(Request::segment(1)) }}@else{{ url(Request::segment(1), $data->staff_id) }}@endif">

      @csrf
      
      @if(Request::segment(3)=="edit")
      {{ method_field("PUT") }}
      @endif

      <div class="row">
        <div class="col-md-4 row">
          <div class="col-md-12 text-center">
            <label class="col-form-label">
              Foto Identitas
            </label>

            <br>

            <img class="img-thumbnail" src="@if(isset($data->identity_picture) and $data->identity_picture != null){{ $data->identity_picture }}@else{{ asset("images/no-image.png") }}@endif" name="img1" id="img1" style="height: 180px; width: 180px" onclick="$('#gambar').trigger('click'); return false;">
            <br>
            (Maksimal 2 Mb | Format: jpg, jpeg, png, svg)
            <input type="file" id="gambar" name="gambar"/>

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
              No. Identitas <span class="text-danger"> *</span>
            </label>

            <input type="text" class="form-control" id="identity_id" name="identity_id" value="@if(old("identity_id")!=null)@elseif(isset($data->identity_id)){{ $data->identity_id }}@endif" placeholder="masukan nomor identitas" minlength="3" maxlength="50" required >

            @if($errors->has('identity_id'))
            <label class="text-danger">
              {{ $errors->first('identity_id') }}
            </label>
            @else
            <label class="text-notif">
              No. Identitas huruf dan angka (3 - 50 Karakter)
            </label>
            @endif
          </div>

          <div class="col-md-6">
            <label class="col-form-label">
              Nama {{ StringHelper::getNameMenu() }} <span class="text-danger"> *</span>
            </label>

            <input type="text" class="form-control" id="name" name="name" value="@if(old("name")!= null){{ old("name") }}@elseif(isset($data->name)){{ $data->name }}@endif" required minlength="4" maxlength="100" placeholder="Masukan Nama {{ StringHelper::getNameMenu() }} ..">

            @if($errors->has('name'))
            <label class="text-danger">
              {{ $errors->first('name') }}
            </label>
            @else
            <label class="text-notif">
              Nama {{ StringHelper::getNameMenu() }} di isi huruf, titik, koma, angka dan spasi  (4 - 100 Karakter)
            </label>
            @endif
          </div>

          <div class="col-md-6">
            <label class="col-form-label">
              Jenis Kelamin <span class="text-danger"> *</span>
            </label>

            <select class="form-control" required id="kelamin" name="kelamin">
              <option value="">-- Pilih Jenis Kelamin --</option>
              <option value="male">Laki - Laki</option>
              <option value="female">Perempuan</option>
            </select>

            @if($errors->has('kelamin'))
            <label class="text-danger">
              {{ $errors->first('kelamin') }}
            </label>
            @endif
          </div>

          <div class="col-md-6">
            <label class="col-form-label">
              Telp / Hp / WA {{ StringHelper::getNameMenu() }} <span class="text-danger"> *</span>
            </label>
            
            <div class="input-group has-validation">
              <span class="input-group-text" id="validationTooltipUsernamePrepend">62</span>
              <input class="form-control" type="number" step="any" value="@if(old("phone")!= null){{ old("phone") }}@elseif(isset($data->name)){{ $data->phone }}@endif"  minlength="6" maxlength="13" onKeyPress="if(this.value.length==13) return false;" required id="phone" name="phone" placeholder="Masukan Telp / Hp / WA {{ StringHelper::getNameMenu() }} ...">
            </div>
            
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

          <div class="col-md-6">
            <label class="col-form-label">
              Alamat <span class="text-danger"> *</span>
            </label>

            <textarea name="address" id="address" required placeholder="Masukan Alamat {{ StringHelper::getNameMenu() }}" class="form-control" minlength="10" maxlength="100">@if(old("address")!= null){{ old("address") }}@elseif(isset($data->address)){{ $data->address }}@endif</textarea>

            @if($errors->has('address'))
            <label class="text-danger">
              {{ $errors->first('address') }}
            </label>
            @else
            <label class="text-notif">
              Alamat berisi 10 -100 karakter
            </label>
            @endif
          </div>

          <div class="col-md-6">
            <label class="col-form-label">
              Tahun Aktif <span class="text-danger"> *</span>
            </label>

            <select class="form-control" id="entry_year" name="entry_year" required>
              <option selected="selected" value="">-- Pilih Tahun --</option>
              @php
              for($i=date('Y'); $i>=date('Y')-20; $i-=1){
                echo"<option value='$i'> $i </option>";
              }
              @endphp
            </select>

            @if($errors->has('entry_year'))
            <label class="text-danger">
              {{ $errors->first('entry_year') }}
            </label>
            @else
            <label class="text-notif">
              Tahun Aktif berisi format tanggal (yyyy)
            </label>
            @endif
          </div>
        </div>

        <div class="col-md-4">
          <label class="col-form-label">
            Tempat Lahir
          </label>

          <input type="text" class="form-control" id="birthplace" name="birthplace" value="@if(old("birthplace")!= null){{ old("birthplace") }}@elseif(isset($data->birthplace)){{ $data->birthplace }}@endif" minlength="4" maxlength="100" placeholder="Masukan Tempat Lahir ..">

          @if($errors->has('birthplace'))
          <label class="text-danger">
            {{ $errors->first('birthplace') }}
          </label>
          @else
          <label class="text-notif">
            Tempat Lahir huruf dan spasi  (4 - 100 Karakter)
          </label>
          @endif
        </div>

        <div class="col-md-4">
          <label class="col-form-label">
            Tgl. Lahir
          </label>
          <input type="date" class="form-control" id="birthdate" name="birthdate" placeholder="Masukan Tgl Lahir">

          @if($errors->has('birthdate'))
          <label class="text-danger">
            {{ $errors->first('birthdate') }}
          </label>
          @else
          <label class="text-notif">
            Tgl. Lahir berisi format tanggal (dd/mm/yyyy)
          </label>
          @endif
        </div>

        <div class="col-md-4">
          <label class="col-form-label">
            Email {{ StringHelper::getNameMenu() }} 
          </label>

          <input type="email" value="@if(old("email")!= null){{ old("email") }}@elseif(isset($data->email)){{ $data->email }}@endif" class="form-control" minlength="10" maxlength="100" id="email" name="email" placeholder="Masukan Email staff ...">

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
          <label class="col-form-label">Status {{ StringHelper::getNameMenu() }} </label>
          <br>
          <label style="margin-left: 10px"><input type="radio" id="status" name="status" value="active"> Active</label>
          <label style="margin-left: 10px"><input type="radio" id="status" name="status" value="inactive"> Inactive</label>
          <label style="margin-left: 10px"><input type="radio" id="status" name="status" value="leave"> Leave</label>
          <br>
          @if($errors->has('status'))
          <label class="text-danger">
            {{ $errors->first('status') }}
          </label>
          @endif
        </div>
      </div>
      <div class="row mt-2">
       @if(Request::segment(2)=="create")
       <div class="col-md-12">
        <hr>
        <label>
          <b><i class="fa fa-users"></i> Data User</b> <span class="text-danger"> *</span>
        </label>
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
        <input type="text" class="form-control @if($errors->has('username')) is-invalid @endif" required id="username" name="username" value="@if(old("username")!= null){{ old("username") }}@elseif(isset($data->username)){{ $data->username }}@endif" minlength="5" maxlength="20" placeholder="Masukan username  ...">
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
      @endif

      @if(Request::segment(3)=="edit" or  Request::segment(2)=="create")
      <div class="col-md-12 text-center">
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

  @if(old("role_id") != null)
  $("#role_id").val('{{ old("role_id") }}');
  @elseif(isset($data->role_id))
  $("#role_id").val('{{ $data->role_id }}');
  @endif


  @if(old("gender") != null)
  $("#kelamin").val('{{ old("gender") }}');
  @elseif(isset($data->gender))
  $("#kelamin").val('{{ $data->gender }}');
  @endif

  @if(old("entry_year") != null)
  $("#entry_year").val('{{ old("entry_year") }}');
  @elseif(isset($data->entry_year))
  $("#entry_year").val('{{ $data->entry_year }}');
  @endif

  @if(old("status")!= null)
  $("#status[value={{ old("status") }}]").prop('checked', true);
  @elseif(isset($data->staff_status) and $data->staff_status=="active")
  $("#status[value=active]").prop('checked', true);
  @elseif(isset($data->staff_status) and $data->staff_status=="inactive")
  $("#status[value=inactive]").prop('checked', true);
  @elseif(isset($data->staff_status) and $data->staff_status=="leave")
  $("#status[value=leave]").prop('checked', true);
  @endif

  @if(isset($data->is_terapis) and $data->is_terapis=="1")
  $("#is_terapis").prop('checked', true);
  @elseif(old("is_terapis")=="1")
  $("#is_terapis[value={{ old("is_terapis") }}]").prop('checked', true);
  @else
  $("#is_terapis").prop('checked', false);
  @endif
  
  @if(old("birthdate")!= null)
  $("#birthdate").val('{{ old("birthdate") }}');
  @elseif(isset($data->birthdate))
  $("#birthdate").val('{{ date("Y-m-d", strtotime($data->birthdate)) }}');
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