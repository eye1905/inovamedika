@extends("template.layout")

@section("content")
<div class="card">
    <div class="card-body">
        @include("template.page-name")
        @include("template.notif")
        <form method="GET" action="{{ url()->current() }}" enctype="multipart/form-data" id="form-select">
            @csrf
            <input type="hidden" name="_method" value="GET">
            <div class="row">
                <div class="col-sm-12 col-lg-12 col-xl-12">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Kode {{ StringHelper::getNameMenu() }}</th>
                                    <th>{{ StringHelper::getNameMenu() }}</th>
                                    <th>Level</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($data) < 1)
                                <tr>
                                    <td colspan="3" class="text-center">Data Kosong</td>
                                </tr>
                                @endif
                                @foreach($data as $key => $value)
                                <tr>
                                    <td>{{ $value->id_wil }}</td>
                                    <td>
                                        {{ $value->nama_wil }}
                                    </td>
                                    <td>
                                        @if($value->level_wil == "1")
                                        Provinsi
                                        @elseif($value->level_wil =="2")
                                        Kabupaten
                                        @else
                                        Kecataman
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @include("template.paginate")
            </div>
        </form>
    </div>
</div>
@endsection

@section("script")
<script type="text/javascript">
    $("#shareselect").change(function(){
        $("#_method").attr("method", "GET");
        $("#form-select").submit();
    });

    @if(isset($filter["page"]))
    $("#shareselect").val('{{ $filter["page"] }}');
    @endif
</script>
@endsection