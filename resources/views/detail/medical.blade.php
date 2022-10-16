@extends("template.layout")
@section("content")
<div class="card">
  <div class="card-body">
    @include("template.notif")
    @csrf
    <div class="row">
      <div class="text-end">
        <a href="{{ url("medical") }}" class="btn btn-sm btn-warning"><i class="fa fa-reply"></i> Kembali</a>
      </div>
      <div class="col-md-4">
        <label class="col-form-label">
          No. Rekam Medis
        </label>
        <input type="text" class="form-control" value="@if(isset($pasien->medical_record_number)){{ $pasien->medical_record_number }}@endif" disabled readonly>
      </div>

      <div class="col-md-4">
        <label class="col-form-label">
          Nama Pasien
        </label>
        <input type="text" class="form-control" value="@if(isset($pasien->name)){{ ucfirst($pasien->name) }}@endif" disabled readonly>
      </div>

      <div class="col-md-4">
        <label class="col-form-label">
          Jenis Kelamin
        </label>
        <input type="text" class="form-control" value="@if(isset($pasien->gender) and $pasien->gender=="male"){{ 'Laki-Laki' }}@else{{ 'Perempuan' }}@endif" disabled readonly>
      </div>

      <div class="col-md-4">
        <label class="col-form-label">
          Tanggal Pemeriksaan <span class="text-danger"> *</span>
        </label>
        <input type="date" class="form-control" id="date" name="date" disabled readonly placeholder="Masukan Tgl Pemeriksaan Pasien">
      </div>

      <div class="col-md-4">
        <label class="col-form-label">
          Biaya Pemeriksaan
        </label>
        <input type="text" class="form-control" value="{{ StringHelper::toRupiah($data->nominal) }}" disabled readonly  placeholder="Masukan biaya pemeriksaan">
      </div>

      <div class="col-md-4">
        <label class="col-form-label">
          Total Biaya
        </label>
        <input type="text" class="form-control" id="total" name="total" value="{{ StringHelper::toRupiah($data->total) }}" readonly disabled>
      </div>

      <div class="col-md-6 mt-2">
        <label class="col-form-label">
          Keterangan Pemeriksaan <span class="text-danger"> *</span>
        </label>

        <textarea name="description" style="height: 200px" id="description" required placeholder="Masukan Keterangan Pemeriksaan" class="form-control" disabled readonly>@if(isset($data->description)){{ $data->description }}@else{{ old('description') }}@endif</textarea>
      </div>

      <div class="col-md-6 ">
        <label class="col-form-label">
          Tindakan Medis <span class="text-danger"> *</span>
        </label>
        <div class="table-responsive mt-2">
          <table class="table table-hover" >
            <thead class="table-dark">
              <tr>
                <th>No </th>
                <th>Tindakan</th>
                <th>Keterangan</th>
              </tr>
            </thead>
            <tbody>
              @foreach($tindakan as $key => $value)
              <tr>
                <td>{{ $key+1 }}</td>
                <td>
                  {{ $value->name }}
                </td>
                <td>
                  {{ $value->description }}
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

      <div class="col-md-12 mt-2 row">
        <div class="col-md-6">
          <h4><i class="fa fa-medkit"></i> Data Obat</h4>
        </div>
        
        <div class="col-md-6 text-end">
          @if($data->status=="1")
          <a class="btn btn-sm btn-info" href="#" onclick="goGenerate('{{ $data->medical_id }}')">
            <i class="fa fa-chevron-right"></i> Generate Tagihan
          </a>
          <button type="button" class="btn btn-sm btn-primary" onclick="addObat()">
            <i class="fa fa-plus"></i> Tambah Obat
          </button>
          @elseif($data->status=="2")
          <button type="button" class="btn btn-sm btn-success" onclick="goBayar('{{ $data->medical_id }}', '{{ $data->total }}')">
            <i class="fa fa-money"></i> Pembayaran
          </button>
          @endif
        </div>
      </div>

      <div class="col-md-12">
        <div class="table-responsive mt-2">
          <table class="table table-hover">
            <thead class="table-dark">
              <tr>
                <th>No </th>
                <th>Obat</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              @php
              $total = 0;
              @endphp
              @foreach($detail as $key => $value)
              <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $value->name }}</td>
                <td >{{ StringHelper::toRupiah($value->harga) }}</td>
                <td >{{ $value->qty }}</td>
                <td class="text-end">{{ StringHelper::toRupiah($value->price) }}</td>
                <td class="text-center">
                  @if($data->status=="1")
                  <button class="btn btn-warning btn-sm" type="button" onclick="goEdit('{{ $value->medical_medicine_id }}', '{{ $value->medicine_id }}', '{{ $value->qty }}')">
                    <i class="fa fa-edit"></i>
                  </button>
                  <a class="btn btn-danger btn-sm" href="{{ url("medical/".$value->medical_medicine_id."/deleteobat") }}" >
                    <i class="fa fa-times"></i>
                  </a>
                  @endif
                </td>
                @php
                $total += $value->price;
                @endphp
              </tr>
              @endforeach
              <tr>
                <td colspan="4" class="text-end"><b>Total : </b></td>
                <td class="text-end">
                  <b>{{ StringHelper::toRupiah($total) }}</b>
                </td>
                <td></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bd-example-modal-sm" id="modal-tagihan" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="mySmallModalLabel">Apakah Anda ingin melakukan generate tagihan ?</h4>
      </div>
      <form method="POST" action="" enctype="multipart/form-data" id="form-tagihan">
        @csrf
        <div class="modal-body text-end">
          <button type="submit" class="btn btn-md btn-success">
            <i class="fa fa-save"></i> Iya
          </button>
          <button type="button" class="btn btn-md btn-danger" data-bs-dismiss="modal" aria-label="Close">
            <i class="fa fa-times"></i> Tidak
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

@include("detail.modal-obat")
@include("detail.modal-bayar")

@endsection
@section("script")
<script src="{{ URL::asset('js/select2/select2.full.min.js') }}"></script>
<script src="{{ URL::asset('js/select2/select2-custom.js') }}"></script>
<script type="text/javascript">

  @if(isset($data->date))
  $("#date").val('{{ date("Y-m-d", strtotime($data->date)) }}');
  @elseif(old("date")!=null)
  $("#date").val('{{ old("date") }}');
  @else
  $("#date").val('{{ date("Y-m-d") }}');
  @endif

  function goGenerate(id) {
    $("#modal-tagihan").modal("show");
    $("#form-tagihan").attr("action", "{{ url("medical") }}/"+id+"/generate");
  }

  function goBayar(id, total) {
    $("#modal-bayar").modal("show");
    $("#form-bayar").attr("action", "{{ url("medical") }}/"+id+"/payment");
    $("#nominal").val(total);
  }

</script>
@include("detail.js-obat")
@endsection