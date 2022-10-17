@extends("template.layout")

@section("content")
<div class="container-fluid general-widget">
	<div class="row">
		@include("template.notif")
		<div class="col-sm-12">
			<div class="card o-hidden">
				<div class="card-body">
					<form method="GET" action="{{ url()->current() }}">
						@csrf
						<div class="row">
							<div class="col-md-4">
								<label class="col-form-label">
									<b>Tgl. Awal </b>
								</label>
								<input type="date" class="form-control" id="start_date" name="start_date">
							</div>

							<div class="col-md-4">
								<label class="col-form-label">
									<b>Tgl. Akhir</b>
								</label>
								<input type="date" class="form-control" id="end_date" name="end_date">
							</div>

							<div class="col-md-4" style="margin-top: 40px">
								<button class="btn btn-sm btn-primary" type="submit">
									<i class="fa fa-search"></i> Cari
								</button>
								<a href="{{ Request::segment(1) }}" class="btn btn-warning btn-sm">
									<i class="fa fa-refresh"></i> Reset
								</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-xl-3 col-lg-6">
			<div class="card o-hidden">
				<a href="{{ url("patient") }}">
					<div class="card-body">
						<div class="media static-widget">
							<div class="media-body">
								<h6 class="font-roboto">Jumlah Pasien</h6>
								<h4 class="mb-0 counter">{{ $pasien }}</h4>
							</div>
							<i class="fa fa-user-md text-warning" style="font-size: 25pt;"></i>
						</div>
						<div class="progress-widget">
							<div class="progress sm-progress-bar progress-animate">
								<div class="progress-gradient-secondary" role="progressbar" style="width: 60%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"><span class="animate-circle"></span></div>
							</div>
						</div>
					</div>
					
					<div class="text-end">
						<a href="{{ url("patient/create") }}" class="btn btn-sm btn-warning" style="margin-right: 10px !important">
							<i class="fa-wheelchair"> +</i> Tambah Pasien
						</a>
					</div>
				</a>
				<br>
			</div>
		</div>

		<div class="col-sm-6 col-xl-3 col-lg-6">
			<div class="card o-hidden">
				<a href="{{ url("medical") }}">
					<div class="card-body">
						<div class="media static-widget">
							<div class="media-body">
								<h6 class="font-roboto">Jumlah Pemeriksaan Medis</h6>
								<h4 class="mb-0 counter">{{ $medical }}</h4>
							</div>
							<i class="fa fa-medkit text-info" style="font-size: 25pt;"></i>
						</div>
						<div class="progress-widget">
							<div class="progress sm-progress-bar progress-animate">
								<div class="progress-gradient-info" role="progressbar" style="width: 60%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"><span class="animate-circle"></span></div>
							</div>
						</div>
					</div>
					<div class="text-end">
						<a href="{{ url("medical/create") }}" style="margin-right: 10px !important;" class="btn btn-sm btn-info">
							<i class="fa fa-medkit"> +</i> Tambah Pemeriksaan Medis
						</a>
					</div>
				</a>
				<br>
			</div>
		</div>

		<div class="col-sm-6 col-xl-3 col-lg-6">
			<div class="card o-hidden">
				<a href="{{ url("payment") }}">
					<div class="card-body">
						<div class="media static-widget">
							<div class="media-body">
								<h6 class="font-roboto">Nominal Pembayaran</h6>
								<h4 class="mb-0 counter">
									{{ StringHelper::toRupiah($payment) }}
								</h4>
							</div>
							<i class="fa fa-money text-primary" style="font-size: 25pt;"></i>
						</div>
						<div class="progress-widget">
							<div class="progress sm-progress-bar progress-animate">
								<div class="progress-gradient-primary" role="progressbar" style="width: 48%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"><span class="animate-circle"></span></div>
							</div>
						</div>
					</div>
					<div class="text-end">
						<a href="{{ url("medical") }}" style="margin-right: 10px !important;" class="btn btn-sm btn-primary">
							<i class="fa fa-money"> +</i> Tambah Pembayaran
						</a>
					</div>
				</a>
				<br>
			</div>
		</div>

		<div class="col-sm-6 col-xl-3 col-lg-6">
			<div class="card o-hidden">
				<a href="{{ url("staff") }}">
					<div class="card-body">
						<div class="media static-widget">
							<div class="media-body">
								<h6 class="font-roboto">Jumlah Pegawai</h6>
								<h4 class="mb-0 counter">{{ $user }}</h4>
							</div>
							<i class="fa fa-users text-success" style="font-size: 25pt;"></i>
						</div>
						<div class="progress-widget">
							<div class="progress sm-progress-bar progress-animate">
								<div class="progress-gradient-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"><span class="animate-circle"></span></div>
							</div>
						</div>
					</div>
					<div class="text-end">
						<a href="{{ url("staff/create") }}" style="margin-right: 10px !important" class="btn btn-sm btn-success">
							<i class="fa fa-users"> +</i> Tambah Pegawai
						</a>
					</div>
				</a>
				<br>
			</div>
		</div>

		<div class="col-xl-6 col-md-6 dash-xl-50 dash-32">
			<div class="card revenue-category">
				<div class="card-header card-no-border">
					<div class="media">
						<div class="media-body"> 
							<h5 class="mb-0">Statistik Penjualan Obat</h5>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="donut-inner">
						<h5>{{ $totalobat }}</h5>
						<h6>{{ StringHelper::toRupiah($sumtotalobat) }}</h6>
					</div>
					<div id="chart-obat">            </div>
				</div>
			</div>
		</div>

		<div class="col-xl-6 col-md-6 dash-xl-50 dash-32">
			<div class="card">
				<div class="card-header pb-0">
					<div class="media">
						<div class="media-body">
							<h5>Statistik Data Usia Pasien </h5>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="chart-container">
						<div class="row">
							<div class="col-12">
								<div id="chart-usia"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
@endsection

@section("script")
<script src="{{ URL::asset('js/chart/apex-chart/apex-chart.js') }}"></script>
<script src="{{ URL::asset('js/prism/prism.min.js') }}"></script>
<script type="text/javascript">
	@if(isset($filter["start_date"]))
	$("#start_date").val('{{ $filter["start_date"] }}');
	@endif

	@if(isset($filter["end_date"]))
	$("#end_date").val('{{ $filter["end_date"] }}');
	@endif
</script>
@include("dashboard.js-statistik")
@endsection