@extends("template.layout")
@section("content")
<div class="card">
  <div class="card-body">
    @include("template.page-name")
    @include("template.notif")
    <form method="POST" enctype="multipart/form-data" action="{{ url(Request::segment(1)."/".$pasien->patient_id."/savepackage") }}">
      @csrf
      
      {{ method_field("PUT") }}
      
      <div class="row">
        <div class="col-md-3">
          <img class="img-thumbnail" src="{{ $pasien->picture }}" name="img1" id="img1" width="80%">
        </div>
        <div class="col-md-9 row">
          <div class="col-md-6">
            <label class="col-form-label">
              No. Rekam Medis
            </label>
            <input type="text" class="form-control" value="@if(isset($pasien->medical_record_number)){{ $pasien->medical_record_number }}@endif" disabled readonly>
          </div>
          <div class="col-md-6">
            <label class="col-form-label">
              Nama Pasien
            </label>
            <input type="text" class="form-control" value="@if(isset($pasien->name)){{ ucfirst($pasien->name) }}@endif" disabled readonly>
          </div>
          <div class="col-md-6">
            <label class="col-form-label">
              Referral dokter
            </label>
            <input type="text" class="form-control" value="@if(isset($pasien->refferal->name)){{ ucfirst($pasien->refferal->name) }}@endif" disabled readonly>
          </div>
          <div class="col-md-6">
            <label class="col-form-label">
              Jenis Kelamin
            </label>
            <input type="text" class="form-control" value="@if(isset($pasien->gender) and $pasien->gender=="male"){{ 'Laki-Laki' }}@else{{ 'Perempuan' }}@endif" disabled readonly>
          </div>
          <div class="col-md-6">
            <label class="col-form-label">
              Tgl. Lahir
            </label>
            <input type="text" class="form-control" value="{{ StringHelper::dateindo($pasien->birthdate) }}" disabled readonly>
          </div>
          <div class="col-md-6">
            <label class="col-form-label">
              Usia
            </label>
            <input type="text" class="form-control" value="{{ $pasien->usia }}" disabled readonly>
          </div>
          <hr class="mt-3">
          <h4>
            <i class="fa fa-stethoscope"></i> Paket Treatment
          </h4>
          <div class="col-md-6">
            <label class="col-form-label">
              Paket Treatment <span class="text-danger"> *</span>
            </label>
            <select class="js-example-basic-single col-sm-12" id="package_id" name="package_id" required>
              <option value="">-- Pilih Paket --</option>
              @foreach($paket as $key => $value)
              <option value="{{ $value->package_id }}">{{ ucfirst($value->name) }}</option>
              @endforeach
            </select>
            <input type="hidden" name="nama_paket" id="nama_paket">
            @if($errors->has('package_id'))
            <label class="text-danger">
              {{ $errors->first('package_id') }}
            </label>
            @endif
          </div>
          <div class="col-md-6">
            <label class="col-form-label">
              Tanggal Mulai Treatment <span class="text-danger"> *</span>
            </label>
            <input type="date" class="form-control" id="registration_date" name="registration_date" placeholder="Masukan Tgl Treatment" value="@if(isset($data->registration_date)){{ $data->registration_date }}@else{{ old('registration_date') }}@endif" required>
            @if($errors->has('registration_date'))
            <label class="text-danger">
              {{ $errors->first('registration_date') }}
            </label>
            @else
            <label class="text-notif">
              Tanggal Mulai Treatment berisi format tanggal (d/m/Y)
            </label>
            @endif
          </div>
          <div class="col-md-6">
            <label class="col-form-label">
              Waktu Treatment<span class="text-danger"> *</span>
            </label>
            
            <select class="form-control" id="times" name="times" required>
              <option value="">-- Pilih Waktu Treatment --</option>
              @foreach($times as $key => $value)
              <option value="{{ $value->schedule_shift_id }}">
                {{ $value->start_clock." - ".$value->end_clock }}
              </option>
              @endforeach
            </select>
            @if($errors->has('times'))
            <label class="text-danger">
              {{ $errors->first('times') }}
            </label>
            @else
            <label class="text-notif">
              Waktu Treatment berisi format jam (HH:ii)
            </label>
            @endif
          </div>
          
          <div class="col-md-6">
            <label class="col-form-label">
              Fisioterapis <span class="text-danger"> *</span>
            </label>
            
            <select class="form-control" id="staff_id" name="staff_id" readonly disabled required>
              <option value="">-- Pilih Fisioterapis --</option>
            </select>
            
            <input type="hidden" name="nm_staff" id="nm_staff">
            @if($errors->has('package_id'))
            <label class="text-danger">
              {{ $errors->first('package_id') }}
            </label>
            @endif
          </div>
          
          <div class="col-md-6">
            <label class="col-form-label">
              Jumlah Pertemuan Paket
            </label>
            <input type="number" class="form-control" name="total" id="total" readonly>
          </div>
          <div class="col-md-6">
            <label class="col-form-label">
              Sisa Jumlah Pertemuan Paket
            </label>
            <input type="number" class="form-control" name="ready" id="ready" readonly>
          </div>
          
          <div class="col-md-6">
            <label class="col-form-label">
              Diagnosa <span class="text-danger"> *</span>
            </label>
            
            <select class="js-example-basic-single col-sm-12" id="diagnose_id" name="diagnose_id" required>
              <option value="">-- Pilih Diagnosa --</option>
              @foreach($diagnosa as $key => $value)
              <option value="{{ $value->diagnose_id }}">{{ StringHelper::ucsplit($value->name) }}</option>
              @endforeach
            </select>
            
            @if($errors->has('diagnose_id'))
            <label class="text-danger">
              {{ $errors->first('diagnose_id') }}
            </label>
            @endif
          </div>
          
          <div class="form-group col-md-6 mt-2">
            <label for="description">
              <b>Catatan</b>
            </label>
            <textarea class="form-control m-input m-input--square" maxlength="255" name="note" id="note" placeholder="Masukan Catatan ...">@if(isset($data->note)){{$data->note}}@else{{old('note')}}@endif</textarea>
            @if ($errors->has('note'))
            <label class="text-danger">
              {{ $errors->first('note') }}
            </label>
            @else
            <label class="text-notif">
              Catatan  berisi 10 - 255 Karakter
            </label>
            @endif
          </div>
          
          <div class="col-md-12 text-center mt-2">
            <button type="submit" class="btn btn-sm btn-primary">
              Atur Jadwal  <i class="fa fa-chevron-right" style="margin-left: 5px"></i>
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
@section("script")
<script src="{{ URL::asset('js/select2/select2.full.min.js') }}"></script>
<script src="{{ URL::asset('js/select2/select2-custom.js') }}"></script>
<script type="text/javascript">
  $("#registration_date").val('{{ date("Y-m-d") }}');
  $(".form-read").css("background-color", "#FFFF");
  
  $("#package_id").on("change", function(e) {
    var name = $(this).find("option:selected").text();
    $("#nama_paket").val(name);
    $.ajax({
      type: "POST",
      dataType: "json",
      data:{package_id:this.value, patient_id:"{{ $pasien->patient_id }}", _token: "{{ csrf_token() }}"},
      url: "{{ url('patient') }}/"+this.value+"/getpackage",
      success: function(data) {
        $("#total").val(data.total);
        $("#ready").val(data.ready);
      },
    });
  });
  
  $("#registration_date").on("change", function(e) {
    $("#times").val('');
  });
  
  $("#times").on("change", function(e) {
    getTerapis();
  });

 function getTerapis() {
  $.ajax({
    type: "POST",
    dataType: "json",
    data:{date:$("#registration_date").val(), times:$("#times").val(), _token: "{{ csrf_token() }}"},
    url: "{{ url('appointment') }}/"+$("#times").val()+"/getlistterapis",
    success: function(data) {
      $("#staff_id").removeAttr("readonly");
      $("#staff_id").removeAttr("disabled");
      $("#staff_id").empty();
      $("#staff_id").append('<option value="">-- Pilih Fisioterapis --</option>');
      $.each(data, function(key, value) {
        $("#staff_id").append('<option value="'+key+'">'+value.name+'</option>');
      });
    },
  });
}
  
  $("#staff_id").on("change", function(e) {
    var name = $(this).find("option:selected").text();
    $("#nm_staff").val(name);
  });
  
  @if(old("nama_paket")!= null and old("package_id") != null)
  $('#package_id').val({{ old("package_id") }});
  @endif
  
  @if(old("times"))
  $('#times').val('{{ old("times") }}');
  @endif
  
  @if(old("diagnose_id"))
  $('#diagnose_id').val('{{ old("diagnose_id") }}');
  @endif
  
  @if(old("registration_date")!=null)
  $('#registration_date').val('{{ old("registration_date") }}');
  @endif
  
  @if(old("total")!=null)
  $('#total').val('{{ old("total") }}');
  @endif
  
  @if(old("ready")!=null)
  $('#ready').val('{{ old("ready") }}');
  @endif
  
  @if(old("nm_staff")!= null and old("staff_id") != null)
  $("#staff_id").removeAttr("readonly");
  $("#staff_id").removeAttr("disabled");
  $('#staff_id').append('<option value="{{ old("staff_id") }}">{{ strtoupper(old("nm_staff")) }}</option>');
  $('#staff_id').val('{{ old("staff_id") }}');
  @endif
</script>
@endsection