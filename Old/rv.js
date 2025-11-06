const dadosSection = document.querySelector('#dados_section');
const chapaUser = dadosSection.getAttribute('data_chapa');
const funcaoUsuario = dadosSection.getAttribute('data_funcao');
const funcao = funcaoUsuario.split(' ')[0].toUpperCase();

// const btnGuiaRvEquipe    = document.getElementById('btnGuiaRvEquipe');
// const btnGuiaMinhaRV     = document.getElementById('btnGuiaMinhaRV');
const guiaMinhaRV = document.getElementById('guiaMinhaRV');
const guiaRvEquipe = document.getElementById('guiaRvEquipe');
const guiaRvEquipeOutras = document.getElementById('guiaOutrasRV');

const crdsInfoGest = document.getElementById('crdsInfoGest');
const dvCardInfo1 = document.getElementById('dvCardInfo1');
const dvCardInfo2 = document.getElementById('dvCardInfo2');
const tagTitle1 = document.getElementById('tagTitle1');
const dvTableOther = document.getElementById('dv_section_table_other_area');
const dvAssuidade = document.getElementById('dvAssuidade');

// document.querySelectorAll('.dv-sub').forEach(function (el) {
//     el.addEventListener('click', function () {
//         document.querySelectorAll('.dv-sub').forEach(function (div) {
//             div.style.backgroundColor = '';
//         });

//         this.style.backgroundColor = '#E5E5E5';


//         if (this.id == 'btnGuiaMinhaRV') {// AO CLICAR NA GUIA VAI VERIFICAR SE O USUARIO FAZ PARTE DO CL/SEF PARA HABILITAR A DIV 

//             guiaMinhaRV.style.display        = 'flex';
//             guiaRvEquipe.style.display       = 'none';
//             guiaRvEquipeOutras.style.display = 'none';
//             conMinhaRV(chapaUser, cargoUser);

//         }

//         if (this.id == 'btnGuiaRvEquipe') {
//             guiaRvEquipe.style.display = 'flex';
//             guiaMinhaRV.style.display = 'none';
//             if (cargoUser === 'SUPERVISOR') {
//                 let ctrl_view_sup = document.querySelectorAll('.ctrl-sup');
//                 ctrl_view_sup.forEach(div => {
//                     div.style.display = 'none';
//                 });
//             }
//             conRvEquipe(cargoUser);
//         }
//     });
// });

function destroyGraficos() {
    var existingChart1 = Chart.getChart("myChart1");
    var existingChart2 = Chart.getChart("myChart2");
    if (existingChart1 || existingChart2) {
        existingChart1.destroy();
        existingChart2.destroy();
    }
}

