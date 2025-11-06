// ARRAY DE UFS POR REGIONAL
const ufList = [
    { regional: 'RCO', uf: ['', 'AC', 'DF', 'GO', 'MS', 'MT', 'RO', 'TO'] },
    { regional: 'RMG', uf: ['', 'MG', 'ES'] },
    { regional: 'RSUL', uf: ['', 'RS'] },
    { regional: 'RSP', uf: ['', 'SP'] }
];

// PREENCHER AS UFS DE ACORDO COM O FILTRO DA REGIONAL
const selectRegional = document.getElementById('slt_regional');
selectRegional.addEventListener('change', function() {
    
    const selectedRegional = ufList.find(item => item.regional === selectRegional.value);
    const ufSelect = document.getElementById('slt_uf');
    ufSelect.innerHTML = '';

    if (selectedRegional) {
        selectedRegional.uf.forEach(uf => {
            const option = document.createElement('option');
            option.value = uf;
            option.textContent = uf;
            ufSelect.appendChild(option);
        });
    }
});

// RECARREGAR A PÁGINA NO CASO DO USO (LIMPAR FILTROS)
const btnClearFilter = document.getElementById('btnClearFilter');
btnClearFilter.addEventListener('click', function() {
    window.location.reload();
});

// VALIDAÇÃO PARA ABRIR OS SELECTS DE UF
function validarRegionalAntesDeAbrir(selectId) {
    const regional = document.getElementById('slt_regional').value;
    if (!regional) {
        Swal.fire({
            text: "Por favor, selecione uma Regional primeiro.",
            customClass: {
                popup: 'swal-small-text'
            }
        });
        return false; // bloqueia
    }
    return true;
}

['slt_uf'].forEach(id => {
    document.getElementById(id).addEventListener('click', function(e) {
        if (!validarRegionalAntesDeAbrir(id)) {
            e.preventDefault(); // impede abrir o dropdown
        }
    });
});

document.addEventListener('DOMContentLoaded', () => {

    const slt_uf           = document.getElementById('slt_uf');
    const slt_gerente      = document.getElementById('slt_gerente');
    const slt_coordenador  = document.getElementById('slt_coordenador');
    const slt_supervisor   = document.getElementById('slt_supervisor');

    // Quando selecionar UF → buscar GERENTES
    slt_uf.addEventListener('change', async () => {
        clearSelects([slt_gerente, slt_coordenador, slt_supervisor]);
        const dataForm = { uf: slt_uf.value };
        const data = await verifyFilter(dataForm);
        populateSelect(slt_gerente, data);
    });

    // Quando selecionar GERENTE → buscar COORDENADORES
    slt_gerente.addEventListener('change', async () => {
        clearSelects([slt_coordenador, slt_supervisor]);
        const dataForm = { uf: slt_uf.value, gerente: slt_gerente.value };
        const data = await verifyFilter(dataForm);
        populateSelect(slt_coordenador, data);
    });

    // Quando selecionar COORDENADOR → buscar SUPERVISORES
    slt_coordenador.addEventListener('change', async () => {
        clearSelects([slt_supervisor]);
        const dataForm = { uf: slt_uf.value, gerente: slt_gerente.value, coordenador: slt_coordenador.value };
        const data = await verifyFilter(dataForm);
        populateSelect(slt_supervisor, data);
    });

});

// Limpa selects dependentes
function clearSelects(selects) {
    selects.forEach(sel => sel.innerHTML = `<option value="" selected disabled>Selecione...</option>`);
}

// Preenche um select com um array retornado
function populateSelect(selectElement, data) {
    data.forEach(item => {
        const option = document.createElement('option');
        option.value = item;
        option.textContent = item;
        selectElement.appendChild(option);
    });
}

// Função fetch dos Filtros - carregar os options dos filtros
async function verifyFilter(dataForm) {
    const spinner = document.getElementById('loadingSpinner');
    spinner.classList.remove('d-none');

    try {
        const response = await fetch('dono_de_area.php?page=verifyFilter', {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(dataForm)
        });

        if (!response.ok) throw new Error('Network response was not ok');
        return await response.json();

    } catch (error) {
        console.error('Erro na requisição fetch:', error);
        return {};
    } finally {
        spinner.classList.add('d-none');
    }
}

