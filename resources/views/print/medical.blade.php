@extends("print.layout")
@section("title", StringHelper::getNameMenu('medical'))
@section("content")
<h4 class="text-title">
	<i class="fa fa-file"></i>	Laporan {{ StringHelper::getNameMenu("medical") }}
</h4>
<table class="table1">
	<thead class="table-dark">
		<tr>
			<th>Kode</th>
			<th>Pasien</th>
			<th>Tgl Pemeriksaan</th>
			<th>Total Biaya</th>
			<th>Status </th>
			<th>Tindakan</th>
			<th>Resep Obat</th>
			<th>Staff </th>
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
				<a href="{{ url("medical/".$value->medical_id) }}">
					<b>{{ $value->medical_code }}</b>
				</a>
				<br>
				{{ $value->created_at }}
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
				{{ StringHelper::toRupiah($value->total) }}
			</td>
			<td>
				@if($value->status=="1")
				<span class="badge badge-warning"><i class="fa fa-download"></i> Draft</span>
				@elseif($value->status=="2")
				<span class="badge badge-primary"><i class="fa fa-upload"></i> Menunggu Pembayaran</span>
				@else
				<span class="badge badge-success"><i class="fa fa-check"></i> Pembayaran Selesai</span>
				@endif
			</td>
			<td>
				@if(isset($tindakan[$value->medical_id]))
				<ol>
					@foreach($tindakan[$value->medical_id] as $key2 => $value2)
					<li>{{ $value2 }}</li>
					@endforeach
				</ol>
				@endif
			</td>
			<td>
				@if(isset($obat[$value->medical_id]))
				<ol>
					@foreach($obat[$value->medical_id] as $key2 => $value2)
					<li>{{ $value2 }}</li>
					@endforeach
				</ol>
				@endif
			</td>
			<td>
				{{ $value->staff }}
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
@endsection