@extends("print.layout")
@section("title", StringHelper::ucsplit("fisioterapis"))
@section("content")
<h4 class="text-title">
	<i class="fa fa-file"></i>	Laporan fisioterapis
</h4>
<table class="table1">
	<thead>
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
@endsection