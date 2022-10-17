<script type="text/javascript">
    (function($) {
        "use strict";
        var options = {
          labels: [@foreach($obat as $key => $value) '{{ $value->name }}', @endforeach],
          series: [@foreach($statsobat as $key => $value) '{{ $value->jumlah }}', @endforeach],
          chart: {
            type: 'donut',
            height: 390 ,
        },
        legend:{
            position:'bottom'
        },
        dataLabels: {
            enabled: false,
        },      
        states: {          
            hover: {
              filter: {
                type: 'darken',
                value: 1,
            }
        }           
    },
    stroke: {
        width: 0,
    },
    responsive: [
    {
      breakpoint: 1661,
      options: {
        chart: {
            height:310,
        }
    }
},            
{
  breakpoint: 481,
  options:{
    chart:{
        height:280,
    }
},
}

],     
colors:[zetaAdminConfig.primary,zetaAdminConfig.secondary,zetaAdminConfig.success,zetaAdminConfig.info,zetaAdminConfig.warning,zetaAdminConfig.danger],
};
var chart = new ApexCharts(document.querySelector("#chart-obat"), options);
chart.render();


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
var chartcolumnchart = new ApexCharts(document.querySelector("#chart-usia"),optionscolumnchart);
chartcolumnchart.render();

})(jQuery);
</script>