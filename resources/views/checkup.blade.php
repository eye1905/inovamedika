@extends("template.layout")

@section("content")
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h3 class="font-roboto">
                    <span><i class="fa fa-users"></i> </span> 
                    Data {{ StringHelper::getNameMenu() }}
                </h3>
            </div>
            @if(StringHelper::getAccess("create_permission")==true)
            <div class="col-md-6 text-end">
                <a href="#" onclick="goPopUp()" class="btn btn-sm btn-primary">
                    <i class="fa fa-plus"> </i> Tambah {{ StringHelper::getNameMenu() }}
                </a>
            </div>
            @endif
        </div>
        <hr>
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
                                    <th>No {{ StringHelper::getNameMenu() }}</th>
                                    <th>Nama {{ StringHelper::getNameMenu() }}</th>
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
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        {{ $value->name }}
                                    </td>
                                    <td class="text-center">
                                        @if(StringHelper::getAccess("update_permission")==true)
                                        <a href="#" onclick="goEdit('{{ $value->checkup_id }}', '{{ $value->name }}')" class="btn btn-sm btn-warning" style="color: #fff" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                            <i class="fa fa-pencil"></i> Edit
                                        </a>
                                        @endif
                                        @if(StringHelper::getAccess("delete_permission")==true)
                                        <button class="btn btn-sm btn-danger" type="button" onclick="CheckDelete('{{ url(Request::segment(1)) }}/{{ $value->checkup_id }}')" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                            <i class="fa fa-times"></i> Hapus
                                        </button>
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

<div class="modal fade bd-example-modal-sm" id="modal-Posisi" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="mySmallModalLabel">Form Input  {{ StringHelper::getNameMenu() }}</h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="#" enctype="multipart/form-data" id="form-Posisi">
                @csrf
                <input type="hidden" name="_method" id="method_desc" value="POST">
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12 mt-2">
                            <label class="col-form-label">
                                Nama  {{ StringHelper::getNameMenu() }} <span class="text-danger"> *</span>
                            </label>

                            <input type="text" class="form-control @if($errors->has('name')) is-invalid @endif" required id="name" name="name" minlength="5" maxlength="255" placeholder="Masukan nama  ...">
                            
                            @if($errors->has('name'))
                            <label class="text-danger">
                                {{ $errors->first('name') }}
                            </label>
                            @else
                            <label class="text-notif">
                                Nama {{ StringHelper::getNameMenu() }} berisi huruf, angka dan spasi 3 - 255 Karakter
                            </label>
                            @endif
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i> Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section("script")
<script type="text/javascript">
    function goPopUp() {
        $("#modal-Posisi").modal("show");
        $("#form-Posisi").attr("action", "{{ url(Request::segment(1)) }}");
        $("#method_desc").val("POST");
        $("#name").val('');

    }

    function goEdit(id, name){
        $("#modal-Posisi").modal("show");
        $("#name").val(name);
        $("#form-Posisi").attr("action", "{{ url(Request::segment(1)) }}/"+id);
        $("#method_desc").val("PUT");

    }

    $("#shareselect").change(function(){
        $("#_method").attr("method", "GET");
        $("#form-select").submit();
    });

    @if(isset($filter["page"]))
    $("#shareselect").val('{{ $filter["page"] }}');
    @endif
</script>
@endsection
