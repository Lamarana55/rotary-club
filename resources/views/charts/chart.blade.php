<div class="row">
    @if (hasPermission('afficher_stats_type_media') )
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header statistique">
                    <h4 class="card-title">Statistique par type media créé</h4>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <div class="px-10" id="chartByTypeMedia"></div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (hasPermission('afficher_stats_type_promoteur') )
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header statistique">
                    <h3 class="card-title">Statistique par type des promoteurs</h3>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <div class="px-10" id="chartByTypePromoteur"></div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if (hasPermission('afficher_stats_paiement_cahier') )
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header statistique">
                    <h4 class="card-title">Statistique Paiement cahier des charges</h4>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <div class="px-18 chartjs-render-monitor" id="chartPaiementCahier"></div>

                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (hasPermission('afficher_stats_frais_agrement') )
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header statistique">
                    <h4 class="card-title">Statistique Paiement frais d'agrement</h4>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <div class="px-18" id="chartPaiementFraisAgrement"></div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (hasPermission('afficher_stats_commission') )
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header statistique">
                    <h4 class="card-title">Niveau d’avancement des demandes (Commission Technique MIC)</h4>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <div class="px-10" id="chartEtudeCommission"></div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (hasPermission('afficher_stats_hac') )
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header statistique">
                    <h4 class="card-title">Niveau d’avancement des demandes (HAC)</h4>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <div class="px-10" id="chartEtudeHac"></div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (hasPermission('afficher_stats_sgg') )
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header statistique">
                    <h4 class="card-title">Niveau d’avancement des demandes (SGG)</h4>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (hasPermission('afficher_stats_arpt') )
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header statistique">
                    <h4 class="card-title">Niveau d’avancement des demandes (ARPT)</h4>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="donutChartArpt" class="chartjs-render-monitor" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
<script src="{{asset('js/app.js')}} "></script>

@push('js')
<script>
    var options = {
        chart: {
            type: 'bar',
            height: '250px',
            animations: {
                enabled: false,
            }
        },
        series: [{
            name: 'Nombre de Media',
            data: @json($nombreTypeMedia)
        }],
        colors:['#e03387', '#E91E63', '#9C27B0','#40E0D0','#FF7F50'],
        xaxis: {
            categories: @json($type_media)
        }
    }
    var chart = new ApexCharts(document.querySelector("#chartByTypeMedia"), options);
    chart.render();
    document.addEventListener('livewire:load', () => {
        @this.on('refreshChart', (chartData) => {
            chart.updateSeries([{
                data: chartData.seriesData
            }])
        })
    })
</script>
<script>
    var options = {
        chart: {
            type: 'bar',
            height: '250px',
            animations: {
                enabled: false,
            }
        },
        series: [{
            name: 'Type promoteur',
            data: @json($nombreTypePromoteur)
        }],
        fill: {
            colors:['#c92ab4', '#E91E63', '#9C27B0','#40E0D0','#FF7F50'],
        },

        colors:['#c92ab4', '#E91E63', '#9C27B0','#40E0D0','#FF7F50'],
        xaxis: {
            categories: @json($type_promoteur)
        }
    }
    var chart = new ApexCharts(document.querySelector("#chartByTypePromoteur"), options);
    chart.render();
    document.addEventListener('livewire:load', () => {
        @this.on('refreshChart', (chartData) => {
            chart.updateSeries([{
                data: chartData.seriesData
            }])
        })
    })
</script>
<script>
    var options = {
          series: @json($nombrePaiementCahierCharge),
          chart: {
            width: 400,
            type: 'pie',
        },
        labels: @json($cahierCharges),
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 200
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
    };
    var chart = new ApexCharts(document.querySelector("#chartPaiementCahier"), options);
    chart.render();
    document.addEventListener('livewire:load', () => {
        @this.on('refreshChart', (chartData) => {
            chart.updateSeries([{
                data: chartData.seriesData
            }])
        })
    })
</script>
<script>
    var options = {
          series: @json($nombrePaiementFraisAgrement),
          chart: {
            width: 400,
            type: 'pie',
        },
        labels: @json($FraisAgrement),
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 200
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
    };
    var chart = new ApexCharts(document.querySelector("#chartPaiementFraisAgrement"), options);
    chart.render();
    document.addEventListener('livewire:load', () => {
        @this.on('refreshChart', (chartData) => {
            chart.updateSeries([{
                data: chartData.seriesData
            }])
        })
    })
</script>
<script>
    var options = {
        chart: {
            type: 'bar',
            height: '250px',
            animations: {
                enabled: false,
            }
        },
        series: [{
            name: 'Nombre de Media',
            data: @json($nombreEtudeCommission)
        }],
        colors:['#e03387', '#E91E63', '#9C27B0','#40E0D0','#FF7F50'],
        xaxis: {
            categories: @json($etudeCommission)
        }
    }
    var chart = new ApexCharts(document.querySelector("#chartEtudeCommission"), options);
    chart.render();
    document.addEventListener('livewire:load', () => {
        @this.on('refreshChart', (chartData) => {
            chart.updateSeries([{
                data: chartData.seriesData
            }])
        })
    })
</script>

<script>
    var options = {
        chart: {
            type: 'bar',
            height: '250px',
            animations: {
                enabled: false,
            }
        },
        series: [{
            name: 'Nombre de Media',
            data: @json($nombreEtudeHac)
        }],
        colors:['#e03387', '#E91E63', '#9C27B0','#40E0D0','#FF7F50'],
        xaxis: {
            categories: @json($etudeCommission)
        }
    }
    var chart = new ApexCharts(document.querySelector("#chartEtudeHac"), options);
    chart.render();
    document.addEventListener('livewire:load', () => {
        @this.on('refreshChart', (chartData) => {
            chart.updateSeries([{
                data: chartData.seriesData
            }])
        })
    })
</script>
@endpush
<script>
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData= {
      labels: [
        @foreach($sggTitleList as $prod)
          '{{$prod}}',
        @endforeach
      ],
      datasets: [
        {
          data: [
            @foreach ($sggData as $value )
              '{{$value}} ',
            @endforeach
          ],
          backgroundColor : ['#3c8dbc', '#00a65a', '#f39c12'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    var donutChart = new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    })
</script>

<script>
    var donutChartCanvasArpt = $('#donutChartArpt').get(0).getContext('2d')
    var donutDataArpt= {
      labels: [
        @foreach($sggTitleList as $prod)
          '{{$prod}}',
        @endforeach
      ],
      datasets: [
        {
          data: [
            @foreach ($arptData as $value )
              '{{$value}} ',
            @endforeach
          ],
          backgroundColor : ['#3c8dbc', '#00a65a', '#f39c12'],
        }
      ]
    }
    var donutOptionsArpt     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    var donutChart = new Chart(donutChartCanvasArpt, {
      type: 'pie',
      data: donutDataArpt,
      options: donutOptionsArpt
    })
</script>
