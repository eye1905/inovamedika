@extends("print.layout")
@section("title", StringHelper::ucsplit(StringHelper::getNameMenu("appointment")))
@section("content")
<h4 class="text-title">
	<i class="fa fa-file"></i>	Laporan {{ StringHelper::ucsplit(StringHelper::getNameMenu("appointment")) }}
</h4>
<table class="table1">
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
	@endsection