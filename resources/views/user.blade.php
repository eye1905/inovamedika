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
									<th scope="col">No</th>
									<th scope="col">Nama
										{{ StringHelper::getNameMenu() }}
									</th>
									<th scope="col">Username</th>
									<th scope="col">Role</th>
									<th scope="col">Kontak</th>
									<th scope="col">Status</th>
									<th scope="col">
										Action
									</th>
								</tr>
							</thead>
							<tbody>
								@if(count($data)<1)
								<tr>
									<td colspan="6" class="text-center">Data Kosong</td>
								</tr>
								@endif
								@foreach($data as $key => $value)
								<tr>
									<td>{{ $key+1 }}</td>
									<td>
										<a href="{{ url(Request::segment(1)."/".$value->user_id) }}">
											{{ ucfirst($value->name) }}
											@if(isset($value->staff->gender) and $value->staff->gender=="male")
											<br> > Laki-Laki
											@elseif(isset($value->staff->gender) and $value->staff->gender=="female")
											<br> > Perempuan
											@else
											<br> -
											@endif
										</a>
									</td>
									<td>
										{{ $value->username }}
									</td>
									<td>
										@if(isset($roles[$value->user_id]))
										@foreach($roles[$value->user_id] as $key2 => $value2)
										- {{ ucfirst($value2->role) }}
										<br>
										@endforeach
										@endif
									</td>
									<td>
										{{ $value->email }}
										<br>
										> {{ "62".$value->phone }}
									</td>
									<td>
										@if($value->status == "active")
										<span class="badge rounded-pill badge-success">Active</span>
										@elseif($value->status == "inactive")
										<span class="badge rounded-pill badge-warning">Inactive</span>
										@elseif($value->status == "suspended")
										<span class="badge rounded-pill badge-danger">Suspended</span>
										@else
										<span class="badge rounded-pill badge-danger">Deleted</span>
										@endif
									</td>
									<td width="200" class="text-center">
										<button class="btn btn-sm btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
										<div class="dropdown-menu">
											@if(StringHelper::getAccess("update_permission")==true)
											{{-- <a class="dropdown-item" href="#">
												<i class="fa fa-retweet"></i> Ganti Role
											</a>
											<a class="dropdown-item" href="#">
												<i class="fa fa-pencil"></i> Ubah Status
											</a> --}}
											<a class="dropdown-item" href="{{ url(Request::segment(1)."/".$value->user_id."/edit") }}">
												<i class="fa fa-edit"></i> Edit
											</a>
											@endif
											@if(StringHelper::getAccess("delete_permission")==true)
											<a class="dropdown-item" href="#" onclick="CheckDelete('{{ url(Request::segment(1)) }}/{{ $value->user_id }}')">
												<i class="fa fa-times"></i> Hapus
											</a>
											@endif
										</div>
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
<script type="text/javascript">
	$("#shareselect").change(function(){
		$("#_method").attr("method", "GET");
		$("#form-select").submit();
	});
	@if(isset($filter["page"]))
	$("#shareselect").val('{{ $filter["page"] }}');
	@endif
</script>
<script src="{{ URL::asset('js/select2/select2.full.min.js') }}"></script>
<script src="{{ URL::asset('js/select2/select2-custom.js') }}"></script>
@endsection