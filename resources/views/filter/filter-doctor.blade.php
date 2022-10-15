<div class="col-md-4">
  <label class="col-form-label">
    Nama Dokter
  </label>
  <select class="js-example-basic-single col-sm-12" id="fdoctor_id" name="fdoctor_id">
    <option value="">-- Semua Data --</option>
    @foreach($dokter as $key => $value)
    <option value="{{ $value->doctor_id }}">{{ StringHelper::ucsplit($value->name) }}</option>
    @endforeach
  </select>
</div>

<div class="col-md-4">
  <label class="col-form-label">
    Jenis Dokter
  </label>
  <select class="js-example-basic-single col-sm-12" id="ftype" name="ftype">
    <option value="">-- Semua Data --</option>
    <option value="referral">Referral</option>
    <option value="dpjp">dpjp</option>
  </select>
</div>

<div class="col-md-4">
  <label class="col-form-label">
    Tahun Awal Aktif
  </label>
  <select class="form-control" id="start_date" name="start_date">
    <option selected="selected" value="">-- Pilih Tahun Awal --</option>
    @php
    for($i=date('Y'); $i>=date('Y')-20; $i-=1){
      echo"<option value='$i'> $i </option>";
    }
    @endphp
  </select>
</div>

<div class="col-md-12 mt-2 text-end" >
  <button class="btn btn-sm btn-primary" type="submit">
    <i class="fa fa-search"></i> Cari
  </button>
  <a href="{{ Request::segment(1) }}" class="btn btn-warning btn-sm">
    <i class="fa fa-refresh"></i> Reset
  </a>
</div>