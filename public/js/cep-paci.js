function limpa_formulário_cep() {
    // Limpa os campos de endereço
    document.getElementById('rua_paci').value = "";
    document.getElementById('bairro_paci').value = "";
    document.getElementById('cidade_paci').value = "";
    document.getElementById('uf_paci').value = "";
    document.getElementById('cod_ibge_paci').value = "";
}

function meu_callback(conteudo) {
    if (!("erro" in conteudo)) {
        // Atualiza os campos com os valores recebidos do ViaCEP
        document.getElementById('rua_paci').value = conteudo.logradouro;
        document.getElementById('bairro_paci').value = conteudo.bairro;
        document.getElementById('cidade_paci').value = conteudo.localidade;
        document.getElementById('uf_paci').value = conteudo.uf;
    } else {
        // Caso o CEP não seja encontrado
        limpa_formulário_cep();
        alert("CEP não encontrado.");
    }
}

function pesquisacep(valor) {
    // Remove tudo que não for número
    var cep = valor.replace(/\D/g, '');

    // Verifica se o CEP possui valor e é válido
    if (cep != "") {
        var validacep = /^[0-9]{8}$/; // Validação do formato do CEP

        if (validacep.test(cep)) {
            // Preenche os campos com "..." enquanto consulta o webservice
            document.getElementById('rua_paci').value = "...";
            document.getElementById('bairro_paci').value = "...";
            document.getElementById('cidade_paci').value = "...";
            document.getElementById('uf_paci').value = "...";

            // Cria um script para fazer a consulta no ViaCEP
            var script = document.createElement('script');
            script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';
            document.body.appendChild(script);
        } else {
            // Caso o CEP seja inválido
            limpa_formulário_cep();
            alert("Formato de CEP inválido.");
        }
    } else {
        // Caso o campo de CEP esteja vazio, limpa o formulário
        limpa_formulário_cep();
    }
}

function formatCEP(cep) {
    // Formata o CEP para o formato correto
    return cep.replace(/^(\d{5})(\d{3})$/, '$1-$2');
}
