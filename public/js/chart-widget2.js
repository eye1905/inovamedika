var dslaki = [];
(function($) {
    "use strict";

// column chart
var optionscolumnchart = {
        series: [{
          name: 'Laki - Laki',
          data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
        }, {
          name: 'Perempuan',
          data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
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
            text: 'Bulan'
        },
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    },
    yaxis: {
        title: {
            text: 'Jumlah Pasien'
        }
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

// column chart
var optionscolumnchart = {
        series: [{
          name: 'Jumlah',
          data: [76, 85, 101, 98, 87, 105, 91]
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
        categories: ['5-10', '10-15', '15-20', '20-25', '25-30', '30-35', '35-40', '40-45', '45-50', '50++'],
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


var optionscolumnchart = {
        series: [{
          name: 'Paket 1',
          data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
        }, {
          name: 'Paket 2',
          data: [50, 77, 45, 82, 20, 55, 68, 50, 58]
        }, {
          name: 'Paket 3',
          data: [44, 80, 90, 66, 78, 58, 63, 80, 58]
        },
         {
          name: 'Paket 4',
          data: [88, 85, 40, 60, 85, 58, 72, 58, 60]
        }
        ],
        
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
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    },
    yaxis: {
        title: {
            text: 'Jumlah Ambil Paket'
        }
    },
    fill: {
        colors:[zetaAdminConfig.primary, zetaAdminConfig.secondary,zetaAdminConfig.success, zetaAdminConfig.info],
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
    document.querySelector("#chart-paket"),
    optionscolumnchart
);
chartcolumnchart.render();


})(jQuery);