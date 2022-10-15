@extends("template.layout")
@section("content")
<div class="card">
	<div class="card-body">
		@include("template.page-name2")
		@include("template.notif")
		<form method="GET" action="{{ url()->current() }}" enctype="multipart/form-data">
			@csrf
			@include("filter.filter-collapse")
			<div class="row mt-2">
				<div class="col-sm-12">
					<div class="table-responsive">
						<table class="table table-hover">
							<thead class="table-dark">
								<tr>
									<th scope="col" rowspan="2">No Registerasi</th>
									<th scope="col" rowspan="2">Pasien</th>
									<th scope="col" rowspan="2">Paket</th>
									<th scope="col" colspan="2"class="text-center">Tanggal</th>
									<th scope="col" colspan="3" class="text-center">Pertemuan</th>
									<th scope="col" rowspan="2" class="text-center">Status</th>
								</tr>
								<tr>
									<th>
										Registerasi
									</th>
									<th>
										Pertemuan Selanjutnya
									</th>
									<th>
										Total
									</th>
									<th>
										Diambil
									</th>
									<th>
										Sisa
									</th>
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
									@php
									$ambil = 0;
									$ambil = $value->total_meet-$value->remaining_meet;
									@endphp 
									<td>
										<b>{{ ucfirst($value->registration_code) }}</b>
									</td>
									<td>
										@if(isset($value->pasien))
										{{ $value->pasien }}
										@endif
									</td>
									<td>
										@if(isset($value->paket))
										{{ $value->paket }}
										@endif
									</td>
									<td class="text-center">
										{{ StringHelper::daydate($value->registration_date).", ".StringHelper::dateindo($value->registration_date) }}
									</td>
									<td class="text-center">
										@if($value->remaining_meet != 0)
										{{ StringHelper::daydate($value->date_scheduled).", ".StringHelper::dateindo($value->date_scheduled) }}
										@else
										-
										@endif
									</td>
									<td>
										{{ $value->total_meet }}
									</td>
									<td>
										{{ $value->total_meet-$value->remaining_meet }}
									</td>
									<td>
										{{ $value->remaining_meet }}
									</td>
									<td class="text-center">
										@if($ambil == 0)
										<span class="badge rounded-pill badge-warning">
											Baru
										</span>
										@elseif($ambil != 0 and $value->remaining_meet!= 0)
										<span class="badge rounded-pill badge-info">
											Proses
										</span>
										@else
										<span class="badge rounded-pill badge-success">
											Selesai
										</span>
										@endif
									</td>
									@endforeach
								</tbody>
							</table>
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
	$("#shareselect").change(function(){
		$("#_method").attr("method", "GET");
		$("#form-filter").submit();
	});

	function goSubmit() {
		$("#form-filter").submit();
	}

	@if(isset($filter["page"]))
	$("#shareselect").val('{{ $filter["page"] }}');
	@endif
	@if(isset($filter["start_date"]) and $filter["start_date"]!=null)
	$("#start_date").val('{{ $filter["start_date"] }}');
	@endif
	
	@if(isset($filter["end_date"]) and $filter["end_date"]!=null)
	$("#end_date").val('{{ $filter["end_date"] }}');
	@endif

	@if(isset($filter["patient_id"]) and $filter["patient_id"]!=null)
	$("#patient_id").val('{{ $filter["patient_id"] }}');
	@endif
	
	@if(isset($filter["package_id"]) and $filter["package_id"]!=null)
	$("#package_id").val('{{ $filter["package_id"] }}');
	@endif
	
	@if(isset($filter["status"]) and $filter["status"]!=null)
	$("#status").val('{{ $filter["status"] }}');
	@endif
</script>
@endsection