
<div class="col-md-4" style="margin-top: 35px">
  <button class="btn btn-sm btn-primary" type="submit">
    <i class="fa fa-search"></i> Cari
  </button>
  <a href="{{ Request::segment(1) }}" class="btn btn-warning btn-sm">
    <i class="fa fa-refresh"></i> Reset
  </a>
  @if(StringHelper::getAccess("export_permission")==true)
  @include("filter.export")
  @endif
</div>