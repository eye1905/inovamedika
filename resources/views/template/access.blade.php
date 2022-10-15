@php
$ses_login = Session("role_id");

if($ses_login == 1){
  $level1 = App\Models\Navigations::getMenu(1);
  $level = App\Models\Navigations::getMenu(2);
}else{
  $level1 = App\Models\RolePermition::getMenu(1, $ses_login);
  $level = App\Models\RolePermition::getMenu(2, $ses_login);
  $access_login = App\Models\RolePermition::getAccess(Request::segment(1), $ses_login);
}

$level2 = [];
foreach ($level as $key => $value) {
  $level2[$value->parent_navigation_id][$key] = $value;
}
@endphp

@php
$nav_menu = \App\Models\Navigations::where("uri", Request::segment(1))->get()->first();
@endphp
@section('description', ucfirst($nav_menu->description))
@section('title', ucfirst($nav_menu->name))
@section('icon-title',strtolower($nav_menu->icon))