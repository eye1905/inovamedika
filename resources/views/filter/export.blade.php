 <button class="btn btn-sm btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Export</button>
  <div class="dropdown-menu">
    
    @php
    $furl = str_replace("report", "cetak", url()->current());
    $params = request()->query();
    $excel = "?format=excel";
    $pdf = "?format=pdf";
    $f_params = null;
    foreach($params as $key => $value){
        $f_params .= "&".$key."=".$value;
    }
    $excelurl = $furl.$excel.$f_params;
    $pdfurl = $furl.$pdf.$f_params;
    @endphp
    
    <a class="dropdown-item" target="_blank" href="{{ url($pdfurl) }}">PDF</a>
    <a class="dropdown-item" target="_blank" href="{{ url($excelurl) }}">Excel</a>
  </div>