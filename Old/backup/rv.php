<?php
// DESENVOLVIDO POR: PATRICK BELTRÃO
// DATA DE INICIO: 02/06/2025

include_once('../topo.php');
include_once('../conexao/config.php');

// DADOS DA SEÇÃO
$nome_usuario = $_SESSION['usr_nome'];
$chapa_usuario = $_SESSION['chapa_tlm'];
$matricula_usuario = $_SESSION['usr_matricula'];
$funcao_usuario = $_SESSION['usr_funcao'];
?>

<style>
    /* ------- CONTAINER ------ */
    table>tbody>tr>td img {
        display: none;
    }

    body {
        margin: 0;
        padding: 0;
    }

    .dv-ctn {
        width: 100vw;
        background-color: #E5E5E5;
    }

    .dv-lyt {
        width: 100%;
        height: 100%;
        display: none;
        flex-direction: column;
        padding: 10px;
    }

    /* ------- DIV GUIAS ------ */
    #guiaOutrasRV {
        justify-content: center;
    }

    .dv-sub-menu {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 15px;
    }

    .dv-sub {
        padding: 3px 20px;
        background-color: #CCCCCC;
        border-radius: 5px 5px 0 0;
        font-size: 1.3em;
        font-weight: 500;
        letter-spacing: 1.1px;
        cursor: pointer;
    }

    .dv-sub:hover {
        background-color: #ef7c34;
    }

    /* ---- SECTION - DADOS PESSOAIS ---- */
    .dv-dados-pessoais {
        width: 100%;
        padding: 5px;
        display: flex;
        align-items: center;
        background-color: #FFF;
    }

    .dv-tags-dados {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 3px;
    }

    .dv-tags-dados:hover {
        background-color: #E5E5E5;
    }

    .dv-tags-dados>img {
        width: 20px;
        height: 20px;
    }

    .dv-tags-dados>span {
        font-size: 1.2em;
        font-weight: 600;
        letter-spacing: 1.1px;
        color: #333;
    }

    @media (max-width: 8in) {
        .dv-dados-pessoais {
            flex-direction: column;
            justify-content: left;
            align-items: flex-start;
        }

        .dv-tags-dados>span {
            width: 100%;
            font-size: .85em;
        }
    }

    /* ---- SECTION ---- */
    .dv-lyt-sect {
        width: 100%;
        display: flex;
        justify-content: center;
        gap: 5px;
        padding: 5px;
    }

    .dv-section1 {
        width: 50%;
        padding: 10px;
        border: 1px solid #A8E3D7;
        border-radius: 5px;
        display: flex;
        flex-direction: column;
        background-color: #FFF;
        overflow: hidden;
    }

    @media (min-width: 9in) and (max-width: 15in) {
        .lmt-dv-md {
            height: 50vh;
            overflow-y: hidden;
        }
    }

    /* @media (min-width: 16in) {
            .lmt-dv-md {
                height: 33vh;
                overflow-y: hidden; 
            }
        } */

    .dv-lmt-crd {
        height: 70px;
    }

    .titleDescript {
        width: 100%;
        font-size: 1.5em;
        font-weight: 600;
        letter-spacing: 1.1px;
        color: #333;
        /* margin-bottom: 5px; */
        background-color: #bfbfbf;
        padding: 10px;
        padding-bottom: 0px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .dataHora {
        width: 100%;
        /* font-size: 1.5em; */
        /* font-weight: 600; */
        letter-spacing: 1.1px;
        color: #333;
        margin-bottom: 5px;
        background-color: #bfbfbf;
        /* padding: 5px; */
        padding-right: 15px;
        display: flex;
        align-items: center;
        justify-content: right;
        gap: 10px;
    }

    .dv-section1>span {
        width: 100%;
        font-size: 1.5em;
        font-weight: 600;
        letter-spacing: 1.1px;
        color: #444;
        margin-bottom: 5px;
        background-color: #A8E3D7;
        padding-left: 3px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .dv-tag-mes {
        font-size: .8em;
        font-weight: 500;
        letter-spacing: 1.1px;
        color: #73879C;
    }

    .dv-sct-prod {
        width: 100%;
        /* height: 100%; */
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 5px;
        overflow: auto;
    }

    .lm-height-dv {
        height: 100%;
    }

    @media (max-width: 8in) {
        .dv-lyt-sect {
            flex-direction: column;
        }

        .dv-section1 {
            width: 100%;
        }

        .dv-sct-prod {
            flex-direction: column;
        }
    }

    .dv-card-prod {
        width: 100%;
        height: 100%;
        padding: 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border-radius: 5px;
        box-shadow: 1px 1px 3px #444;
    }
    #resVlrFinalApHE, #resVlrFinalOnusHE {
        display: flex;
        justify-content: center;
        width: 100%;
        height: 100%;
    }

    .dv-card-prod:hover {
        box-shadow: 1px 1px 2px #333;
    }

    .dv-card-prod span {
        width: 100%;
        height: 100%;
        font-size: 1.2em;
        font-weight: 500;
        letter-spacing: 1.1px;
        color: #444;
        text-align: center;
    }

    .dv-ctx-card-prod {
        width: 100%;
        height: 100%;
        font-size: 1.5em;
        font-weight: 600;
        color: #1ABB9C;
        text-align: center;
        margin-bottom: 5px;
    }
    .frmt-dv {
        font-size: 1.5em;
        font-weight: 600;
        color: #1ABB9C;
        text-align: center;
    }

    .dv-crd-mult {
        width: 100%;
        padding: 1px;
        border-radius: 5px;
        margin-top: 5px;
        box-shadow: 1px 1px 3px #444;
    }

    .dv-brd-int {
        border-radius: 5px;
        border: 1px solid #A8E3D7;
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 5px;
    }

    .dv-brd-int>span {
        width: 100%;
        padding: 2px;
        background-color: #A8E3D7;
        text-align: center;
        color: #333;
        font-weight: 600;
    }

    .dv-crd-mult-vlr {
        width: 100%;
        font-size: 1.5em;
        font-weight: 600;
        color: #1ABB9C;
        padding: 15px;
        text-align: center;
        border-bottom: 1px solid #ccc;
    }

    .dv-rv-nvl {
        width: 100%;
        text-align: center;
        padding: 5px;
        font-size: 1.5em;
        font-weight: 600;
        color: #1ABB9C;
    }

    .dv-ctx-tot-atv {
        width: 100%;
        height: 100%;
        padding: 5px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .dv-ctx-tot-atv span {
        width: 100%;
        height: 20px;
        padding: 5px;
        font-size: .9em;
        font-weight: 600;
        letter-spacing: 1.1px;
        color: #444;
        text-align: center;
        border-bottom: 1px solid #eae8e8;
    }

    .dv-ctx-tot-atv span:hover {
        background-color: #eae8e8;
    }

    .dv-graf-hist {
        width: 100%;
        height: 200px;
        padding: 5px;
    }

    /* ---- GRÁFICO HISTORICO RV ---- */
    /* ---- TABELAS ---- */
    .lmt-dv-fl {
        width: 100%;
        height: 50vh;
        overflow-y: scroll;
        overflow-x: auto;
    }

    #div_tbl_res_TEC>table {
        font-size: 1em;
        width: 100%;
    }

    #tbl_res_TEC_wrapper {
        width: 100%;
        height: 100%;
        margin-top: 10px;
    }

