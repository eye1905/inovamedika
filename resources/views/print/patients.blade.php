@extends("print.layout")
@section("title", StringHelper::getNameMenu('patient'))
@section("content")
<h4 class="text-title">
	<i class="fa fa-file"></i>	Laporan {{ StringHelper::getNameMenu("patient") }}
</h4>
<table class="table1">
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
@endsection