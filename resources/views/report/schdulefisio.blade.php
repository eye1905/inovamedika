@extends("template.layout")
@section("content")
<div class="card">
  <div class="card-body">
    @include("template.page-name2")
    @include("template.notif")
    <form method="GET" action="{{ url()->current() }}" enctype="multipart/form-data" id="form-select">
      @include("filter.filter-collapse")
      <div class="row">
        <div class="col-md-12 table-responsive">
          @csrf
          <input type="hidden" name="_method" value="GET">
          <table class="table table-hover mt-2">
            <thead class="table-dark">
              <tr>
                <th>
                  No
                </th>
                <th>
                  Fisioterapis
                </th>
                <th>
                  Pasien
                </th>
                <th>
                  Paket ( Pertemuan Ke)
                </th>
                <th>
                  Waktu Treatment
                </th>
                <th>
                  Treament
                </th>
                <th>
                  Assesment
                </th>
              </tr>
            </thead>
            <tbody>
              @foreach($data as $key => $value)
              <tr>
                <td>{{ $key+1 }}</td>
                <td>
                  <b>
                  {{ $value->name }}
                  </b>
                </td>
                <td>
                  {{ $value->pasien }}
                </td>
                <td>
                  {{ $value->paket." ( " .$value->meeting_index." )" }}
                </td>
                <td>
                  {{ StringHelper::daydate($value->date_scheduled).", ".StringHelper::dateindo($value->date_scheduled) }}
                  <br> {{ "( ".$value->start_clock." - ".$value->end_clock." )" }}
                </td>
                <td>
                  @if($value->is_claimed == true)
                  <span class="badge rounded-pill badge-success">Treatment Selesai</span>
                  @else
                  <span class="badge rounded-pill badge-warning text-dark">
                    Belum Selesai
                  </span>
                  @endif
                </td>
                <td>
                  @if($value->is_assesment == true)
                  <span class="badge rounded-pill badge-success">
                    Submitted
                  </span>
                  @else
                  <span class="badge rounded-pill badge-warning text-dark">
                    Unsubmitted
                  </span>
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
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
@if(isset($filter["start_date"]) and $filter["start_date"]!=null)
$("#start_date").val('{{ $filter["start_date"] }}');
@endif
@if(isset($filter["end_date"]) and $filter["end_date"]!=null)
$("#end_date").val('{{ $filter["end_date"] }}');
@endif
@if(isset($filter["staff_id"]) and $filter["staff_id"]!=null)
$("#fstaff_id").val('{{ $filter["staff_id"] }}');
@endif
@if(isset($filter["package_id"]) and $filter["package_id"]!=null)
$("#package_id").val('{{ $filter["package_id"] }}');
@endif
@if(isset($filter["patient_id"]) and $filter["patient_id"]!=null)
$("#patient_id").val('{{ $filter["patient_id"] }}');
@endif

</script>
@endsection