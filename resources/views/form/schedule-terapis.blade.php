@extends("template.layout")

@section("content")
<div class="card">
	<div class="card-body">
		@include("template.page-name")
		@include("template.notif")

		<form method="POST" enctype="multipart/form-data" action="@if(Request::segment(2)=='create'){{ url(Request::segment(1)) }}@else{{ url(Request::segment(1), $data->staff_id) }}@endif">

			@csrf

			@if(Request::segment(3)=="edit")
			{{ method_field("PUT") }}
			@endif

			<div class="row">
				<div class="col-md-4 mt-2">
					<label class="col-form-label">
						Fisioterapis <span class="text-danger"> *</span>
					</label>

					<select class="form-control @if($errors->has('staff_id')) is-invalid @endif" id="staff_id" name="staff_id" required>
						<option value="">-- Pilih Fisioterapis --</option>
						@foreach($staff as $key => $value)
						<option value="{{ $value->staff_id }}">{{ ucfirst($value->name) }}</option>
						@endforeach
					</select>

					@if($errors->has('staff_id'))
					<label class="text-danger">
						{{ $errors->first('staff_id') }}
					</label>
					@endif
				</div>

				<div class="col-md-4 mt-2">
					<label class="col-form-label">
						Hari <span class="text-danger"> *</span>
					</label>

					<select class="form-control @if($errors->has('day')) is-invalid @endif" id="day" name="day" required>
						<option value="">-- Pilih Hari --</option>
						@foreach($hari as $key => $value)
						<option value="{{ $key }}">{{ ucfirst($value) }}</option>
						@endforeach
					</select>

					@if($errors->has('day'))
					<label class="text-danger">
						{{ $errors->first('day') }}
					</label>
					@endif
				</div>

				<div class="col-md-4 mt-2">
					<label class="col-form-label">Jadwal 
						{{ StringHelper::getNameMenu() }} <span class="text-danger"> *</span>
					 </label>
					<br>
					<label style="margin-left: 10px">
						<input type="checkbox" id="checkall" name="checkall" value="1"> Semua Jadwal
					</label>
					<br>
					@foreach($jadwal as $key => $value)
					<label style="margin-left: 10px">
						<input type="checkbox" class="check-all" id="jadwal{{ $value->schedule_shift_id }}" name="jadwal[]" value="{{ $value->schedule_shift_id }}"> {{ ucfirst($value->name)." ( ".$value->start_clock." - ".$value->end_clock." )" }}
					</label>
					<br>
					@endforeach

					@if($errors->has('status'))
					<label class="text-danger">
						{{ $errors->first('status') }}
					</label>
					@endif
				</div>

				<div class="col-md- text-center"> 
					<button class="btn btn-sm btn-success" type="submit">
						<i class="fa fa-save"></i> Buat Jadwal
					</button>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection

@section("script")
<script type="text/javascript">

	$(function(){
		$('#checkall').change(function()
		{
			if($(this).is(':checked')) {
				$(".check-all").attr("checked", true);
			}else{
				$(".check-all").attr("checked", false);
			}
		});
	});

	@if(old("staff_id") != null)
	$("#staff_id").val('{{ old("staff_id") }}');
	@endif

	@if(old("day") != null)
	$("#day").val('{{ old("day") }}');
	@endif

	@if(old("jadwal") != null)
	@foreach(old("jadwal") as $key => $value)
	$("#jadwal{{ $value }}").attr("checked", true);
	@endforeach
	@endif

</script>
@endsection