<div class="col-md-4">
  <label class="col-form-label">
    Pasien
  </label>
  <select class="js-example-basic-single col-sm-12" id="patient_id" name="patient_id">
    <option value="">-- Pilih Pasien --</option>
    @foreach($pasien as $key => $value)
    <option value="{{ $value->patient_id }}">{{ $value->name }}</option>
    @endforeach
  </select>
</div>

<div class="col-md-4">
  <label class="col-form-label">
    Paket
  </label>
  <select class="js-example-basic-single col-sm-12" id="package_id" name="package_id">
    <option value="">-- Pilih Paket --</option>
    @foreach($paket as $key => $value)
    <option value="{{ $value->package_id }}">{{ $value->name }}</option>
    @endforeach
  </select>
</div>

<div class="col-md-4">
  <label class="col-form-label">
    Status
  </label>
  <select class="form-control" id="status" name="status">
    <option value="">-- Semua Status --</option>
    <option value="0">Belum Selesai</option>
    <option value="1">Selesai</option>
  </select>
</div>


<div class="col-md-4">
  <label class="col-form-label">
    Tgl. Awal Pendaftaran
  </label>
  <input type="date" class="form-control" id="start_date" name="start_date">
</div>

<div class="col-md-4">
  <label class="col-form-label">
    Tgl. Akhir Pendaftaran
  </label>
  <input type="date" class="form-control" id="end_date" name="end_date">
</div>

@include("filter.action")