function conMinhaRV(chapaUser, funcaoUser, otherTable = false) {// TRUE > SIGNIFICA QUE A CONSULTA VAI SER FEITA NA ORIGEM APOIO
    // alert(otherTable)
    showLoad();
    fetch('rvAcoes.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            action: 'consultarMinhaRV',
            chapaUser: chapaUser,
            funcaoUser,
            otherTable
        })
    })

        .then(response => response.text())
        .then(data => {
            hideLoad();
            destroyGraficos();

            var dados = JSON.parse(data);


            if (otherTable == false) {

                // ------- DATA ATUALIZAÇÃO BASE ------- \\
                document.getElementById('dataHora').innerHTML = 'Última Atualização da Base: ' + dados.dataHora;

                // DADOS PESSOAIS
                document.getElementById('nomeFunc1').innerHTML = dados.nomeUser || 'Nome não encontrado';
                document.getElementById('chapaFunc1').innerHTML = dados.chapaUser || 'Chapa não encontrada';
                document.getElementById('cargoFunc1').innerHTML = dados.cargoUser || 'Cargo não encontrado';
                document.getElementById('liderFunc1').innerHTML = dados.hierarquiaUser || 'Liderança não encontrada';
                // DADOS PRODUTIVIDADE
                document.getElementById('totAtv').innerHTML = dados.totAtv;
                document.getElementById('atvInstMigMud').innerHTML = dados.atvInstMigMud;
                document.getElementById('atvRET').innerHTML = dados.atvRET;
                document.getElementById('atvREP').innerHTML = dados.atvREP;
                document.getElementById('atvSRV').innerHTML = dados.atvSRV;
                document.getElementById('resProd').innerHTML = dados.resProd;

                document.getElementById('diasAtvEnc').innerHTML = dados.diasAtvEnc;
                document.getElementById('nivelProd').innerHTML = dados.nivelProd;
                document.getElementById('valorNivel').innerHTML = dados.valorNivel;

                document.getElementById('vlrFinalProd').innerHTML = dados.vlrFinalProd;
                document.getElementById('vlrFinalRet').innerHTML = dados.vlrFinalRet;

                
                document.getElementById('totalOs').innerHTML = dados.totalOs;
                document.getElementById('totalRet').innerHTML = dados.totalRet;


                // document.getElementById('totalOs').innerHTML = dados.totalOs;
                // document.getElementById('totalRet').innerHTML = dados.totalRet;

                        // PAULO
                        // document.getElementById('mediaEquipeOs').innerHTML = dados.mediaEquipeOs;
                        // document.getElementById('mediaEquipeRet').innerHTML = dados.mediaEquipeRet;

                        // mostra ou oculta todos os elementos com classe visaoTec
                        // if (funcaoUser == 'AGENTE' || funcaoUser == 'INSTALADOR' || funcaoUser == 'AUXILIAR'
                        //     || funcaoUser == 'REPARADOR' || funcaoUser == 'TECNICO' || funcaoUser == 'TRAINEE') {
                        //     document.getElementById('diasAtvEnc').innerHTML = dados.diasAtvEnc;
                        //     document.getElementById('nivelProd').innerHTML = dados.nivelProd;
                        //     document.getElementById('valorNivel').innerHTML = dados.valorNivel;

                        //     // document.getElementById('totalOs').innerHTML = dados.totalOs;
                        //     // document.getElementById('totalRet').innerHTML = dados.totalRet;

                        //     document.querySelectorAll('.visaoTec').forEach(el => {
                        //         el.style.display = 'flex';
                        //     });

                        //     document.querySelectorAll('.semVisaoTec').forEach(el => {
                        //         el.style.display = 'none';
                        //     });
                        // } else {
                        //     // console.log('entrou', dados)
                        //     document.getElementById('totalOs').innerHTML = dados.totalOs;
                        //     document.getElementById('totalRet').innerHTML = dados.totalRet;

                        //     document.querySelectorAll('.visaoTec').forEach(el => {
                        //         el.style.display = 'none';
                        //     });

                        //     document.querySelectorAll('.semVisaoTec').forEach(el => {
                        //         el.style.display = 'flex';
                        //     });
                        // }

                // DADOS INDICADORES
                document.getElementById('resInfancia').innerHTML = dados.resInfancia;
                document.getElementById('metaInf').innerHTML = dados.metaInf;
                document.getElementById('bonusOnusInf').innerHTML = dados.bonusOnusInf;
                document.getElementById('resRepetida').innerHTML = dados.resRepetida;
                document.getElementById('metaRep').innerHTML = dados.metaRep;
                document.getElementById('bonusOnusRep').innerHTML = dados.bonusOnusRep;
                document.getElementById('resBonusOnus').innerHTML = dados.resBonusOnus;


                document.getElementById('numInf').innerHTML = dados.numInf;
                document.getElementById('denInf').innerHTML = dados.denInf;
                document.getElementById('deflatorInf').innerHTML = dados.deflatorInf;
                document.getElementById('numRep').innerHTML = dados.numRep;
                document.getElementById('denRep').innerHTML = dados.denRep;
                document.getElementById('deflatorRep').innerHTML = dados.deflatorRep;
                document.getElementById('padrinho').innerHTML = dados.padrinho;

                // PAULO
                // if (funcaoUser == 'GESTOR' || funcaoUser == 'SUPERVISOR') {
                //     document.querySelectorAll('.semVisaoGestSuper').forEach(el => {
                //         el.style.display = 'none';
                //     });
                // } else {
                //     document.getElementById('numInf').innerHTML = dados.numInf;
                //     document.getElementById('denInf').innerHTML = dados.denInf;
                //     document.getElementById('deflatorInf').innerHTML = dados.deflatorInf;
                //     document.getElementById('numRep').innerHTML = dados.numRep;
                //     document.getElementById('denRep').innerHTML = dados.denRep;
                //     document.getElementById('deflatorRep').innerHTML = dados.deflatorRep;
                //     document.getElementById('padrinho').innerHTML = dados.padrinho;
                //     document.querySelectorAll('.semVisaoGestSuper').forEach(el => {
                //         el.style.display = 'flex';
                //     });
                // }

                // DADOS VALOR FINAL DA RV
                document.getElementById('resVlrFinalProd').innerHTML = dados.vlrFinalProd;
                document.getElementById('resVlrFinalRet').innerHTML = dados.vlrFinalRet;
                document.getElementById('resVlrFinalApHE').innerHTML = dados.vlrFinalApHE;
                document.getElementById('resVlrFinalOnusHE').innerHTML = dados.vlrFinalOnusHE;
                document.getElementById('resVlrFinalBonus').innerHTML = dados.resBonusOnus;
                document.getElementById('valorFinalRV').innerHTML = dados.valorFinalRV;

                // DATA DA CONSULTA
                document.querySelectorAll('.dv-tag-mes').forEach(function (div) {
                    div.innerHTML = dados.dataCon;
                });

                document.getElementById('mesAnterior').innerHTML = "Historico RV - (O Mês de " + dados.mesEmAberto + " esta em apuração)";

                // GRÁFICO HISTORICO
                var options = {
                    maintainAspectRatio: false,
                    responsive: true,
                    plugins: { legend: { display: false } },
                    layout: { padding: { right: 17, left: 15, top: 15 } },
                    scales: {
                        x: { display: true, grid: { display: false } },
                        y: { display: false, grid: { display: false } }
                    },
                }

                // console.log(dados.sql_rv);

                const dataRV = {
                    labels: dados.legends_graf,
                    datasets: [{
                        type: 'line',
                        label: 'Historico Quadrante',
                        backgroundColor: (context) => {
                            const bgColor = [
                                'rgba(26, 188, 156, 1)',
                                'rgba(76, 196, 172, .7)',
                                // 'rgba(136, 206, 191, .5)',
                                'rgba(194, 249, 237, .5)',
                            ];
                            if (!context.chart.chartArea) {
                                return;
                            }
                            const { ctx, data, chartArea: { top, bottom } } = context.chart;
                            const gradientBg = ctx.createLinearGradient(0, top, 0, bottom);
                            const colorTranches = 1 / (bgColor.length - 1);
                            for (let i = 0; i < bgColor.length; i++) {
                                gradientBg.addColorStop(0 + i * colorTranches, bgColor[i])
                            }
                            return gradientBg;
                        },
                        pointBachgroundColor: '#000',
                        fill: true,
                        data: dados.histRV,
                        tension: 0.3,
                        datalabels: {
                            align: 'start',
                            anchor: 'end',
                            align: 'end',
                            color: '#000',
                            font: {
                                size: 10
                            }
                        },
                        order: 1
                    }]
                };

                new Chart("myChart1", {
                    data: dataRV,
                    options: options,
                    plugins: [ChartDataLabels]
                })

                if (funcaoUser == 'COORDENADOR' || funcaoUser == 'SUPERVISOR' || funcaoUser == 'GESTOR') {
                    document.querySelectorAll('.visaoTec').forEach(el => {
                        el.style.display = 'none';
                    });
                } else {
                    document.querySelectorAll('.semVisaoTec').forEach(el => {
                        el.style.display = 'none';
                    }); 
                }

            } else {
                // DADOS PESSOAIS
                if (dados.tag == 'OPERACIONAL') {
                    document.getElementById('tagProdutividade').innerHTML = 'Média dos Indicadores';
                    document.getElementById('tagAssiduidade').innerHTML = 'Assiduidade';
                    document.getElementById('tagBonus').innerHTML = 'Valor Assiduidade';
                } else {
                    document.getElementById('tagProdutividade').innerHTML = 'Média dos Indicadores';
                    document.getElementById('tagAssiduidade').innerHTML = 'Aprovação HE';
                    document.getElementById('tagBonus').innerHTML = 'Penalidade Aprov. HE';
                }
               const container = document.querySelector('.dv-ctx-tot-atv');
                container.innerHTML = '';

                for (const [chave, valor] of Object.entries(dados.mediaInd)) {
                    if (valor) {
                        const span = document.createElement('span');
                        span.textContent = valor;
                        container.appendChild(span);
                    }
                }

                    
                document.getElementById('nomeFunc2').innerHTML = dados.nomeUser || 'Nome não encontrado';
                document.getElementById('chapaFunc2').innerHTML = dados.chapaUser || 'Chapa não encontrada';
                document.getElementById('cargoFunc2').innerHTML = dados.cargoUser || 'Cargo não encontrado';
                document.getElementById('liderFunc2').innerHTML = dados.hierarquiaUser || 'Liderança não encontrada';

                document.getElementById('resVlrFinalProdOutras').innerHTML = dados.prodOutrasAreas;
                if (dados.assidOutrasAreas == null || dados.assidOutrasAreas == '') {
                    dvAssuidade.style.display = 'none';
                } else {
                    document.getElementById('resVlrFinalAssidOutras').innerHTML = dados.assidOutrasAreas;
                }

                document.getElementById('resVlrFinalBonusOutras').innerHTML = dados.bonusOutrasAreas;
                document.getElementById('valorFinalRVOutras').innerHTML = dados.rvOutrasAreas;

                // GRÁFICO HISTORICO
                var options = {
                    maintainAspectRatio: false,
                    responsive: true,
                    plugins: { legend: { display: false } },
                    layout: { padding: { right: 17, left: 15, top: 15 } },
                    scales: {
                        x: { display: true, grid: { display: false } },
                        y: { display: false, grid: { display: false } }
                    },
                }

                const dataRV = {
                    labels: dados.legends_graf,
                    datasets: [{
                        type: 'line',
                        label: 'Historico Quadrante',
                        backgroundColor: (context) => {
                            const bgColor = [
                                'rgba(26, 188, 156, 1)',
                                'rgba(76, 196, 172, .7)',
                                // 'rgba(136, 206, 191, .5)',
                                'rgba(194, 249, 237, .5)',
                            ];
                            if (!context.chart.chartArea) {
                                return;
                            }
                            const { ctx, data, chartArea: { top, bottom } } = context.chart;
                            const gradientBg = ctx.createLinearGradient(0, top, 0, bottom);
                            const colorTranches = 1 / (bgColor.length - 1);
                            for (let i = 0; i < bgColor.length; i++) {
                                gradientBg.addColorStop(0 + i * colorTranches, bgColor[i])
                            }
                            return gradientBg;
                        },
                        pointBachgroundColor: '#000',
                        fill: true,
                        data: dados.histRV,
                        tension: 0.3,
                        datalabels: {
                            align: 'start',
                            anchor: 'end',
                            align: 'end',
                            color: '#000',
                            font: {
                                size: 10
                            }
                        },
                        order: 1
                    }]
                };

                new Chart("myChart2", {
                    data: dataRV,
                    options: options,
                    plugins: [ChartDataLabels]
                })
            }


        })
        .catch(error => {
            console.error('Erro:', error);
        });
}

