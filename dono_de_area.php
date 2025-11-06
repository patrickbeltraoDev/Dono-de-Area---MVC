<?php
// DESENVOLVIDO POR: PATRICK BELTRÃO
// DATA DE INICIO: 02/06/2025
// REFATORADO PARA POO/MVC POR: PATRICK BELTRÃO
// DATA DE REFACTOR: 13/10/2025
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); 

require_once __DIR__ . "/auto_load.php";

use Model\User;
use Service\Rv\DtoSection;
use Repository\Connection;
use Repository\Rv\PdoRepository;
use Controller\Rv\ControllerRV;
use Controller\Rv\ControllerInterface;
use Controller\Rv\ControllerLideranca;

// $uri = $_SERVER['REQUEST_URI'];
// $path_uri = pathinfo($uri, PATHINFO_FILENAME);

$routes = include __DIR__ . '/Src/Config/Routes.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'dono_de_area';

$mesAnterior = isset($_GET['mes']) ? $_GET['mes'] : '';

// só incluir topo se NÃO for AJAX
if (!isAjax()) {
    include_once __DIR__ . "/../topo.php";
}

$dataSectionDTO = new DtoSection(
    $_SESSION['usr_nome'], 
    $_SESSION['chapa_tlm'],
    $_SESSION['usr_matricula'], 
    $_SESSION['usr_funcao']
);

if (array_key_exists($page, $routes)) {
    $route = $routes[$page];

    if (is_array($route)) {
        list($controllerClass, $method) = $route;
        $instance = new $controllerClass();
        $instance->$method();
        exit;
    }

    $controllerClass = $route;
    $instance = new $controllerClass($dataSectionDTO, $mesAnterior);
    $instance->handle();
}

function isAjax() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}



?>





<!-- INPUT CRIADO PARA PEGAR OS DADOS DA SESSÃO NO CONTROLLER    -->
<!-- <input type="text" id='dados_section' data_nome='< ?php echo $nome_usuario ?>' data_chapa='< ?php echo $chapa_usuario ?>'
    data_matricula='< ?php echo $matricula_usuario ?>' data_funcao='< ?php echo $funcao_usuario ?>' style='display: none'> -->

<!-- CONTAINER -->
<!-- LAYOUT - INTERFACE -->
<!-- <div class="dv-sub-menu">
        <div class="dv-sub" id="btnGuiaMinhaRV">Minha - RV</div>
        <div class="dv-sub" id="btnGuiaRvEquipe">RV - Equipe</div>
    </div> -->
    
<!-- <div class="dv-ctn">
    <span class="titleDescript">Minha RV</span>
    <span class="dataHora" id="dataHora"></span>
    <div class="dv-lyt" id="guiaOutrasRV">
        <div class="dv-dados-pessoais">
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
                        <span id="tagProdutividade"></span>
                        <div class="dv-ctx-tot-atv">
                            <span id="indInf"></span>
                            <span id="indEfi"></span>
                            <span id="indRep"></span>
                            <span id="indPro"></span>
                        </div>
                        <div class="dv-ctx-card-prod" id="resVlrFinalProdOutras"></div>
                    </div>

                    <div class="dv-card-prod" id="dvAssuidade">
                        <span id="tagAssiduidade"></span>
                        <div class="dv-ctx-card-prod" id="resVlrFinalAssidOutras"></div>
                    </div>

                    <div class="dv-card-prod">
                        <span id="tagBonus"></span>
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

    </div> -->

    <!-- GUIA - MINHA RV -->
    <!-- <div class="dv-lyt" id="guiaMinhaRV"> 

        <div class="dv-dados-pessoais">
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
        </div> -->

        <!-- <div class="dv-lyt-sect">

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
                            <span>(Total Atv. / Dias Trab.)</span>
                        </div>
                        <div class="dv-ctx-card-prod" id="resProd"></div>
                        <span>Nível Produtividade</span>
                                <div class="dv-ctx-card-prod" id="nivelProd"></div>

                                <span>Valor do Nível</span>
                                <div class="dv-ctx-card-prod" id="valorNivel"></div>
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
                            
                        </div>
                        <div class="dv-ctx-card-prod" id="vlrFinalProd"></div>

                        <span>Valor Total das Retiradas</span>
                        
                        <div class="dv-ctx-tot-atv semVisaoTec">
                            <span id="totalRet"></span>
                            
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
                        
                        <div id="resVlrFinalOnusHE"></div>
                        <
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
    </div> -->

    <!-- GUIA - RV EQUIPE -->
    <!-- <div class="dv-lyt" id="guiaRvEquipe">
        <span class="titleDescript">RV EQUIPE</span>
        <div class="dv-lyt-sect"> 

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
    </div> -->



<!-- </div> -->

<!-- < ?php include_once('modalLoad.html'); ?> -->
<!-- <script src="rv.js"></script> -->
<!-- <script src="rv.js?v=< ?= filemtime('rv.js') ?>"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script> -->