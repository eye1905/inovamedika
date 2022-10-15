@extends("print.layout")
@section("title", "Laporan Penggunaan Alat")
@section("content")
<h4 class="text-title">
	<i class="fa fa-file"></i>	Laporan Penggunaan Alat
</h4>
<div style="margin-left: 20px">
	<label>Periode : 
		@if(isset($filter["start_date"])){{ StringHelper::dateindo($filter["start_date"]) }}@endif - 
		@if(isset($filter["end_date"])){{ StringHelper::dateindo($filter["end_date"]) }}@endif
	</label>
	<br>
	@if(isset($filter["name"]) and $filter["name"] !=null)
	<label>
		Mitra : <b>{{ StringHelper::ucsplit($filter["name"]) }}</b>
	</label>
	@endif
</div>
<table class="table1" style="margin-top: 5px;">
	<thead>
		<tr>
			<th scope="col"><b>Kode</b></th>
			<th scope="col"><b>Nama Alat</b></th>
			<th scope="col"><b>Mitra</b></th>
			<th scope="col"><b>Satuan</b></th>
			<th><b>Tgl. Penggunaan</b></th>
			<th><b>Durasi Penggunaan</b></th>
			<th style="text-align: right;"><b>Harga</b></th>
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
				{{ ucfirst($value->code) }}
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
			<td style="text-align: right;">
				{{ StringHelper::toRupiah($value->price) }}
			</td>
			@php
			$total += $value->price;
			@endphp
		</tr>
		@endforeach
		<tr style="background-color: grey; ">
			<th colspan="6" style="color: #FFFF; text-align: right;">
				<b>
					TOTAL : 
				</b>
			</th>
			<th style="color: #FFFF; text-align: right;">
				<b>
					{{ StringHelper::toRupiah($total) }}
				</b>
			</th>
		</tr>
	</tbody>
</table>
@endsection