function conRvEquipe(chapaUser, funcaoUser, otherTable = false) {
    showLoad();
    // alert(otherTable)
    fetch('rvAcoes.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            action: 'conRvEquipe',
            chapaUser: chapaUser,
            funcaoUser: funcaoUser,
            otherTable: otherTable
        })
    })

        .then(response => response.text())
        .then(data => {
            hideLoad();
            var dados = JSON.parse(data);
            // console.log(dados.testess)
            if (otherTable == false) {
                // SUPERVISORES
                document.getElementById('totLideres').innerHTML = dados.totLideres;
                document.getElementById('resTotRvLideres').innerHTML = dados.resTotRvLideres;
                document.getElementById('tbl_res_lideres').innerHTML = dados.tbl_res_lideres;

                // TÉCNICOS
                document.getElementById('totTecnicos').innerHTML = dados.totTecnicos;
                document.getElementById('resTotRvTecnicos').innerHTML = dados.resTotRvTecnicos;

                document.getElementById('totNivelA').innerHTML = dados.totNivelA;
                document.getElementById('totNivelB').innerHTML = dados.totNivelB;
                document.getElementById('totNivelC').innerHTML = dados.totNivelC;
                document.getElementById('totNivelD').innerHTML = dados.totNivelD;

                document.getElementById('totRvNivelA').innerHTML = dados.totRvNivelA;
                document.getElementById('totRvNivelB').innerHTML = dados.totRvNivelB;
                document.getElementById('totRvNivelC').innerHTML = dados.totRvNivelC;
                document.getElementById('totRvNivelD').innerHTML = dados.totRvNivelD;

                // TABELA TÉCNICOS
                document.getElementById('div_tbl_res_TEC').innerHTML = dados.tbl_res_TEC;
                $('#tbl_res_TEC').DataTable({
                    "bJQueryUI": true,
                    "searching": true,
                    "paging": false,
                    "oLanguage": {
                        "sProcessing": "Processando...",
                        "sLengthMenu": "Mostrar _MENU_ registros",
                        "sZeroRecords": "Não foram encontrados resultados",
                        "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                        "sInfoEmpty": "Mostrando de 0 até 0 de 0 registros",
                        "sInfoFiltered": "",
                        "sInfoPostFix": "",
                        "sUrl": "",
                        "oPaginate": {
                            "sFirst": "Primeiro",
                            "sPrevious": "Anterior",
                            "sNext": "Seguinte",
                            "sLast": "Último"
                        }
                    }
                });
                

            } else {
                dvCardInfo1.style.display = 'none';
                dvCardInfo2.style.display = 'none';
                tagTitle1.style.display = 'none';
                dvTableOther.style.width = '90%';

                // TÉCNICOS
                document.getElementById('totTecnicos').innerHTML = dados.totFunc;
                document.getElementById('resTotRvTecnicos').innerHTML = dados.totRVEquipe;

                // TABELA TÉCNICOS
                document.getElementById('div_tbl_res_TEC').innerHTML = dados.tbl_res_TEC;
                $('#tbl_res_TEC').DataTable({
                    "bJQueryUI": true,
                    "searching": true,
                    "paging": false,
                    "oLanguage": {
                        "sProcessing": "Processando...",
                        "sLengthMenu": "Mostrar _MENU_ registros",
                        "sZeroRecords": "Não foram encontrados resultados",
                        "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                        "sInfoEmpty": "Mostrando de 0 até 0 de 0 registros",
                        "sInfoFiltered": "",
                        "sInfoPostFix": "",
                        "sUrl": "",
                        "oPaginate": {
                            "sFirst": "Primeiro",
                            "sPrevious": "Anterior",
                            "sNext": "Seguinte",
                            "sLast": "Último"
                        }
                    }
                });
            }



        })
        .catch(error => {
            console.error('Erro:', error);
        });
}