// Função fetch para carregar a tabela com os filtros depois do submit
async function carregarTabelaComFiltros() {
    const tblElegiveis = document.getElementById('tblElegiveis');
    const spinner = document.getElementById('loadingSpinner');

    const dataForm = {
        regional: document.getElementById('slt_regional').value,
        uf:       document.getElementById('slt_uf').value,
        gerente:  document.getElementById('slt_gerente').value,
        coordenador: document.getElementById('slt_coordenador').value,
        supervisor:  document.getElementById('slt_supervisor').value
    };

    spinner.classList.remove('d-none');

    try {
        const response = await fetch('dono_de_area.php?page=buscarElegiveis', {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(dataForm)
        });

        if (!response.ok) throw new Error('Erro na requisição');

        const data = await response.json();

        tblElegiveis.innerHTML = renderTable(data);

        if ($.fn.DataTable.isDataTable('#tableResult')) {
            $('#tableResult').DataTable().destroy();
        }

        $('#tableResult').DataTable({
            pageLength: 10,
            scrollY: '600px',
            scrollCollapse: true,
            autoWidth: false,
            columnDefs: [{ targets: [6,7,8,9], width: '130px' }],
            language: { url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json' }
        });

        // inicializa bootstrap-select
        setTimeout(() => {
            $('.selectpicker').selectpicker('render');
        }, 10);

    } catch (error) {
        console.error('Erro na requisição fetch:', error);
        tblElegiveis.innerHTML = `<div class="alert alert-danger">Erro ao carregar dados</div>`;
    } finally {
        spinner.classList.add('d-none');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('formFilter');

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        carregarTabelaComFiltros();
    });
});

// tabela
function renderTable(data) {
    if (!data || !data.length) 
        return '<div class="alert alert-info">Nenhum registro encontrado</div>';

    let html = `
    <table id="tableResult" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>CHAPA</th>
                <th>NOME</th>
                <th>AREA</th>
                <th>CENTRO DE CUSTO</th>
                <th>CARGO</th>
                <th>EIXO</th>
                <th>SEGMENTO</th>
                <th>UF</th>
                <th>Elegível</th>
                <th>Editar</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
    `;

    data.forEach(row => {
        const jaSalvo = row.JA_SALVO ? true : false;
        const ufSelecionadas = jaSalvo && row.UF ? row.UF.split(',') : [];

        html += `<tr data-ja-cadastrado="${jaSalvo ? 1 : 0}">
            <td>${row.CHAPA}</td>
            <td>${row.NOME}</td>
            <td>${row.AREA}</td>
            <td>${row.CENTRO_DE_CUSTO}</td>
            <td>${row.CARGO}</td>

            <td>
                <select class="form-select form-select-sm eixo-select" ${jaSalvo ? 'disabled' : ''}>
                    <option value="">Selecione</option>
                    <option value="OPERACIONAL" ${row.EIXO === 'OPERACIONAL' ? 'selected' : ''}>Operacional</option>
                    <option value="LIDERANCA" ${row.EIXO === 'LIDERANCA' ? 'selected' : ''}>Liderança</option>
                </select>
            </td>
        `;

        if (row.AREA === 'TECNICO') {
            html += `
                <td>${row.SEGMENTO}</td>
                <td>${row.UF}</td>
            `;
        } else {

            html += `
                <td>
                    <select class="selectpicker segmento-select" multiple data-live-search="true" data-actions-box="true" ${jaSalvo ? 'disabled' : ''}>   
                        <option value="DADOS" ${row.SEGMENTO === 'DADOS' ? 'selected' : ''}>DADOS</option>
                        <option value="FO" ${row.SEGMENTO === 'FO' ? 'selected' : ''}>FO</option>
                        <option value="FTTH" ${row.SEGMENTO === 'FTTH' ? 'selected' : ''}>FTTH</option>
                    </select>
                </td>

                <td>
                    <select class="selectpicker uf-select" multiple data-live-search="true" data-actions-box="true" ${jaSalvo ? 'disabled' : ''}>
                        ${
                            ufList
                                .flatMap(r => r.uf.filter(u => u !== "")
                                .map(uf => {
                                    const selecionado = row.UF
                                        ? row.UF.split(',').map(u => u.trim()).includes(uf)
                                        : false;
                                    return `<option value="${uf}" ${selecionado ? 'selected' : ''}>${uf}</option>`;
                                }))
                                .join('')
                        }
                    </select>
                </td>
            `;
            // <td class="regional-output">${regionaisSelecionadas.join(', ')}</td>
        }


        html += `
            <td>
                <select class="form-select form-select-sm elegivel-select" ${jaSalvo ? 'disabled' : ''}>
                    <option value="">Selecione</option>
                    <option value="SIM" ${row.ELEGIVEL === 'SIM' ? 'selected' : ''}>Sim</option>
                    <option value="NÃO" ${row.ELEGIVEL === 'NÃO' ? 'selected' : ''}>Não</option>
                </select>
            </td>

            <td><button class="btn btn-sm btn-warning editar-linha" ${jaSalvo ? '' : 'disabled'}>Editar</button></td>
            <td><button class="btn btn-sm btn-success salvar-linha" ${jaSalvo ? 'disabled' : ''}>Salvar</button></td>
        </tr>`;
    });

    html += '</tbody></table>';

    setTimeout(() => {
        $('.selectpicker').selectpicker('refresh');
    }, 0);

    return html;
}

