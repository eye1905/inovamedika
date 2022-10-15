@extends("template.layout")

@section("content")
<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-md-6">
				<h3 class="font-roboto">
					<span><i class="fa fa-bell"></i></span>
					Detail Notifikasi
				</h3>
			</div>
			<div class="col-md-6 text-end">
				<a href="{{ URL::previous() }}" class="btn btn-sm btn-warning">
					<i class="fa fa-reply"> </i> Kembali
				</a>
			</div>
		</div>
		<hr>
		@include("template.notif")
		<div class="row">
			<div class="col-md-12 mt-2">
				<label class="col-form-label">
					Isi Notifikasi {{ StringHelper::getNameMenu() }}
				</label>

				<textarea class="form-control" id="address" minlength="5" maxlength="1000" name="text" required style="min-height: 300px; background-color: #FFFF" disabled>@if(isset($notif->text)){{ $notif->text }}@else{{ old('text') }}@endif</textarea>
			</div>
		</div>
	</div>
</div>

@endsection