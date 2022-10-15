@extends("template.layout")

@section("content")
<div class="card">
	<div class="card-body">
		@include("template.page-name")
		@include("template.notif")

		<form method="GET" action="{{ url()->current() }}" enctype="multipart/form-data" id="form-select">
			@csrf
			@include("filter.filter-collapse")
			<input type="hidden" name="_method" value="GET">
			<div class="row mt-3">
				<div class="col-sm-12 col-lg-12 col-xl-12">
					<div class="table-responsive">
						<table class="table table-hover">
							<thead class="table-dark">
								<tr>
									<th scope="col" rowspan="2">Role</th>
									<th scope="col" rowspan="2">Menu</th>
									<th scope="col" colspan="7" class="text-center">Akses</th>
									<th scope="col" class="text-center" rowspan="2">
										Action
									</th>
								</tr>
								<tr>
									<th scope="col">Read</th>
									<th scope="col">Create</th>
									<th scope="col">Update</th>
									<th scope="col">Delete</th>
									<th scope="col">Detail</th>
									<th scope="col">Import</th>
									<th scope="col">Export</th>
								</tr>
							</thead>
							<tbody>
								@foreach($data as $key => $value)
								<tr>
									<td>
										<a href="{{ url(Request::segment(1).'/'.$value->role_permission_id) }}">
											@if(isset($value->role->name)){{ ucfirst($value->role->name) }}@endif
										</a>
									</td>
									<td>
										<a href="{{ url(Request::segment(1).'/'.$value->role_permission_id) }}">
											@if(isset($value->menu->name)){{ ucfirst($value->menu->name) }}@endif
										</a>
									</td>
									<td>
										@if($value->read_permission==true)
										<i class="fa fa-check text-success"></i>
										@else
										<i class="fa fa-times text-danger"></i>
										@endif
									</td>
									<td>
										@if($value->create_permission==true)
										<i class="fa fa-check text-success"></i>
										@else
										<i class="fa fa-times text-danger"></i>
										@endif
									</td>
									<td>
										@if($value->update_permission==true)
										<i class="fa fa-check text-success"></i>
										@else
										<i class="fa fa-times text-danger"></i>
										@endif
									</td>
									<td>
										@if($value->delete_permission==true)
										<i class="fa fa-check text-success"></i>
										@else
										<i class="fa fa-times text-danger"></i>
										@endif
									</td>
									<td>
										@if($value->detail_permission==true)
										<i class="fa fa-check text-success"></i>
										@else
										<i class="fa fa-times text-danger"></i>
										@endif
									</td>
									<td>
										@if($value->import_permission==true)
										<i class="fa fa-check text-success"></i>
										@else
										<i class="fa fa-times text-danger"></i>
										@endif
									</td>
									<td>
										@if($value->export_permission==true)
										<i class="fa fa-check text-success"></i>
										@else
										<i class="fa fa-times text-danger"></i>
										@endif
									</td>
									<td class="text-center">
										{!! StringHelper::inc_dropdown($value->role_permission_id) !!}
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
				@include("template.paginate")
			</div>
		</form>
	</div>
</div>
@endsection

@section("script")
<script src="{{ URL::asset('js/select2/select2.full.min.js') }}"></script>
<script src="{{ URL::asset('js/select2/select2-custom.js') }}"></script>
<script type="text/javascript">
	$("#shareselect").change(function(){
		$("#_method").attr("method", "GET");
		$("#form-select").submit();
	});

	@if(isset($filter["page"]))
	$("#shareselect").val('{{ $filter["page"] }}');
	@endif

	@if(isset($filter["navigation_id"]))
	$("#navigation_id").val('{{ $filter["navigation_id"] }}');
	@endif

	@if(isset($filter["role_id"]))
	$("#role_id").val('{{ $filter["role_id"] }}');
	@endif

</script>
@endsection