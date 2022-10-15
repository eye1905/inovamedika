@extends("template.layout")
@section("content")
<div class="card">
  <div class="card-body">
    @include("template.page-name")
    @include("template.notif")
    <div class="row">
      <div class="col-md-4">
        <label class="col-form-label">
          No. Rekam Medis
        </label>
        <input type="text" class="form-control" value="@if(isset($pasien->medical_record_number)){{ $pasien->medical_record_number }}@endif" disabled readonly>
      </div>
      
      <div class="col-md-4">
        <label class="col-form-label">
          Nama Pasien
        </label>
        <input type="text" class="form-control" value="@if(isset($pasien->name)){{ ucfirst($pasien->name) }}@endif" disabled readonly>
      </div>
      <div class="col-md-4">
        <label class="col-form-label">
          Referral dokter
        </label>
        <input type="text" class="form-control" value="@if(isset($pasien->refferal->name)){{ ucfirst($pasien->refferal->name) }}@endif" disabled readonly>
      </div>
      <div class="col-md-4">
        <label class="col-form-label">
          Jenis Kelamin
        </label>
        <input type="text" class="form-control" value="@if(isset($pasien->gender) and $pasien->gender=="male"){{ 'Laki-Laki' }}@else{{ 'Perempuan' }}@endif" disabled readonly>
      </div>
      <div class="col-md-4">
        <label class="col-form-label">
          Tgl. Lahir
        </label>
        <input type="text" class="form-control" value="{{ StringHelper::dateindo($pasien->birthdate) }}" disabled readonly>
      </div>
      <div class="col-md-4">
        <label class="col-form-label">
          Usia
        </label>
        <input type="text" class="form-control" value="{{ $pasien->usia }}" disabled readonly>
      </div>
      <div class="col-md-4">
        <label class="col-form-label">
          Paket Treatment
        </label>
        <input type="text" class="form-control" value="@if(isset($data->paket->name)){{ ucfirst($data->paket->name) }}@endif" disabled readonly>
      </div>
      <div class="col-md-4">
        <label class="col-form-label">
          Jumlah Pertemuan
        </label>
        <input type="text" class="form-control" value="@if(isset($data->total_meet)){{ $data->total_meet." Pertemuan" }}@endif" disabled readonly>
      </div>
      <div class="col-md-4">
        <label class="col-form-label">
          Pertemuan Ke
        </label>
        <input type="text" class="form-control" value="@if(isset($meet->meeting_index)){{ $meet->meeting_index}}@endif" disabled readonly>
      </div>
    </div>

    <form method="POST" enctype="multipart/form-data" action="{{ url("assesment", $ass->assesment_id) }}">
      @csrf
      @if(Request::segment(3)=="edit")
      {{ method_field("PUT") }}
      @endif

      <input type="hidden" name="patient_package_meet_id" id="" value="{{ Request::segment(2) }}">

      <hr>
      <div class="row">
        <div class="col-md-6 mt-2">
          <h4>
            <i class="fa fa-medkit"></i> Pemeriksaan Pertemuan Ke @if(isset($meet->meeting_index)){{ $meet->meeting_index}}@endif
          </h4>
        </div>

        <div class="col-md-6 text-end">
          @if(Request::segment(2)!= null and Request::segment(3)=="edit")
          <button type="button" onclick="goDetail()" class="btn btn-sm btn-primary">
            <i class="fa fa-eye"></i> Semua Assesment 
          </button>
          @endif
        </div>

        <div class="col-md-4">
          <label class="col-form-label">
            Tgl. Assesment <span class="text-danger"> *</span>
          </label>
          <input type="date" class="form-control" id="date_assesment" name="date_assesment" placeholder="Masukan Tgl Assesment" value="{{ $meet->date_scheduled }}" readonly disabled required>
        </div>

        <div class="col-md-4">
          <label class="col-form-label">
            Diagnosa <span class="text-danger"> *</span>
          </label>

          <input type="text" class="form-control" value="@if(isset($data->diagnosa->name)){{ StringHelper::ucsplit($data->diagnosa->name) }}@endif" disabled>
        </div>

        <div class="col-md-4">
          <label class="col-form-label">
            PIC
          </label>
          <input type="" name="" class="form-control" readonly disabled value="{{ $meet->staff->name }}">
        </div>

        @if(Request::segment(3)=="edit" and Session("role_id") < 4)
        <div class="col-md-12">
          <label class="col-form-label">
            <b>SOAP</b> <span class="text-danger"> *</span>
          </label>

          <textarea class="form-control" id="treatment" name="treatment" style="height: 300px" minlength="5" maxlength="1000" required>@if(old('treatment')!=null){{ old("treatment") }} @elseif(isset($ass->assesment_treatment)) {{ $ass->assesment_treatment }} @endif</textarea>
          @if($errors->has('treatment'))
          <label class="text-danger">
            {{ $errors->first('treatment') }}
          </label>
          @else
          <label class="text-notif">
            SOAP berisi 5  - 1000 Karakter
          </label>
          @endif
        </div>
        @endif
        
        @if(Request::segment(2)!=null and Request::segment(3)==null)
         <div class="col-md-12">
          <label class="col-form-label">
            <b>SOAP</b> <span class="text-danger"> *</span>
          </label>

          <textarea class="form-control" id="treatment" style="height: 300px" name="treatment" minlength="5" disabled required>@if(old('treatment')!=null){{ old("treatment") }} @elseif(isset($ass->assesment_treatment)) {{ $ass->assesment_treatment }} @endif</textarea>
          @if($errors->has('treatment'))
          <label class="text-danger">
            {{ $errors->first('treatment') }}
          </label>
          @endif
        </div>
        @endif
        
        <div class="col-md-12">
          <label class="col-form-label">
            <b>Treatment</b> <span class="text-danger"> *</span>
          </label>

          <textarea class="form-control" id="tindakan" style="height: 300px" name="tindakan" minlength="5" required>@if(old('tindakan')!=null){{ old("tindakan") }} @elseif(isset($ass->assesment_tindakan)) {{ $ass->assesment_tindakan }} @endif</textarea>
          @if($errors->has('tindakan'))
          <label class="text-danger">
            {{ $errors->first('tindakan') }}
          </label>
          @endif
        </div>
      </div>
      <div class="row mt-2">
        <div class="col-md-6">
          <h4>
            <i class="fa fa-stethoscope"></i> Penggunaan Alat Medis
          </h4>
        </div>

        @if(Request::segment(3)=="edit")

        @if(count($utilities)>=1 and Session("is_self")!=true)
        <div class="col-md-6 text-end">
          <button class="btn btn-sm btn-primary" type="button" onclick="addTools()">
            <i class="fa fa-plus"></i> Tambah Alat
          </button>
        </div>
        @endif

        <div class="col-md-12 table-responsive mt-2">
          <table class="table table-hover">
            <thead class="table-dark">
              <th>Alat</th>
              <th>Satuan</th>
              <th>Durasi</th>
              <th>
                Keterangan Penggunaan
              </th>
              <th>
                Aksi
              </th>
            </thead>
            <tbody id="table-tools">
              @foreach($tools as $key => $value)
              <tr>
                <td>
                  {{ ucfirst($value->alat) }}
                </td>
                <td>
                  {{ StringHelper::ucsplit($value->type) }}
                  <input type="hidden" name="satuan[]"  value="{{ $value->medical_utilities_detail_id }}" id="tools{{ $key }}" required> 
                </td>
                <td>

                  @if($key+1 <= $tools_paket)
                  {{ " ( ".$value->usage_duration." x ) " }}
                  <input type="hidden" name="durasi[]" id="durasi{{ $key }}" placeholder="masukan durasi" value="{{ $value->usage_duration }}" required>
                  @else
                  <input type="number" class="form-control" name="durasi[]" id="durasi{{ $key }}" placeholder="masukan durasi" value="{{ $value->usage_duration }}" required>
                  @endif
                </td>
                <td>
                  <textarea class="form-control" placeholder="masukan deskripsi" maxlength="255" name="description[]" id="description{{ $key }}">{{ $value->description }}</textarea>
                </td>
                <td>
                  @if($key+1 > $tools_paket)
                  <a href="{{ url("assesment/".$value->assesment_detail_id."/deletealat") }}" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        @else
        <div class="col-md-12 table-responsive mt-2">
          <table class="table table-hover">
            <thead class="table-dark">
              <th>Alat</th>
              <th>Satuan</th>
              <th>Durasi</th>
              <th>Keterangan Penggunaan</th>
            </thead>
            <tbody id="table-tools">
              @foreach($tools as $key => $value)
              <tr>
                <td>
                  {{ ucfirst($value->alat) }}
                </td>
                <td>
                  {{ StringHelper::ucsplit($value->type) }}
                </td>
                <td>
                  {{ $value->usage_duration }}
                </td>
                <td>
                  {{ $value->description }}
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @endif

        @if(Request::segment(3)=="edit")
        <div class="col-md-12 text-center mt-4">
          <button type="submit" class="btn btn-sm btn-success">
            <i class="fa fa-save"></i> Simpan Assesment
          </button>
        </div>
        @endif
      </div>
    </form>
  </div>
