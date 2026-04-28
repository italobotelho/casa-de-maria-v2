// Função para aplicar a máscara de CPF
function aplicarMascaraCPF(input) {
    let cpf = input.value.replace(/\D/g, ''); // Remove tudo que não for dígito
    if (cpf.length <= 11) {
        cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
        cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
        cpf = cpf.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    }
    input.value = cpf;
}

// Função para validar CPF
function TestaCPF(strCPF) {
    var Soma;
    var Resto;
    Soma = 0;

    // CPF inválido se todos os dígitos forem iguais
    if (/^(\d)\1{10}$/.test(strCPF)) return false;

    for (let i = 1; i <= 9; i++) Soma += parseInt(strCPF.charAt(i - 1)) * (11 - i);
    Resto = (Soma * 10) % 11;

    if (Resto === 10 || Resto === 11) Resto = 0;
    if (Resto !== parseInt(strCPF.charAt(9))) return false;

    Soma = 0;
    for (let i = 1; i <= 10; i++) Soma += parseInt(strCPF.charAt(i - 1)) * (12 - i);
    Resto = (Soma * 10) % 11;

    if (Resto === 10 || Resto === 11) Resto = 0;
    return Resto === parseInt(strCPF.charAt(10));
}

// Função para alternar campos de responsável com base na idade
document.addEventListener('DOMContentLoaded', function () {
    const dataNasciInput = document.getElementById('data_nasci_paci');
    const responsavelFields = document.getElementById('responsavel-fields');

    function toggleResponsavelFields() {
        const birthDate = new Date(dataNasciInput.value);
        const age = new Date().getFullYear() - birthDate.getFullYear();

        if (age < 18) {
            responsavelFields.style.display = 'block';
            document.getElementById('cpf_responsavel_paci').setAttribute('required', true);
            document.getElementById('responsavel_paci').setAttribute('required', true);
        } else {
            responsavelFields.style.display = 'none';
            document.getElementById('cpf_responsavel_paci').removeAttribute('required');
            document.getElementById('responsavel_paci').removeAttribute('required');
        }
    }

    dataNasciInput.addEventListener('input', toggleResponsavelFields);
    toggleResponsavelFields(); // Check on page load
});

// Função para carregar convênios
document.addEventListener('DOMContentLoaded', function () {
    fetch('/convenio')
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('fk_convenio_paci');
            data.forEach(convenio => {
                const option = document.createElement('option');
                option.value = convenio.pk_id_conv; // ID do convênio
                option.text = convenio.nome_conv; // Nome do convênio
                select.add(option);
            });
        })
        .catch(error => console.error('Erro ao carregar convênios:', error));
});

  // Função para alternar campo da Carteira do Convênio
// Função para alternar campo da Carteira do Convênio
document.addEventListener('DOMContentLoaded', function () {
    const convenioSelect = document.getElementById('fk_convenio_paci');
    const carteiraConvenioField = document.getElementById('carteira-convenio-field');
    const carteiraConvenioInput = document.getElementById('carteira_convenio_paci');

    convenioSelect.addEventListener('change', function () {
        // Substitua '2' pelo ID correto do convênio "Particular"
        if (this.value === '4') { 
            carteiraConvenioField.style.display = 'none';
            carteiraConvenioInput.removeAttribute('required');
        } else {
            carteiraConvenioField.style.display = 'block';
            carteiraConvenioInput.setAttribute('required', true);
        }
    });
});


// Função para aplicar máscara de telefone
function aplicarMascaraTelefone(input) {
    let telefone = input.value.replace(/\D/g, '');
    telefone = telefone.replace(/(\d{2})(\d)/, '($1) $2');
    telefone = telefone.replace(/(\d{4})(\d)/, '$1-$2');
    input.value = telefone;
}

document.addEventListener('DOMContentLoaded', function () {
    const cpfInput = document.getElementById('cpf_paci');
    cpfInput.addEventListener('input', function () {
        aplicarMascaraCPF(cpfInput);
    });

    // Aplica a máscara no campo de telefone
    const telefoneInput = document.getElementById('telefone_paci');
    telefoneInput.addEventListener('input', function () {
        aplicarMascaraTelefone(telefoneInput);
    });
});