// verifica o btn de editar para ver se vai habilitar   
$(document).on('click', '.editar-linha', function() {
    const tr = $(this).closest('tr');
    tr.find('select').prop('disabled', false);
    tr.find('.salvar-linha').prop('disabled', false);
});

// Salvar linha
// $(document).on('click', '.salvar-linha', async function () {

//     const tr = $(this).closest('tr');

//     // --- 1) PEGAR UF DO SELECT ---
//     let selectedUFs = tr.find('.uf-select').selectpicker('val') || [];
//     if (!Array.isArray(selectedUFs)) selectedUFs = [selectedUFs];
//     selectedUFs = selectedUFs.map(u => String(u).trim()).filter(u => u !== '');

//     // --- 2) PEGAR SEGMENTO DO SELECT ---
//     let selectedSegmentos = tr.find('.segmento-select').selectpicker('val') || [];
//     if (!Array.isArray(selectedSegmentos)) selectedSegmentos = [selectedSegmentos];
//     selectedSegmentos = selectedSegmentos.map(u => String(u).trim()).filter(u => u !== '');

//     // --- 3) CALCULAR REGIONAIS (SEM REPETIR) ---
//     const regionais = ufList
//         .filter(r => r.uf.some(uf => selectedUFs.includes(String(uf).trim())))
//         .map(r => r.regional);

//     const regionalStr = [...new Set(regionais)].join(','); // remove duplicados

//     // --- 3) MONTAR PAYLOAD ---
//     const data = {
//         NOME_USER: $('input[name="nomeUSER"]').val() || '',
//         CHAPA: tr.find('td:eq(0)').text(),
//         NOME: tr.find('td:eq(1)').text(),
//         AREA: tr.find('td:eq(3)').text(),
//         CENTRO_DE_CUSTO: tr.find('td:eq(4)').text(),
//         CARGO: tr.find('td:eq(5)').text(),
//         EIXO: tr.find('.eixo-select').val() || '',

//         // UF salva como string
//         SEGMENTO: selectedSegmentos.join(','),

//         // UF salva como string
//         UF: selectedUFs.join(','),

//         // REGIONAL calculada agora
//         REGIONAL: regionalStr,

//         ELEGIVEL: tr.find('.elegivel-select').val() || '',

//         // flag para update
//         JA_CADASTRADO: tr.data('ja-cadastrado') ? 1 : 0
//     };

//     // --- 4) VALIDAÇÃO ---
//     if (!data.EIXO || !data.ELEGIVEL) {
//         Swal.fire({
//             icon: 'warning',
//             title: 'Campos obrigatórios',
//             text: 'Selecione EIXO e ELEGÍVEL antes de salvar.'
//         });
//         return;
//     }

//     // --- 5) ENVIAR ---
//     try {
//         const response = await fetch('dono_de_area.php?page=saveElegiveis', {
//             method: 'POST',
//             headers: { 
//                 'Content-Type': 'application/json',
//                 'X-Requested-With': 'XMLHttpRequest'
//             },
//             body: JSON.stringify([data])
//         });

