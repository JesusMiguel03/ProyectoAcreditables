<article id="seccion-Estudiantes" class="col-12">
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title text-uppercase">Estudiantes</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
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

                <section class="row">
                    <article class="col-6">
                        <canvas id="graficoPNF" data-tipo="bar"
                            style="min-height: 500px; height: 500px; max-height: 500px; max-width: 100%; display: block; width: 443px;"
                            width="443" height="500" class="chartjs-render-monitor"></canvas>
                    </article>
                    <article class="col-6">
                        <canvas id="graficoTrayecto" data-tipo="bar"
                            style="min-height: 500px; height: 500px; max-height: 500px; max-width: 100%; display: block; width: 443px;"
                            width="443" height="500" class="chartjs-render-monitor"></canvas>
                    </article>
                </section>
            </div>
        </div>
    </div>
</article>
