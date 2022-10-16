@extends("template.layout")

@section("content")
<div class="card">
	<div class="card-body">
		@include("template.page-name")
		@include("template.notif")
		<form method="GET" action="{{ url()->current() }}" enctype="multipart/form-data" id="form-select">
			@csrf
			<input type="hidden" name="_method" value="GET">
			@include("filter.filter-collapse")
			<div class="row mt-2">
				<div class="col-sm-12">
					<div class="table-responsive">
						<table class="table table-hover">
							<thead class="table-dark">
								<tr>
									<th scope="col">No</th>
									<th scope="col">Nama 
										{{ StringHelper::getNameMenu() }}
									</th>
									<th scope="col">Jenis Kelamin</th>
									<th scope="col">Kontak</th>
									<th scope="col">Status</th>
									<th scope="col" class="text-center">
										Action
									</th>
								</tr>
							</thead>
							<tbody>
								@if(count($data) < 1)
								<tr>
									<td class="text-center" colspan="8">Data Kosong</td>
								</tr>
								@endif
								@foreach($data as $key => $value)
								<tr>
									<td>
										{{ $key+1 }}
									</td>
									<td>
										<a href="{{ url(Request::segment(1)."/".$value->patient_id) }}">
											<b>{{ ucfirst($value->name) }}</b>
											<br> >
											{{ $value->medical_record_number }}
										</a>
									</td>
									<td>
										@if($value->gender=="male")
										Laki-Laki
										@else
										Perempuan
										@endif
									</td>
									<td>
										<i class="fa fa-phone"></i> {{ "62".$value->phone }}
										<br>
										<i class="fa fa-envelope"></i> {{ $value->email }}
									</td>
									<td>
										@if($value->status == "active")
										<span class="badge rounded-pill badge-success">Active</span>
										@elseif($value->status == "inactive")
										<span class="badge rounded-pill badge-warning text-dark">Inactive</span>
										@endif
									</td>
									<td width="200" class="text-center">
										<button class="btn btn-sm btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
										<div class="dropdown-menu">
											@if(StringHelper::getAccess("update_permission")==true)
											<a class="dropdown-item" href="#" onclick="changeStatus('{{ $value->patient_id }}', '{{ $value->status }}')">
												<i class="fa fa-pencil"></i> Ubah Status
											</a>

											<a class="dropdown-item" href="{{ url(Request::segment(1)."/".$value->patient_id."/edit") }}">
												<i class="fa fa-edit"></i> Edit
											</a>

											<a class="dropdown-item" href="{{ url(Request::segment(1)."/".$value->patient_id."/medical") }}">
												<i class="fa fa-chevron-right"></i> Pemeriksaan Medis
											</a>
											@endif


											@if(StringHelper::getAccess("delete_permission")==true)
											<a class="dropdown-item" href="#" onclick="CheckDelete('{{ url(Request::segment(1)) }}/{{ $value->patient_id }}')">
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

<div class="modal fade" id="modal-status" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" style="margin-left: 7%; font-weight: bold;">Apakah Anda ingin mengubah Status ?</h4>
				<button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			
			<div class="modal-body row">
				<form method="POST" action="#" enctype="multipart/form-data" id="form-status">
					@csrf
					{{ method_field("PUT") }}
					<div class="col-md-12">
						<label>
							Status {{ StringHelper::getNameMenu() }}
							<span class="text-danger"> * </span>
						</label>

						<select class="form-control" id="status" name="status" required>
							<option value="active">Active</option>
							<option value="inactive">Inactive</option>
						</select>

						@if($errors->has('staff_status'))
						<label class="text-danger">
							{{ $errors->first('staff_status') }}
						</label>
						@endif
					</div>
					<br>
					<div class="col-md-12 mt-2 text-end">
						<hr>
						<button type="submit" class="btn btn-success">
							<i class="fa fa-save"></i> Simpan
						</button>

						<button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
							<span aria-hidden="true"><i class="fa fa-times"></i> Tidak</span>
						</button>
					</div>
				</form>
			</div>
		</div>
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
	
	@if(isset($filter["doctor_id"]))
	$("#doctor_id").val('{{ $filter["doctor_id"] }}');
	@endif

	@if(isset($filter["patient_status_id"]))
	$("#patient_status_id").val('{{ $filter["patient_status_id"] }}');
	@endif

	@if(isset($filter["fpatient_id"]))
	$("#fpatient_id").val('{{ $filter["fpatient_id"] }}');
	@endif
	
	@if(isset($filter["kelamin"]))
	$("#kelamin").val('{{ $filter["kelamin"] }}');
	@endif
	
	@if(isset($filter["start_date"]) and $filter["start_date"]!=null)
	$("#start_date").val('{{ $filter["start_date"] }}');
	@endif

	@if(isset($filter["end_date"]) and $filter["end_date"]!=null)
	$("#end_date").val('{{ $filter["end_date"] }}');
	@endif

	function changeStatus(id, status) {
		$("#status").val(status);
		$("#form-status").attr("action", "{{ url(Request::segment(1)) }}/"+id+"/changestatus");
		$("#modal-status").modal("show");
	}
</script>
@endsection