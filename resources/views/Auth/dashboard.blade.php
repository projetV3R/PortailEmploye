@extends('layouts.app')

@section('title', "Accueil")

@section('header')
@endsection
@section('contenu')

@auth
<div class="flex flex-col w-full h-full p-4 lg:p-16 gap-y-4 ">
    <div class="flex w-full flex-col lg:flex-row  h-fit gap-4">
        <div class="flex lg:w-1/2 w-full h-full">
            <div class="flex w-full border-2 justify-center p-4 rounded-sm shadow-md daltonien:border-black"  id="linechart">
            </div>
        </div>
        <div class="flex lg:w-1/2 w-full h-full ">
            <div class="flex w-full border-2 rounded-sm shadow-md justify-center p-4 daltonien:border-black" id="piechart">

            </div>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-y-4 pt-8 pb-4  ">
        <div class="flex flex-wrap lg:flex-col gap-y-2 px-2 ">
            <div class="p-2 w-1/2 lg:w-48 border rounded shadow text-center cursor-pointer region-select hover:bg-primary-200" data-region-value="">Toutes les regions</div>
            <div class="p-2 w-1/2 lg:w-48 border rounded shadow text-center cursor-pointer region-select hover:bg-primary-200" data-region-value="Bas-Saint-Laurent (01)">Bas-Saint-Laurent (01)</div>
            <div class="p-2 w-1/2 lg:w-48 border rounded shadow text-center cursor-pointer region-select hover:bg-primary-200" data-region-value="Saguenay-Lac-Saint-Jean (02)">Saguenay-Lac-Saint-Jean (02)</div>
            <div class="p-2 w-1/2 lg:w-48 border rounded shadow text-center cursor-pointer region-select hover:bg-primary-200" data-region-value="Capitale-Nationale (03)">Capitale-Nationale (03)</div>
            <div class="p-2 w-1/2 lg:w-48 border rounded shadow text-center cursor-pointer region-select hover:bg-primary-200" data-region-value="Mauricie (04)">Mauricie (04)</div>
            <div class="p-2 w-1/2 lg:w-48 border rounded shadow text-center cursor-pointer region-select hover:bg-primary-200" data-region-value="Estrie (05)">Estrie (05)</div>
            <div class="p-2 w-1/2 lg:w-48 border rounded shadow text-center cursor-pointer region-select hover:bg-primary-200" data-region-value="Montréal (06)">Montréal (06)</div>
            <div class="p-2 w-1/2 lg:w-48 border rounded shadow text-center cursor-pointer region-select hover:bg-primary-200" data-region-value="Outaouais (07)">Outaouais (07)</div>
            <div class="p-2 w-1/2 lg:w-48 border rounded shadow text-center cursor-pointer region-select hover:bg-primary-200" data-region-value="Abitibi-Témiscamingue (08)">Abitibi-Témiscamingue (08)</div>
            <div class="p-2 w-1/2 lg:w-48 border rounded shadow text-center cursor-pointer region-select hover:bg-primary-200" data-region-value="Côte-Nord (09)">Côte-Nord (09)</div>
            <div class="p-2 w-1/2 lg:w-48 border rounded shadow text-center cursor-pointer region-select hover:bg-primary-200" data-region-value="Nord-du-Québec (10)">Nord-du-Québec (10)</div>
            <div class="p-2 w-1/2 lg:w-48 border rounded shadow text-center cursor-pointer region-select hover:bg-primary-200" data-region-value="Gaspésie-Îles-de-la-Madeleine (11)">Gaspésie-Îles-de-la-Madeleine (11)</div>
            <div class="p-2 w-1/2 lg:w-48 border rounded shadow text-center cursor-pointer region-select hover:bg-primary-200" data-region-value="Chaudière-Appalaches (12)">Chaudière-Appalaches (12)</div>
            <div class="p-2 w-1/2 lg:w-48 border rounded shadow text-center cursor-pointer region-select hover:bg-primary-200" data-region-value="Laval (13)">Laval (13)</div>
            <div class="p-2 w-1/2 lg:w-48 border rounded shadow text-center cursor-pointer region-select hover:bg-primary-200" data-region-value="Lanaudière (14)">Lanaudière (14)</div>
            <div class="p-2 w-1/2 lg:w-48 border rounded shadow text-center cursor-pointer region-select hover:bg-primary-200" data-region-value="Laurentides (15)">Laurentides (15)</div>
            <div class="p-2 w-1/2 lg:w-48 border rounded shadow text-center cursor-pointer region-select hover:bg-primary-200" data-region-value="Montérégie (16)">Montérégie (16)</div>
            <div class="p-2 w-1/2 lg:w-48 border rounded shadow text-center cursor-pointer region-select hover:bg-primary-200" data-region-value="Centre-du-Québec (17)">Centre-du-Québec (17)</div>
        </div>
        <div class="flex w-full">
            <div id="barChart" class="w-full border rounded-sm shadow-md   p-4"></div>
        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        initializeLineChart();
        initializeBarChart()
        TopVille("");
        document.querySelectorAll('.region-select').forEach(element => {
        element.addEventListener('click', () => {
            const regionValue = element.dataset.regionValue; 

           
            document.querySelectorAll('.region-select').forEach(el => el.classList.remove('bg-blue-500', 'text-white'));
            element.classList.add('bg-blue-500', 'text-white');

        
            TopVille(regionValue);
        });
    });
    });

 

    function TopVille(regionValue) {
    axios.get(`/top-cities?region_value=${encodeURIComponent(regionValue)}`)
        .then(response => {
            const data = response.data;

            Highcharts.chart('barChart', {
                chart: {
                    type: 'bar',
                    backgroundColor: 'transparent'
                },
                title: {
                    text: regionValue === ''
                        ? 'Top 10 Villes (Toutes Régions)'
                        : `Top 10 Villes pour ${regionValue}`
                },
                xAxis: {
                    categories: data.map(item => item.ville),
                    title: {
                        text: 'Villes'
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Nombre de Fiches Fournisseurs'
                    }
                },
                series: [{
                    name: 'Fiches Fournisseurs',
                    data: data.map(item => item.fournisseur_count)
                }],
                credits: {
                    enabled: false
                }
            });
        })
        .catch(error => console.error('Erreur lors de la mise à jour du graphique:', error));
}


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
            const counts = data.data;

        
            const startOfWeek = moment().startOf('isoWeek'); 
            const labels = [];
            for (let i = 0; i < 7; i++) {
                labels.push(startOfWeek.clone().add(i, 'days').format('dddd')); 
            }

         
            const currentWeek = `${startOfWeek.format('D MMM')} - ${startOfWeek.clone().add(6, 'days').format('D MMM')}`;

            Highcharts.chart('linechart', {
                chart: {
                    type: 'line',
                    backgroundColor: 'transparent',
                    style: {
                        fontFamily: 'Arial, sans-serif'
                    }
                },
                title: {
                    text: `Inscriptions du (${currentWeek})`,
                    align: 'center',
                    style: {
                        color: '#333',
                        fontSize: '18px',
                        fontWeight: 'bold'
                    }
                },
                xAxis: {
                    categories: labels,
                    title: {
                        text: 'Jour'
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
                        text: 'Nombre d\'inscriptions',
                        align: 'middle'
                    },
                    labels: {
                        style: {
                            fontSize: '12px'
                        }
                    }
                },
                tooltip: {
                    pointFormat: '<b>{point.y}</b> Inscriptions'
                },
                plotOptions: {
                    line: {
                        dataLabels: {
                            enabled: true,
                            style: {
                                fontSize: '12px',
                                fontWeight: 'bold',
                                color: '#000'
                            }
                        },
                        enableMouseTracking: true
                    }
                },
                series: [{
                    name: 'Inscriptions',
                    data: counts
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
        .catch(error => console.error('Erreur lors de la récupération des données :', error));
}

</script>

@endauth

@endsection
