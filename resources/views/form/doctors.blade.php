@extends("template.layout")

@section("content")
<div class="card">
  <div class="card-body">
    @include("template.page-name")
    @include("template.notif")

    <form method="POST" enctype="multipart/form-data" action="@if(Request::segment(2)=='create'){{ url(Request::segment(1)) }}@else{{ url(Request::segment(1), $data->doctor_id) }}@endif">

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

            <input type="text" class="form-control" id="identity_id" name="identity_id" value="@if(isset($data->identity_id)){{ $data->identity_id }} @else{{ old("identity_id") }}@endif" placeholder="masukan nomor identitas" minlength="3" maxlength="50" required >

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
            
            <input type="text" class="form-control" id="name" name="name" value="@if(isset($data->name)){{ $data->name }} @else{{ old("name") }}@endif" required minlength="4" maxlength="100" placeholder="Masukan Nama {{ StringHelper::getNameMenu() }} ..">

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

            <textarea name="address" id="address" required placeholder="Masukan Alamat {{ StringHelper::getNameMenu() }}" class="form-control" minlength="10" maxlength="100">@if(isset($data->address)){{ $data->address }}@else{{ old('address') }}@endif</textarea>

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

          <input type="text" class="form-control" id="birthplace" name="birthplace" value="@if(isset($data->birthplace)){{ $data->birthplace }} @else{{ old("birthplace") }}@endif" minlength="4" maxlength="100" placeholder="Masukan Tempat Lahir ..">

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

          <input type="email" value="@if(isset($data->email)){{ $data->email }}@else{{ old('email') }}@endif" class="form-control" minlength="10" maxlength="100" id="email" name="email" placeholder="Masukan Email {{ StringHelper::getNameMenu() }} ...">

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
          <label class="col-form-label">Jenis</label>
          <br>
          <label style="margin-left: 10px"><input type="radio" id="type" name="type" value="referral"> Refferal</label>
          <label style="margin-left: 10px"><input type="radio" id="type" name="type" value="dpjp"> DPJP</label>
          <br>
          @if($errors->has('type'))
          <label class="text-danger">
            {{ $errors->first('type') }}
          </label>
          @endif
        </div>

        <div class="col-md-4 mt-2">
          <label class="col-form-label">Status</label>
          <br>
          <label style="margin-left: 10px"><input type="radio" id="status" name="status" value="active"> Active</label>
          <label style="margin-left: 10px"><input type="radio" id="status" name="status" value="inactive"> Inactive</label>
          <br>
          @if($errors->has('status'))
          <label class="text-danger">
            {{ $errors->first('status') }}
          </label>
          @endif
        </div>

        @if(Request::segment(3)=="edit" or  Request::segment(2)=="create")
        <div class="col-md-4 mt-4">
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

  @if(isset($data->gender))
  $("#kelamin").val('{{ $data->gender }}');
  @else
  $("#kelamin").val('{{ old("kelamin") }}');
  @endif

  @if(old("type")!= null)
  $("#type[value={{ old("type") }}]").prop('checked', true);
  @elseif(isset($data->type) and $data->type != null)
  $("#type[value={{ $data->type }}]").prop('checked', true);
  @endif
  
  @if(isset($data->entry_year))
  $("#entry_year").val('{{ $data->entry_year }}');
  @else
  $("#entry_year").val('{{ old("entry_year") }}');
  @endif

  @if(isset($data->status) and $data->status=="active")
  $("#status[value=active]").prop('checked', true);
  @elseif(isset($data->status) and $data->status=="inactive")
  $("#status[value=inactive]").prop('checked', true);
  @else
  $("#status[value={{ old("status") }}]").prop('checked', true);
  @endif

  @if(isset($data->birthdate))
  $("#birthdate").val('{{ date("Y-m-d", strtotime($data->birthdate)) }}');
  @else
  $("#birthdate").val('{{ old("birthdate") }}');
  @endif

  @if(Request::segment(3)==null and  Request::segment(2)!="create")
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