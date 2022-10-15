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
									<th scope="col">Dokter</th>
									<th scope="col">Tgl Referral</th>
									<th scope="col">Pasien</th>
									<th scope="col">Paket Treatment</th>
									<th scope="col" class="text-end">Nominal</th>
								</tr>
							</thead>
							<tbody>
								@if(count($data) < 1)
								<tr>
									<td class="text-center" colspan="5">Data Kosong</td>
								</tr>
								@endif
								@php
								$total = 0;
								@endphp
								@foreach($data as $key => $value)
								<tr>
									<td>
										{{ $key+1 }}
									</td>
									<td>
										@if(isset($value->doctor->name))
										{{ $value->doctor->name }}
										@endif
									</td>
									<td>
										{{ StringHelper::daydate($value->date_referral).", ".StringHelper::dateindo($value->date_referral) }}
									</td>
									<td>
										@if(isset($value->pasien->name))
										{{ $value->pasien->name }}
										@else
										-
										@endif
									</td>
									<td>
										@if(isset($value->paket->name))
										{{ StringHelper::ucsplit($value->paket->name) }}
										@else
										-
										@endif
									</td>
									<td class="text-end">
										{{ StringHelper::toRupiah($value->nominal) }}
										@php
										$total += $value->nominal;
										@endphp
									</td>
								</tr>
								@endforeach
								<tr style="background-color: grey;">
									<th colspan="5" class="text-end text-white">
										<b>
											TOTAL : 
										</b>
									</th>
									<th class="text-end text-white">
										<b>
											{{ StringHelper::toRupiah($total) }}
										</b>
									</th>
								</tr>
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
	@if(isset($filter["doctor_id"]))
	$("#doctor_id").val('{{ $filter["doctor_id"] }}');
	@endif
	
	@if(isset($filter["start_date"]) and $filter["start_date"]!=null)
	$("#start_date").val('{{ $filter["start_date"] }}');
	@endif

	@if(isset($filter["end_date"]) and $filter["end_date"]!=null)
	$("#end_date").val('{{ $filter["end_date"] }}');
	@endif
	
</script>
@endsection