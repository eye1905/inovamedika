@extends("print.layout")
@section("title", "Laporan Penggunaan Referral")
@section("content")
<h4 class="text-title">
	<i class="fa fa-file"></i>	Laporan Penggunaan Referral
</h4>
<div style="margin-left: 20px">
	<label>Periode :
		@if(isset($filter["start_date"])){{ StringHelper::dateindo($filter["start_date"]) }}@endif -
		@if(isset($filter["end_date"])){{ StringHelper::dateindo($filter["end_date"]) }}@endif
	</label>
	<br>
	@if(isset($filter["name"]) and $filter["name"] !=null)
	<label>
		Doctor : <b>{{ StringHelper::ucsplit($filter["name"]) }}</b>
	</label>
	@endif
</div>
<table class="table1" style="margin-top: 5px;">
	<thead>
		<tr>
			<th scope="col">No</th>
			<th scope="col">Dokter</th>
			<th scope="col">Tgl Referral</th>
			<th scope="col">Pasien</th>
			<th scope="col">Paket Treatment</th>
			<th scope="col" style="text-align: right;">Nominal</th>
		</tr>
	</thead>
	<tbody>
		@if(count($data) < 1)
		<tr>
			<td style="text-align:center;" colspan="5">Data Kosong</td>
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
				{{ $value->paket->name }}
				@else
				-
				@endif
			</td>
			<td style="text-align: right;">
				{{ StringHelper::toRupiah($value->nominal) }}
				@php
				$total += $value->nominal;
				@endphp
			</td>
		</tr>
		@endforeach
		<tr style="background-color: grey;">

			
			<th colspan="5" style="text-align: right;">
				<b>
					TOTAL :
				</b>
			</th>
			<th style="text-align:right;">
				<b>
					{{ StringHelper::toRupiah($total) }}
				</b>
			</th>
		</tr>
	</tbody>
</table>
@endsection