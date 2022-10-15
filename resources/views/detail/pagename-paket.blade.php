@php
$page_menu = \App\Models\Navigations::where("uri", Request::segment(1))->get()->first();
@endphp

<div class="row">
  <div class="col-md-6">
    <h3 class="font-roboto">
      <span>
        <i class="{{ $page_menu->icon }}"></i>
      </span>
      Data {{ StringHelper::ucsplit($page_menu->name) }}
    </h3>
  </div>
  <div class="col-md-6 text-end">
    <a href="{{ url(Request::segment(1)."/".$meet->patient_package_id) }}" class="btn btn-sm btn-warning">
      <i class="fa fa-reply"> </i> Kembali
    </a>
  </div>
</div>
<hr>