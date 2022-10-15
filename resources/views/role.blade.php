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
									<th scope="col">Kode</th>
									<th scope="col">
										{{ StringHelper::getNameMenu() }}
									</th>
									<th scope="col">Deskripsi</th>
									<th scope="col">Self Data</th>
									<th scope="col" class="text-center">
										Action
									</th>
								</tr>
							</thead>
							<tbody>
								@foreach($data as $key => $value)
								<tr>
									<td>{{ $value->code }}</td>
									<td>
										<a href="{{ url(Request::segment(1).'/'.$value->role_id) }}">
											<b>
												{{ ucfirst($value->name) }}
											</b>
										</a>
									</td>
									<td>
										{{ $value->description }}
									</td>
									<td>
										@if($value->is_self==true)
										<i class="fa fa-check text-success"></i>
										@else
										<i class="fa fa-times text-danger"></i>
										@endif
									</td>
									<td class="text-center">
										{!! StringHelper::inc_edit($value->role_id) !!}
									</td>
								</tr>
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