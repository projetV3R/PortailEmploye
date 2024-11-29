@extends('layouts.app')

@section('title', "Accueil")

@section('header')
@endsection
@section('contenu')

@auth
<div class="flex flex-col w-full h-full p-4 lg:p-16 gap-y-4 ">
    <div class="flex w-full flex-col lg:flex-row lg:h-3/4 h-full gap-4">
        <div class="flex lg:w-1/2 w-full h-full">
            <div class="flex w-full border-2 justify-center p-4 daltonien:border-black"  id="piechart">
            </div>
        </div>
        <div class="flex lg:w-1/2 w-full h-full">
            <div class="flex w-full border-2 justify-center p-4 daltonien:border-black" id="linechart">

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', initializePieChart);
function initializePieChart() {
    axios.get('/chart/pie')
        .then(response => {
            console.log(response.data);
            const data = response.data;

            let chartData = data.map(item => ({
                name: item.sous_categorie,
                y: item.fournisseur_count
            }));

            Highcharts.chart('piechart', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'HIGHCHARTS SOUS CATEGORIE RBQ PIE CHARTS'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y}</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '{point.name}: {point.percentage:.1f} %',
                            style: {
                                fontSize: '10px', 
                                fontWeight: '600' 
                            }
                        }
                    }
                },
                series: [
                    {
                        name: 'Fournisseurs',
                        colorByPoint: true,
                        data: chartData
                    }
                ]
            });
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des données pour le pie chart:', error);
        });
}

        document.addEventListener('DOMContentLoaded', initializeLineChart);
        function initializeLineChart() {
            axios.get('/line-chart-data')
                .then(response => {
                    const data = response.data;
                    const currentYear = new Date().getFullYear();
                    Highcharts.chart('linechart', {
                        title: {
                            text: `Inscriptions Mensuelles (${currentYear})`,
                            align: 'center'
                        },
                        xAxis: {
                            categories: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
                            title: {
                                text: 'Mois'
                            }
                        },
                        yAxis: {
                            title: {
                                text: 'Nombre d\'inscriptions'
                            }
                        },
                        legend: {
                            layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'middle'
                        },
                        series: [{
                            name: 'fiche_fournisseurs',
                            data: data
                        }],
                        responsive: {
                            rules: [{
                                condition: {
                                    maxWidth: 500
                                },
                                chartOptions: {
                                    legend: {
                                        layout: 'horizontal',
                                        align: 'center',
                                        verticalAlign: 'bottom'
                                    }
                                }
                            }]
                        }
                    });
                })
                .catch(error => {
                    console.error('Erreur lors de la récupération des données :', error);
                });
        }
        
    </script>


    <div class="flex w-full ">
        <div class="flex w-full h-36 border-2 border-dashed justify-center daltonien:border-black">
            DERNIERE INSCRIPTION ENREGISTRER OU TIMEPICKER POUR LES CHARTS OU FILTRE POUR LES LISTE ICI
        </div>
    </div>

    <div class="flex w-full">
        <div class="flex w-full justify-center border-2 border-dashed daltonien:border-black">LISTES FOURNISSEURS
        </div>
    </div>

</div>



@endauth

@endsection