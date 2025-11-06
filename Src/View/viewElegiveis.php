<link rel="stylesheet" href="/pci/d_area/Public/css/elegiveis.css">
<link rel="stylesheet" 
    href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" 
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" 
    crossorigin="anonymous"
>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select/dist/css/bootstrap-select.min.css">


<div class="container-fluid">

    <form action="#" class="container d-flex p-2" id="formFilter">

        <select name="slt_regional" id="slt_regional" class="form-control mr-2" title="Selecione uma Regional">
            <option selected disabled>Regional</option>
            <option value="RCO">RCO</option>
            <option value="RMG">RMG</option>
            <option value="RSUL">RSUL</option>
            <option value="RSP">RSP</option>
        </select>

        <select name="slt_uf" id="slt_uf" class="form-control mr-2" title="Selecione uma UF">
            <option selected disabled>UF</option>
        </select>

        <select name="slt_gerente" id="slt_gerente" class="form-control mr-2" title="Gerente">
            <option selected disabled value="">Gerente</option>
        </select>

        <select name="slt_coordenador" id="slt_coordenador" class="form-control mr-2" title="Coordenador">
            <option selected disabled value="">Coordenador</option>
        </select>

        <select name="slt_supervisor" id="slt_supervisor" class="form-control mr-2" title="Supervisor">
            <option selected disabled value="">Supervisor</option>
        </select>

        <button type="button" class="btn btn-danger form-control mr-2" title="Limpar Filtros" id="btnClearFilter">
            <i class="bi bi-x-circle"></i>
        </button>

        <button type="submit" class="btn btn-primary form-control mr-2" title="Buscar" id="btnRequest">
            <i class="bi bi-search"></i>
        </button>

        <a href="/pci/d_area/dono_de_area.php" 
            class="btn btn-secondary form-control mr-2 d-flex justify-content-center align-items-center"
            target="_blank" rel="noopener noreferrer">
                <i class="bi bi-house-door-fill"></i>
        </a>


    </form>

    <input type="hidden" name="nomeUSER" value="<?= $nomeUser?>">
    <!-- Tabela agora é <table> para o DataTables -->
    <div id="tblElegiveis"></div>

    <div id="loadingSpinner" class="d-none text-center my-3">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Carregando...</span>
        </div>
    </div>

</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="/pci/d_area/Public/js/api.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap-select/dist/js/bootstrap-select.min.js"></script>






