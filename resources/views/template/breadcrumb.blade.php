<div class="container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-sm-6">
        <h3>
          @if(Request::segment(1) != null)
          @yield('title')
          @endif
        </h3>
      </div>
      <div class="col-12 col-sm-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="@if(Request::segment(1) != null){{ url(Request::segment(1)) }}@endif">
              <i class="@yield('icon-title')"></i>
            </a>
          </li>
          <li class="breadcrumb-item active">
            <a href="@if(Request::segment(1) != null){{ url(Request::segment(1)) }}@endif">
              @yield('title')
            </a>
          </li>
          @if(Request::segment(2) != null)
          <li class="breadcrumb-item active">
            <a href="{{ url(Request::segment(1)."/".Request::segment(2)) }}">
              {{ Request::segment(2) }}
            </a>
          </li>
          @endif
          @if(Request::segment(3) != null)
          <li class="breadcrumb-item active">
            <a href="{{ url(Request::segment(1)."/".Request::segment(2)."/".Request::segment(3)) }}">
              {{ Request::segment(3) }}
            </a>
          </li>
          @endif
        </ol>
      </div>
    </div>
  </div>
</div>