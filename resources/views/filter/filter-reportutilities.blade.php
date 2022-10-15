<div class="col-md-4">
  <label class="col-form-label">
    Tgl. Awal
  </label>
  <input type="date" class="form-control" id="start_date" name="start_date">
</div>

<div class="col-md-4">
  <label class="col-form-label">
    Tgl. Akhir
  </label>
  <input type="date" class="form-control" id="end_date" name="end_date">
</div>

<div class="col-md-4">
  <label class="col-form-label">
    Mitra
  </label>
  <select class="js-example-basic-single col-sm-12" id="partner_id" name="partner_id">
    <option value="">-- Pilih Mitra --</option>
    @foreach($mitra as $key => $value)
    <option value="{{ $value->partner_id }}">{{ StringHelper::ucsplit($value->name) }}</option>
    @endforeach
  </select>
</div>

<div class="col-md-12 mt-2 text-end">
  <button class="btn btn-sm btn-primary" type="submit">
    <i class="fa fa-search"></i> Cari
  </button>
  <a href="{{ Request::segment(1) }}" class="btn btn-warning btn-sm">
    <i class="fa fa-refresh"></i> Reset
  </a>
  @include("filter.export")
</div>