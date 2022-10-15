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
				<div class="col-sm-12 col-lg-12 col-xl-12">
					<div class="table-responsive">
						<table class="table table-hover">
							<thead class="table-dark">
								<tr>
									<th scope="col">No</th>
									<th scope="col">Fisioterapis</th>
									<th scope="col">Pasien</th>
									<th scope="col">Paket</th>
									<th scope="col" class="text-center">Pertemuan</th>
									<th scope="col" class="text-center">Tgl. Treatment</th>
									<th scope="col" class="text-center">Tgl. Pengisian</th>
									<th scope="col" >Keterangan</th>
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
									<td>
										{{ $value->staff }}
									</td>
									<td>
										{{ $value->pasien }}
									</td>
									<td>
										{{ $value->paket }}
									</td>
									<td>
										{{ $value->meeting_index }}
									</td>
									<td>
										{{ StringHelper::daydate($value->date).", ".StringHelper::dateindo($value->date) }}
									</td>
									<td>@if(isset($value->created_at)){{ StringHelper::daydate($value->created_at).", ".StringHelper::dateindo($value->created_at) }}@endif
									</td>
									<td>
										{{ $value->diagnose_description }}
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