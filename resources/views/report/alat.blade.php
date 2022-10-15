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
									<th scope="col">Kode</th>
									<th scope="col">Nama Alat</th>
									<th>Mitra</th>
									<th scope="col">Satuan</th>
									<th>Tgl. Penggunaan</th>
									<th>Durasi Penggunaan</th>
									<th>Harga</th>
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
								@php
								$total = 0;
								@endphp
								@foreach($data as $key => $value)
								<tr>
									<td>
										{{ $value->code }}
									</td>
									<td>
										{{ $value->alat }}
									</td>
									<td>
										{{ $value->mitra }}
									</td>
									<td>
										{{ $value->quantity." x ".$value->satuan }}
									</td>
									<td>
										{{ StringHelper::dateindo($value->created_at) }}
									</td>
									<td>
										{{ $value->usage_duration }}
									</td>
									<td class="text-end">
										{{ StringHelper::toRupiah($value->price) }}
									</td>
									@php
									$total += $value->price;
									@endphp
								</tr>
								@endforeach
								<tr style="background-color: grey;">
									<th colspan="6" class="text-end text-white">
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
	@if(isset($filter["page"]))
	$("#shareselect").val('{{ $filter["page"] }}');
	@endif
	@if(isset($filter["start_date"]) and $filter["start_date"]!=null)
	$("#start_date").val('{{ $filter["start_date"] }}');
	@endif
	
	@if(isset($filter["end_date"]) and $filter["end_date"]!=null)
	$("#end_date").val('{{ $filter["end_date"] }}');
	@endif

	@if(isset($filter["partner_id"]) and $filter["partner_id"]!=null)
	$("#partner_id").val('{{ $filter["partner_id"] }}');
	@endif
</script>
@endsection