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
	@if(isset($filter["f_medicine_id"]))
    $("#f_medicine_id").val('{{ $filter["f_medicine_id"] }}');
    @endif

</script>
@endsection