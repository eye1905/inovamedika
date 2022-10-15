<div class="col-md-4">
  <label class="col-form-label">
    Nama Staff
  </label>
  <select class="js-example-basic-single col-sm-12" id="fstaff_id" name="fstaff_id">
    <option value="">-- Semua Data --</option>
    @foreach($staff as $key => $value)
    <option value="{{ $value->staff_id }}">{{ StringHelper::ucsplit($value->name) }}</option>
    @endforeach
  </select>
</div>

<div class="col-md-4">
  <label class="col-form-label">
    Tahun Awal Masuk
  </label>
  <select class="form-control" id="start_date" name="start_date" required>
    <option selected="selected" value="">-- Pilih Tahun Awal --</option>
    @php
    for($i=date('Y'); $i>=date('Y')-20; $i-=1){
      echo"<option value='$i'> $i </option>";
    }
    @endphp
  </select>
</div>

@include("filter.action")