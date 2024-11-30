@extends('layouts.app')

@section('title', "Accueil")

@section('header')
@endsection
@section('contenu')

@auth
<div class="flex flex-col w-full h-full p-4 lg:p-16 gap-y-4 ">
    <div class="flex w-full flex-col lg:flex-row lg:h-3/4 h-full gap-4">
        <div class="flex lg:w-1/2 w-full h-full">
            <div class="flex w-full border-2 justify-center p-4 rounded-sm shadow-md  daltonien:border-black"  id="linechart">
            </div>
        </div>
        <div class="flex lg:w-1/2 w-full h-full ">
            <div class="flex w-full border-2 rounded-sm shadow-md justify-center p-4 daltonien:border-black" id="piechart">

            </div>
        </div>
    </div>


    <div class="flex w-full">
        <div class="flex w-full justify-center border-2 border-dashed daltonien:border-black">LISTES FOURNISSEURS
        </div>
    </div>

</div>

<script>
      document.addEventListener('DOMContentLoaded', () => {
        initializeLineChart();
        initializeBarChart();
    });

function initializeBarChart() {
    axios.get('/chart/pie')
        .then(response => {
            const data = response.data;

            let categories = data.map(item => item.sous_categorie);
            let counts = data.map(item => item.fournisseur_count);

            Highcharts.chart('piechart', {
                chart: {
                    type: 'column',
                    backgroundColor: 'transparent', 
                    style: {
                        fontFamily: 'Arial, sans-serif' 
                    }
                },
                title: {
                    text: 'Top Sous-Catégories de Licences RBQ',
                    style: {
                        color: '#333',
                        fontSize: '18px',
                        fontWeight: 'bold'
                    }
                },
                xAxis: {
                    categories: categories,
                    title: {
                        text: 'Sous-Catégories'
                    },
                    labels: {
                        style: {
                            fontSize: '12px'
                        }
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Nombre de Fournisseurs',
                        align: 'middle'
                    },
                    labels: {
                        style: {
                            fontSize: '12px'
                        }
                    }
                },
                tooltip: {
                    pointFormat: '<b>{point.y}</b> Fournisseurs'
                },
                
                plotOptions: {
                    column: {
                        colorByPoint: true,
                        dataLabels: {
                            enabled: true,
                            style: {
                                fontSize: '12px',
                                fontWeight: 'bold',
                                color: '#000'
                            }
                        }
                    }
                },
                series: [{
                    name: 'Fournisseurs',
                    data: counts,
                    showInLegend: false 
                }],
                credits: {
                    enabled: false 
                }
            });
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des données pour le bar chart:', error);
        });
}

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
                    credits: {
                    enabled: false 
                },
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

@endauth

@endsection