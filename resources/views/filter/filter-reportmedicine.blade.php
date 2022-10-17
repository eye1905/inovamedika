<div class="col-md-4">
  <label class="col-form-label">
    Nama Obat
  </label>
  <select class="js-example-basic-single col-sm-12" id="f_medicine_id" name="f_medicine_id">
    <option value="">-- Semua Data --</option>
    @foreach($obat as $key => $value)
    <option value="{{ $value->medicine_id }}">{{ $value->name." ( ".$value->code." ) " }}</option>
    @endforeach
  </select>
</div>

<div class="col-md-4" style="margin-top: 35px">
  <button class="btn btn-sm btn-primary" type="submit">
    <i class="fa fa-search"></i> Cari
  </button>
  <a href="{{ Request::segment(1) }}" class="btn btn-warning btn-sm">
    <i class="fa fa-refresh"></i> Reset
  </a>
  @include("filter.export")
</div>