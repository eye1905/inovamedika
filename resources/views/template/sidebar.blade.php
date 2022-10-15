<ul class="sidebar-links" id="simple-bar">
  <li class="back-btn">
    <a href="{{ url('/') }}">
      <img class="img-fluid" src="{{ URL::asset('cc.png') }}" alt="">
    </a>
    <div class="mobile-back text-end">
      <span>Back</span>
      <i class="fa fa-angle-right ps-2" aria-hidden="true"></i>
    </div>
  </li>
  <br>
  
  @foreach($level1 as $key => $value)
  @php
  $url = $value->uri;
  @endphp

  @if(isset($level2[$value->navigation_id]))
  @php
  $level4 = $level2[$value->navigation_id];
  @endphp
  <li class="sidebar-list">
    <a class="sidebar-link sidebar-title" id="side-{{ $value->navigation_id }}" href="#">
      <i class="{{ $value->icon }}"></i>
      <span>{{ StringHelper::ucsplit($value->name) }}</span>
    </a>
    <ul class="sidebar-submenu" id="sub-menu-{{ $value->navigation_id }}">
      @foreach($level4 as $key2 => $value2)
      @php
      $url2 = $value2->uri;
      @endphp
      <li>
        <a href="{{ url($url2) }}" id="menu-item-{{ $value2->uri }}">
          {{ StringHelper::ucsplit($value2->name) }} 
        </a>
      </li>
      @endforeach
    </ul>
  </li>
  @elseif(!isset($level2[$value->navigation_id]))
  <li class="sidebar-list">
    <a class="sidebar-link sidebar-title link-nav" href="@if($url != null){{ url($url) }}@endif" id="link-nav-{{ $value->uri }}">
      <i class="{{ $value->icon }}"></i>
      <span>{{ StringHelper::ucsplit($value->name) }}</span>
    </a>
  </li>
  @endif
  @endforeach
</ul>