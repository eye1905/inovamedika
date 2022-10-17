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
    
    @if(isset($filter["f_method"]))
    $("#f_method").val('{{ $filter["f_method"] }}');
    @endif

    @if(isset($filter["start_date"]))
    $("#start_date").val('{{ $filter["start_date"] }}');
    @endif
    
    @if(isset($filter["end_date"]))
    $("#end_date").val('{{ $filter["end_date"] }}');
    @endif

</script>
@endsection