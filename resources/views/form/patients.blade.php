@extends("template.layout")

@section("content")
<div class="card">
  <div class="card-body">
    @include("template.page-name")
    @include("template.notif")

    <form method="POST" enctype="multipart/form-data" action="@if(Request::segment(2)=='create'){{ url(Request::segment(1)) }}@else{{ url(Request::segment(1), $data->patient_id) }}@endif">

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

            <img class="img-thumbnail" src="@if(isset($data->picture) and $data->picture != null){{ $data->picture }}@endif" name="img1" id="img1" style="height: 180px; width: 180px" onclick="$('#gambar').trigger('click'); return false;">

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
              No. Rekam Medis <span class="text-danger"> *</span>
            </label>

            <input type="text" class="form-control" id="record" name="record" value="@if(isset($data->medical_record_number)){{ $data->medical_record_number }} @else{{ old("record") }}@endif" placeholder="masukan no rekam medis" minlength="3" maxlength="50" required >

            @if($errors->has('record'))
            <label class="text-danger">
              {{ $errors->first('record') }}
            </label>
            @else
            <label class="text-notif">
              No. Rekam Medis huruf dan angka (3 - 50 Karakter)
            </label>
            @endif
          </div>

          <div class="col-md-6">
            <label class="col-form-label">
              Nama {{ StringHelper::getNameMenu() }} <span class="text-danger"> *</span>
            </label>

            <input type="text" class="form-control" id="name" name="name" value="@if(isset($data->name)){{ $data->name }} @else{{ old("name") }}@endif" required minlength="4" maxlength="100" placeholder="Masukan Nama  {{ StringHelper::getNameMenu() }} ..">

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

          <div class="col-md-6 mt-2">
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

          <div class="col-md-6 mt-2">
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
        </div>

        <div class="col-md-4">
          <label class="col-form-label">
            Tanggal Terdaftar {{ StringHelper::getNameMenu() }} <span class="text-danger"> *</span>
          </label>

          <input type="date" class="form-control" id="first_entry" name="first_entry" placeholder="Masukan Tgl Terdaftar {{ StringHelper::getNameMenu() }}">

          @if($errors->has('first_entry'))
          <label class="text-danger">
            {{ $errors->first('first_entry') }}
          </label>
          @else
          <label class="text-notif">
            Tgl terdaftar {{ StringHelper::getNameMenu() }} berisi format tanggal (dd-mm-yy)
          </label>
          @endif
        </div>

        <div class="col-md-4">
          <label class="col-form-label">
            Tgl. Lahir <span class="text-danger"> *</span>
          </label>
          <input type="date" class="form-control" id="birthdate" name="birthdate" placeholder="Masukan Tgl Lahir" required>

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
            Tempat Lahir
          </label>

          <input type="text" class="form-control" id="birthplace" name="birthplace" placeholder="Masukan tempat lahir {{ StringHelper::getNameMenu() }}">

          @if($errors->has('birthplace'))
          <label class="text-danger">
            {{ $errors->first('birthplace') }}
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

        <div class="col-md-4">
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

        @if(Request::segment(3)=="edit")
        <div class="col-md-12 text-end mt-4">
          @include("template.action")
        </div>
        @elseif(Request::segment(2)=="create")
        <div class="col-md-12 mt-4 text-center">
          <button class="btn btn-sm btn-primary">
           Buat Paket 
           <i class="fa fa-chevron-right"></i>
         </button>
       </div>
       @endif

     </div>
   </form>

 </div>
</div>
@endsection

@section("script")
<script src="{{ URL::asset('js/select2/select2.full.min.js') }}"></script>
<script src="{{ URL::asset('js/select2/select2-custom.js') }}"></script>
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

  @if(isset($data->status) and $data->status=="active")
  $("#status[value=active]").prop('checked', true);
  @elseif(isset($data->status) and $data->status=="inactive")
  $("#status[value=inactive]").prop('checked', true);
  @elseif(old("status")!=null)
  $("#status[value={{ old("status") }}]").prop('checked', true);
  @endif

  @if(isset($data->patient_status_id) and $data->patient_status_id)
  $("#patient_status_id").val('{{ $data->patient_status_id }}');
  @elseif(old("patient_status_id")!=null)
  $("#patient_status_id").val('{{ old("patient_status_id") }}');
  @endif
  
  @if(isset($data->birthplace) and $data->birthplace)
  $("#birthplace").val('{{ $data->birthplace }}');
  @elseif(old("birthplace")!=null)
  $("#birthplace").val('{{ old("birthplace") }}');
  @endif

  @if(isset($data->birthdate))
  $("#birthdate").val('{{ date("Y-m-d", strtotime($data->birthdate)) }}');
  @else
  $("#birthdate").val('{{ old("birthdate") }}');
  @endif

  @if(isset($data->first_entry))
  $("#first_entry").val('{{ date("Y-m-d", strtotime($data->first_entry)) }}');
  @else
  $("#first_entry").val('{{ old("first_entry") }}');
  @endif

  @if(isset($data->referral_doctor_id))
  $("#doctor_id").val('{{ $data->referral_doctor_id }}');
  @else
  $("#doctor_id").val('{{ old("doctor_id") }}');
  @endif

  @if(isset($data->dpjp_doctor_id))
  $("#dpjp_doctor_id").val('{{ $data->dpjp_doctor_id }}');
  @else
  $("#dpjp_doctor_id").val('{{ old("dpjp_doctor_id") }}');
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