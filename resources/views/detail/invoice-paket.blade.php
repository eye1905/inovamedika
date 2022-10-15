@extends("template.layout")
@section("content")
<div class="card">
  <div class="card-body">
    @include("template.page-name")
    @include("template.notif")
    <form method="POST" enctype="multipart/form-data" id="form-invoice" action="@if(Request::segment(2)=='createinvoicepaket'){{ url(Request::segment(1)."/storeinvoicepaket") }}@else{{ url(Request::segment(1), $data->invoice_id) }}@endif">

      @csrf
      @if(Request::segment(3)=="edit")
      {{ method_field("PUT") }}
      @endif

      <div class="row">

        <div class="col-md-4">
          <label class="col-form-label">
            Mitra
          </label>
          <select class="form-control" id="partner_id" name="partner_id">
            <option value="">-- Pilih Mitra --</option>
            @foreach($mitra as $key => $value)
            <option value="{{ $value->partner_id }}">{{ ucfirst($value->name) }}</option>
            @endforeach
          </select>
          @if($errors->has('partner_id'))
          <label class="text-danger">
            {{ $errors->first('partner_id') }}
          </label>
          @endif
        </div>

        <div class="col-md-4">
          <label class="col-form-label">
            Tgl. Awal Invoice
          </label>
          <input type="date" class="form-control" id="tgl_awal" name="tgl_awal" placeholder="Masukan Awal">

          @if($errors->has('tgl_awal'))
          <label class="text-danger">
            {{ $errors->first('tgl_awal') }}
          </label>
          @else
          <label class="text-notif">
            Tgl. Awal berisi format tanggal (dd/mm/yyyy)
          </label>
          @endif
        </div>

        <div class="col-md-4">
          <label class="col-form-label">
            Tgl. Akhir Invoice
          </label>
          <input type="date" class="form-control" id="tgl_akhir" name="tgl_akhir" placeholder="Masukan Akhir">

          @if($errors->has('tgl_akhir'))
          <label class="text-danger">
            {{ $errors->first('tgl_akhir') }}
          </label>
          @else
          <label class="text-notif">
            Tgl. Akhir berisi format tanggal (dd/mm/yyyy)
          </label>
          @endif
        </div>

        @if(isset($detail))
        <div class="col-md-4">
          <label class="col-form-label">
            Admin
          </label>
          <input type="text" class="form-control" value="@if(isset($staff->name)){{ StringHelper::ucsplit($staff->name) }}@endif">
        </div>
        <div class="col-md-4">
          <label class="col-form-label">
            Total Invoice
          </label>
          <input type="text" class="form-control" value="@if(isset($data->nominal)){{ StringHelper::toRupiah($data->nominal) }}@endif">
        </div>
        @endif

        @if(Request::segment(2)=="createinvoicepaket")
        <div class="col-md-12 text-end">
          <button type="submit" class="btn btn-success btn-md">
            <i class="fa fa-save"> </i> Simpan
          </button>
          <a href="{{ url(Request::segment(1)) }}" class="btn btn-danger btn-md">
            <i class="fa fa-times"> </i>  Batal
          </a>
        </div>
        @endif
      </div>
    </form>
    
    @if(isset($detail))
    <div class="col-md-12 mt-4">
      <table class="table table-hover">
        <thead class="table-dark">
          <th>No</th>
          <th>Paket</th>
          <th colspan="text-end">Harga</th>
        </thead>
        <tbody id="table-tools">
          @php
          $total = 0;
          @endphp
          @foreach($detail as $key => $value)
          <tr>
            <td>
              {{ $key+1 }}
            </td>
            <td class="text-end">
              @if(isset($value->paket->name))
              {{ $value->paket->name }}
              @endif
            </td>
            <td class="text-end">
              {{ $value->nominal }}
            </td>
            @php
            $total += $value->nominal
            @endphp
          </tr>
          @endforeach
          <tr style="background-color:gray">
            <td colspan="2" class="text-end text-white">
              <b>Total </b>
            </td>
            <td class="text-end text-white">
              <b>{{ StringHelper::toRupiah($total) }}</b>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    @endif
  </div>

</div>

@endsection
@section("script")
<script type="text/javascript">
  $(".form-control").attr("readonly", true);
  $(".form-control").attr("disabled",  true);
  $(".form-control").css("background-color", "#FFFF");

  @if(old("tgl_awal") != null)
  $("#tgl_awal").val('{{ old("tgl_awal") }}');
  @elseif(isset($data->tgl_awal))
  $("#tgl_awal").val('{{ $data->tgl_awal }}');
  @endif

  @if(old("tgl_akhir") != null)
  $("#tgl_akhir").val('{{ old("tgl_akhir") }}');
  @elseif(isset($data->tgl_akhir))
  $("#tgl_akhir").val('{{ $data->tgl_akhir }}');
  @endif

  @if(old("partner_id") != null)
  $("#partner_id").val('{{ old("partner_id") }}');
  @elseif(isset($data->tgl_akhir))
  $("#partner_id").val('{{ $data->partner_id }}');
  @endif

  @if(isset($filter["start_date"]) and $filter["start_date"]!=null)
  $("#tgl_awal").val('{{ $filter["start_date"] }}');
  @endif

  @if(isset($filter["end_date"]) and $filter["end_date"]!=null)
  $("#tgl_akhir").val('{{ $filter["end_date"] }}');
  @endif
</script>
@endsection