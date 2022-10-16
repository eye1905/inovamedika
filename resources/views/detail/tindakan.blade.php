<div class="table-responsive">
	<div class="text-end">
		<button type="button" class="btn btn-sm btn-primary" onclick="addTindakan()">
			<i class="fa fa-plus"></i> Tambah Tindakan
		</button>
	</div>
	<table class="table table-hover mt-2" id="table-tindakan">
		<thead class="table-dark">
			<tr>
				<th>No </th>
				<th>Tindakan</th>
				<th>Keterangan</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td></td>
				<td>
					<select class="form-control js-example-basic-single" id="checkup_id[]" name="checkup_id[]">
						<option value="">-- Pilih Tindakan --</option>
						@foreach($tindakan as $key => $value)
						<option value="{{ $value->checkup_id }}">{{ $value->name }}</option>
						@endforeach
					</select>
				</td>
				<td>
					<textarea class="form-control" id="description_act[]" name="description_act[]" placeholder="Masukan Keterangan"></textarea>
				</td>
				<td></td>
			</tr>
		</tbody>
	</table>
</div>