//         const result = await response.json();

//         if (result.status === 'ok') {
//             Swal.fire({
//                 icon: 'success',
//                 title: 'Salvo!',
//                 text: 'Registro salvo com sucesso.'
//             }).then(() => {
//                 carregarTabelaComFiltros();
//             });
//         }

//     } catch (err) {
//         console.error(err);
//         Swal.fire({
//             icon: 'error',
//             title: 'Erro',
//             text: 'Falha ao salvar registro.'
//         });
//     }
// });
$(document).on('click', '.salvar-linha', async function () {

    const tr = $(this).closest('tr');

    let UF = '';
    let SEGMENTO = '';

    const area = tr.find('td:eq(2)').text().trim();

    if (area === 'TECNICO') {
        // pega diretamente o texto da tabela
        SEGMENTO = tr.find('td:eq(6)').text().trim();
        UF = tr.find('td:eq(7)').text().trim();
    } else {

        // MULTIPLO
        let selectedUFs = tr.find('.uf-select').selectpicker('val') || [];
        if (!Array.isArray(selectedUFs)) selectedUFs = [selectedUFs];
        selectedUFs = selectedUFs.map(u => String(u).trim()).filter(u => u !== '');
        UF = selectedUFs.join(',');

        let selectedSegmentos = tr.find('.segmento-select').selectpicker('val') || [];
        if (!Array.isArray(selectedSegmentos)) selectedSegmentos = [selectedSegmentos];
        selectedSegmentos = selectedSegmentos.map(u => String(u).trim()).filter(u => u !== '');
        SEGMENTO = selectedSegmentos.join(',');
    }

    // REGIONAL pelo UF agora funciona certinho
    const regionais = ufList
        .filter(r => UF.split(',').some(u => r.uf.includes(u)))
        .map(r => r.regional);

    const regionalStr = [...new Set(regionais)].join(',');

    const data = {
        NOME_USER: $('input[name="nomeUSER"]').val() || '',
        CHAPA: tr.find('td:eq(0)').text(),
        NOME: tr.find('td:eq(1)').text(),
        AREA: area,
        CENTRO_DE_CUSTO: tr.find('td:eq(3)').text(),
        CARGO: tr.find('td:eq(4)').text(),
        EIXO: tr.find('.eixo-select').val() || '',
        SEGMENTO: SEGMENTO,
        UF: UF,
        REGIONAL: regionalStr,
        ELEGIVEL: tr.find('.elegivel-select').val() || '',
        JA_CADASTRADO: tr.data('ja-cadastrado') ? 1 : 0
    };

    if (!data.EIXO || !data.ELEGIVEL) {
        Swal.fire({ icon: 'warning', title: 'Campos obrigatórios', text: 'Selecione EIXO e ELEGÍVEL antes de salvar.' });
        return;
    }

    try {
        const response = await fetch('dono_de_area.php?page=saveElegiveis', {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify([data])
        });

        const result = await response.json();

        if (result.status === 'ok') {
            Swal.fire({ icon: 'success', title: 'Salvo!', text: 'Registro salvo com sucesso.' })
                .then(() => carregarTabelaComFiltros());
        }

    } catch (err) {
        console.error(err);
        Swal.fire({ icon: 'error', title: 'Erro', text: 'Falha ao salvar registro.' });
    }
});


// Função para bloquear a linha após salvar
function bloquearLinha(tr) {
    tr.find('select').attr('disabled', true);
    tr.find('.salvar-linha').attr('disabled', true).text('Salvo');
}

// Enable e Disabled os Selects
$(document).on('click', '.editar-linha', function () {
    const tr = $(this).closest('tr');

    // habilita selects normais
    tr.find('select').prop('disabled', false);

    // habilita selectpicker (UF)
    tr.find('.selectpicker').prop('disabled', false).selectpicker('refresh');

    // habilita botão Salvar
    tr.find('.salvar-linha').prop('disabled', false);

    // desabilita botão Editar enquanto edita
    $(this).prop('disabled', true);

    // marca para salvar como update
    tr.data('ja-cadastrado', 1);
});









