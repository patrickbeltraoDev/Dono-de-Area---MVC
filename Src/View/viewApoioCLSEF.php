<link rel="stylesheet" href="/pci/d_area/Public/css/style.css">

<div class="dv-ctn">
    <span class="titleDescript">Minha RV</span>
    <a href="/pci/d_area/dono_de_area.php?page=rv&mes=anterior" target="_blank" class="linkMes" id="linkMesAnt">Visualizar Mês Anterior</a>

    <span class="dataHora">Última Atualização da Base: <?= $dadosMinhaRV['DataHora']?></span>

    <div class="dv-lyt"> 

        <?= include_once __DIR__ . "/template.php"?>
      
        <div class="dv-lyt-sect"> 

            <div class="dv-section1">
                <span>Valor Final da RV <div class="dv-tag-mes"><?= $treatMonth['mesAtual'] ?></div></span>

                <div class="dv-sct-prod lm-height-dv">
                    <div class="dv-card-prod ">
                        <span id="tagProdutividade">Média dos Indicadores</span>
                        <div class="dv-ctx-tot-atv">
                            <span>Eficácia: R$ <?= number_format($dadosMinhaRV['VALOR_ATINGIDO_EFICACIA'], 2)?></span>
                            <span>Produtividade: R$ <?= number_format($dadosMinhaRV['VALOR_ATINGIDO_PRODUTIVIDADE'], 2)?></span>
                        </div>
                        <div class="dv-ctx-card-prod" id="resVlrFinalProdOutras">R$<?= number_format($dadosMinhaRV['VALOR_FINAL_OS_RET'], 2, ',', '.') ?></div>
                    </div>

                    <div class="dv-card-prod" id="dvAssuidade">
                        <span id="tagAssiduidade">Assiduidade</span>
                        <div class="dv-ctx-card-prod" id="resVlrFinalAssidOutras"><?= $dadosMinhaRV['ASSIDUIDADE'] * 100 ?>%</div>
                    </div>

                    <div class="dv-card-prod">
                        <span id="tagBonus">Valor Assiduidade</span>
                        <div class="dv-ctx-card-prod" id="resVlrFinalBonusOutras">R$ <?= number_format($dadosMinhaRV['BONUS'], 2, ',', '.') ?></div>
                    </div>

                    <div class="dv-card-prod">
                        <span>Valor Final</span>
                        <div class="dv-ctx-card-prod" id="valorFinalRVOutras">R$ <?= number_format($dadosMinhaRV['RV'], 2, ',', '.') ?></div>
                    </div>
                </div>
            </div>

            <div class="dv-section1">
                <!-- <span>< ?= "Historico RV - (O Mês de " . $treatMonth['mesAnterior'] . " esta em apuração)" ?></span> -->
                <span><?= $treatMonth['mesAnterior'] ?></span>
                <div class="dv-graf-hist">
                    <div class="conteudo-grafico" style="width: 100%; height: 90%">
                        <canvas id="myChart1"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    const dados = <?= json_encode($dadosGraficoRV) ?>;
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script src="/pci/d_area/Public/js/renderGraph.js"></script>