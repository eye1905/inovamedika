<script type="text/javascript">
	function addTindakan() {
		$('#table-tindakan').append('<tr><td></td><td><select class="form-control js-example-basic-single" id="checkup_id[]" name="checkup_id[]"><option value="">-- Pilih Tindakan --</option>@foreach($tindakan as $key => $value)<option value="{{ $value->checkup_id }}">{{ $value->name }}</option>@endforeach</select></td><td><textarea class="form-control" id="description_act[]" name="description_act[]" placeholder="Masukan Keterangan"></textarea></td><td><button type="button" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Hapus</button></td></tr>');
	}	
	
	$("#table-tindakan").on('click', '.btn-danger', function () {
		$(this).closest('tr').remove();
	});
</script>