</div>

<div class="modal fade bd-example-modal-sm" id="modal-assesment" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="mySmallModalLabel">
          <i class="fa fa-eye"></i>
          Hasil Assesment
        </h4>
        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @if(count($assesment)>=1)
        <div class="table-responsive">
          <table class="table table-hover">
            <thead class="table-dark">
              <tr>
                <th>Pertemuan (Tgl)</th>
                <th>SOAP</th>
                <th>Treament</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($assesment as $key => $value)
              <tr>
                <td>
                  {{ ($key+1)." ( ".StringHelper::dateindo($value->date_assesment)." )" }}
                </td>
                <td>
                  {{ substr($value->assesment_treatment, 0, 40) }}
                </td>
                <td>
                  {{ substr($value->assesment_tindakan, 0, 40) }}
                </td>
                <td>
                  <a href="{{ url("assesment/".$value->assesment_id) }}" target="_blank" class="btn btn-sm btn-info">
                    <i class="fa fa-book"></i> Detail
                  </a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>

@endsection
@section("script")
<script type="text/javascript">
  @if(Request::segment(2)!= null and Request::segment(3)==null)
  $(".form-control").attr("readonly", true);
  $(".form-control").attr("disabled",  true);
  @else
  @endif

  function goDetail() {
    $("#modal-assesment").modal("show");
  }

  var id = {{ count($tools)+1 }};

  function addTools(){
    $("#table-tools").append('<tr><td><select name="tools[]" id="tools'+id+'" class="form-control" onchange="goGetSatuan('+id+')" required>@foreach($utilities as $key => $value)<option value="{{ $value->medical_utility_id }}">{{ ucfirst($value->name) }}</option>@endforeach</select></td><td><select name="satuan[]" id="satuan'+id+'" class="form-control" required><option>-- Pilih Satuan --</option></select></td><td><input type="number" name="durasi[]" class="form-control" id="durasi" placeholder="masukan durasi" required></td><td><textarea class="form-control" placeholder="masukan deskripsi" name="description[]" id="description[]"></textarea></td><td><button type="button" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button></td></tr>');
    id +=1;
  }
  

  @if(old('durasi') != null)
  @foreach(old('durasi') as $key => $value)
  $("#durasi{{ $key }}").val('{{ $value }}');
  @endforeach
  @endif
  
  @if(old('description') != null)
  @foreach(old('description') as $key => $value)
  $("#description{{ $key }}").text('{{ $value }}');
  @endforeach
  @endif

  $("#table-tools").on('click', '.btn-danger', function () {
    $(this).closest('tr').remove();
  });

  function goGetSatuan(ids) {
    var id_alat = $("#tools"+ids).val();
    $.ajax({
      type: "GET",
      dataType: "json",
      url: "{{ url('appointment') }}/"+id_alat+"/satuanalat",
      success: function(data) {
        $("#satuan"+ids).empty();
        $("#satuan"+ids).append('<option value="">-- Pilih Satuan --</option>');
        $.each(data, function(key, value) {
          $("#satuan"+ids).append('<option value="'+value.id+'">'+value.name+'</option>');
        });
      },
    });
  }
</script>
@endsection