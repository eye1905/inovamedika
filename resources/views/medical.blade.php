@extends("template.layout")

@section("content")
<div class="card">
    <div class="card-body">
        @include("template.page-name")
        @include("template.notif")
        <form method="GET" action="{{ url()->current() }}" enctype="multipart/form-data" id="form-select">
            @csrf
            <input type="hidden" name="_method" value="GET">
            @include("filter.filter-collapse")
            <div class="row">
                <div class="col-sm-12 col-lg-12 col-xl-12">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Kode {{ StringHelper::getNameMenu() }}</th>
                                    <th>Pasien</th>
                                    <th>Tgl Pemeriksaan</th>
                                    <th>Total Biaya</th>
                                    <th>Status </th>
                                    <th>Staff </th>
                                    <th class="text-center">Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($data) < 1)
                                <tr>
                                    <td colspan="6" class="text-center">Data Kosong</td>
                                </tr>
                                @endif
                                @foreach($data as $key => $value)
                                <tr>
                                    <td>
                                        <a href="{{ url("medical/".$value->medical_id) }}">
                                            <b>{{ $value->medical_code }}</b>
                                        </a>
                                        <br>
                                        {{ $value->created_at }}
                                    </td>
                                    <td>
                                        <b>{{ $value->pasien }} </b> (
                                        @if($value->gender=="male")
                                        Laki-Laki
                                        @else
                                        Perempuan
                                        @endif
                                        )
                                        <br>
                                        <i class="fa fa-phone"></i> {{ "62".$value->phone }}
                                    </td>
                                    <td>
                                        {{ StringHelper::daydate($value->date).", ".StringHelper::dateindo($value->date) }}
                                    </td>
                                    <td>
                                        {{ StringHelper::toRupiah($value->total) }}
                                    </td>
                                    <td>
                                        @if($value->status=="1")
                                        <span class="badge badge-warning"><i class="fa fa-download"></i> Draft</span>
                                        @elseif($value->status=="2")
                                        <span class="badge badge-primary"><i class="fa fa-upload"></i> Menunggu Pembayaran</span>
                                        @else
                                        <span class="badge badge-success"><i class="fa fa-check"></i> Pembayaran Selesai</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $value->staff }}
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                        <div class="dropdown-menu">

                                            @if(StringHelper::getAccess("detail_permission")==true)
                                            <a class="dropdown-item" href="{{ url(Request::segment(1)."/".$value->medical_id) }}">
                                                <i class="fa fa-edit"></i> Detail
                                            </a>
                                            @if($value->status=="1")
                                            <a class="dropdown-item" href="#" onclick="goGenerate('{{ $value->medical_id }}')">
                                                <i class="fa fa-chevron-right"></i> Generate Tagihan
                                            </a>
                                            @elseif($value->status=="2")
                                            <a class="dropdown-item" href="#" onclick="goBayar('{{ $value->medical_id }}', '{{ $value->total }}')">
                                                <i class="fa fa-money"></i> Bayar Tagihan
                                            </a>
                                            @endif
                                            @endif

                                            @if(StringHelper::getAccess("export_permission")==true)
                                            <a class="dropdown-item" href="{{ url(Request::segment(1)."/".$value->medical_id) }}">
                                                <i class="fa fa-print"></i> Cetak Struk
                                            </a>
                                            @endif

                                            {{-- @if(StringHelper::getAccess("delete_permission")==true and $value->status=="1")
                                            <a class="dropdown-item" href="#" onclick="CheckDelete('{{ url(Request::segment(1)) }}/{{ $value->medical_id }}')">
                                                <i class="fa fa-times"></i> Hapus
                                            </a>
                                            @endif --}}
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @include("template.paginator")
            </div>
        </form>
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

@include("detail.modal-bayar")

@endsection

@section("script")
<script src="{{ URL::asset('js/select2/select2.full.min.js') }}"></script>
<script src="{{ URL::asset('js/select2/select2-custom.js') }}"></script>
<script type="text/javascript">
    $("#shareselect").change(function(){
        $("#_method").attr("method", "GET");
        $("#form-select").submit();
    });

    @if(isset($filter["page"]))
    $("#shareselect").val('{{ $filter["page"] }}');
    @endif

    @if(isset($filter["f_patient_id"]))
    $("#f_patient_id").val('{{ $filter["f_patient_id"] }}');
    @endif

    @if(isset($filter["f_medical_code"]))
    $("#f_medical_code").val('{{ $filter["f_medical_code"] }}');
    @endif

    @if(isset($filter["f_status"]))
    $("#f_status").val('{{ $filter["f_status"] }}');
    @endif

    @if(isset($filter["start_date"]))
    $("#start_date").val('{{ $filter["start_date"] }}');
    @endif
    
    @if(isset($filter["end_date"]))
    $("#end_date").val('{{ $filter["end_date"] }}');
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
@endsection