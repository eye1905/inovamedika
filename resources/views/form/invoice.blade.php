@extends("template.layout")
@section("content")
<div class="card">
  <div class="card-body">
    @include("template.page-name")
    @include("template.notif")
    <form method="POST" enctype="multipart/form-data" id="form-invoice" action="@if(Request::segment(2)=='create'){{ url(Request::segment(1)) }}@else{{ url(Request::segment(1), $data->invoice_id) }}@endif">

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

        @if(Request::segment(3)=="edit" or  Request::segment(2)=="create")
        <div class="col-md-12 text-end">
          <button type="button" class="btn btn-success btn-md" onclick="goCheck()">
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
          <th>Alat</th>
          <th>Satuan</th>
          <th>Durasi</th>
          <th colspan="text-end">Harga</th>
        </thead>
        <tbody id="table-tools">
          @php
          $total = 0;
          @endphp
          @foreach($detail as $key => $value)
          <tr>
            <td>
              {{ ucfirst($value->alat) }}
            </td>
            <td>
              {{ " ( ".$value->quantity." x ".$value->satuan." ) " }}
            </td>
            <td>
              {{ $value->usage_duration }}
            </td>
            <td class="text-end">
              {{ $value->price }}
            </td>
            @php
            $total += $value->price
            @endphp
          </tr>
          @endforeach
          <tr style="background-color:gray">
            <td colspan="3" class="text-end text-white">
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

<div class="modal fade" id="modal-status" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div class="alert alert-danger">
          <h4 class="modal-title" style="margin-left: 5%; font-weight: bold;" id="label-status">

          </h4>
        </div>
        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body row">
        <div class="col-md-12 mt-2 text-end">
          <button type="button" onclick="showModal()" class="btn btn-primary">
            <i class="fa fa-plus"></i> Buat Pengumuman
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-pengumuman" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" style="margin-left: 7%; font-weight: bold;"></h4>
        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body row">
        <form method="POST" action="{{ url("invoice/1/createpengumuman") }}" enctype="multipart/form-data" id="form-status">
          @csrf
          <div class="col-md-12">
            <label>
              Isi Pengumuman
              <span class="text-danger"> * </span>
            </label>

            <textarea class="form-control" name="announcement" id="announcement" minlength="5" maxlength="255" style="min-height: 200px" placeholder="Masukan isi Pengumuman">{{ old("announcement") }}</textarea>

            @if($errors->has('announcement'))
            <label class="text-danger">
              {{ $errors->first('announcement') }}
            </label>
            @endif

          </div>
          <br>
          <div class="col-md-12 mt-2 text-end">
            <hr>
            <button type="submit" class="btn btn-success">
              <i class="fa fa-save"></i> Simpan
            </button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true"><i class="fa fa-times"></i> Tidak</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
@section("script")
<script type="text/javascript">
  @if(Request::segment(3)==null and  Request::segment(2)!='create')
  $(".form-control").attr("readonly", true);
  $(".form-control").attr("disabled",  true);
  $(".form-control").css("background-color", "#FFFF");
  @else
  $(".form-control").removeAttr("readonly");
  $(".form-control").removeAttr("disabled");
  @endif

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

  function goCheck() {
    var start = $("#tgl_awal").val();
    var end = $("#tgl_akhir").val();
    $.ajax({
      type: "POST",
      dataType: "json",
      data:{start:start, end:end, _token: "{{ csrf_token() }}"},
      url: "{{ url('invoice') }}/1/checkinvoice",
      success: function(data) {
        if(data>0){

          $("#label-status").text("Terdapat "+data+" Assesment pada tanggal "+start+" Sampai "+end+" yang belum di isi oleh Fisioterapis, Silahkan Buat pengumuman untuk memberitahu Fisioterapis");
          $("#modal-status").modal("show");

        }else{
          $("#form-invoice").submit();
        }
      },
    });
  }

  function showModal() {
    $("#modal-status").modal("hide");
    var text = "Diberitahukan kepada seluruh Fisioterapis, admin akan melakukan pembuatan invoice mitra pada tanggal "+$("#tgl_awal").val()+" s/d "+$("#tgl_akhir").val()+". Dimohon kepada semua Fisioterapis untuk mengisi form Assesment pada tanggal tersebut. Terimakasih ";

    $("#announcement").html(text);
    $("#modal-pengumuman").modal("show");
  }

  @if(isset($filter["start_date"]) and $filter["start_date"]!=null)
  $("#tgl_awal").val('{{ $filter["start_date"] }}');
  @endif

  @if(isset($filter["end_date"]) and $filter["end_date"]!=null)
  $("#tgl_akhir").val('{{ $filter["end_date"] }}');
  @endif
</script>
@endsection