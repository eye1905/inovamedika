@php
$page_menu = \App\Models\Navigations::where("uri", Request::segment(1))->get()->first();
$acc = StringHelper::getAccess("create_permission");
$acc_import = StringHelper::getAccess("import_permission");
@endphp

<div class="row">
	<div class="col-md-6">
		<h3 class="font-roboto">
			<span>
				<i class="{{ $page_menu->icon }}"></i>
			</span>
			@if(Request::segment(2)=="create")
			Form Input Data {{ StringHelper::ucsplit($page_menu->name) }}
			@elseif(Request::segment(2)!= null and Request::segment(2)!= "create")
			Detail {{ StringHelper::ucsplit($page_menu->name) }}
			@elseif(Request::segment(2)== null)
			Data {{ StringHelper::ucsplit($page_menu->name) }}
			@elseif(Request::segment(3)== "edit")
			Edit Data {{ StringHelper::ucsplit($page_menu->name) }}
			@endif
		</h3>
	</div>
	<div class="col-md-6 text-end">
		@if(Request::segment(2)!= null)
		<a href="{{ url(Request::segment(1)) }}" class="btn btn-sm btn-warning">
			<i class="fa fa-reply"> </i> Kembali
		</a>
		@else
			@if($acc == 1)
			<a href="{{ url(Request::segment(1).'/create') }}" class="btn btn-sm btn-primary">
				<i class="fa fa-plus"> </i> Tambah {{ StringHelper::ucsplit($page_menu->name) }}
			</a>
			@endif

			@if($acc_import == 1)
			<a href="#" onclick="goImport()" class="btn btn-sm btn-info">
				<i class="fa fa-upload"> </i> 
				Import Data {{ StringHelper::ucsplit($page_menu->name) }}
			</a>
			@endif
		@endif
	</div>
</div>
<hr>