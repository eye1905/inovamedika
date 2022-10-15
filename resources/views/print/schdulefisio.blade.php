@extends("print.layout")
@section("title", StringHelper::ucsplit(StringHelper::getNameMenu("treatmentschedule")))
@section("content")
<h4 class="text-title">
<i class="fa fa-file"></i>  Laporan {{ StringHelper::ucsplit(StringHelper::getNameMenu("treatmentschedule")) }}
</h4>
<table class="table1">
  <thead>
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
@endsection