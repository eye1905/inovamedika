<div class="col-md-4">
  <label class="col-form-label">
    Role
  </label>
  <select class="js-example-basic-single col-sm-12" id="role_id" name="role_id">
    <option value="">-- Pilih Role --</option>
    @foreach($role as $key => $value)
    <option value="{{ $value->role_id }}">{{ StringHelper::ucsplit($value->name) }}</option>
    @endforeach
  </select>
</div>

<div class="col-md-4">
  <label class="col-form-label">
    Menu
  </label>
  <select class="js-example-basic-single col-sm-12" id="navigation_id" name="navigation_id">
    <option value="">-- Pilih Menu --</option>
    @foreach($menu as $key => $value)
    <option value="{{ $value->navigation_id }}">{{ StringHelper::ucsplit($value->name) }}</option>
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
</div>