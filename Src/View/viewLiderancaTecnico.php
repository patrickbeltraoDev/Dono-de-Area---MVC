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
                        </div>
                        <div class="dv-ctx-card-prod"><?= number_format($dadosMinhaRV['PRODUTIVIDADE'], 2)?></div>
                    </div>

                    <div class="dv-card-prod">
                        <span>Valor Produtividade</span>
                        
                        <div class="dv-ctx-tot-atv semVisaoTec">
                            <span><?= "(R$ {$dadosMinhaRV['VALOR_FINAL_OS_TOTAL']}/{$dadosMinhaRV['COLAB_CONSIDERADO_PROD']})"?></span>
                        </div>
                        <div class="dv-ctx-card-prod">R$ <?= number_format($dadosMinhaRV['VALOR_FINAL_OS'], 2, ',', '.')?></div>

                        <span>Valor Total das Retiradas</span>
                        
                        <div class="dv-ctx-tot-atv semVisaoTec">
                            <span><?= "(R$ {$dadosMinhaRV['VALOR_FINAL_RET_TOTAL']}/{$dadosMinhaRV['COLAB_CONSIDERADO_RET']})"?></span>
                        </div>
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
                            <span>BÔNUS/ÔNUS: R$ <?= $dadosMinhaRV['INFANCIA_BONUS']?></span>
                        </div>
                    </div>
                    <div class="dv-card-prod">
                        <span>Repetido</span>
                        <div class="dv-ctx-tot-atv">
                            <span>META: <?= number_format($dadosMinhaRV['REPETIDA_META_CONSIDERADA'] * 100, 2)?>%</span>
                        </div>
                        <div class="dv-ctx-card-prod" id="resRepetida"><?= number_format($dadosMinhaRV['REPETIDA_RESULTADO'] * 100, 2)?>%</div>
                        <div class="dv-ctx-tot-atv">
                            <span>BÔNUS/ÔNUS: R$ <?= $dadosMinhaRV['REPETIDA_BONUS']?></span>
                        </div>
                    </div>
                    <div class="dv-card-prod">
                        <span>Bônus/Ônus</span>
                        <div class="dv-ctx-card-prod">R$ <?= $dadosMinhaRV['BONUS']?></div>
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

                    <div class="dv-card-prod semVisaoTec">
                        <span>Validação HE</span>
                        <div id="resVlrFinalApHE">
                            <span>Aprovação: <?= number_format($dadosMinhaRV['APROVACAO_HE'] * 100, 0)?>%</span>
                            <!-- <div class='frmt-dv'>
                                
                            </div> -->
                        </div>
                        <div id="resVlrFinalOnusHE">
                            <span>Ônus: R$<?= number_format($dadosMinhaRV['PENALIDADE_HE_VALOR'], 2, ',', '.')?></span>
                            <!-- <div class='frmt-dv'>
                                
                            </div> -->
                        </div>
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
                <!-- <span id="mesAnterior"><  ?= "Historico RV - (O Mês de " . $treatMonth['mesAnterior'] . " esta em apuração)" ?></span> -->
                <span><?= $treatMonth['mesAnterior'] ?></span>
                <div class="dv-graf-hist">
                    <div class="conteudo-grafico" style="width: 100%; height: 90%">
                        <canvas id="myChart1"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- GUIA - RV EQUIPE -->
    <div class="dv-lyt" id="guiaRvEquipe">
        <span class="titleDescript">RV EQUIPE</span>
        <div class="dv-lyt-sect"> 

            <div class="dv-section1 lmt-dv-md" id='crdsInfoGest'>
                <span class="ctrl-sup" id="tagTitle1">Supervisores <div class="dv-tag-mes"></div></span>

                <div class="dv-sct-prod ctrl-sup" id="dvCardInfo1">
                    <div class="dv-card-prod dv-lmt-crd">
                        <span>Total Supervisores</span>
                        <div class="dv-ctx-card-prod" id="totLideres"><?= $dadosRvEquipe['LIDERES']?></div>
                    </div>
                    <div class="dv-card-prod dv-lmt-crd">
                        <span>Total RV</span>
                        <div class="dv-ctx-card-prod" id="resTotRvLideres"><?= number_format($dadosRvEquipe['RV_LIDERES'], 2, ',', '.') ?></div>
                    </div>

                </div>
                <div class="dv-sct-prod ctrl-sup" id="tbl_res_lideres">
                    <table id='tbl_res_lider' class='display table table-striped table-bordered table-sm' border='1' style='margin-top: 5px;'>
                        <thead>
                            <tr>
                                <th>NOME</th>
                                <th>CHAPA</th>
                                <th>TÉCNICOS</th>
                                <th>ATV.</th>
                                <th>RV</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tabelaRvLeader as $row): ?>
                                <tr>
                                    <td style="text-align: center"><?= $row['NM_FUNCIONARIO'] ?></td>
                                    <td style="text-align: center"><?= $row['NK_CHAPA'] ?></td>
                                    <td style="text-align: center"><?= $row['TECNICOS'] ?></td>
                                    <td style="text-align: center"><?= $row['TOTAL_CS'] ?></td>
                                    <td style="text-align: center">R$ <?= $row['RV'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>


                <span>Funcionários<div class="dv-tag-mes"></div></span>
                <div class="dv-sct-prod">
                    <div class="dv-card-prod dv-lmt-crd">
                        <span>Total Funcionários</span>
                        <div class="dv-ctx-card-prod" id="totTecnicos"><?= $dadosRvEquipe['TECNICOS'] ?></div>
                    </div>
                    <div class="dv-card-prod dv-lmt-crd">
                        <span>Total RV</span>
                        <div class="dv-ctx-card-prod" id="resTotRvTecnicos">R$ <?= number_format($dadosRvEquipe['RV_TECNICOS'], 2, ',', '.') ?></div>
                    </div>
                </div>
                
                <div class="dv-sct-prod" id="dvCardInfo2">
                    <div class="dv-crd-mult">
                        <div class="dv-brd-int">
                            <span>Nível A</span>
                            <div class="dv-crd-mult-vlr" id="totNivelA"><?= $dadosQd['QTD_NIVEL_A'] ?></div>
                            <div class="dv-rv-nvl" id="totRvNivelA">R$ <?= number_format($dadosQd['RV_NIVEL_A'], 2, ',', '.') ?></div>
                        </div>
                    </div>
                    <div class="dv-crd-mult">
                        <div class="dv-brd-int">
                            <span>Nível B</span>
                            <div class="dv-crd-mult-vlr" id="totNivelB"><?= $dadosQd['QTD_NIVEL_B'] ?></div>
                            <div class="dv-rv-nvl" id="totRvNivelB">R$ <?= number_format($dadosQd['RV_NIVEL_B'], 2, ',', '.') ?></div>
                        </div>
                    </div>
                    <div class="dv-crd-mult">
                        <div class="dv-brd-int">
                            <span>Nível C</span>
                            <div class="dv-crd-mult-vlr" id="totNivelC"><?= $dadosQd['QTD_NIVEL_C'] ?></div>
                            <div class="dv-rv-nvl" id="totRvNivelC">R$ <?= number_format($dadosQd['RV_NIVEL_C'], 2, ',', '.') ?></div>
                        </div>
                    </div>
                    <div class="dv-crd-mult">
                        <div class="dv-brd-int">
                            <span>Nível D</span>
                            <div class="dv-crd-mult-vlr" id="totNivelD"><?= $dadosQd['QTD_NIVEL_D'] ?></div>
                            <div class="dv-rv-nvl" id="totRvNivelD">R$ <?= number_format($dadosQd['RV_NIVEL_D'], 2, ',', '.') ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dv-section1" id='dv_section_table_other_area'>
                <span>Funcionários<div class="dv-tag-mes"></div></span>
                <div class="lmt-dv-fl" id="div_tbl_res_TEC">
                    <table id='tbl_res_TEC' class='display table table-striped table-bordered table-sm' border='1' style='margin-top: 5px;'>
                        <thead>
                            <tr>
                                <th>NOME</th>
                                <th>CHAPA</th>
                                <th>SITUACÃO</th>
                                <th>ATV.</th>
                                <th>PROD.</th>
                                <th>NÍVEL PROD.</th>
                                <th>INFÂNCIA</th>
                                <th>REPETIDA</th>
                                <th>BONUS</th>
                                <th>RV</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tabelaFunc as $func) : ?>
                                <tr>
                                    <td><?= $func['NM_FUNCIONARIO'] ?></td>
                                    <td><?= $func['NK_CHAPA'] ?></td>
                                    <td><?= $func['SITUACAO'] ?></td>
                                    <td><?= $func['TOTAL_CS'] ?></td>
                                    <td><?= $func['PRODUTIVIDADE'] ?></td>
                                    <td><?= $func['NIVEL_PRODUTIVIDADE'] ?></td>
                                    <td><?= number_format($func['INFANCIA_RESULTADO'] * 100, 2, ',', '.') ?>%</td>
                                    <td><?= number_format($func['REPETIDA_RESULTADO'] * 100, 2, ',', '.') ?>%</td>
                                    <td><?= number_format($func['BONUS'], 2, ',', '.') ?></td>
                                    <td><?= number_format($func['RV'], 2, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
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
