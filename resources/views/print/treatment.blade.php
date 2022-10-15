@extends("print.layout")
@section("title", StringHelper::ucsplit(StringHelper::getNameMenu("treatment")))
@section("content")
<h4 class="text-title">
	<i class="fa fa-file"></i>	Laporan {{ StringHelper::ucsplit(StringHelper::getNameMenu("treatment")) }}
</h4>
<table class="table1">
	<thead >
		<tr>
			<th scope="col">No</th>
			<th scope="col">Fisioterapis</th>
			<th scope="col">Pasien</th>
			<th scope="col">Paket</th>
			<th scope="col" class="text-center">Pertemuan</th>
			<th scope="col" class="text-center">Tgl. Treatment</th>
			<th scope="col" class="text-center">Tgl. Pengisian</th>
			<th scope="col" >Keterangan</th>
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
			<td>{{ $key+1 }}</td>
			<td>
				{{ $value->staff }}
			</td>
			<td>
				{{ $value->pasien }}
			</td>
			<td>
				{{ $value->paket }}
			</td>
			<td>
				{{ $value->meeting_index }}
			</td>
			<td>
				{{ StringHelper::daydate($value->date).", ".StringHelper::dateindo($value->date) }}
			</td>
			<td>@if(isset($value->created_at)){{ StringHelper::daydate($value->created_at).", ".StringHelper::dateindo($value->created_at) }}@endif
			</td>
			<td>
				{{ $value->diagnose_description }}
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
@endsection