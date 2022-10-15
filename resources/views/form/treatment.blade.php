@extends("template.layout")
@section("content")
<div class="card">
  <div class="card-body">
    @include("detail.pagename-paket")
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

    @if(count($detail)>=1)
    <div class="row  mt-2">
      <hr>
      <div class="col-md-4">
        <h4>
          <i class="fa fa-calendar"></i> Hasil Treatment Sebelumnya
        </h4>
      </div>
      <div class="col-md-12 table-responsive">
        <table class="table table-hover mt-2">
          <thead class="table-dark">
            <tr>
              <th>Pertemuan</th>
              <th>Tgl. Treatment</th>
              <th>Fisioterapi</th>
              <th>Keterangan</th>
            </tr>
          </thead>
          <tbody>
            @foreach($detail as $key =>  $value)
            <tr>
              <td>{{ $key+1 }}</td>
              <td>{{ StringHelper::daydate($value->date).", ".StringHelper::dateindo($value->date) }}</td>
              <td>
                @if(isset($value->staff->name))
                {{ ucfirst($value->staff->name) }}
                @endif
              </td>
              <td>
                {{ $value->diagnose_description }}
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @endif
    
    <form method="POST" enctype="multipart/form-data" action="{{ url("treatment") }}">
      @csrf

      <input type="hidden" name="patient_package_meet_id" id="" value="{{ Request::segment(2) }}">
      <div class="row">
        <div class="mt-2">
          <hr>
          <h4>
            <i class="fa fa-stethoscope"></i> Treatment Pertemuan Ke @if(isset($meet->meeting_index)){{ $meet->meeting_index}}@endif
          </h4>
        </div>

        <div class="col-md-4">
          <label class="col-form-label">
            Tgl. Treatment <span class="text-danger"> *</span>
          </label>

          <input type="date" class="form-control" readonly disabled value="{{ $meet->date_scheduled }}" disabled>
        </div>
        
        <div class="col-md-4">
          <label class="col-form-label">
            Diagnosa <span class="text-danger"> *</span>
          </label>

          <select class="js-example-basic-single col-sm-12" id="diagnose_id" name="diagnose_id" required>
            @foreach($diagnosa as $key => $value)
            <option value="{{ $value->diagnose_id }}" @if($value->diagnose_id==$data->diagnose_id) selected @endif>{{ $value->name }}</option>
            @endforeach
          </select>

        </div>

        <div class="form-group col-md-4">
          <label for="description">
            <b>Keterangan</b>
          </label>
          <textarea class="form-control m-input m-input--square" maxlength="255" name="diagnose_description" id="diagnose_description" placeholder="Masukan Keterangan ...">@if(isset($data->diagnose_description)){{$data->diagnose_description}}@else{{old('diagnose_description')}}@endif</textarea>
          @if ($errors->has('diagnose_description'))
          <label class="text-danger">
            {{ $errors->first('diagnose_description') }}
          </label>
          @else
          <label class="text-notif">
            Keterangan  berisi 10 - 255 Karakter
          </label>
          @endif
        </div>

        <div class="col-md-12 text-center mt-4">
          <a href="{{ url('appointment/'.$data->patient_package_id) }}" class="btn btn-sm btn-info">
            <i class="fa fa-chevron-left"></i> Appointment
          </a>
          <button type="submit" class="btn btn-sm btn-primary">
            Assesment <i class="fa fa-chevron-right"></i>
          </button>
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
  $("#date").val("{{ $meet->date_scheduled }}");
  
  @if(old("diagnose_id") != null)
  $('#diagnose_id').val('{{ old("diagnose_id") }}');
  @endif

</script>
@endsection