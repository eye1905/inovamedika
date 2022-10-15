@extends("print.layout")
@section("title", StringHelper::ucsplit(StringHelper::getNameMenu("assesment")))
@section("content")
<h4 class="text-title">
	<i class="fa fa-file"></i>	Laporan {{ StringHelper::ucsplit(StringHelper::getNameMenu("assesment")) }}
</h4>
<table class="table1">
	<thead>
		<tr>
			<th scope="col">No</th>
			@if(Session("role_id")<3)<th scope="col" >Fisioterapis</th>@endif
				<th scope="col">Pasien</th>
				<th scope="col" class="text-center">Paket</th>
				<th scope="col" class="text-center">Pertemuan</th>
				<th scope="col" class="text-center">Tgl. Assesment</th>
				<th>Tgl. Pengisian</th>
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
				@if(Session("role_id")<3)
				<td>@if(isset($value->staff)){{ $value->staff }}@endif</td>
				@endif
				<td>@if(isset($value->pasien)){{ $value->pasien }}@endif</td>
				<td>@if(isset($value->paket)){{ $value->paket }}@endif</td>
				<td>
					@if(isset($value->meeting_index)){{ StringHelper::ucsplit($value->meeting_index) }}@endif
				</td>
				<td>@if(isset($value->date_assesment)){{ StringHelper::daydate($value->date_assesment).", ".StringHelper::dateindo($value->date_assesment) }}@endif
				</td>
				<td>@if(isset($value->created_at)){{ StringHelper::daydate($value->created_at).", ".StringHelper::dateindo($value->created_at) }}@endif
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection