@extends("template.layout")
@section("content")
<div class="card">
  <div class="card-body">
    @include("template.notif")
    <form method="POST" enctype="multipart/form-data" action="{{ url("medical") }}">
      <input type="hidden" name="patient_id" value="{{ $pasien->patient_id }}"  id="patient_id">
      @csrf
      <div class="row">
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
          <input type="date" class="form-control" id="date" name="date" placeholder="Masukan Tgl Pemeriksaan Pasien">

          @if($errors->has('date'))
          <label class="text-danger">
            {{ $errors->first('date') }}
          </label>
          @else
          <label class="text-notif">
            Tgl Pemeriksaan {{ StringHelper::getNameMenu() }} berisi format tanggal (dd-mm-yy)
          </label>
          @endif
        </div>

        <div class="col-md-8 mt-2">
          <label class="col-form-label">
            Keterangan Pemeriksaan <span class="text-danger"> *</span>
          </label>

          <textarea name="description" style="height: 200px" id="description" required placeholder="Masukan Keterangan Pemeriksaan" class="form-control">@if(isset($data->description)){{ $data->description }}@else{{ old('description') }}@endif</textarea>

          @if($errors->has('description'))
          <label class="text-danger">
            {{ $errors->first('description') }}
          </label>
          @endif
        </div>

        @if(!request()->routeIs('medical.show'))
        <div class="col-md-12 mt-4 text-center">
          <button class="btn btn-sm btn-success">
            Selesai Pemeriksaan
            <i class="fa fa-chevron-right"></i>
          </button>
        </div>
        @endif

        <div class="col-md-6">
          @include("detail.tindakan")
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

  @if(isset($data->date))
  $("#date").val('{{ date("Y-m-d", strtotime($data->date)) }}');
  @elseif(old("date")!=null)
  $("#date").val('{{ old("date") }}');
  @else
  $("#date").val('{{ date("Y-m-d") }}');
  @endif

  @if(Request::segment(3)==null and  Request::segment(2)!="create")
  $(".form-control").attr("readonly", true);
  $(".form-control").attr("disabled",  true);
  $("input").attr("disabled",  true);
  $("input").attr("readonly", true);
  $(".form-control").css("background-color", "#FFFF");
  @else
  $(".form-control").removeAttr("readonly");
  $(".form-control").removeAttr("disabled");
  $("input").removeAttr("disabled");
  $("input").removeAttr("readonly");
  @endif


</script>
@endsection