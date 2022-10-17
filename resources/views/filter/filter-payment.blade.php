<div class="col-md-4">
  <label class="col-form-label">
    Kode Tagihan
  </label>
  <select class="js-example-basic-single col-sm-12" id="f_medical_code" name="f_medical_code">
    <option value="">-- Semua Data --</option>
    @foreach($code as $key => $value)
    <option value="{{ $value->medical_code }}">{{ strtoupper($value->medical_code) }}</option>
    @endforeach
  </select>
</div>

<div class="col-md-4">
  <label class="col-form-label">
    Nama Pasien
  </label>
  <select class="js-example-basic-single col-sm-12" id="f_patient_id" name="f_patient_id">
    <option value="">-- Semua Pasien --</option>
    @foreach($pasien as $key => $value)
    <option value="{{ $value->patient_id }}">{{ StringHelper::ucsplit($value->name) }}</option>
    @endforeach
  </select>
</div>

<div class="col-md-4">
  <label class="col-form-label">
    Metode Bayar 
  </label>

  <select class="form-control" id="f_method" name="f_method">
    <option value="">-- Semua Metode --</option>
    @foreach($metode as $key => $value)
    <option value="{{ $key }}">{{ $value }}</option>
    @endforeach
  </select>
</div>

<div class="col-md-4">
  <label class="col-form-label">
    Tgl. Awal Pemeriksaan
  </label>
  <input type="date" class="form-control" id="start_date" name="start_date">
</div>

<div class="col-md-4">
  <label class="col-form-label">
    Tgl. Akhir Pemeriksaan
  </label>
  <input type="date" class="form-control" id="end_date" name="end_date">
</div>

<div class="col-md-4" style="margin-top: 40px">
  <button class="btn btn-sm btn-primary" type="submit">
    <i class="fa fa-search"></i> Cari
  </button>
  <a href="{{ Request::segment(1) }}" class="btn btn-warning btn-sm">
    <i class="fa fa-refresh"></i> Reset
  </a>
</div>