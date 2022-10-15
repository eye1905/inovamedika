@extends("template.layout")

@section("content")
<div class="container-fluid general-widget">
	<div class="row">
		@include("template.notif")

		<div class="col-sm-6 col-xl-3 col-lg-6">
			<div class="card o-hidden">
				@if(Session("role_id")<4)
				<a href="{{ url("patient") }}">
					@endif
					<div class="card-body">
						<div class="media static-widget">
							<div class="media-body">
								<h6 class="font-roboto">Jumlah Pasien</h6>
								<h4 class="mb-0 counter">{{ $pasien }}</h4>
							</div>
							<i class="fa fa-wheelchair text-warning" style="font-size: 25pt;"></i>
						</div>
						<div class="progress-widget">
							<div class="progress sm-progress-bar progress-animate">
								<div class="progress-gradient-secondary" role="progressbar" style="width: 60%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"><span class="animate-circle"></span></div>
							</div>
						</div>
					</div>
					
					<div class="text-end">
						@if(Session("role_id")<4)
						<a href="{{ url("patient/create") }}" class="btn btn-sm btn-warning" style="margin-right: 10px !important">
							<i class="fa-wheelchair"> +</i> Tambah Pasien
						</a>
						@else
						<div style="height: 31px;"></div>
						@endif
					</div>
					@if(Session("role_id")<4)
				</a>
				@endif
				<br>
			</div>
		</div>

		<div class="col-sm-6 col-xl-3 col-lg-6">
			<div class="card o-hidden">
				@if(Session("role_id")<3)
				<a href="{{ url("doctor") }}">
					@endif
					<div class="card-body">
						<div class="media static-widget">
							<div class="media-body">
								<h6 class="font-roboto">Jumlah Dokter Referral</h6>
								<h4 class="mb-0 counter">{{ $doctor }}</h4>
							</div>
							<i class="fa fa-wheelchair text-info" style="font-size: 25pt;"></i>
						</div>
						<div class="progress-widget">
							<div class="progress sm-progress-bar progress-animate">
								<div class="progress-gradient-info" role="progressbar" style="width: 60%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"><span class="animate-circle"></span></div>
							</div>
						</div>
					</div>
					<div class="text-end">
						@if(Session("role_id")<3)
						<a href="{{ url("user/create") }}" style="margin-right: 10px !important;" class="btn btn-sm btn-info">
							<i class="fa fa-user-md"> +</i> Tambah Doktor
						</a>
						@else
						<div style="height: 31px;"></div>
						@endif
					</div>

					@if(Session("role_id")<3)
				</a>
				@endif
				<br>
			</div>
		</div>

		<div class="col-sm-6 col-xl-3 col-lg-6">
			<div class="card o-hidden">
				@if(Session("role_id")<3)
				<a href="{{ url("staff") }}">
					@endif
					<div class="card-body">
						<div class="media static-widget">
							<div class="media-body">
								<h6 class="font-roboto">Jumlah Fisioterapis</h6>
								<h4 class="mb-0 counter">{{ $terapis }}</h4>
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
						@if(Session("role_id")<3)
						<a href="{{ url("staff/create") }}" style="margin-right: 10px !important" class="btn btn-sm btn-success">
							<i class="fa fa-users"> +</i> Tambah Fisioterapis
						</a>
						@else
						<div style="height: 31px;"></div>
						@endif
					</div>
					@if(Session("role_id")<3)
				</a>
				@endif
				<br>
			</div>
		</div>
		
		<div class="col-sm-6 col-xl-3 col-lg-6">
			<div class="card o-hidden">
				@if(Session("role_id")<3)
				<a href="{{ url("user") }}">
					@endif
					<div class="card-body">
						<div class="media static-widget">
							<div class="media-body">
								<h6 class="font-roboto">Pengguna Aplikasi</h6>
								<h4 class="mb-0 counter">
									{{ $user }}
								</h4>
							</div>
							<i class="fa fa-user text-primary" style="font-size: 25pt;"></i>
						</div>
						<div class="progress-widget">
							<div class="progress sm-progress-bar progress-animate">
								<div class="progress-gradient-primary" role="progressbar" style="width: 48%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"><span class="animate-circle"></span></div>
							</div>
						</div>
					</div>
					<div class="text-end">
						@if(Session("role_id")<3)
						<a href="{{ url("user/create") }}" style="margin-right: 10px !important" class="btn btn-sm btn-primary">
							<i class="fa fa-user"> +</i> Tambah User
						</a>
						@else
						<div style="height: 31px;"></div>
						@endif
					</div>
					@if(Session("role_id")<3)
				</a>
				@endif
				<br>
			</div>
		</div>

		<div class="col-md-12">
			<div class="card">
				<div class="card-header pb-0">
					<h6>
						<b>Pengumuman Terbaru</b>
					</h6>
					@if(Session("role_id")<3)
					<div class="text-end">
						<a href="{{ url("announcement/create") }}" class="btn btn-sm btn-primary">
							<i class="fa fa-volume-down"> +</i> Tambah Pengumuman
						</a>
					</div>
					@endif
					<hr>
				</div>
				<div class="card-body" style="margin-top: -20px;">
					<div class="activity-media">
						@foreach($pengumuman as $key => $value)
						<a href="{{ url("announcement"."/".$value->announcement_id) }}" class="text-decoration-none">

							<div class="media">
								<div class="recent-circle bg-primary"></div>
								<div class="media-body">
									<strong class="font-roboto">
										{{ substr($value->announcement, 0, 1000) }}
									</strong>
									<br>
									<span><i class="me-2" data-feather="clock"></i>
										<span class="font-roboto">
											{{ StringHelper::daydate($value->date).", ".StringHelper::dateindo($value->date) }}
										</span>
									</span>
								</div>
							</div>
						</a>
						@endforeach
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-12">
			<div class="widget-joins card">
				<div class="card-header pb-0">
					<div class="media">
						<div class="media-body">
							<h5>Jadwal Fisioterapis</h5>
						</div>
						@if(Session("role_id")<4)
						<a href="{{ url("appointment/create") }}" class="btn btn-sm btn-info">
							<i class="fa fa-ambulance"> +</i> Tambah Jadwal
						</a>
						@endif
					</div>
					{{-- <div class="row">
						<div class="col-md-4">
							<label class="col-form-label">
								Dari Tgl :
							</label>
							<input type="date" class="form-control" required id="tgl_lahir" name="tgl_lahir" value=""required placeholder="Tgl Awal">
						</div>
						<div class="col-md-4">
							<label class="col-form-label">
								Sampai Tgl :
							</label>
							<input type="date" class="form-control" required id="tgl_lahir" name="tgl_lahir" value=""required placeholder="Tgl Akhir">
						</div>
						<div class="col-md-4" style="padding-top: 35px;">
							<button class="btn btn-sm btn-primary" type="button">
								<i class="fa fa-search"> </i>
							</button>
							<button class="btn btn-sm btn-warning" type="button">
								<i class="fa fa-refresh"> </i>
							</button>
						</div>
					</div> --}}
				</div>

				<div class="card-body">
					<div class="row gy-4">
						@foreach($jadwal as $key => $value)
						<div class="col-sm-6">
							<a href="{{ url("appointment/".$value->patient_package_meet_id."/treatment") }}">
								<div class="widget-card">
									<div class="media align-self-center">
										@if($key==0)
										<div class="widget-icon bg-light-success">
											<svg class="fill-success" width="112" height="82" viewBox="0 0 112 82" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M40.2301 0.0161888C50.6652 0.0134581 61.103 0.0134581 71.5381 0.0161888C74.6718 0.0161888 75.6717 1.07297 75.6769 4.36891C75.6796 5.82437 75.7532 7.28803 75.6559 8.73529C75.5664 10.046 76.1058 10.3601 77.2582 10.3519C82.7389 10.3109 88.2196 10.33 93.7003 10.3355C97.105 10.3382 98.3048 11.2748 99.252 14.6964C100.946 20.8104 102.601 26.9381 104.341 33.0385C104.512 33.6365 105.098 34.1307 105.556 34.6086C107.556 36.7003 109.616 38.732 111.563 40.8728C111.921 41.266 111.974 42.0661 111.974 42.6778C112 50.0043 112.003 57.3334 111.984 64.6599C111.979 66.9865 110.824 68.2043 108.593 68.2398C105.83 68.2835 103.067 68.2835 100.304 68.248C99.3204 68.2344 98.8836 68.461 98.7389 69.6434C97.9864 75.7219 94.287 80.1812 89.0195 81.5656C81.1181 83.641 73.5115 78.1086 72.6932 69.6106C72.5853 68.4938 72.1854 68.248 71.2382 68.2508C61.0662 68.2671 50.8915 68.2699 40.7195 68.248C39.7407 68.2453 39.4013 68.5648 39.2934 69.6434C38.6199 76.4019 33.6102 81.5001 27.3743 81.907C20.6912 82.3411 15.1185 78.1932 13.5608 71.6259C13.5293 71.4948 13.4872 71.3638 13.4608 71.2299C12.9083 68.259 12.9083 68.2589 9.94563 68.2589C7.75389 68.2589 5.55951 68.2917 3.36777 68.2453C1.13918 68.1989 -0.000101532 66.9755 -0.000101532 64.6381C-0.00273268 45.9301 -0.0185196 27.2248 0.0525214 8.51957C0.0551525 7.50375 0.62348 6.33501 1.26022 5.51308C2.38109 4.06854 3.78612 2.8643 5.02276 1.50988C5.99102 0.447638 7.10662 -0.0056568 8.52744 -0.00019541C19.0941 0.0353036 29.6608 0.0189194 40.2301 0.0161888ZM97.7943 34.1307C97.7549 33.7539 97.7628 33.4836 97.6943 33.2378C96.2972 28.1232 94.8685 23.0196 93.5029 17.8968C93.253 16.9629 92.7136 16.8482 91.9453 16.8509C86.9935 16.8673 82.039 16.8864 77.0872 16.8427C75.9927 16.8318 75.648 17.2332 75.6611 18.3473C75.7085 22.214 75.6717 26.0807 75.6796 29.9473C75.6848 32.8937 76.9372 34.2127 79.7473 34.2181C85.3122 34.229 90.8797 34.2236 96.4445 34.2181C96.8734 34.2154 97.2997 34.1635 97.7943 34.1307ZM32.9392 68.4091C32.9313 64.5425 29.9923 61.4513 26.2903 61.424C22.583 61.3967 19.5835 64.5725 19.6046 68.5047C19.623 72.3386 22.6304 75.4243 26.3219 75.4052C30.0081 75.3833 32.9445 72.2785 32.9392 68.4091ZM79.0553 68.3791C79.0369 72.254 81.9522 75.3642 85.6437 75.4025C89.3273 75.4434 92.3636 72.355 92.39 68.5348C92.4189 64.5944 89.4457 61.4213 85.7332 61.424C82.0417 61.4322 79.0711 64.5261 79.0553 68.3791Z"></path>
											</svg>
										</div>
										@else
										<div class="widget-icon bg-light-warning">
											<svg class="fill-warning" width="110" height="105" viewBox="0 0 110 105" xmlns="http://www.w3.org/2000/svg">
												<g>
													<path d="M56.4571 104.995C56.4571 100.722 56.4571 96.6523 56.4571 92.5829C56.4596 79.9804 56.4645 67.3755 56.4547 54.773C56.4547 54.0685 56.5307 53.5801 57.3208 53.1997C74.5917 44.9155 91.8454 36.5959 109.104 28.2835C109.318 28.1802 109.543 28.0956 109.914 27.9407C109.943 28.3938 109.985 28.7555 109.985 29.1171C109.987 45.479 109.982 61.8386 110.002 78.2005C110.002 78.9472 109.828 79.3746 109.067 79.7409C91.9092 87.9759 74.7708 96.2437 57.625 104.505C57.3036 104.655 56.9675 104.779 56.4571 104.995Z"></path>
													<path d="M0.0819734 27.9477C0.543251 28.1426 0.911292 28.2788 1.26216 28.4479C7.06002 31.2375 12.8481 34.0482 18.6607 36.8096C19.4262 37.1736 19.7059 37.5822 19.6985 38.4087C19.6568 43.9645 19.6765 49.5202 19.6765 55.0759C19.6765 55.5033 19.6765 55.933 19.6765 56.5482C21.7645 56.5482 23.7936 56.6257 25.8154 56.52C27.0765 56.4543 27.9353 56.8511 28.799 57.7082C30.8821 59.7816 33.078 61.7494 35.3427 63.8674C35.3427 57.5391 35.3427 51.3095 35.3427 44.8967C36.3487 45.364 37.1878 45.7397 38.0147 46.1365C42.8655 48.4706 47.7089 50.814 52.567 53.1363C53.1927 53.4369 53.573 53.7234 53.573 54.5124C53.5411 71.0621 53.546 87.6119 53.5411 104.162C53.5411 104.387 53.5117 104.613 53.4822 104.998C51.3476 103.976 49.3111 103.011 47.282 102.032C31.8562 94.6 16.4377 87.1587 0.999622 79.7456C0.280715 79.4004 -0.00390273 79.0459 -0.00144913 78.2522C0.0255405 61.8198 0.0181797 45.3874 0.0206333 28.9551C0.0230869 28.6615 0.0574374 28.361 0.0819734 27.9477Z"></path>
													<path d="M36.9977 42.4758C41.7184 40.0572 46.2846 37.7137 50.8507 35.3773C63.131 29.0936 75.4162 22.8194 87.6842 16.5146C88.4105 16.1412 88.965 16.1248 89.6986 16.484C95.5578 19.3371 101.437 22.1478 107.308 24.975C107.595 25.1135 107.86 25.2873 108.277 25.5244C107.531 25.9001 106.906 26.2265 106.268 26.5318C89.5661 34.5789 72.8596 42.619 56.1677 50.6849C55.3653 51.0723 54.747 51.1217 53.9128 50.7107C48.6866 48.1348 43.4261 45.6223 38.1779 43.0863C37.8245 42.9149 37.4786 42.7247 36.9977 42.4758Z"></path>
													<path d="M1.65613 25.5056C5.03965 23.8736 8.20725 22.3426 11.3749 20.8163C25.5665 13.9785 39.7606 7.1454 53.94 0.28645C54.7129 -0.086906 55.3042 -0.100995 56.0795 0.279406C61.2763 2.8248 66.5024 5.31854 71.7163 7.83341C72.0697 8.00483 72.4083 8.20677 72.9162 8.4815C72.0868 8.9253 71.3949 9.3104 70.6883 9.67202C54.5509 17.9305 38.416 26.1889 22.264 34.4239C21.8223 34.6493 21.1083 34.8231 20.7182 34.6376C14.4198 31.6648 8.15573 28.6334 1.65613 25.5056Z"></path>
												</g>
											</svg>
										</div>
										@endif
										<div class="media-body">
											<h6>{{ StringHelper::ucsplit($value->name) }}</h6>
											<label>Pasien : {{ StringHelper::ucsplit($value->pasien) }}</label>
											<h5>
												<span class="font-roboto @if($key==0) font-success @else font-warning @endif f-w-700">
													{{ StringHelper::daydate($value->date_scheduled).", ".StringHelper::dateindo($value->date_scheduled) }}

													<i class="icofont icofont-arrow-up"></i>
												</span>
											</h5>
											@if($key==0)
											<div class="icon-bg">
												<svg width="100" height="80" viewBox="0 0 112 82" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M40.2301 0.0161888C50.6652 0.0134581 61.103 0.0134581 71.5381 0.0161888C74.6718 0.0161888 75.6717 1.07297 75.6769 4.36891C75.6796 5.82437 75.7532 7.28803 75.6559 8.73529C75.5664 10.046 76.1058 10.3601 77.2582 10.3519C82.7389 10.3109 88.2196 10.33 93.7003 10.3355C97.105 10.3382 98.3048 11.2748 99.252 14.6964C100.946 20.8104 102.601 26.9381 104.341 33.0385C104.512 33.6365 105.098 34.1307 105.556 34.6086C107.556 36.7003 109.616 38.732 111.563 40.8728C111.921 41.266 111.974 42.0661 111.974 42.6778C112 50.0043 112.003 57.3334 111.984 64.6599C111.979 66.9865 110.824 68.2043 108.593 68.2398C105.83 68.2835 103.067 68.2835 100.304 68.248C99.3204 68.2344 98.8836 68.461 98.7389 69.6434C97.9864 75.7219 94.287 80.1812 89.0195 81.5656C81.1181 83.641 73.5115 78.1086 72.6932 69.6106C72.5853 68.4938 72.1854 68.248 71.2382 68.2508C61.0662 68.2671 50.8915 68.2699 40.7195 68.248C39.7407 68.2453 39.4013 68.5648 39.2934 69.6434C38.6199 76.4019 33.6102 81.5001 27.3743 81.907C20.6912 82.3411 15.1185 78.1932 13.5608 71.6259C13.5293 71.4948 13.4872 71.3638 13.4608 71.2299C12.9083 68.259 12.9083 68.2589 9.94563 68.2589C7.75389 68.2589 5.55951 68.2917 3.36777 68.2453C1.13918 68.1989 -0.000101532 66.9755 -0.000101532 64.6381C-0.00273268 45.9301 -0.0185196 27.2248 0.0525214 8.51957C0.0551525 7.50375 0.62348 6.33501 1.26022 5.51308C2.38109 4.06854 3.78612 2.8643 5.02276 1.50988C5.99102 0.447638 7.10662 -0.0056568 8.52744 -0.00019541C19.0941 0.0353036 29.6608 0.0189194 40.2301 0.0161888ZM97.7943 34.1307C97.7549 33.7539 97.7628 33.4836 97.6943 33.2378C96.2972 28.1232 94.8685 23.0196 93.5029 17.8968C93.253 16.9629 92.7136 16.8482 91.9453 16.8509C86.9935 16.8673 82.039 16.8864 77.0872 16.8427C75.9927 16.8318 75.648 17.2332 75.6611 18.3473C75.7085 22.214 75.6717 26.0807 75.6796 29.9473C75.6848 32.8937 76.9372 34.2127 79.7473 34.2181C85.3122 34.229 90.8797 34.2236 96.4445 34.2181C96.8734 34.2154 97.2997 34.1635 97.7943 34.1307ZM32.9392 68.4091C32.9313 64.5425 29.9923 61.4513 26.2903 61.424C22.583 61.3967 19.5835 64.5725 19.6046 68.5047C19.623 72.3386 22.6304 75.4243 26.3219 75.4052C30.0081 75.3833 32.9445 72.2785 32.9392 68.4091ZM79.0553 68.3791C79.0369 72.254 81.9522 75.3642 85.6437 75.4025C89.3273 75.4434 92.3636 72.355 92.39 68.5348C92.4189 64.5944 89.4457 61.4213 85.7332 61.424C82.0417 61.4322 79.0711 64.5261 79.0553 68.3791Z"></path>
												</svg>
											</div>
											@else
											<div class="icon-bg">
												<svg width="110" height="105" viewBox="0 0 110 105" xmlns="http://www.w3.org/2000/svg">
													<g>
														<path d="M56.4571 104.995C56.4571 100.722 56.4571 96.6523 56.4571 92.5829C56.4596 79.9804 56.4645 67.3755 56.4547 54.773C56.4547 54.0685 56.5307 53.5801 57.3208 53.1997C74.5917 44.9155 91.8454 36.5959 109.104 28.2835C109.318 28.1802 109.543 28.0956 109.914 27.9407C109.943 28.3938 109.985 28.7555 109.985 29.1171C109.987 45.479 109.982 61.8386 110.002 78.2005C110.002 78.9472 109.828 79.3746 109.067 79.7409C91.9092 87.9759 74.7708 96.2437 57.625 104.505C57.3036 104.655 56.9675 104.779 56.4571 104.995Z"></path>
														<path d="M0.0819734 27.9477C0.543251 28.1426 0.911292 28.2788 1.26216 28.4479C7.06002 31.2375 12.8481 34.0482 18.6607 36.8096C19.4262 37.1736 19.7059 37.5822 19.6985 38.4087C19.6568 43.9645 19.6765 49.5202 19.6765 55.0759C19.6765 55.5033 19.6765 55.933 19.6765 56.5482C21.7645 56.5482 23.7936 56.6257 25.8154 56.52C27.0765 56.4543 27.9353 56.8511 28.799 57.7082C30.8821 59.7816 33.078 61.7494 35.3427 63.8674C35.3427 57.5391 35.3427 51.3095 35.3427 44.8967C36.3487 45.364 37.1878 45.7397 38.0147 46.1365C42.8655 48.4706 47.7089 50.814 52.567 53.1363C53.1927 53.4369 53.573 53.7234 53.573 54.5124C53.5411 71.0621 53.546 87.6119 53.5411 104.162C53.5411 104.387 53.5117 104.613 53.4822 104.998C51.3476 103.976 49.3111 103.011 47.282 102.032C31.8562 94.6 16.4377 87.1587 0.999622 79.7456C0.280715 79.4004 -0.00390273 79.0459 -0.00144913 78.2522C0.0255405 61.8198 0.0181797 45.3874 0.0206333 28.9551C0.0230869 28.6615 0.0574374 28.361 0.0819734 27.9477Z"></path>
														<path d="M36.9977 42.4758C41.7184 40.0572 46.2846 37.7137 50.8507 35.3773C63.131 29.0936 75.4162 22.8194 87.6842 16.5146C88.4105 16.1412 88.965 16.1248 89.6986 16.484C95.5578 19.3371 101.437 22.1478 107.308 24.975C107.595 25.1135 107.86 25.2873 108.277 25.5244C107.531 25.9001 106.906 26.2265 106.268 26.5318C89.5661 34.5789 72.8596 42.619 56.1677 50.6849C55.3653 51.0723 54.747 51.1217 53.9128 50.7107C48.6866 48.1348 43.4261 45.6223 38.1779 43.0863C37.8245 42.9149 37.4786 42.7247 36.9977 42.4758Z"></path>
														<path d="M1.65613 25.5056C5.03965 23.8736 8.20725 22.3426 11.3749 20.8163C25.5665 13.9785 39.7606 7.1454 53.94 0.28645C54.7129 -0.086906 55.3042 -0.100995 56.0795 0.279406C61.2763 2.8248 66.5024 5.31854 71.7163 7.83341C72.0697 8.00483 72.4083 8.20677 72.9162 8.4815C72.0868 8.9253 71.3949 9.3104 70.6883 9.67202C54.5509 17.9305 38.416 26.1889 22.264 34.4239C21.8223 34.6493 21.1083 34.8231 20.7182 34.6376C14.4198 31.6648 8.15573 28.6334 1.65613 25.5056Z"></path>
													</g>
												</svg>
											</div>
											@endif
										</div>
									</div>
								</div>
							</a>
						</div>
						@endforeach

						<div class="col-md-8">
							<span class="badge badge-success">Jadwal Terdekat</span>
							<span class="badge badge-warning">Jadwal Akan Datang</span>
						</div>

						<div class="col-sm-12 text-end">
							<a href="{{ url("treatmentschedule") }}" style="float: right;">
								<h6>Semua jadwal >>></h6>
							</a>
						</div>

					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-12">
			<div class="card o-hidden">
				<div class="card-header pb-0">
					<div class="media">
						<div class="media-body">
							<h5>Statistik Pasien (Jenis Kelamin)</h5>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-12">
							<div id="chart-widget4"></div>
						</div>
						<div class="col-md-12">
							<span class="badge badge-primary">Laki-Laki</span>
							<span class="badge badge-warning">Perempuan</span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-12">
			<div class="card">
				<div class="card-header pb-0">
					<div class="media">
						<div class="media-body">
							<h5>Statistik Pasien (Rata-Rata Usia)</h5>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="chart-container">
						<div class="row">
							<div class="col-12">
								<div id="chart-widget8"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-12">
			<div class="card">
				<div class="card-header pb-0">
					<div class="media">
						<div class="media-body">
							<h5>Statistik Diagnosis Pasien</h5>
						</div>
					</div>
					{{-- <div class="row">
						<div class="col-md-4">
							<label class="col-form-label">
								Dari Tgl :
							</label>
							<input type="date" class="form-control" required id="tgl_lahir" name="tgl_lahir" value=""required placeholder="Tgl Awal">
						</div>
						<div class="col-md-4">
							<label class="col-form-label">
								Sampai Tgl :
							</label>
							<input type="date" class="form-control" required id="tgl_lahir" name="tgl_lahir" value=""required placeholder="Tgl Akhir">
						</div>
						<div class="col-md-4" style="padding-top: 35px;">
							<button class="btn btn-sm btn-primary" type="button">
								<i class="fa fa-search"> </i>
							</button>
							<button class="btn btn-sm btn-warning" type="button">
								<i class="fa fa-refresh"> </i>
							</button>
						</div>
					</div> --}}
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordernone">
							<thead>
								<tr>
									<th>No</th>
									<th scope="col">Diagnosa</th>
									<th scope="col">Jumlah</th>
									<th scope="col">Level</th>
								</tr>
							</thead>
							<tbody>
								@foreach($diagnosa as $key =>  $value)
								<tr>
									<td>{{ ($key+1) }}</td>
									<td>{{ $value->name }}</td>
									<td>{{ $value->total }}</td>
									<td>
										@if($value->total >= 0 and $value->total <= 25)
										<div class="progress-showcase">
											<div class="progress" style="height: 8px;">
												<div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="100" aria-valuemax="100"></div>
											</div>
										</div>
										@elseif($value->total > 25 and $value->total <= 50)
										<div class="progress-showcase">
											<div class="progress" style="height: 8px;">
												<div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="100" aria-valuemax="100"></div>
											</div>
										</div>
										@elseif($value->total > 50 and $value->total <= 75)
										<div class="progress-showcase">
											<div class="progress" style="height: 8px;">
												<div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="100" aria-valuemax="100"></div>
											</div>
										</div>
										@elseif($value->total > 75 and $value->total <= 100)
										<div class="progress-showcase">
											<div class="progress" style="height: 8px;">
												<div class="progress-bar bg-warning" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="100" aria-valuemax="100"></div>
											</div>
										</div>
										@else
										<div class="progress-showcase">
											<div class="progress" style="height: 8px;">
												<div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="100" aria-valuemax="100"></div>
											</div>
										</div>
										@endif
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="col-md-12">
						<span class="badge badge-info">0-25</span>
						<span class="badge badge-primary">25-50</span>
						<span class="badge badge-success">50-75</span>
						<span class="badge badge-warning">75-100</span>
						<span class="badge badge-danger">100++</span>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-12">
			<div class="card">
				<div class="card-header pb-0">
					<div class="media">
						<div class="media-body">
							<h5>Statistik Pengambilan Paket Treatment</h5>
						</div>
					</div>
				</div>
				<style type="text/css">
					.back-badge{
						border-radius: 20px;
						padding: 2px;
						padding-left: 10px;
						padding-right: 10px;
						color :black;
						color: #FFFF;
					}
				</style>
				<div class="card-body">
					<div class="chart-container">
						<div class="row">
							<div class="col-12">
								<div id="chart-paket"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-12">
			<div class="card">
				<div class="card-header pb-0">
					<div class="media">
						<div class="media-body">
							<h5>Statistik Intervensi</h5>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">

						<table class="table table-bordernone">
							<thead>
								<tr>
									<th>No</th>
									<th scope="col">Intervensi</th>
									<th scope="col">Jumlah</th>
									<th scope="col">Level</th>
								</tr>
							</thead>
							<tbody>
								@foreach($intervensi as $key =>  $value)
								<tr>
									<td>{{ ($key+1) }}</td>
									<td>{{ $value->name }}</td>
									<td>{{ $value->total }}</td>
									<td>
										@if($value->total >= 0 and $value->total <= 25)
										<div class="progress-showcase">
											<div class="progress" style="height: 8px;">
												<div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="100" aria-valuemax="100"></div>
											</div>
										</div>
										@elseif($value->total > 25 and $value->total <= 50)
										<div class="progress-showcase">
											<div class="progress" style="height: 8px;">
												<div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="100" aria-valuemax="100"></div>
											</div>
										</div>
										@elseif($value->total > 50 and $value->total <= 75)
										<div class="progress-showcase">
											<div class="progress" style="height: 8px;">
												<div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="100" aria-valuemax="100"></div>
											</div>
										</div>
										@elseif($value->total > 75 and $value->total <= 100)
										<div class="progress-showcase">
											<div class="progress" style="height: 8px;">
												<div class="progress-bar bg-warning" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="100" aria-valuemax="100"></div>
											</div>
										</div>
										@else
										<div class="progress-showcase">
											<div class="progress" style="height: 8px;">
												<div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="100" aria-valuemax="100"></div>
											</div>
										</div>
										@endif
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="col-md-12">
						<span class="badge badge-info">0-25</span>
						<span class="badge badge-primary">25-50</span>
						<span class="badge badge-success">50-75</span>
						<span class="badge badge-warning">75-100</span>
						<span class="badge badge-danger">100++</span>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-12">
			<div class="card">
				<div class="card-header pb-0">
					<div class="media">
						<div class="media-body">
							<h5>Statistik Fisioterapis (Penanganan Terapi)</h5>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<div id="chart-fisioterapis"></div>
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
@include("dashboard.js-statistik")
@endsection