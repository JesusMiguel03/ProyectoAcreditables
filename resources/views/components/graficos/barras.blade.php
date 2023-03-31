@php
    $trayecto = atributo($attributes, 'trayecto');
@endphp

<article id="seccion" class="col-12">
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title text-uppercase">Trayecto {{ $trayecto }}</h3>
        </div>

        <div class="card-body" style="display: block;">
            <div class="chart">
                <div class="chartjs-size-monitor">
                    <div class="chartjs-size-monitor-expand">
                        <div class=""></div>
                    </div>
                    <div class="chartjs-size-monitor-shrink">
                        <div class=""></div>
                    </div>
                </div>
                <canvas id="graficoTrayecto{{ $trayecto }}" data-tipo="bar"
                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 443px;"
                    width="443" height="250" class="chartjs-render-monitor"></canvas>
            </div>
        </div>
    </div>
</article>
