@extends('layouts.app')

@section('title', "Accueil")

@section('header')
@endsection
@section('contenu')

@auth
<div class="flex flex-col w-full h-full p-4 lg:p-16 gap-y-4 ">
    <div class="flex w-full flex-col lg:flex-row lg:h-3/4 h-full gap-4">
        <div class="flex lg:w-1/2 w-full h-full">
            <div class="flex w-full justify-center border-2 border-dashed daltonien:border-black">HIGHCHARTS INSCRIPTION </div>
        </div>
        <div class="flex lg:w-1/2 w-full h-full">
            <div class="flex w-full border-2 border-dashed justify-center daltonien:border-black" id="container">

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            axios.get('/line-chart-data')
                .then(response => {
                    const data = response.data;

                    Highcharts.chart('container', {
                        title: {
                            text: 'Inscriptions Mensuelles',
                            align: 'center'
                        },
                        subtitle: {
                            text: 'Nombre d\'inscriptions par mois pour l\'année en cours',
                            align: 'left'
                        },
                        yAxis: {
                            title: {
                                text: 'Nombre d\'inscriptions'
                            }
                        },
                        xAxis: {
                            categories: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
                            title: {
                                text: 'Mois'
                            }
                        },
                        legend: {
                            layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'middle'
                        },
                        series: [{
                            name: 'Inscriptions',
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
        });
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