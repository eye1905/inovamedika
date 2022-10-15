<script type="text/javascript">
    var dslaki = [];
    var dsperempuan = [];
    var i = 0;
    @foreach($kelaminpasien as $key => $value)
    dslaki.push({{ $value["laki"] }});
    dsperempuan.push({{ $value["perempuan"] }});
    @endforeach

    (function($) {
        "use strict";

// column chart
var optionscolumnchart = {
    series: [{
      name: 'Laki - Laki',
      data: dslaki
  }, {
      name: 'Perempuan',
      data: dsperempuan,
  }],

  legend: {
    show: false
},
chart: {
  type: 'bar',
  height: 380,
},
plotOptions: {
    bar: {
        radius: 10,
        horizontal: false,
        columnWidth: '55%',
        endingShape: 'rounded',
    }
},
dataLabels: {
    enabled: false
},
stroke: {
    show: true,
    colors: ['transparent'],
    curve: 'smooth',
    lineCap: 'butt'
},
grid: {
    show: false,
    padding: {
        left: 0,
        right: 0
    }
},
xaxis: {
    title: {
        text: 'Bulan'
    },
    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
},
yaxis: {
    title: {
        text: 'Jumlah Pasien'
    },
    categories: [10, 50, 100, 500, 1000]
},
fill: {
    colors:[zetaAdminConfig.primary, zetaAdminConfig.warning],
    type: 'gradient',
    gradient: {
        shade: 'light',
        type: 'vertical',
        shadeIntensity: 0.1,
        inverseColors: false,
        opacityFrom: 1,
        opacityTo: 0.9,
        stops: [0, 100]
    }
},
tooltip: {
    y: {
        formatter: function (val) {
            return  val 
        }
    }
}
};
var chartcolumnchart = new ApexCharts(
    document.querySelector("#chart-widget4"),
    optionscolumnchart
    );
chartcolumnchart.render();

var dsusia = [];

@foreach($usia as $key => $value)
dsusia.push({{ $value }});
@endforeach

var optionscolumnchart = {
    series: [{
      name: 'Jumlah',
      data: dsusia
  }],

  legend: {
    show: false
},
chart: {
  type: 'bar',
  height: 380
},
plotOptions: {
    bar: {
        radius: 10,
        horizontal: false,
        columnWidth: '55%',
        endingShape: 'rounded',
    }
},
dataLabels: {
    enabled: false
},
stroke: {
    show: true,
    colors: ['transparent'],
    curve: 'smooth',
    lineCap: 'butt'
},
grid: {
    show: false,
    padding: {
        left: 0,
        right: 0
    }
},
xaxis: {
    title: {
        text: 'Usia'
    },
    categories: ['<10', '10-15', '15-20', '20-25', '25-30', '30-35', '35-40', '40-45', '45-50', '50++'],
},
yaxis: {
    title: {
        text: 'Jumlah Pasien'
    }
},
fill: {
    colors:[zetaAdminConfig.success],
    type: 'gradient',
    gradient: {
        shade: 'light',
        type: 'vertical',
        shadeIntensity: 0.1,
        inverseColors: false,
        opacityFrom: 1,
        opacityTo: 0.9,
        stops: [0, 100]
    }
},
tooltip: {
    y: {
        formatter: function (val) {
            return  val 
        }
    }
}
};
var chartcolumnchart = new ApexCharts(
    document.querySelector("#chart-widget8"),
    optionscolumnchart
    );
chartcolumnchart.render();

var twpaket = [];
var twnamapaket = [];
@foreach($paket as $key => $value)
twpaket.push({{ $value->total }});
twnamapaket.push('{{ $value->name }}');
@endforeach

var optionscolumnchart2 = {
    series: [{
      name: 'Jumlah',
      data: twpaket
  }],
  legend: {
    show: false
},
chart: {
  type: 'bar',
  height: 380
},
plotOptions: {
    bar: {
        radius: 10,
        horizontal: false,
        columnWidth: '55%',
        endingShape: 'rounded',
    }
},
dataLabels: {
    enabled: false
},
stroke: {
    show: true,
    colors: ['transparent'],
    curve: 'smooth',
    lineCap: 'butt'
},
grid: {
    show: false,
    padding: {
        left: 0,
        right: 0
    }
},
xaxis: {
    title: {
        text: 'Jenis Paket'
    },
    categories: twnamapaket,
},
yaxis: {
    title: {
        text: 'Jumlah Ambil Paket'
    }
},
fill: {
    colors: [function({ value, seriesIndex, w }) {
        if (value <= 25) {
          return '#77d8e7'
        }else if(value >25 && value <= 50){
            return '#77bae7'
        }
        else if(value >75 && value <= 100){
            return '#dd9d45'
        }
        else {
          return '#099c35'
        }
  }],
  type: 'gradient',
  gradient: {
    shade: 'light',
    type: 'vertical',
    shadeIntensity: 0.1,
    inverseColors: false,
    opacityFrom: 1,
    opacityTo: 0.9,
    stops: [0, 100]
}
},
tooltip: {
    y: {
        formatter: function (val) {
            return  val 
        }
    }
}
};


var chartcolumnchart1 = new ApexCharts(
    document.querySelector("#chart-paket"),
    optionscolumnchart2
    );
chartcolumnchart1.render();



var twpaket = [];
var twnamapaket = [];
@foreach($fisio as $key => $value)
twpaket.push({{ $value->total }});
twnamapaket.push('{{ $value->name }}');
@endforeach

var optionscolumnchart2 = {
    series: [{
      name: 'Jumlah',
      data: twpaket
  }],
  legend: {
    show: false
},
chart: {
  type: 'bar',
  height: 380
},
plotOptions: {
    bar: {
        radius: 10,
        horizontal: false,
        columnWidth: '55%',
        endingShape: 'rounded',
    }
},
dataLabels: {
    enabled: false
},
stroke: {
    show: true,
    colors: ['transparent'],
    curve: 'smooth',
    lineCap: 'butt'
},
grid: {
    show: false,
    padding: {
        left: 0,
        right: 0
    }
},
xaxis: {
    title: {
        text: 'Fisioterapis'
    },
    categories: twnamapaket,
},
yaxis: {
    title: {
        text: 'Jumlah Penangan Terapi'
    }
},
fill: {
    colors: [function({ value, seriesIndex, w }) {
        if (value <= 25) {
          return '#6fa8dc'
        }else if(value >25 && value <= 50){
            return '#38761d'
        }
        else if(value >75 && value <= 100){
            return '#f1c232'
        }
        else {
          return '#f44336'
        }
  }],
  type: 'gradient',
  gradient: {
    shade: 'light',
    type: 'vertical',
    shadeIntensity: 0.1,
    inverseColors: false,
    opacityFrom: 1,
    opacityTo: 0.9,
    stops: [0, 100]
}
},
tooltip: {
    y: {
        formatter: function (val) {
            return  val 
        }
    }
}
};
var chartcolumnchart1 = new ApexCharts(
    document.querySelector("#chart-fisioterapis"),
    optionscolumnchart2
    );
chartcolumnchart1.render();


})(jQuery);
</script>