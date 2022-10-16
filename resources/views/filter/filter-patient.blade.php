
<div class="col-md-4">
  <label class="col-form-label">
    Nama Pasien
  </label>
  <select class="js-example-basic-single col-sm-12" id="fpatient_id" name="fpatient_id">
    <option value="">-- Pilih Pasien --</option>
    @foreach($pasien as $key => $value)
    <option value="{{ $value->patient_id }}">{{ StringHelper::ucsplit($value->name) }}</option>
    @endforeach
  </select>
</div>

<div class="col-md-4">
  <label class="col-form-label">
    Jenis Kelamin 
  </label>

  <select class="form-control" id="kelamin" name="kelamin">
    <option value="">-- Pilih Jenis Kelamin --</option>
    <option value="male">Laki - Laki</option>
    <option value="female">Perempuan</option>
  </select>
</div>

<div class="col-md-4">
  <label class="col-form-label">
    Wilayah Asal 
  </label>

  <select class="form-control" id="f_wilayah" name="f_wilayah">
    <option value="">-- Pilih Semua Wilayah --</option>
  </select>
</div>

<div class="col-md-4">
  <label class="col-form-label">
    Tgl. Awal Terdaftar
  </label>
  <input type="date" class="form-control" id="start_date" name="start_date">
</div>

<div class="col-md-4">
  <label class="col-form-label">
    Tgl. Akhir Terdaftar
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