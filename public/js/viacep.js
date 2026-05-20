// viacep.js - Script Universal para Busca de CEP
// Substitui antigas redundâncias (cep.js, cep-paci.js, validate-cep.js)

(function(window) {
    "use strict";

    // Detecta dinamicamente qual sufixo de ID está sendo usado na página atual
    function getSuffix() {
        if (document.getElementById('rua_paci')) return '_paci';
        if (document.getElementById('rua_clin')) return '_clin';
        return ''; // Fallback genérico
    }

    function limpa_formulario_cep(suffix) {
        const fields = ['rua', 'bairro', 'cidade', 'uf', 'cod_ibge'];
        fields.forEach(field => {
            const el = document.getElementById(field + suffix);
            if (el) el.value = "";
        });
    }

    // Função de callback acionada pelo JSONP do ViaCEP
    window.viacep_callback = function(conteudo) {
        const suffix = getSuffix();
        
        if (!("erro" in conteudo)) {
            const map = {
                'rua': conteudo.logradouro,
                'bairro': conteudo.bairro,
                'cidade': conteudo.localidade,
                'uf': conteudo.uf,
                'cod_ibge': conteudo.ibge
            };

            Object.keys(map).forEach(key => {
                const el = document.getElementById(key + suffix);
                if (el) el.value = map[key] || "";
            });
        } else {
            limpa_formulario_cep(suffix);
            alert("CEP não encontrado.");
        }
    };

    // Chamado pelo evento onblur no HTML
    window.pesquisacep = function(valor) {
        const cep = valor.replace(/\D/g, '');
        const suffix = getSuffix();

        if (cep !== "") {
            const validacep = /^[0-9]{8}$/;

            if(validacep.test(cep)) {
                const fields = ['rua', 'bairro', 'cidade', 'uf', 'cod_ibge'];
                fields.forEach(field => {
                    const el = document.getElementById(field + suffix);
                    if (el) el.value = "...";
                });

                const script = document.createElement('script');
                script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=viacep_callback';
                document.body.appendChild(script);
            } else {
                limpa_formulario_cep(suffix);
                alert("Formato de CEP inválido.");
            }
        } else {
            limpa_formulario_cep(suffix);
        }
    };

    // Chamado pelo evento oninput no HTML
    window.formatCEP = function(cep) {
        return cep.replace(/^(\d{5})(\d{3})$/, '$1-$2');
    };

})(window);
