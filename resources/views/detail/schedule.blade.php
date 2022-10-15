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

      <hr class="mt-3">
      <h4>
        <i class="fa fa-stethoscope"></i> Paket Treatment
      </h4>

      <div class="col-md-4">
        <label class="col-form-label">
          Paket Treatment
        </label>

        <input type="text" class="form-control" value="@if(isset($data->paket->name)){{ ucfirst($data->paket->name) }}@endif" disabled readonly>
      </div>

      <div class="col-md-4">
        <label class="col-form-label">
          Tanggal Mulai Treatment
        </label>

        <input type="text" class="form-control" value="@if(isset($data->registration_date)){{ $data->registration_date }}@endif" disabled readonly>
      </div>

      <div class="col-md-4">
        <label class="col-form-label">
          Jumlah Pertemuan
        </label>

        <input type="text" class="form-control" value="@if(isset($data->total_meet)){{ $data->total_meet." Pertemuan" }}@endif" disabled readonly>
      </div>

      <div class="col-md-4">
        <label class="col-form-label">
          Sisa Pertemuan
        </label>

        <input type="text" class="form-control" value="@if(isset($data->remaining_meet)){{ $data->remaining_meet." Pertemuan" }}@endif" disabled readonly>
      </div>

      <div class="col-md-8">
        <label class="col-form-label">
          Catatan
        </label>
        <textarea class="form-control" disabled readonly>@if(isset($data->note)){{ $data->note }}@endif</textarea>
      </div>
      
      <div class="mt-2">
        <hr>
      </div>
      <div class="col-md-6">
        <h4>
          <i class="fa fa-calendar"></i> Jadwal Treatment
        </h4>
      </div>
      @if(Session("role_id")<5)
      <div class="col-md-6 text-end">
        <button type="button" class="btn btn-sm btn-primary" onclick="goEditAll()">
          <i class="fa fa-gear"></i> Atur Ulang Semua Jadwal
        </button>
      </div>
      @endif
      <div class="col-md-12 table-responsive">
        <table class="table table-hover mt-2">
          <thead class="table-dark">
            <tr>
              <th>
                Pertemuan Ke
              </th>
              <th>
                Tanggal
              </th>
              <th>
                Fisioterapi
              </th>
              <th>
                Jam
              </th>
              <th>
                Treament
              </th>
              <th>
                Assesment
              </th>
              <th>
                Aksi
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach($detail as $key => $value)
            <tr>
              <td>
                {{ $value->meeting_index }}
              </td>
              <td>
                {{ StringHelper::daydate($value->date_scheduled).", ".StringHelper::dateindo($value->date_scheduled) }}
              </td>
              <td>
                {{ ucfirst($value->name) }}
              </td>
              <td>
                {{ $value->start_clock." - ".$value->end_clock }}
              </td>
              <td>
                @if($value->is_claimed == true)
                <span class="badge rounded-pill badge-success">Treatment Selesai</span>
                @else
                <span class="badge rounded-pill badge-warning text-dark">
                  Belum Selesai
                </span>
                @endif
              </td>
              <td>
                @if($value->is_assesment == true)
                <span class="badge rounded-pill badge-success">
                  Submitted
                </span>
                @else
                <span class="badge rounded-pill badge-warning text-dark">
                  Unsubmitted
                </span>
                @endif
              </td>
              <td>

                @if(Session("role_id") < 5)
                @if(($value->is_claimed == null or !$value->is_claimed) or ($value->is_assesment == null or !$value->is_assesment)) 
                <button class="btn btn-sm btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Aksi</button>
                <div class="dropdown-menu">
                  @if(StringHelper::getAccess("update_permission")==true and ($value->is_claimed!=true and $value->is_assesment!=true))
                  <a class="dropdown-item" href="#" onclick="goEdit('{{ $value->patient_package_meet_id }}','{{ $value->date_scheduled }}','{{ $value->schedule_shift_id }}')">
                    <i class="fa fa-edit"></i> Edit Jadwal
                  </a>
                  @endif

                  @if(StringHelper::getAccess("update_permission")==true)
                  
                  @if($value->is_claimed == null or !$value->is_claimed)
                  <a class="dropdown-item" href="{{ url("appointment/".$value->patient_package_meet_id."/treatment") }}">
                    <i class="fa fa-check"></i> Proses Treatment
                  </a>
                  @endif

                  @if($value->is_claimed==true and ($value->is_assesment == null or !$value->is_assesment))
                  <a class="dropdown-item" href="{{ url("appointment/".$value->patient_package_meet_id."/assesment") }}">
                    <i class="fa fa-medkit"></i> Proses Assesment
                  </a>
                  @endif

                  @endif
                </div>
                @endif
                @endif

                @if(Session("role_id")>4 and $value->staff_id==Auth::user()->staff_id)
                @if(($value->is_claimed == null or !$value->is_claimed) or ($value->is_assesment == null or !$value->is_assesment))
                <button class="btn btn-sm btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Aksi</button>
                <div class="dropdown-menu">

                  @if(StringHelper::getAccess("update_permission")==true)
                  
                  @if($value->is_claimed == null or !$value->is_claimed)
                  <a class="dropdown-item" href="{{ url("appointment/".$value->patient_package_meet_id."/treatment") }}">
                    <i class="fa fa-check"></i> Proses Treatment
                  </a>
                  @endif

                  @if($value->is_claimed==true and ($value->is_assesment == null or !$value->is_assesment))
                  <a class="dropdown-item" href="{{ url("appointment/".$value->patient_package_meet_id."/assesment") }}">
                    <i class="fa fa-medkit"></i> Proses Assesment
                  </a>
                  @endif
                  @endif
                  @endif
                </div>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>

