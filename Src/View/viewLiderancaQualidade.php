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
                            <span id="indInf">Infância: R$ <?= number_format($dadosMinhaRV['VALOR_ATINGIDO_INFANCIA'], 2)?></span>
                            <span id="indRep">Repetido: R$ <?= number_format($dadosMinhaRV['VALOR_ATINGIDO_REPETIDA'], 2)?></span>
                            <span id="indPro">Produtividade: R$ <?= number_format($dadosMinhaRV['VALOR_ATINGIDO_PRODUTIVIDADE'], 2)?></span>
                        </div>
                        <div class="dv-ctx-card-prod" id="resVlrFinalProdOutras">R$<?= number_format($dadosMinhaRV['VALOR_FINAL_OS_RET'], 2, ',', '.') ?></div>
                    </div>

                    <div class="dv-card-prod">
                        <span>Aprovação HE</span>
                        <div class="dv-ctx-card-prod"><?= $dadosMinhaRV['APROVAÇÃO_HE'] * 100 ?>%</div>
                    </div>

                    <div class="dv-card-prod">
                        <span>Penalidade Aprov. HE</span>
                        <div class="dv-ctx-card-prod">R$ <?= number_format($dadosMinhaRV['PENALIDADE_HE_VALOR'], 2, ',', '.') ?></div>
                    </div>

                    <div class="dv-card-prod">
                        <span>Valor Final</span>
                        <div class="dv-ctx-card-prod">R$ <?= number_format($dadosMinhaRV['RV'], 2, ',', '.') ?></div>
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

    <!-- GUIA - RV EQUIPE -->
    <div class="dv-lyt" id="guiaRvEquipe">
        <span class="titleDescript">RV EQUIPE</span>
        <div class="dv-lyt-sect"> 

            <div class="dv-section1 lmt-dv-md" id='crdsInfoGest'>
                
                <span>Funcionários<div class="dv-tag-mes"><?= $treatMonth['mesAtual'] ?></div></span>
                <div class="dv-sct-prod">
                    <div class="dv-card-prod dv-lmt-crd">
                        <span>Total Funcionários</span>
                        <div class="dv-ctx-card-prod"><?= $dadosQtdEquipe['TOTAL_FUNCIONARIOS'] ?></div>
                    </div>
                    <div class="dv-card-prod dv-lmt-crd">
                        <span>Total RV</span>
                        <div class="dv-ctx-card-prod">R$ <?= number_format($dadosQtdEquipe['TOTAL_RV'], 2, ',', '.') ?></div>
                    </div>
                </div>
                
            </div>

            <div class="dv-section1" id='dv_section_table_other_area'>
                <span>Funcionários<div class="dv-tag-mes"><?= $treatMonth['mesAtual'] ?></div></span>
                <div class="lmt-dv-fl" id="div_tbl_res_TEC">
                    <table id='tbl_res_TEC' class='display table table-striped table-bordered table-sm' border='1' style='margin-top: 5px;'>
                        <thead>
                            <tr>
                                <th>UF</th>
                                <th>NOME</th>
                                <th>SITUAÇÃO</th>
                                <th>CARGO</th>
                                <th>ÁREA</th>
                                <th>MÉDIA IND.</th>
                                <th>ASSIDUIDADE</th>
                                <th>VALOR ASSID.</th>
                                <th>RV</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tabelaFuncLeader as $func) : ?>
                                <?php $assiduidade = $func['ASSIDUIDADE'] != '' ? $func['ASSIDUIDADE'] . "%" : ''; ?>  
                                <tr>
                                    <td style='text-align: center'><?= $func['UF'] ?></td>
                                    <td style='text-align: center'><?= $func['NM_FUNCIONARIO'] ?></td>
                                    <td style='text-align: center'><?= $func['SITUACAO'] ?></td>
                                    <td style='text-align: center'><?= $func['CARGO'] ?></td>
                                    <td style='text-align: center'><?= $func['AREA'] ?></td>
                                    <td style='text-align: center'>R$ <?= number_format($func['VALOR_FINAL_OS_RET'], 2, ',', '.') ?></td>
                                    <td style='text-align: center'><?= $assiduidade ?></td>
                                    <td style='text-align: center'>R$ <?= number_format($func['BONUS'], 2, ',', '.') ?></td>
                                    <td style='text-align: center'>R$ <?= number_format($func['RV'], 2, ',', '.') ?></td>
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