@extends("template.layout")
@section("content")
<div class="card">
	<div class="card-body">
		@include("template.page-name2")
		@include("template.notif")
		<form method="GET" action="{{ url()->current() }}" enctype="multipart/form-data" id="form-select">
			@csrf
			<input type="hidden" name="_method" value="GET">
			@include("filter.filter-collapse")
			<div class="row">
				<div class="col-sm-12 col-lg-12 col-xl-12">
					<div class="table-responsive">
						<table class="table table-hover">
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
                                    <td colspan="6" class="text-center">Data Kosong</td>
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
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection
@section("script")
<script src="{{ URL::asset('js/select2/select2.full.min.js') }}"></script>
<script src="{{ URL::asset('js/select2/select2-custom.js') }}"></script>
<script type="text/javascript">
	@if(isset($filter["f_patient_id"]))
    $("#f_patient_id").val('{{ $filter["f_patient_id"] }}');
    @endif

    @if(isset($filter["f_medical_code"]))
    $("#f_medical_code").val('{{ $filter["f_medical_code"] }}');
    @endif

    @if(isset($filter["f_status"]))
    $("#f_status").val('{{ $filter["f_status"] }}');
    @endif

    @if(isset($filter["start_date"]))
    $("#start_date").val('{{ $filter["start_date"] }}');
    @endif
    
    @if(isset($filter["end_date"]))
    $("#end_date").val('{{ $filter["end_date"] }}');
    @endif

</script>
@endsection