<link rel="stylesheet" href="/pci/d_area/Public/css/style.css">

<div class="dv-ctn">
    <span class="titleDescript">Minha RV</span>
    <a href="/pci/d_area/dono_de_area.php?page=rv&mes=anterior" target="_blank" class="linkMes" id="linkMesAnt">Visualizar Mês Anterior</a>

    <span class="dataHora">Última Atualização da Base: <?= $dadosMinhaRV['DataHora']?></span>

    <div class="dv-lyt"> 

        <?= include_once __DIR__ . "/template.php"?>
      
        <div class="dv-lyt-sect"> 

            <div class="dv-section1">
                <span>Produtividade <div class="dv-tag-mes"><?= $treatMonth['mesAtual'] ?></div></span>
                <div class="dv-sct-prod">

                    <div class="dv-card-prod">
                        <span>Total de Atividades</span>
                        <div class="dv-ctx-card-prod"><?= $dadosMinhaRV['TOTAL_CS']?></div>
                        <div class="dv-ctx-tot-atv">
                            <span>INST + MIG + MUD: <?= $dadosMinhaRV['INST_CS'] + $dadosMinhaRV['MUD_CS']?></span>
                            <span>RET + EQUIP. RECOLHIDO: <?= $dadosMinhaRV['RET_CS']?></span>
                            <span>REPARO: <?= $dadosMinhaRV['REP_CS']?></span>
                            <span>OUTRAS: <?= $dadosMinhaRV['SRV_CS']?></span>
                        </div>
                    </div>

                    <div class="dv-card-prod">
                        <span>Resultado Produtividade</span>
                        <div class="dv-ctx-tot-atv visaoTec">
                            <span>Meta Produtividade: <?= $dadosMinhaRV['META_PRODUTIVIDADE']?></span>
                            <span>(Total Atv. / Dias Trab.)</span>
                        </div>
                        <div class="dv-ctx-card-prod"><?= number_format($dadosMinhaRV['PRODUTIVIDADE'], 2)?></div>
                        <div class="dv-ctx-tot-atv visaoTec">
                            <span>DIAS ATV. ENCERRADA: <?= $dadosMinhaRV['DIAS_ATIV_ENCERRADAS']?></span>
                            <span>NIVEL PRODUTIVIDADE: <?= $dadosMinhaRV['NIVEL_PRODUTIVIDADE']?></span>
                            <span>VALOR NIVEL: R$ <?= number_format($dadosMinhaRV['VALOR_OS'], 2, ',', '.')?></span>
                        </div>

                    </div>

                    <div class="dv-card-prod">
                        <span>Valor Produtividade</span>
                        <div class="dv-ctx-card-prod">R$ <?= number_format($dadosMinhaRV['VALOR_FINAL_OS'], 2, ',', '.')?></div>
                        <span>Valor Total das Retiradas</span>
                        <div class="dv-ctx-card-prod">R$ <?= number_format($dadosMinhaRV['VALOR_FINAL_RET'], 2, ',', '.');?></div>
                    </div>

                </div>
            </div>
            <div class="dv-section1">
                <span>Indicadores <div class="dv-tag-mes"><?= $treatMonth['mesAtual'] ?></div></span>
                <div class="dv-sct-prod lm-height-dv">
                    <div class="dv-card-prod">
                        <span>Infância 30 dias</span>
                        <div class="dv-ctx-tot-atv">
                            <span>META: <?= number_format($dadosMinhaRV['INFANCIA_META_CONSIDERADA'] * 100, 2)?>%</span>
                        </div>
                        <div class="dv-ctx-card-prod" id="resInfancia"><?= number_format($dadosMinhaRV['INFANCIA_RESULTADO'] * 100, 2)?>%</div>
            
                        <div class="dv-ctx-tot-atv">
                            <div class="visaoTec">
                                <span id="numInf">(Num): <?= $dadosMinhaRV['INFANCIA_NUMERADOR']?></span>
                                <span id="denInf">(Den): <?= $dadosMinhaRV['INFANCIA_DENOMINADOR']?></span>
                            </div>
                            <span class="visaoTec" id="deflatorInf">(Deflator): <?= $dadosMinhaRV['INFANCIA_DEFLATOR']?></span>
                            <span id="bonusOnusInf">BÔNUS/ÔNUS: R$ <?= number_format($dadosMinhaRV['INFANCIA_BONUS'], 2, ',', '.')?></span>
                        </div>
                    </div>
                    <div class="dv-card-prod">
                        <span>Repetido</span>
                        <div class="dv-ctx-tot-atv">
                            <span>META: <?= number_format($dadosMinhaRV['REPETIDA_META_CONSIDERADA'] * 100, 2)?>%</span>
                        </div>
                        <div class="dv-ctx-card-prod" id="resRepetida"><?= number_format($dadosMinhaRV['REPETIDA_RESULTADO'] * 100, 2)?>%</div>
                        <div class="dv-ctx-tot-atv">
                            <div class="visaoTec">
                                <span id="numRep">(Num): <?= $dadosMinhaRV['REPETIDA_NUMERADOR']?></span>
                                <span id="denRep">(Den): <?= $dadosMinhaRV['REPETIDA_DENOMINADOR']?></span>
                            </div>
                            <span class="visaoTec" id="deflatorRep">(Deflator): <?= $dadosMinhaRV['REPETIDA_DEFLATOR']?></span>
                            <span id="bonusOnusRep">BÔNUS/ÔNUS: R$ <?= number_format($dadosMinhaRV['REPETIDA_BONUS'], 2, ',', '.')?></span>
                        </div>
                    </div>
                     <div class="dv-card-prod">
                        <span>Bônus/Ônus</span>
                        <div class="dv-ctx-card-prod" id="resBonusOnus">R$ <?= number_format($dadosMinhaRV['BONUS'], 2, ',', '.')?></div>
                        <span class="visaoTec">Padrinho</span>
                        <div class="dv-ctx-card-prod visaoTec" id="padrinho"><?= $dadosMinhaRV['PADRINHO']?></div>
                    </div>

                </div>
            </div>

        </div>

        <div class="dv-lyt-sect">

            <div class="dv-section1">
                <span>Valor Final da RV <div class="dv-tag-mes"><?= $treatMonth['mesAtual'] ?></div></span>

                <div class="dv-sct-prod lm-height-dv">
                    <div class="dv-card-prod ">
                        <span>Produtividade</span>
                        <div class="dv-ctx-card-prod" id="resVlrFinalProd">R$ <?= number_format($dadosMinhaRV['VALOR_FINAL_OS'], 2, ',', '.')?></div>
                    </div>

                    <div class="dv-card-prod">
                        <span>Retirada</span>
                        <div class="dv-ctx-card-prod" id="resVlrFinalRet">R$ <?= number_format($dadosMinhaRV['VALOR_FINAL_RET'], 2, ',', '.')?></div>
                    </div>

                    <div class="dv-card-prod">
                        <span>Bônus/Ônus</span>
                        <div class="dv-ctx-card-prod" id="resVlrFinalBonus">R$ <?= number_format($dadosMinhaRV['BONUS'], 2, ',', '.')?></div>
                    </div>

                    <div class="dv-card-prod">
                        <span>Valor Final</span>
                        <div class="dv-ctx-card-prod" id="valorFinalRV">R$ <?= number_format($dadosMinhaRV['RV'], 2, ',', '.')?></div>
                    </div>
                </div>
            </div>

            <div class="dv-section1">
                <!-- <span id="mesAnterior">< ?= "Historico RV - (O Mês de " . $treatMonth['mesAnterior'] . " esta em apuração)" ?></span> -->
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

