@extends("template.layout")
@section("content")
<div class="card">
  <div class="card-body">
    @include("template.notif")
    <form method="POST" enctype="multipart/form-data" action="{{ url("medical") }}">
      @csrf
      <div class="row">
        <div class="text-end">
          <a href="{{ url("medical") }}" class="btn btn-sm btn-warning"><i class="fa fa-reply"></i> Kembali</a>
        </div>

        <div class="col-md-4">
          <label class="col-form-label">
            Nama Pasien  <span class="text-danger"> *</span>
          </label>
          <select class="js-example-basic-single col-sm-12" id="patient_id" name="patient_id" required>
            <option value="">-- Semua Pasien --</option>
            @foreach($pasien as $key => $value)
            <option value="{{ $value->patient_id }}">{{ $value->name." ( ".$value->medical_record_number." )" }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-4">
          <label class="col-form-label">
            Tanggal Pemeriksaan <span class="text-danger"> *</span>
          </label>
          <input type="date" class="form-control" required id="date" name="date" placeholder="Masukan Tgl Pemeriksaan Pasien">

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

        <div class="col-md-4">
          <label class="col-form-label">
            Biaya Pemeriksaan
          </label>
          <input type="number" class="form-control" id="nominal" name="nominal" placeholder="Masukan biaya pemeriksaan">

          @if($errors->has('date'))
          <label class="text-danger">
            {{ $errors->first('date') }}
          </label>
          @else
          <label class="text-notif">
            Biaya Pemeriksaan {{ StringHelper::getNameMenu() }} berisi format nominal rupiah
          </label>
          @endif
        </div>

        <div class="col-md-12 mt-2">
          <label class="col-form-label">
            Keterangan Pemeriksaan <span class="text-danger"> *</span>
          </label>

          <textarea name="description" style="height: 100px" id="description" required placeholder="Masukan Keterangan Pemeriksaan" class="form-control">@if(isset($data->description)){{ $data->description }}@else{{ old('description') }}@endif</textarea>

          @if($errors->has('description'))
          <label class="text-danger">
            {{ $errors->first('description') }}
          </label>
          @endif
        </div>

        <div class="col-md-12 mt-2">
          @include("detail.tindakan")
        </div>

        @if(!request()->routeIs('medical.show'))
        <div class="col-md-12 mt-4 text-center">
          <button class="btn btn-sm btn-success">
            Resep Obat
            <i class="fa fa-chevron-right"></i>
          </button>
        </div>
        @endif

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

</script>
@include("detail.js-tindakan")
@endsection