<div class="text-end" id="btn-filters">
  <button class="btn btn-info btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
    <i class="fa fa-bars"></i> Filter
  </button>
</div>
<div class="collapse show" id="collapseExample">
  <div style="padding: 5px" class="row">
    @include("filter.filter-".Request::segment(1))
  </div>
</div>