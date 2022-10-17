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
									<th scope="col">Nama
										{{ StringHelper::getNameMenu("patient") }}
									</th>
									<th scope="col">Jenis Kelamin</th>
									<th scope="col">Kontak</th>
									<th scope="col">Tgl. Registerasi</th>
									<th scope="col">Usia</th>
									<th scope="col">Status</th>
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
										<b>{{ $value->name }}</b>
										<br> >
										{{ $value->medical_record_number }}
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
										<i class="fa fa-email"></i> {{ $value->email }}
									</td>
									<td>
										{{ StringHelper::dateindo($value->first_entry) }}
									</td>
									<td>
										@php
										$usia = StringHelper::datedifferent(date("Y-m-d"), $value->birthdate);
										@endphp
										{{ $usia }}
									</td>
									<td>
										@if($value->status == "active")
										<span class="badge rounded-pill badge-success">Active</span>
										@elseif($value->status == "inactive")
										<span class="badge rounded-pill badge-warning text-dark">Inactive</span>
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

	@if(isset($filter["patient_status_id"]))
	$("#patient_status_id").val('{{ $filter["patient_status_id"] }}');
	@endif

	@if(isset($filter["kelamin"]))
	$("#kelamin").val('{{ $filter["kelamin"] }}');
	@endif
</script>
@endsection