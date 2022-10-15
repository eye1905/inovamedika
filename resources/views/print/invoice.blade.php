@extends("print.layout")
@section("title", "Invoice Mitra ".StringHelper::ucsplit($mitra->name))
@section("content")
<h4 class="text-title">
	<i class="fa fa-file"></i>	
	 Invoice Mitra {{ StringHelper::ucsplit($mitra->name) }}
</h4>
<div style="margin-left: 20px">
	@if(isset($mitra->name))
	<label>
		Mitra : <b>{{ StringHelper::ucsplit($mitra->name) }}</b>
	</label>
	@endif
	<br>
	<label>Periode : 
		@if(isset($data->tgl_awal))
		{{ StringHelper::dateindo($data->tgl_awal) }}
		@endif - 
		@if(isset($data->tgl_akhir))
		{{ StringHelper::dateindo($data->tgl_akhir) }}
		@endif
	</label>
	<br>
	@if(isset($data->nominal))
	<label>
		Total : <b>{{ StringHelper::toRupiah($data->nominal) }}</b>
	</label>
	@endif
</div>

<table class="table1" style="margin-top: 5px;">
	<thead>
		<tr>
			<th scope="col"><b>No</b></th>
			<th scope="col"><b>Alat</b></th>
			<th scope="col"><b>Satuan</b></th>
			<th scope="col"><b>Durasi</b></th>
			<th style="text-align: right;"><b>Harga</b></th>
		</tr>
	</thead>
	<tbody>
		@if(count($detail) < 1)
		<tr>
			<td class="text-center" colspan="5">
				<b>Data Kosong</b>
			</td>
		</tr>
		@endif
		@php
		$total = 0;
		@endphp
		@foreach($detail as $key => $value)
          <tr>
          	<td>
              {{ ($key+1) }}
            </td>
            <td>
              {{ ucfirst($value->alat) }}
            </td>
            <td>
              {{ " ( ".$value->quantity." x ".$value->satuan." ) " }}
            </td>
            <td>
              {{ $value->usage_duration }}
            </td>
            <td style="text-align: right;">
              {{ $value->price }}
            </td>
            @php
            $total += $value->price
            @endphp
          </tr>
          @endforeach
		<tr style="background-color: grey; ">
			<th colspan="4" style="color: #FFFF; text-align: right;">
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