<div class="modal fade bd-example-modal-sm" id="modal-schedule" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="mySmallModalLabel">Form Detail Jadwal Treatment</h4>
        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="#" enctype="multipart/form-data" id="form-schedule">
        @csrf
        <input type="hidden" name="_method" id="method_desc" value="PUT">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 mt-2">
              <label class="col-form-label">
                Hari dan Tanggal Jadwal Treatment<span class="text-danger"> *</span>
              </label>

              <input type="date" class="form-control" id="registration_date" name="registration_date" placeholder="Masukan Tgl Treatment" value="@if(isset($data->registration_date)){{ $data->registration_date }}@else{{ old('registration_date') }}@endif" required>
              @if($errors->has('registration_date'))
              <label class="text-danger">
                {{ $errors->first('registration_date') }}
              </label>
              @else
              <label class="text-notif">
                Hari dan Tanggal berisi format tanggal (d/m/Y)
              </label>
              @endif
            </div>

            <div class="col-md-12 mt-2">
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

            <div class="col-md-12 mt-2">
              <label class="col-form-label">
                Fisioterapi <span class="text-danger"> *</span>
              </label>

              <select class="form-control form-read" id="staff_id" name="staff_id" readonly required disabled>
                <option value="">-- Pilih Fisioterapi --</option>
              </select>

              <input type="hidden" name="nm_staff" id="nm_staff">
              @if($errors->has('package_id'))
              <label class="text-danger">
                {{ $errors->first('package_id') }}
              </label>
              @endif
            </div>
            
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-success">
            <i class="fa fa-save"></i> Simpan
          </button>
          <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">
            <i class="fa fa-times"></i> Batal
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section("script")
<script type="text/javascript">
  function goEdit(id, day, shift){
    $("#registration_date").val(day);
    $("#times").val(shift);
    $("#modal-schedule").modal("show");
    $("#form-schedule").attr("action", "{{ url(Request::segment(1)) }}"+"/"+id+"/editschedule");
  }
  
  function goEditAll() {
    $("#modal-schedule").modal("show");
    $("#form-schedule").attr("action", "{{ url(Request::segment(1)."/".Request::segment(2)) }}"+"/editallschedule");
  }

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

  @if(old("nm_staff")!= null and old("staff_id") != null)
  $("#staff_id").removeAttr("readonly");
  $("#staff_id").removeAttr("disabled");
  $('#staff_id').append('<option value="{{ old("staff_id") }}">{{ strtoupper(old("nm_staff")) }}</option>');
  $('#staff_id').val('{{ old("staff_id") }}');
  @endif

  @if(old("times"))
  $('#times').val('{{ old("times") }}');
  @endif
  
  @if(old("registration_date")!=null)
  $('#registration_date').val('{{ old("registration_date") }}');
  @endif

</script>
@endsection