document.addEventListener('DOMContentLoaded', () => {
    const dadosSection = document.querySelector('[data_funcao]');
    if (!dadosSection) return;

    const funcaoUsuario = dadosSection.getAttribute('data_funcao');
    const funcao = funcaoUsuario.split(' ')[0].toUpperCase();

    const cargosLideranca = ['SUPERVISOR', 'COORDENADOR', 'GERENTE', 'LIDER', 'ENCARREGADO', 'GESTOR'];
    const contemCargoLideranca = cargosLideranca.some(cargo => funcao.includes(cargo));

    // PRIMEIRO VAI VERIFICAR SE É ALGUM CARGO DE LIDERANÇA
    // CASO NÃO SEJA VAI CHAMAR A FUNÇÃO DA conMinhaRV() TRAZENDO OS DADOS INDIVIDUAIS DO USUÁRIO
    if (!contemCargoLideranca) {

        // VAI VERIFICAR OS FUNCIONÁRIOS SE NÃO ESTÃO DENTRE OS CARGOS ABAIXO (SÃO CARGOS DE TÉCNICOS QUE ENCERRAM ATIVIDADES)
        if (funcao == 'AGENTE' || funcao == 'INSTALADOR' || funcao == 'AUXILIAR' || funcao == 'REPARADOR' || funcao == 'TECNICO' || funcao == 'TRAINEE') {
            conMinhaRV(chapaUser, funcao); // NÃO REPASSANDO O 3° PARÂMETRO SIGNIFICA QUE VAI CONSULTAR ESSE USUÁRIO NA TABELA DE RV DE FUNCIONÁRIOS QUE ENCERRAM ATIVIDADES
            guiaMinhaRV.style.display = 'flex';
            if (guiaRvEquipe) guiaRvEquipe.style.display = 'none';
            if (guiaRvEquipeOutras) guiaRvEquipeOutras.style.display = 'none';

        } else {// CASO O CARGO DO USUÁRIO NÃO SE ENCONTRA NAS OPÇÕES ACIMA, VAI REALIZAR A CONSULTA NA BASE DE OUTRAS ÁREAS, ONDE ESTÃO FUNCIONÁRIOS DO CL/SEF
            if (guiaMinhaRV) guiaMinhaRV.style.display = 'none';
            if (guiaRvEquipe) guiaRvEquipe.style.display = 'none';
            guiaRvEquipeOutras.style.display = 'flex';
            conMinhaRV(chapaUser, funcao, true);
        }

    } else { 
        // SE TIVER ALGUM CARGO DE LIDERANÇA, VAI VERIFICAR SE DENTRO DESSES CARGOS TEM OS CARGOS DO CL/SEF, 
        // PARA INCLUIR UM PARAMENTRO NA CHAMADA DA FUNÇÃO QUE VAI ALTERAR A TABELA A SER CONSULTADA

        const cargosOutrasAreasLideranca = [
            'SUPERVISOR CONTROLE LOCAL', 
            'SUPERVISOR REG GESTAO QUALIDADE', 
            'COORDENADOR CONTROLE LOCAL', 
            'COORDENADOR REG GESTAO QUALIDADE', 
            'COORDENADOR REG SISTEMAS INFORMACAO',
            'ENCARREGADO EQUIPE I',
            'ENCARREGADO CONTROLE LOCAL'
        ];
        const contemCargoOutrasAreasLideranca = cargosOutrasAreasLideranca.some(cargoOutras => funcaoUsuario.includes(cargoOutras));

        if (contemCargoOutrasAreasLideranca) {// VERIFICA SE É ALGUM CARGO DE LIDERANÇA DA ORIGEM APOIO
            conMinhaRV(chapaUser, funcao, true);
            conRvEquipe(chapaUser, funcao, true);
            guiaMinhaRV.style.display = 'none';
            guiaRvEquipeOutras.style.display = 'flex';
            guiaRvEquipe.style.display = 'flex';
        } else { // CASO SEJA DA ORIGIM APOIO E NÃO SEJA CARGO DE LIDERANÇA
            conMinhaRV(chapaUser, funcao);
            conRvEquipe(chapaUser, funcao);
            guiaMinhaRV.style.display = 'flex';
            guiaRvEquipe.style.display = 'flex';
            guiaRvEquipeOutras.style.display = 'none';
        }

    }

});