</style>


<!-- INPUT CRIADO PARA PEGAR OS DADOS DA SESSÃO NO CONTROLLER    -->
<input type="text" id='dados_section' data_nome='<?php echo $nome_usuario ?>' data_chapa='<?php echo $chapa_usuario ?>'
    data_matricula='<?php echo $matricula_usuario ?>' data_funcao='<?php echo $funcao_usuario ?>' style='display: none'>

<!-- CONTAINER -->
<!-- LAYOUT - INTERFACE -->
<!-- <div class="dv-sub-menu">
        <div class="dv-sub" id="btnGuiaMinhaRV">Minha - RV</div>
        <div class="dv-sub" id="btnGuiaRvEquipe">RV - Equipe</div>
    </div> -->
<div class="dv-ctn">
    <span class="titleDescript">Minha RV</span>
    <span class="dataHora" id="dataHora"></span>
    <!-- GUIA - CL/SEF - RV -->
    <div class="dv-lyt" id="guiaOutrasRV">
        <div class="dv-dados-pessoais"><!-- MÓDULO - DADOS PESSOAIS -->
            <div class="dv-tags-dados">
                <img src="imagens/user.png" alt="Nome">
                <span id="nomeFunc2"></span>
            </div>

            <div class="dv-tags-dados">
                <img src="imagens/cracha.png" alt="chapa">
                <span id="chapaFunc2"></span>
            </div>

            <div class="dv-tags-dados">
                <img src="imagens/estrutura.png" alt="hierarquia">
                <span id="liderFunc2"></span>
            </div>

            <div class="dv-tags-dados">
                <img src="imagens/cargo.png" alt="cargo">
                <span id="cargoFunc2"></span>
            </div>
        </div>

        <div class="dv-lyt-sect">

            <div class="dv-section1">
                <span>Valor Final da RV <div class="dv-tag-mes"></div></span>

                <div class="dv-sct-prod lm-height-dv">
                    <div class="dv-card-prod ">
                        <span>Produtividade</span>
                        <div class="dv-ctx-card-prod" id="resVlrFinalProdOutras"></div>
                    </div>

                    <div class="dv-card-prod" id="dvAssuidade">
                        <span>Assiduidade (%)</span>
                        <div class="dv-ctx-card-prod" id="resVlrFinalAssidOutras"></div>
                    </div>

                    <div class="dv-card-prod">
                        <span>Bônus/Ônus</span>
                        <div class="dv-ctx-card-prod" id="resVlrFinalBonusOutras"></div>
                    </div>

                    <div class="dv-card-prod">
                        <span>Valor Final</span>
                        <div class="dv-ctx-card-prod" id="valorFinalRVOutras"></div>
                    </div>
                </div>
            </div>

            <div class="dv-section1">
                <span>Historico RV</span>
                <div class="dv-graf-hist">
                    <div class="conteudo-grafico" style="width: 100%; height: 90%">
                        <canvas id="myChart2"></canvas>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- GUIA - MINHA RV -->
    <div class="dv-lyt" id="guiaMinhaRV"> <!-- GUIA - MINHA RV -->

        <div class="dv-dados-pessoais"><!-- MÓDULO - DADOS PESSOAIS -->
            <div class="dv-tags-dados">
                <img src="imagens/user.png" alt="Nome">
                <span id="nomeFunc1"></span>
            </div>

            <div class="dv-tags-dados">
                <img src="imagens/cracha.png" alt="chapa">
                <span id="chapaFunc1"></span>
            </div>

            <div class="dv-tags-dados">
                <img src="imagens/estrutura.png" alt="hierarquia">
                <span id="liderFunc1"></span>
            </div>

            <div class="dv-tags-dados">
                <img src="imagens/cargo.png" alt="cargo">
                <span id="cargoFunc1"></span>
            </div>
        </div>

        <div class="dv-lyt-sect"> <!-- // ROW 1 -->

            <div class="dv-section1">
                <span>Produtividade <div class="dv-tag-mes"></div></span>

                <div class="dv-sct-prod">

                    <div class="dv-card-prod">
                        <span>Total de Atividades</span>
                        <div class="dv-ctx-card-prod" id="totAtv"></div>
                        <div class="dv-ctx-tot-atv">
                            <span id="atvInstMigMud"></span>
                            <span id="atvRET"></span>
                            <span id="atvREP"></span>
                            <span id="atvSRV"></span>
                        </div>
                    </div>

                    <div class="dv-card-prod">
                        <span>Resultado Produtividade</span>
                        <div class="dv-ctx-tot-atv visaoTec">
                            <span id="metaProd"></span>
                            <span>(Total Atv. / Dias Trab.)</span>
                        </div>
                        <div class="dv-ctx-card-prod" id="resProd"></div>
                        <!-- <span>Nível Produtividade</span>
                                <div class="dv-ctx-card-prod" id="nivelProd"></div>

                                <span>Valor do Nível</span>
                                <div class="dv-ctx-card-prod" id="valorNivel"></div> -->
                        <div class="dv-ctx-tot-atv visaoTec">
                            <span id="diasAtvEnc"></span>
                            <span id="nivelProd"></span>
                            <span id="valorNivel"></span>
                        </div>
                    </div>

                    <div class="dv-card-prod">
                        <span>Valor Produtividade</span>
                        
                        <div class="dv-ctx-tot-atv semVisaoTec">
                            <span id="totalOs"></span>
                            <!-- <div class="dv-ctx-card-prod" id="mediaEquipeOs"></div>  ATT. PAULO -->
                        </div>
                        <div class="dv-ctx-card-prod" id="vlrFinalProd"></div>

                        <span>Valor Total das Retiradas</span>
                        
                        <div class="dv-ctx-tot-atv semVisaoTec">
                            <span id="totalRet"></span>
                            <!-- <div class="dv-ctx-card-prod" id="mediaEquipeRet"></div> ATT. PAULO -->
                        </div>
                        <div class="dv-ctx-card-prod" id="vlrFinalRet"></div>
                    </div>


                </div>
            </div>

            <div class="dv-section1">
                <span>Indicadores <div class="dv-tag-mes"></div></span>

                <div class="dv-sct-prod lm-height-dv">
                    <div class="dv-card-prod">
                        <span>Infância 30 dias</span>
                        <div class="dv-ctx-tot-atv">
                            <span id="metaInf"></span>
                        </div>
                        <div class="dv-ctx-card-prod" id="resInfancia"></div>
                        <div class="dv-ctx-tot-atv">
                            <div class="visaoTec">
                                <span id="numInf"></span>
                                <span id="denInf"></span>
                            </div>
                            <span class="visaoTec" id="deflatorInf"></span>
                            <span id="bonusOnusInf"></span>
                        </div>
                    </div>

                    <div class="dv-card-prod">
                        <span>Repetido</span>
                        <div class="dv-ctx-tot-atv">
                            <span id="metaRep"></span>
                        </div>
                        <div class="dv-ctx-card-prod" id="resRepetida"></div>
                        <div class="dv-ctx-tot-atv">
                            <div class="visaoTec">
                                <span id="numRep"></span>
                                <span id="denRep"></span>
                            </div>
                            <span class="visaoTec" id="deflatorRep"></span>
                            <span id="bonusOnusRep"></span>
                        </div>
                    </div>

                    <!-- <div class="dv-card-prod"> PAULO
                        <span>Bônus/Ônus</span>
                        <div class="dv-ctx-card-prod" id="resBonusOnus"></div>
                        <div class="semVisaoGestSuper">
                            <span>Padrinho</span>
                            <div class="dv-ctx-card-prod" id="padrinho"></div>
                        </div>
                    </div> -->

                    <div class="dv-card-prod">
                        <span>Bônus/Ônus</span>
                        <div class="dv-ctx-card-prod" id="resBonusOnus"></div>
                        <span class="visaoTec">Padrinho</span>
                        <div class="dv-ctx-card-prod visaoTec" id="padrinho"></div>
                    </div>

                </div>
            </div>

        </div>

        <div class="dv-lyt-sect">

            <div class="dv-section1">
                <span>Valor Final da RV <div class="dv-tag-mes"></div></span>

                <div class="dv-sct-prod lm-height-dv">
                    <div class="dv-card-prod ">
                        <span>Produtividade </span>
                        <div class="dv-ctx-card-prod" id="resVlrFinalProd"></div>
                    </div>

                    <div class="dv-card-prod">
                        <span>Retirada</span>
                        <div class="dv-ctx-card-prod" id="resVlrFinalRet"></div>
                    </div>

                    <div class="dv-card-prod semVisaoTec">
                        <span>Validação HE</span>
                        <div id="resVlrFinalApHE"></div>
                        <!-- <span id="resVlrFinalApHE"></span> -->
                        <div id="resVlrFinalOnusHE"></div>
                        <!-- <div class="dv-ctx-card-prod" id="resVlrFinalOnusHE"></div> -->
                    </div>

                    <div class="dv-card-prod">
                        <span>Bônus/Ônus</span>
                        <div class="dv-ctx-card-prod" id="resVlrFinalBonus"></div>
                    </div>

                    <div class="dv-card-prod">
                        <span>Valor Final</span>
                        <div class="dv-ctx-card-prod" id="valorFinalRV"></div>
                    </div>
                </div>
            </div>

            <div class="dv-section1">
                <span id="mesAnterior"></span>
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
        <div class="dv-lyt-sect"> <!-- // ROW 1 -->

            <div class="dv-section1 lmt-dv-md" id='crdsInfoGest'>
                <span class="ctrl-sup" id="tagTitle1">Supervisores <div class="dv-tag-mes"></div></span>

                <div class="dv-sct-prod ctrl-sup" id="dvCardInfo1">
                    <div class="dv-card-prod dv-lmt-crd">
                        <span>Total Supervisores</span>
                        <div class="dv-ctx-card-prod" id="totLideres"></div>
                    </div>
                    <div class="dv-card-prod dv-lmt-crd">
                        <span>Total RV</span>
                        <div class="dv-ctx-card-prod" id="resTotRvLideres"></div>
                    </div>

                </div>
                <div class="dv-sct-prod ctrl-sup" id="tbl_res_lideres"></div>


                <span>Funcionários<div class="dv-tag-mes"></div></span>
                <div class="dv-sct-prod">
                    <div class="dv-card-prod dv-lmt-crd">
                        <span>Total Funcionários</span>
                        <div class="dv-ctx-card-prod" id="totTecnicos"></div>
                    </div>
                    <div class="dv-card-prod dv-lmt-crd">
                        <span>Total RV</span>
                        <div class="dv-ctx-card-prod" id="resTotRvTecnicos"></div>
                    </div>
                </div>
                <!-- <span>Quantidade de Funcionários por nível <div class="dv-tag-mes"></div></span> -->
                <div class="dv-sct-prod" id="dvCardInfo2">
                    <div class="dv-crd-mult">
                        <div class="dv-brd-int">
                            <span>Nível A</span>
                            <div class="dv-crd-mult-vlr" id="totNivelA"></div>
                            <div class="dv-rv-nvl" id="totRvNivelA"></div>
                        </div>
                    </div>
                    <div class="dv-crd-mult">
                        <div class="dv-brd-int">
                            <span>Nível B</span>
                            <div class="dv-crd-mult-vlr" id="totNivelB"></div>
                            <div class="dv-rv-nvl" id="totRvNivelB"></div>
                        </div>
                    </div>
                    <div class="dv-crd-mult">
                        <div class="dv-brd-int">
                            <span>Nível C</span>
                            <div class="dv-crd-mult-vlr" id="totNivelC"></div>
                            <div class="dv-rv-nvl" id="totRvNivelC"></div>
                        </div>
                    </div>
                    <div class="dv-crd-mult">
                        <div class="dv-brd-int">
                            <span>Nível D</span>
                            <div class="dv-crd-mult-vlr" id="totNivelD"></div>
                            <div class="dv-rv-nvl" id="totRvNivelD"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dv-section1" id='dv_section_table_other_area'>
                <span>Funcionários<div class="dv-tag-mes"></div></span>
                <div class="lmt-dv-fl" id="div_tbl_res_TEC"></div>
            </div>

        </div>
    </div>



</div>

<?php include_once('modalLoad.html'); ?>
<!-- <script src="rv.js"></script> -->
<script src="rv.js?v=<?= filemtime('rv.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>