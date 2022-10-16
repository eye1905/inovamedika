<script type="text/javascript">
	function addObat() {
		$("#modal-obat").modal("show");
	}
	
	function goEdit(id, obat, qty) {
		$("#modal-obat").modal("show");
		$("#form-obat").attr("action", "{{ url("medical") }}/"+id+"/updateobat");
		$("#jumlah").val(qty);
		$("#medicine_id").val(obat);
	}
</script>