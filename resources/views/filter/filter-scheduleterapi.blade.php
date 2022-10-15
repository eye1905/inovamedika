<div class="col-md-4">
  <label class="col-form-label">
    Fisioterapis
  </label>
  <select class="js-example-basic-single col-sm-12" id="fstaff_id" name="fstaff_id">
    <option value="">-- Pilih Fisioterapis --</option>
    @foreach($staff as $key => $value)
    <option value="{{ $value->staff_id }}">{{ $value->name }}</option>
    @endforeach
  </select>
</div>

<div class="col-md-4">
  <label class="col-form-label">
    Hari
  </label>
  <select class="js-example-basic-single" id="fday" name="fday">
    <option value="">-- Pilih Hari --</option>
    @foreach($hari as $key => $value)
    <option value="{{ $key }}">{{ ucfirst($value) }}</option>
    @endforeach
  </select>
</div>

<div class="col-md-4">
  <label class="col-form-label">
    Jadwal Shift
  </label>
  <select class="js-example-basic-single col-sm-12" id="fschedule_shift_id" name="fschedule_shift_id">
    <option value="">-- Pilih Hari --</option>
    @foreach($jadwal as $key => $value)
    <option value="{{ $value->schedule_shift_id }}">
      {{ ucfirst($value->name)." ( ".$value->start_clock." - ".$value->end_clock." )" }}
    </option>
    @endforeach
  </select>
</div>

<div class="col-md-12 text-end mt-2">
  <button class="btn btn-sm btn-primary" type="submit">
    <i class="fa fa-search"></i> Cari
  </button>
  <a href="{{ Request::segment(1) }}" class="btn btn-warning btn-sm">
    <i class="fa fa-refresh"></i> Reset
  </a>
</div>