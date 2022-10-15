@extends("template.layout")
@section("content")
<div class="card">
	<div class="card-body">
		@include("template.page-name2")
		@include("template.notif")
		<form method="GET" action="{{ url()->current() }}" enctype="multipart/form-data" id="form-select">
			@csrf
			<input type="hidden" name="_method" value="GET">
			@include("filter.filter-collapse")
			<div class="row">
				<div class="col-md-12 mt-1">
					<div class="table-responsive">
						<table class="table table-hover">
							<thead class="table-dark">
								<tr>
									<th scope="col">No</th>
									@if(Session("role_id")<3)<th scope="col" >Fisioterapis</th>@endif
									<th scope="col">Pasien</th>
									<th scope="col" class="text-center">Paket</th>
									<th scope="col" class="text-center">Pertemuan</th>
									<th scope="col" class="text-center">Tgl. Assesment</th>
									<th scope="col" class="text-center">Tgl. Pengisian</th>
								</tr>
							</thead>
							<tbody>
								@if(count($data) < 1)
								<tr>
									<td class="text-center" colspan="7">
										<b>Data Kosong</b>
									</td>
								</tr>
								@endif
								@foreach($data as $key => $value)
								<tr>
									<td>{{ $key+1 }}</td>
									@if(Session("role_id")<3)
									<td>@if(isset($value->staff)){{ StringHelper::ucsplit($value->staff) }}@endif</td>
									@endif
									<td>@if(isset($value->pasien)){{ StringHelper::ucsplit($value->pasien) }}@endif</td>
									<td>@if(isset($value->paket)){{ StringHelper::ucsplit($value->paket) }}@endif</td>
									<td>
										@if(isset($value->meeting_index)){{ StringHelper::ucsplit($value->meeting_index) }}@endif
									</td>
									<td>@if(isset($value->date_assesment)){{ StringHelper::daydate($value->date_assesment).", ".StringHelper::dateindo($value->date_assesment) }}@endif
									</td>
									<td>@if(isset($value->created_at)){{ StringHelper::daydate($value->created_at).", ".StringHelper::dateindo($value->created_at) }}@endif
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

@section("script")
<script src="{{ URL::asset('js/select2/select2.full.min.js') }}"></script>
<script src="{{ URL::asset('js/select2/select2-custom.js') }}"></script>
<script type="text/javascript">
	@if(isset($filter["start_date"]) and $filter["start_date"]!=null)
	$("#start_date").val('{{ $filter["start_date"] }}');
	@endif

	@if(isset($filter["end_date"]) and $filter["end_date"]!=null)
	$("#end_date").val('{{ $filter["end_date"] }}');
	@endif

	@if(isset($filter["staff_id"]) and $filter["staff_id"]!=null)
	$("#staff_id").val('{{ $filter["staff_id"] }}');
	@endif

	@if(isset($filter["package_id"]) and $filter["package_id"]!=null)
	$("#package_id").val('{{ $filter["package_id"] }}');
	@endif

	@if(isset($filter["patient_id"]) and $filter["patient_id"]!=null)
	$("#patient_id").val('{{ $filter["patient_id"] }}');
	@endif
</script>
@endsection