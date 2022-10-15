@extends("template.layout")
@section("content")
<div class="card">
	<div class="card-body">
		@include("template.page-name2")
		@include("template.notif")
		<form method="GET" action="{{ url()->current() }}" enctype="multipart/form-data" id="form-select">
			@csrf
			<input type="hidden" name="_method" value="GET">
			<div class="row">
				@include("filter.filter-collapse")
				<div class="col-md-12">
					<div class="table-responsive">
						<table class="table table-hover">
							<thead class="table-dark">
								<tr>
									<th scope="col">No</th>
									<th scope="col">Nama </th>
									<th scope="col">Jenis Kelamin</th>
									<th scope="col">Kontak</th>
									<th scope="col">Tahun Masuk</th>
									<th scope="col">Usia</th>
									<th scope="col">Status</th>
									<th scope="col">Jumlah Treatment</th>
								</tr>
							</thead>
							<tbody>
								@if(count($data) < 1)
								<tr>
									<td class="text-center" colspan="7">Data Kosong</td>
								</tr>
								@endif
								@foreach($data as $key => $value)
								<tr>
									<td>
										{{ $key+1 }}
									</td>
									<td>
										<b>{{ $value->name }}</b>
										<br> >
										{{ $value->identity_id }}
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
										{{ $value->entry_year }}
									</td>
									<td>
										@php
										$usia = StringHelper::datedifferent(date("Y-m-d"), $value->birthdate);
										@endphp
										{{ $usia }}
									</td>
									<td>
										@if($value->staff_status == "active")
										<span class="badge rounded-pill badge-success">Active</span>
										@elseif($value->staff_status == "inactive")
										<span class="badge rounded-pill badge-warning">Inactive</span>
										@else
										<span class="badge rounded-pill badge-danger">Keluar</span>
										@endif
									</td>
									<td>
										@if(isset($stats[$value->staff_id]))
										{{ $stats[$value->staff_id] }}
										@else
										0
										@endif
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
<script type="text/javascript">
	@if(isset($filter["is_terapis"]))
	$("#is_terapis").val('{{ $filter["is_terapis"] }}');
	@endif
	
	@if(isset($filter["start_date"]) and $filter["start_date"]!=null)
	$("#start_date").val('{{ $filter["start_date"] }}');
	@endif

	@if(isset($filter["fstaff_id"]) and $filter["fstaff_id"]!=null)
	$("#fstaff_id").val('{{ $filter["fstaff_id"] }}');
	@endif
	
</script>
<script src="{{ URL::asset('js/select2/select2.full.min.js') }}"></script>
<script src="{{ URL::asset('js/select2/select2-custom.js') }}"></script>
@endsection