<div class="col-md-4">
  <label class="col-form-label">
    Nama Pegawai
  </label>
  <select class="js-example-basic-single col-sm-12" id="fstaff_id" name="fstaff_id">
    <option value="">-- Semua Pegawai --</option>
    @foreach($staff as $key => $value)
    <option value="{{ $value->staff_id }}">{{ StringHelper::ucsplit($value->name) }}</option>
    @endforeach
  </select>
</div>

<div class="col-md-4">
  <label class="col-form-label">
    Status
  </label>
  <select class="js-example-basic-single col-sm-12" id="f_status" name="f_status">
    <option value="">-- Semua Status --</option>
    <option value="active">Active</option>
    <option value="inactive">Inactive</option>
    <option value="leave">Keluar</option>
  </select>
</div>

<div class="col-md-4">
  <label class="col-form-label">
    Tahun Awal Masuk
  </label>
  <select class="form-control" id="start_date" name="start_date" required>
    <option selected="selected" value="">-- Semua Tahun --</option>
    @php
    for($i=date('Y'); $i>=date('Y')-20; $i-=1){
      echo"<option value='$i'> $i </option>";
    }
    @endphp
  </select>
</div>

<div class="col-md-12 text-end mt-1">
  <button class="btn btn-sm btn-primary" type="submit">
    <i class="fa fa-search"></i> Cari
  </button>
  <a href="{{ Request::segment(1) }}" class="btn btn-warning btn-sm">
    <i class="fa fa-refresh"></i> Reset
  </a>
</div>