@extends("print.layout")
@section("title", StringHelper::getNameMenu('medicine'))
@section("content")
<h4 class="text-title">
	<i class="fa fa-file"></i>	Laporan {{ StringHelper::getNameMenu("medicine") }}
</h4>
<table class="table1">
	<thead class="table-dark">
		<tr>
			<th>Kode </th>
			<th>Nama Obat</th>
			<th>Indikasi </th>
			<th>Dosis </th>
			<th>Harga </th>
			<th>Jumlah Terjual</th>
			<th>Nominal Terjual</th>
		</tr>
	</thead>
	<tbody>
		@if(count($data) < 1)
		<tr>
			<td colspan="7" class="text-center">Data Kosong</td>
		</tr>
		@endif
		@foreach($data as $key => $value)
		<tr>
			<td>{{ $value->code }}</td>
			<td>
				{{ $value->name }}
			</td>
			<td>
				{{ $value->indikasi }}
			</td>
			<td>
				{{ $value->dosis }}
			</td>
			<td>
				{{ StringHelper::toRupiah($value->harga) }}
			</td>
			<td>
				@if(isset($jumlah[$value->medicine_id]))
				{{$jumlah[$value->medicine_id]}}
				@endif
			</td>
			<td>
				@if(isset($nominal[$value->medicine_id]))
				{{ StringHelper::toRupiah($nominal[$value->medicine_id] )}}
				@endif
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
@endsection