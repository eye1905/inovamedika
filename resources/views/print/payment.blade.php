@extends("print.layout")
@section("title", StringHelper::getNameMenu('payment'))
@section("content")
<h4 class="text-title">
	<i class="fa fa-file"></i>	Laporan {{ StringHelper::getNameMenu("payment") }}
</h4>
<table class="table1">
	<thead class="table-dark">
		<tr>
			<th>Kode Bayar</th>
			<th>Kode Tagihan</th>
			<th>Pasien</th>
			<th>Tgl Pembayaran</th>
			<th>Total Bayar</th>
			<th>Metode Bayar</th>
			<th>Keterangan</th>
			<th>Staff </th>
		</tr>
	</thead>
	<tbody>
		<tbody>
			@if(count($data) < 1)
			<tr>
				<td colspan="8" class="text-center">Data Kosong</td>
			</tr>
			@endif
			@foreach($data as $key => $value)
			<tr>
				<td>
					<a href="{{ url("medical/".$value->payment_id) }}">
						<b>{{ $value->payment_code }}</b>
					</a>
					<br>
					{{ $value->created_at }}
				</td>
				<td>
					<a href="{{ url("medical/".$value->medical_id) }}" target="_blank">
						<b>{{ $value->medical_code }}</b>
					</a>
				</td>
				<td>
					<b>{{ $value->pasien }} </b> (
					@if($value->gender=="male")
					Laki-Laki
					@else
					Perempuan
					@endif
					)
					<br>
					<i class="fa fa-phone"></i> {{ "62".$value->phone }}
				</td>
				<td>
					{{ StringHelper::daydate($value->date).", ".StringHelper::dateindo($value->date) }}
				</td>
				<td>
					{{ StringHelper::toRupiah($value->nominal) }}
				</td>
				<td>
					{{ $value->method }}
				</td>
				<td>
					{{ $value->name." ( ".$value->number." )" }}
				</td>
				<td>
					{{ $value->staff }}
				</td>
			</tr>
			@endforeach
		</tbody>
	</tbody>
</table>
@endsection