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
                                    <th>Nama {{ StringHelper::getNameMenu() }}</th>
                                    <th>Indikasi </th>
                                    <th>Dosis </th>
                                    <th>Harga </th>
                                    <th>Aksi </th>
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
                                    <td>{{ $value->code }}</td>
                                    <td>
                                        {{ $value->name }}
                                    </td>
                                    <td>
                                        {{ $value->indikasi }}
                                    </td>
                                    <td>
                                        {{ $value->dosis }}
                                    </td>
                                    <td>
                                        {{ StringHelper::toRupiah($value->harga) }}
                                    </td>
                                    <td class="text-center">
                                        {!! StringHelper::inc_dropdown($value->medicine_id) !!}
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