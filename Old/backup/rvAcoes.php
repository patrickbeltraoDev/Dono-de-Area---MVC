<?php 
    include_once('../conexao/config.php');
    $db = conectar();

    if ($_POST['action'] == 'consultarMinhaRV') {
        setlocale(LC_TIME, 'Portuguese_Brazil.1252');
        try {
            $chapaUser  = $_POST['chapaUser'];
            $funcao     = strtoupper(trim($_POST['funcaoUser']));
            $otherTable = filter_var($_POST['otherTable'], FILTER_VALIDATE_BOOLEAN);

            // $dados['testes'] = $otherTable;

            if ($otherTable == true) {// TRUE > SIGNIFICA QUE A CONSULTA VAI SER FEITA NA TABELA DE OUTRAS ÁREAS
                if ($funcao == 'COORDENADOR' || $funcao == 'GESTOR') {
                    $tabela = "tbl_telemont_rv_ftth_outras_areas";
                    $cargo  = 'COORDENADOR';
                } else if ($funcao == 'SUPERVISOR') {
                    $tabela = "tbl_telemont_rv_ftth_outras_areas";
                    $cargo  = 'SUPERVISOR';
                } else if ($funcao == 'ENCARREGADO') {
                    $tabela = "tbl_telemont_rv_ftth_outras_areas";
                    $cargo  = 'ENCARREGADO';
                } else {
                    $tabela = "tbl_telemont_rv_ftth_outras_areas";
                }
            } else {
                if ($funcao == 'COORDENADOR' || $funcao == 'GESTOR') {
                    $tabela = "tbl_telemont_nova_rv_ftth_resultado";
                    $cargo  = 'COORDENADOR';
                } else if ($funcao == 'SUPERVISOR') {
                    $tabela = "tbl_telemont_nova_rv_ftth_resultado";
                    $cargo  = 'SUPERVISOR';
                } else if ($funcao == 'ENCARREGADO') {
                    $tabela = "tbl_telemont_nova_rv_ftth_resultado";
                    $cargo  = '`LIDER IMEDIATO`';
                } else {
                    $tabela = "tbl_telemont_nova_rv_ftth_resultado";
                }
            }
            
            $sqlConDadosUser = "SELECT * 
                                FROM modulo_rv.tbl_telemont_nova_rv_ftth_resultado
                                WHERE 
                                        MES = (SELECT MAX(MES) FROM modulo_rv.tbl_telemont_nova_rv_ftth_resultado WHERE NK_CHAPA = :chapa)
                                    AND NK_CHAPA = :chapa
            ";
            
            $stmt = $db->prepare($sqlConDadosUser);
            $stmt->bindParam(':chapa', $chapaUser);
            $stmt->execute();
            $resConDadosUser = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // $dados['testes'] = $sqlConDadosUser;

            foreach($resConDadosUser as $row) {
                //HORA ATUALIZACAO BASE
                $dados['dataHora'] = $row['DataHora'];
                
                // DADOS PESSOAIS                
                $dados['nomeUser']  = strtoupper($row['NM_FUNCIONARIO']);
                $dados['cargoUser'] = strtoupper($row['CARGO']);
                $dados['chapaUser'] = $row['NK_CHAPA'];

                if (stripos($row['CARGO'], 'SUPERVISOR') !== false) {
                    $dados['hierarquiaUser'] = strtoupper($row['COORDENADOR']);
                } else if (stripos($row['CARGO'], 'coordenador')) {
                    $dados['hierarquiaUser'] = strtoupper($row['GERENTE']);
                } else {
                    $dados['hierarquiaUser'] = strtoupper($row['SUPERVISOR']);
                }

                if ($otherTable == true) {
                    $dados['prodOutrasAreas']  = "R$ " . $row['VALOR_FINAL_OS_RET'];
                    $dados['assidOutrasAreas'] = $row['ASSIDUIDADE'];
                    $dados['bonusOutrasAreas'] = "R$ " . $row['BONUS'];
                    $dados['rvOutrasAreas']    = "R$ " . $row['RV'];
                } else {
                    // DADOS PRODUTIVIDADE
                        $dados['totAtv']         = $row['TOTAL_CS'];
                        $dados['atvInstMigMud']  = "INST + MIG + MUD: " . ($row['INST_CS'] + $row['MUD_CS']);
                        $dados['atvRET']         = "RET + EQUIP. RECOLHIDO: " . $row['RET_CS'];
                        $dados['atvREP']         = "REPARO: " . $row['REP_CS'];
                        $dados['atvSRV']         = "OUTRAS: " . $row['SRV_CS'];
                        $dados['resProd']        = number_format($row['PRODUTIVIDADE'], 2);
                        $dados['diasAtvEnc']     = "DIAS ATV. ENCERRADA: " . $row['DIAS_ATIV_ENCERRADAS'];
                        $dados['nivelProd']      = "NÍVEL PRODUTIVIDADE: " . $row['NIVEL_PRODUTIVIDADE'];
                        $dados['valorNivel']     = "VALOR DO NÍVEL: R$ " . $row['VALOR_OS'];
                        $dados['mediaEquipeOs']  = "R$ " . number_format($row['VALOR_FINAL_OS_TOTAL']/$row['COLAB_CONSIDERADO_PROD'], 2);
                        $dados['mediaEquipeRet'] = "R$ " . number_format($row['VALOR_FINAL_RET_TOTAL']/$row['COLAB_CONSIDERADO_RET'], 2);
                        $dados['totalOs']        = "R$ " . $row['VALOR_FINAL_OS'];
                        $dados['totalRet']       = "R$ " . $row['VALOR_FINAL_RET'];
                        $dados['vlrFinalProd']   = "R$ " . $row['VALOR_FINAL_OS'];
                        $dados['vlrFinalRet']    = "R$ " . $row['VALOR_FINAL_RET'];
                        $dados['vlrFinalApHE']   = "<span>Aprovação:</span><div class='frmt-dv'>" . number_format(($row['APROVACAO_HE'] * 100), 0). "%</div>";
                        $dados['vlrFinalOnusHE'] = "<span>Ônus:</span><div class='frmt-dv'> R$" . number_format(($row['PENALIDADE_HE_VALOR']), 2) . "</div>";
                        $dados['metaProd']       = "Meta Produtividade: " . $row['META_PRODUTIVIDADE'];

                        if ($funcao == 'COORDENADOR' || $funcao == 'GESTOR' || $funcao == 'SUPERVISOR') {
                            $dados['totalOs']    = "(R$ {$row['VALOR_FINAL_OS_TOTAL']}/{$row['COLAB_CONSIDERADO_PROD']})";
                            $dados['totalRet']   = "(R$ {$row['VALOR_FINAL_RET_TOTAL']}/{$row['COLAB_CONSIDERADO_RET']})";
                        }
                    // DADOS INDICADORES
                        $dados['resInfancia']   = number_format(($row['INFANCIA_RESULTADO'] * 100), 2). "%";
                        $dados['metaInf']   = "META: " . number_format(($row['INFANCIA_META_CONSIDERADA'] * 100), 2). "%";
                        $dados['numInf']   = "(Num): " . $row['INFANCIA_NUMERADOR'];
                        $dados['denInf']   = "(Den): " . $row['INFANCIA_DENOMINADOR'];
                        $dados['deflatorInf']   = "DEFLATOR: " . $row['INFANCIA_DEFLATOR'];
                        $dados['bonusOnusInf']  = "BÔNUS/ÔNUS: R$ " . $row['INFANCIA_BONUS'];
                        $dados['resRepetida']   = number_format(($row['REPETIDA_RESULTADO'] * 100), 2) . "%";
                        $dados['numRep']   = "(Num): " . $row['REPETIDA_NUMERADOR'];
                        $dados['denRep']   = "(Den): " . $row['REPETIDA_DENOMINADOR'];
                        $dados['deflatorRep']   = "DEFLATOR: " . $row['REPETIDA_DEFLATOR'];
                        $dados['metaRep']   = "META: " . number_format(($row['REPETIDA_META_CONSIDERADA'] * 100), 2). "%";
                        $dados['bonusOnusRep']  = "BÔNUS/ÔNUS: R$ " . $row['REPETIDA_BONUS'];
                        $dados['resBonusOnus']  = "R$ " . $row['BONUS'];
                        if ($row['PADRINHO'] == 'SIM') {
                            $dados['padrinho']  = "SIM (R$ 200,00)";
                        } else {
                            $dados['padrinho']  = "NÃO";
                        }

                    // SE NAO TIVER DADOS INDICADORES, ENTÃO TROCA PARA 'N/A'
                        if( $row['INFANCIA_DENOMINADOR'] == 0){
                            $dados['resInfancia']   = "N/A";
                        }
                    // SE NAO TIVER DADOS REPARO, ENTÃO TROCA PARA 'N/A'
                        if( $row['REPETIDA_DENOMINADOR'] == 0){
                            $dados['resRepetida']   = "N/A";
                        }

                    // DADOS VALOR FINAL DA RV
                        $dados['valorFinalRV']  = "R$ " . $row['RV'];

                    // DATA DA CONSULTA
                        $data                   = new DateTime($row['MES']);
                        $mesAno                 = strftime('%B/%Y', $data->getTimestamp());
                        $dados['dataCon']       = $mesAno;

                        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'portuguese');
                        $mesEmAberto = $row['MES'];
                        $mesAnterior = strftime('%B', strtotime('-1 month', strtotime($mesEmAberto)));
                        $dados['mesEmAberto']   = $mesAnterior;
                        
                    
                }
                // GRÁFICO HISTORICO RV  
                $array_rv             = [];
                $array_legendas_graf  = [];
                $$arrayMeses          = [];
        
                $meses = array(
                    1 => 'Jan',
                    2 => 'Fev',
                    3 => 'Mar',
                    4 => 'Abr',
                    5 => 'Mai',
                    6 => 'Jun',
                    7 => 'Jul',
                    8 => 'Ago',
                    9 => 'Set',
                    10 => 'Out',
                    11 => 'Nov',
                    12 => 'Dez'
                );
        
                try {
                    $sql_rv = "SELECT
                                    MES, RV 
                                FROM modulo_rv.$tabela
                                WHERE 
                                    MES >= DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 2 MONTH), '%Y-%m-01')
                                    AND MES <= DATE_FORMAT(CURDATE(), '%Y-%m-01')
                                    AND NK_CHAPA = $chapaUser
                    ";
                    $dados['sql_rv'] = $sql_rv;
                    $stmt = $db->prepare($sql_rv);
                    $stmt->execute();
                    $resRV= $stmt->fetchAll(PDO::FETCH_ASSOC);
        
                    foreach ($resRV as $res) {
        
                        $array_rv[]  = $res['RV'];            
                        $lgds_grafico = new DateTime($res['MES']);
                        $lgds_grafico = $lgds_grafico->format('n');
                        $lgds_meses   = $meses[$lgds_grafico];
        
                        $array_legendas_graf[] = $lgds_meses;
        
                        // $arrayMeses[] = $res['dt_load'];
                    }
        
                    $dados['histRV']        = $array_rv;
                    $dados['legends_graf']  = $array_legendas_graf;
                    // $dados['arrayMeses']    = $arrayMeses;
                    // $dados['teste']    = $sql_performace;
        
                } catch (PDOException $e) {
                    echo "Erro: " . $e->getMessage();
                } 
                    
            }
            echo json_encode($dados);
            exit;
        
        } catch (PDOException $e) {
            header('Content-Type: application/json');
            echo json_encode(['erro' => $e->getMessage()]);
            exit;
        }
    }

    if ($_POST['action'] == 'conRvEquipe') {
        setlocale(LC_TIME, 'Portuguese_Brazil.1252');
        try {
            $chapaUser  = $_POST['chapaUser'];
            $funcao     = $_POST['funcaoUser'];
            $otherTable = filter_var($_POST['otherTable'], FILTER_VALIDATE_BOOLEAN);

            if ($otherTable == true) {// TRUE > SIGNIFICA QUE A CONSULTA VAI SER FEITA NA TABELA DE OUTRAS ÁREAS
                if ($funcao == 'COORDENADOR' || $funcao == 'GESTOR') {
                    $tabela = "tbl_telemont_rv_ftth_outras_areas";
                    $cargo  = 'COORDENADOR';
                } else if ($funcao == 'SUPERVISOR') {
                    $tabela = "tbl_telemont_rv_ftth_outras_areas";
                    $cargo  = 'SUPERVISOR';
                } else if ($funcao == 'ENCARREGADO'){
                    $tabela = "tbl_telemont_rv_ftth_outras_areas";
                    $cargo  = 'LIDER IMEDIATO';
                }
            } else {
                if ($funcao == 'COORDENADOR' || $funcao == 'GESTOR') {
                    $tabela = "tbl_telemont_nova_rv_ftth_resultado";
                    $cargo  = 'COORDENADOR';
                    $cargo_atl  = 'COORDENADOR_ATUAL';
                } else if ($funcao == 'SUPERVISOR' || $funcao == 'ENCARREGADO') {
                    $tabela = "tbl_telemont_nova_rv_ftth_resultado";
                    $cargo  = '`LIDER IMEDIATO`';
                    $cargo_atl  = '`LIDER IMEDIATO_ATUAL`';
                } else {
                    $tabela = "tbl_telemont_nova_rv_ftth_resultado";
                }
            }

            if ($otherTable == true) {
                $sqlConDadosUser = "SELECT * 
                                    FROM modulo_rv.$tabela
                                    WHERE 
                                        MES = (SELECT MAX(MES) FROM modulo_rv.$tabela)
                                        AND NK_CHAPA = :chapa
                ";
    
                $stmt = $db->prepare($sqlConDadosUser);
                $stmt->bindParam(':chapa', $chapaUser);
                $stmt->execute();
                $resConDadosUser = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach($resConDadosUser as $row) {
                    $nameUser        = $row['NM_FUNCIONARIO'];                    
                }

                $conDadosEquipe = "SELECT 
                                        COUNT(NK_CHAPA) AS TOTAL_FUNCIONARIOS,
                                        SUM(RV) AS TOTAL_RV
                                    FROM modulo_rv.tbl_telemont_rv_ftth_outras_areas 
                                    WHERE MES = (SELECT MAX(MES) FROM modulo_rv.tbl_telemont_rv_ftth_outras_areas)
                                        AND $cargo IN('$nameUser')
                                        AND SITUACAO = 'ATIVO'
                ";
                $stmt = $db->prepare($conDadosEquipe);
                $stmt->execute();
                $resDadosEquipe = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach($resDadosEquipe as $row) {
                    $totFunc     = $row['TOTAL_FUNCIONARIOS'];                    
                    $totRVEquipe = $row['TOTAL_RV'];                    
                }
                $dados['totFunc']     = $totFunc;
                $dados['totRVEquipe'] = "R$ " . $totRVEquipe;

                // TABELA DE HIERARQUIA - FUNCIONÁRIOS >> CL/SEF
                $sqlConTblFunc = "SELECT 
                                    UF,
                                    NM_FUNCIONARIO,
                                    SITUACAO,
                                    CARGO,
                                    AREA,
                                    VALOR_FINAL_OS_RET,
                                    BONUS,
                                    IF(ASSIDUIDADE IS NULL, '', TRUNCATE((ASSIDUIDADE * 100), 0)) AS ASSIDUIDADE,
                                    RV
                                FROM modulo_rv.tbl_telemont_rv_ftth_outras_areas
                                WHERE MES = (SELECT MAX(MES) FROM modulo_rv.tbl_telemont_rv_ftth_outras_areas)
                                AND $cargo IN('$nameUser')
                                AND (SITUACAO = 'ATIVO')
                                GROUP BY NK_CHAPA ORDER BY RV DESC
                ";

                $stmt = $db->prepare($sqlConTblFunc);
                $stmt->execute();
                $resConTblFunc = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $output = "<table id='tbl_res_TEC' class='display table table-striped table-bordered table-sm' border='1' style='margin-top: 5px;'>
                            <thead>
                                <tr>
                                    <th>UF</th>
                                    <th>NOME</th>
                                    <th>SITUAÇÃO</th>
                                    <th>CARGO</th>
                                    <th>ÁREA</th>
                                    <th>PRODUTIVIDADE</th>
                                    <th>BÔNUS</th>
                                    <th>ASSIDUIDADE</th>
                                    <th>RV</th>
                                </tr>
                            </thead>
                            <tbody>
                ";

                foreach($resConTblFunc as $row) {
                    $assiduidade = $row['ASSIDUIDADE'] != '' ? $row['ASSIDUIDADE'] . "%" : '';
                    $output .= "<tr>
                    <td style='text-align: center'>$row[UF]</td>
                    <td style='text-align: center'>$row[NM_FUNCIONARIO]</td>
                    <td style='text-align: center'>$row[SITUACAO]</td>
                    <td style='text-align: center'>$row[CARGO]</td>
                    <td style='text-align: center'>$row[AREA]</td>
                    <td style='text-align: center'>R$ $row[VALOR_FINAL_OS_RET]</td>
                    <td style='text-align: center'>R$ $row[BONUS]</td>
                    <td style='text-align: center'>$assiduidade</td>
                    <td style='text-align: center'>R$ $row[RV]</td>
                    </tr>
                    ";
                }
                $output .= "</tbody></table>";

                $dados['tbl_res_TEC'] = $output;
            } else {
                // SECTION LIDERES
                $sqlConDadosUser = "SELECT * 
                                    FROM modulo_rv.$tabela
                                    WHERE 
                                        MES = (SELECT MAX(MES) FROM modulo_rv.$tabela)
                                        AND NK_CHAPA = :chapa
                ";

                $stmt = $db->prepare($sqlConDadosUser);
                $stmt->bindParam(':chapa', $chapaUser);
                $stmt->execute();
                $resConDadosUser = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach($resConDadosUser as $row) {
                    if ($funcao === 'SUPERVISOR') {
                        $dados['totLideres']       = '0';
                        $dados['totTecnicos']      = $row['TECNICOS'];
                        $dados['resTotRvTecnicos'] = "R$ " . $row['RV_TECNICOS'];
                        $dados['resTotRvLideres']  = "R$ 0,00";
                    } else {
                        $dados['totLideres']       = $row['LIDERES'];
                        $dados['totTecnicos']      = $row['TECNICOS'];
                        $dados['resTotRvLideres']  = "R$ " . $row['RV_LIDERES'];
                        $dados['resTotRvTecnicos'] = "R$ " . $row['RV_TECNICOS'];
                    }
                    $nameUser        = $row['NM_FUNCIONARIO'];                    
                }

                // TABELA DE HIERARQUIA - SUPERVISORES
                $sqlConTblHierarquia = "SELECT 
                            NK_CHAPA,
                            NM_FUNCIONARIO,
                            TECNICOS,
                            TOTAL_CS,
                            PRODUTIVIDADE,
                            NIVEL_PRODUTIVIDADE,
                            RV
                        FROM modulo_rv.tbl_telemont_nova_rv_ftth_resultado
                        WHERE MES = (SELECT MAX(MES) FROM modulo_rv.tbl_telemont_nova_rv_ftth_resultado)
                            AND $cargo_atl IN('$nameUser')
                            AND (SITUACAO = 'ATIVO' OR (SITUACAO <> 'ATIVO' AND COM_RV = 'SIM'))
                            AND ORIGEM = 'LIDER'
                        GROUP BY NK_CHAPA
                ";

                $stmt = $db->prepare($sqlConTblHierarquia);
                $stmt->execute();
                $resConTblHierarquia = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $output = "<table id='tbl_res_lider' class='display table table-striped table-bordered table-sm' border='1' style='margin-top: 5px;'>
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
                ";

                foreach($resConTblHierarquia as $row) {

                    $output .= "<tr>
                        <td style='text-align: center'>$row[NM_FUNCIONARIO]</td>
                        <td style='text-align: center'>$row[NK_CHAPA]</td>
                        <td style='text-align: center'>$row[TECNICOS]</td>
                        <td style='text-align: center'>$row[TOTAL_CS]</td>
                        <td style='text-align: center'>R$ $row[RV]</td>
                        </tr>
                    ";
                    // <td style='text-align: center'>" . number_format($row['PRODUTIVIDADE'], 2) . "</td>
                    // <td style='text-align: center'>$row[NIVEL_PRODUTIVIDADE]</td>
                }
                $output .= "</tbody></table>";

                $dados['tbl_res_lideres'] = $output;

                // SECTION TÉCNICOS
                // TABELA DE HIERARQUIA - TÉCNICOS
                    $sqlConTblFunc = "SELECT 
                            NK_CHAPA,
                            NM_FUNCIONARIO,
                            SITUACAO,
                            TOTAL_CS,
                            PRODUTIVIDADE,
                            NIVEL_PRODUTIVIDADE,
                            TRUNCATE((INFANCIA_RESULTADO * 100), 2) AS INFANCIA_RESULTADO,
                            TRUNCATE((REPETIDA_RESULTADO * 100), 2) AS REPETIDA_RESULTADO,
                            BONUS,
                            RV
                        FROM modulo_rv.tbl_telemont_nova_rv_ftth_resultado
                        WHERE MES = (SELECT MAX(MES) FROM modulo_rv.tbl_telemont_nova_rv_ftth_resultado)
                            AND $cargo_atl IN('$nameUser')
                            AND (SITUACAO = 'ATIVO' OR (SITUACAO <> 'ATIVO' AND (COM_RV = 'SIM' OR ATIV_ENCERRADAS = 'SIM')))
                            AND ORIGEM = 'TECNICOS'
                        GROUP BY NK_CHAPA ORDER BY RV DESC
                    ";

                $stmt = $db->prepare($sqlConTblFunc);
                $stmt->execute();
                $resConTblFunc = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $output = "<table id='tbl_res_TEC' class='display table table-striped table-bordered table-sm' border='1' style='margin-top: 5px;'>
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
                ";

                foreach($resConTblFunc as $row) {
                    $output .= "<tr>
                                    <td style='text-align: center'>$row[NM_FUNCIONARIO]</td>
                                    <td style='text-align: center'>$row[NK_CHAPA]</td>
                                    <td style='text-align: center'>$row[SITUACAO]</td>
                                    <td style='text-align: center'>$row[TOTAL_CS]</td>
                                    <td style='text-align: center'>" . number_format($row['PRODUTIVIDADE'], 2) . "</td>
                                    <td style='text-align: center'>$row[NIVEL_PRODUTIVIDADE]</td>
                                    <td style='text-align: center'>$row[INFANCIA_RESULTADO]</td>
                                    <td style='text-align: center'>$row[REPETIDA_RESULTADO]</td>
                                    <td style='text-align: center'>$row[BONUS]</td>
                                    <td style='text-align: center'>R$ $row[RV]</td>
                                </tr>
                    ";
                }
                $output .= "</tbody></table>";

                $dados['tbl_res_TEC'] = $output;

                // DADOS TÉCNICOS
                $sqlConResTec = "SELECT 
                        COUNT(IF(NIVEL_PRODUTIVIDADE = 'A', 1, NULL)) AS QTD_NIVEL_A,
                        SUM(IF(NIVEL_PRODUTIVIDADE = 'A', RV, 0)) AS RV_NIVEL_A,
                        COUNT(IF(NIVEL_PRODUTIVIDADE = 'B', 1, NULL)) AS QTD_NIVEL_B,
                        SUM(IF(NIVEL_PRODUTIVIDADE = 'B', RV, 0)) AS RV_NIVEL_B,
                        COUNT(IF(NIVEL_PRODUTIVIDADE = 'C', 1, NULL)) AS QTD_NIVEL_C,
                        SUM(IF(NIVEL_PRODUTIVIDADE = 'C', RV, 0)) AS RV_NIVEL_C,
                        COUNT(IF(NIVEL_PRODUTIVIDADE = 'D', 1, NULL)) AS QTD_NIVEL_D,
                        SUM(IF(NIVEL_PRODUTIVIDADE = 'D', RV, 0)) AS RV_NIVEL_D
                    FROM 
                        modulo_rv.tbl_telemont_rv_ftth_tecnicos AS a
                    WHERE 
                        $cargo IN('$nameUser') 
                        AND MES = (SELECT MAX(MES) FROM modulo_rv.tbl_telemont_rv_ftth_tecnicos)
                        AND (SITUACAO = 'ATIVO' OR (SITUACAO <> 'ATIVO' AND (COM_RV = 'SIM' OR ATIV_ENCERRADAS = 'SIM')))
                ";

                $stmt = $db->prepare($sqlConResTec);
                $stmt->execute();
                $resConTec = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach($resConTec as $row) {
                    $dados['totNivelA'] = $row['QTD_NIVEL_A'];
                    $dados['totNivelB'] = $row['QTD_NIVEL_B'];
                    $dados['totNivelC'] = $row['QTD_NIVEL_C'];
                    $dados['totNivelD'] = $row['QTD_NIVEL_D'];

                    $dados['totRvNivelA'] = "R$ " . $row['RV_NIVEL_A'];
                    $dados['totRvNivelB'] = "R$ " . $row['RV_NIVEL_B'];
                    $dados['totRvNivelC'] = "R$ " . $row['RV_NIVEL_C'];
                    $dados['totRvNivelD'] = "R$ " . $row['RV_NIVEL_D'];
                }
            }
            


            echo json_encode($dados);
            exit;
        
        } catch (PDOException $e) {
            header('Content-Type: application/json');
            echo json_encode(['erro' => $e->getMessage()]);
            exit;
        }
    }




    desconectar($db);