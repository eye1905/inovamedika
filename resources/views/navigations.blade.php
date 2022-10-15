@extends("template.layout")

@section("content")
<div class="card">
	<div class="card-body">
		@include("template.page-name")
		@include("template.notif")
		<form method="GET" action="{{ url()->current() }}" enctype="multipart/form-data" id="form-select">
			@csrf
			<input type="hidden" name="_method" value="GET">
			<div class="row">
				<div class="col-sm-12 col-lg-12 col-xl-12">
					<div class="table-responsive">
						<table class="table table-hover">
							<thead class="table-dark">
								<tr>
									<th>
										{{ StringHelper::getNameMenu() }}
									</th>
									<th>Uri</th>
									<th>Controller</th>
									<th>Level</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@if(count($data) < 1)
								<tr>
									<td colspan="6" class="text-center">Data Kosong</td>
								</tr>
								@endif
								@foreach($data as $key => $value)
								@if(isset($level2[$value->navigation_id]))
								<tr>
									<td>
										<i class="{{ $value->icon }}"></i>
										<label>{{ ucfirst($value->name) }}</label> 
										>
									</td>
									<td>
										{{ $value->uri }}
									</td>
									<td>
										{{ $value->controller }}
									</td>
									<td>
										{{ $value->level }}
									</td>
									<td width="400">
										<a href="{{ url(Request::segment(1).'/up/'.$value->navigation_id) }}" class="btn btn-sm btn-info" style="color: #fff" data-toggle="tooltip" data-placement="bottom" title="Up Menu">
											<i class="fa fa-arrow-up"></i>
										</a>
										<a href="{{ url(Request::segment(1).'/down/'.$value->navigation_id) }}" class="btn btn-sm btn-info" style="color: #fff" data-toggle="tooltip" data-placement="bottom" title="Down Menu">
											<i class="fa fa-arrow-down"></i>
										</a>

										<a href="{{ url(Request::segment(1).'/'.$value->navigation_id.'/edit') }}" class="btn btn-sm btn-warning" style="color: #fff" data-toggle="tooltip" data-placement="bottom" title="Edit">
											<i class="fa fa-pencil"></i>
										</a>
										<button class="btn btn-sm btn-danger" type="button" onclick="CheckDelete('{{ url(Request::segment(1)) }}/{{ $value->navigation_id }}')" data-toggle="tooltip" data-placement="bottom" title="Delete">
											<i class="fa fa-times"></i>
										</button>
									</td>
								</tr>
								@foreach($level2[$value->navigation_id] as $key2 => $value2)
								<tr>
									<td>
										<i class="{{ $value2->icon }}" style="margin-left: 20px;"></i>
										<label>{{ ucfirst($value2->name) }}</label>
									</td>
									<td>
										{{ $value2->uri }}
									</td>
									<td>
										{{ $value2->controller }}
									</td>
									<td>
										{{ $value2->level }}
									</td>
									<td width="400">
										<a href="{{ url(Request::segment(1).'/up/'.$value2->navigation_id) }}" class="btn btn-sm btn-info" style="color: #fff" data-toggle="tooltip" data-placement="bottom" title="Up Menu">
											<i class="fa fa-arrow-up"></i>
										</a>
										<a href="{{ url(Request::segment(1).'/down/'.$value2->navigation_id) }}" class="btn btn-sm btn-info" style="color: #fff" data-toggle="tooltip" data-placement="bottom" title="Down Menu">
											<i class="fa fa-arrow-down"></i>
										</a>

										<a href="{{ url(Request::segment(1).'/'.$value2->navigation_id.'/edit') }}" class="btn btn-sm btn-warning" style="color: #fff" data-toggle="tooltip" data-placement="bottom" title="Edit">
											<i class="fa fa-pencil"></i>
										</a>
										<button class="btn btn-sm btn-danger" type="button" onclick="CheckDelete('{{ url(Request::segment(1)) }}/{{ $value2->navigation_id }}')" data-toggle="tooltip" data-placement="bottom" title="Delete">
											<i class="fa fa-times"></i>
										</button>
									</td>
								</tr>
								@endforeach
								@else
								<tr>
									<td>
										<i class="{{ $value->icon }}"></i>
										<label>{{ ucfirst($value->name) }}</label>
									</td>
									<td>
										{{ $value->uri }}
									</td>
									<td>
										{{ $value->controller }}
									</td>
									<td>
										{{ $value->level }}
									</td>
									<td width="400">
										<a href="{{ url(Request::segment(1).'/up/'.$value->navigation_id) }}" class="btn btn-sm btn-info" style="color: #fff" data-toggle="tooltip" data-placement="bottom" title="Up Menu">
											<i class="fa fa-arrow-up"></i>
										</a>
										<a href="{{ url(Request::segment(1).'/down/'.$value->navigation_id) }}" class="btn btn-sm btn-info" style="color: #fff" data-toggle="tooltip" data-placement="bottom" title="Down Menu">
											<i class="fa fa-arrow-down"></i>
										</a>

										<a href="{{ url(Request::segment(1).'/'.$value->navigation_id.'/edit') }}" class="btn btn-sm btn-warning" style="color: #fff" data-toggle="tooltip" data-placement="bottom" title="Edit">
											<i class="fa fa-pencil"></i>
										</a>
										<button class="btn btn-sm btn-danger" type="button" onclick="CheckDelete('{{ url(Request::segment(1)) }}/{{ $value->navigation_id }}')" data-toggle="tooltip" data-placement="bottom" title="Delete">
											<i class="fa fa-times"></i>
										</button>
									</td>
								</tr>
								@endif
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection

@section("script")
<script type="text/javascript">
	$("#shareselect").change(function(){
		$("#_method").attr("method", "GET");
		$("#form-select").submit();
	});

	@if(isset($filter["page"]))
	$("#shareselect").val('{{ $filter["page"] }}');
	@endif

</script>
@endsection