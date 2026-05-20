@extends('layouts.app')

@section('title', 'PACIENTE')

@section('css')
    <style>
      label {
        font-weight: bold;
        text-transform: uppercase;
      }
    </style>
@endsection

@section('content')<!-- Error and Success Messages -->

@if ($errors->any())
<div class="alert alert-danger my-3">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
<div class="container">
    <x-layout.page-header 
        title="{{ isset($paciente) ? 'Editar Paciente' : 'Cadastrar Paciente' }}" 
        subtitle="Gerencie as informações detalhadas do paciente." 
        actionText="Voltar para a Lista" 
        actionUrl="/pacientes" 
    />

    <form action="{{ isset($paciente) ? route('paciente.update', ['id' => $paciente->pk_cod_paci]) : route('paciente.store') }}" method="POST" id="paciente-form" enctype="multipart/form-data">
        @csrf

        @if(isset($paciente))
         @method('PUT') <!-- Especifica que o método é PUT para atualização -->
        @endif
    <div class="d-flex flex-column flex-lg-row gap-4 mb-5">
        <div class="glass-panel rounded-4 p-4 d-flex flex-column fade-in-up" style="flex: 1; align-self: flex-start; animation-delay: 0.1s;">
            <div class="d-flex flex-column align-items-center text-center">
                <div class="profile-image-container mt-5 mb-2">
                    <!-- Título exibido apenas quando o paciente for encontrado -->
                    <h2 @if(!isset($paciente)) style="visibility: hidden;" @endif>
                        {{ isset($paciente) ? $paciente->nome_paci : '' }}
                    </h2>
                    <img id="img_paci" src="{{ asset('storage/' . (isset($paciente) ? $paciente->img_paci : 'imagens_pacientes/default-profile-pic.png')) }}" alt="Imagem de Perfil" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover; transition: transform 0.5s; transform: rotate({{ isset($paciente) ? $paciente->angulo_rotacao : 0 }}deg);">
                </div>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Ações foto
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" onclick="document.getElementById('uploadImage').click()">Enviar Imagem</a></li>
                        <li><a class="dropdown-item" href="#" onclick="capturarImagem()">Capturar Imagem</a></li>
                        <li><a class="dropdown-item" href="#" onclick="girarImagem()">Girar Foto</a></li>
                    </ul>
                </div>
                
                <!-- Input invisível para upload de imagem -->
                <input type="file" id="uploadImage" name="img_paci" style="display: none;" onchange="carregarImagem(event)">

                <!-- Elemento de vídeo para captura de imagem -->
                <video id="videoStream" style="display: none; width: 150px; height: 150px; object-fit: cover;" autoplay></video>
            </div>

            <div class="my-4">
                <!-- Exibindo Idade com anos, meses e dias com negrito no resultado -->
                <p>Idade: 
                    @if(isset($paciente) && $paciente->data_nasci_paci)
                        @php
                            $dataNascimento = new \Carbon\Carbon($paciente->data_nasci_paci);
                            $idade = $dataNascimento->diff(\Carbon\Carbon::now());
                        @endphp
                        <span class="fw-bold text-end">{{ $idade->y }} anos, {{ $idade->m }} meses e {{ $idade->d }} dias</span>
                    @endif
                </p>

                <!-- Exibindo os outros dados com negrito no resultado -->
                <p>CPF: <span class="fw-bold text-end">{{ isset($paciente) ? $paciente->cpf_paci : '' }}</span></p>
                <p>Celular: <span class="fw-bold text-end">{{ isset($paciente) ? $paciente->telefone_paci : '' }}</span></p>
                <p>E-mail: <span class="fw-bold text-end">{{ isset($paciente) ? $paciente->email_paci : '' }}</span></p>
                <p>Cidade: <span class="fw-bold text-end">{{ isset($paciente) ? $paciente->cidade_paci : '' }}</span></p>
            </div>

            @if(!isset($paciente)) <!-- Exibe o botão apenas se não for atualização -->
            <div class="d-flex justify-content-center mt-4 mb-2">
                <button type="submit" class="btn btn-primary-custom px-4 py-2 rounded-pill w-100">Salvar novo paciente</button>
            </div>
            @endif

            @if(isset($paciente)) <!-- Mostrar botões apenas na atualização -->
                <div class="d-flex flex-column justify-content-center mt-4 mb-2 gap-2">
                    <!-- Botão Salvar e Sair -->
                    <button type="submit" name="action" value="save_and_exit" class="btn btn-primary-custom px-4 py-2 rounded-pill w-100">
                        Salvar e Sair
                    </button>

                    <!-- Botão Salvar Dados e Continuar -->
                    <button type="submit" name="action" value="save_and_stay" class="btn btn-outline-secondary px-4 py-2 rounded-pill w-100">
                        Salvar Dados
                    </button>
                </div>

                <div class="my-3 text-center">
                    <p>Última alteração feita em: 
                        <span class="fw-bold">
                            @if(isset($paciente) && $paciente->updated_at)
                                {{ \Carbon\Carbon::parse($paciente->updated_at)->format('d/m/Y H:i') }}
                            @endif
                        </span>
                    </p>
                </div>
            @endif
        </div>
        

        <div class="glass-panel rounded-4 p-4 fade-in-up" style="flex: 2; animation-delay: 0.2s;">
            
            {{-- Dados Pessoais --}}
            <div class="row g-3 my-2">
                <h1 class="fs-4">DADOS PESSOAIS</h1>
                <!-- Nome -->
                <x-form.input name="nome_paci" label="Nome Completo" col="8" maxlength="54" :value="$paciente->nome_paci ?? ''" required="true" />

                <!-- Data de Nascimento -->
                <x-form.input name="data_nasci_paci" type="date" label="Data de Nascimento" col="4" :value="isset($paciente) && $paciente->data_nasci_paci ? \Carbon\Carbon::parse($paciente->data_nasci_paci)->format('Y-m-d') : ''" size="8" required="true" />

                {{-- Gênero --}}
                <div class="form-group col-md-2">
                    <label for="genero">Gênero</label>
                    <select name="genero" id="genero" class="form-select">
                        <option value="">Selecione</option>
                        <option value="masc" {{ old('genero', $paciente->genero ?? '') == 'masc' ? 'selected' : '' }}>Masculino</option>
                        <option value="fem" {{ old('genero', $paciente->genero ?? '') == 'fem' ? 'selected' : '' }}>Feminino</option>
                        <option value="nao_informar" {{ old('genero', $paciente->genero ?? '') == 'nao_informar' ? 'selected' : '' }}>Não Informar</option>
                    </select>
                </div>

                <!-- Telefone -->
                <x-form.input name="telefone_paci" label="Telefone" col="4" maxlength="15" :value="$paciente->telefone_paci ?? ''" oninput="aplicarMascaraTelefone(this);" required="true" />

                <!-- Email -->
                <x-form.input name="email_paci" type="email" label="E-mail" col="6" maxlength="100" :value="$paciente->email_paci ?? ''" required="true" />

                <!-- CPF Paciente -->
                <div class="form-group col-md-4">
                    <label for="cpf_paci">CPF</label>
                    <input maxlength="14" type="text" class="form-control" id="cpf_paci" name="cpf_paci" value="{{ old('cpf_paci', $paciente->cpf_paci ?? '') }}" required oninput="aplicarMascaraCPF(this);">
                    <span id="cpf-error" style="color: red;"></span>
                </div>

                <!-- Adicionando o valor de fk_convenio_paci ao HTML -->
                <input type="hidden" id="paciente_fk_convenio_paci" value="{{ $paciente->fk_convenio_paci ?? '' }}">

                <!-- Convênio -->
                <div class="form-group col-md-4">
                    <label for="fk_convenio_paci">Convênio</label>
                    <select name="fk_convenio_paci" class="form-select" id="fk_convenio_paci" required>
                        <option value="">Selecione um convênio</option>
                    </select>
                </div>

                <!-- Carteira do Convênio -->
                <div class="form-group col-md-4" id="carteira-convenio-field">
                    <label for="carteira_convenio_paci">Carteira do Convênio</label>
                    <input maxlength="12" type="text" class="form-control" id="carteira_convenio_paci" name="carteira_convenio_paci" value="{{ old('carteira_convenio_paci', $paciente->carteira_convenio_paci ?? '') }}" required>
                </div>
            </div>

            {{-- Endereço --}}
            <div class="row g-3 my-2">
                <h2 class="fs-4">ENDEREÇO</h2>
                <x-form.input name="cep_paci" label="CEP" col="2" maxlength="9" :value="$paciente->cep_paci ?? ''" onblur="pesquisacep(this.value)" />
                <x-form.input name="rua_paci" label="LOGRADOURO" col="8" maxlength="60" size="60" :value="$paciente->rua_paci ?? ''" />
                <x-form.input name="numero_paci" type="number" label="NÚMERO" col="2" maxlength="10" size="10" :value="$paciente->numero_paci ?? ''" />
                <x-form.input name="bairro_paci" label="BAIRRO" col="6" maxlength="40" size="40" :value="$paciente->bairro_paci ?? ''" />
                <x-form.input name="cidade_paci" label="CIDADE" col="6" maxlength="40" size="40" :value="$paciente->cidade_paci ?? ''" />
                <x-form.input name="complemento_paci" label="COMPLEMENTO" col="10" maxlength="40" size="40" :value="$paciente->complemento_paci ?? ''" />
                <x-form.input name="uf_paci" label="UF (ESTADO)" col="2" maxlength="2" size="2" :value="$paciente->uf_paci ?? ''" />
            </div>

            <!-- Campos do Responsável -->
            <div class="row g-3 my-2" id="responsavel-fields" style="display: none;">
                <h2 class="fs-4">DADOS FAMILIARES</h2>
                <div class="form-group col-md-7">
                    <label for="responsavel_paci">NOME RESPONSÁVEL</label>
                    <input maxlength="54" type="text" class="form-control" id="responsavel_paci" name="responsavel_paci" value="{{ old('responsavel_paci', $paciente->responsavel_paci ?? '') }}" required>
                </div>
                <div class="form-group col-md-5">
                    <label for="cpf_responsavel_paci">CPF</label>
                    <input maxlength="14" type="text" class="form-control" name="cpf_responsavel_paci" id="cpf_responsavel_paci" value="{{ old('cpf_responsavel_paci', $paciente->cpf_responsavel_paci ?? '') }}" required oninput="aplicarMascaraCPF(this);">
                    <span id="cpf-error-responsavel" style="color: red;"></span>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
    function aplicarMascaraCPF(input) {
        let cpf = input.value.replace(/\D/g, '');
        if (cpf.length <= 11) {
            cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
            cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
            cpf = cpf.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        }
        input.value = cpf;
    }

    function TestaCPF(strCPF) {
        let Soma = 0;
        let Resto;
        strCPF = strCPF.replace(/\D/g, '');
        if (!/^\d{11}$/.test(strCPF) || /^(\d)\1{10}$/.test(strCPF)) return false;

        for (let i = 1; i <= 9; i++) {
            Soma += parseInt(strCPF.charAt(i - 1)) * (11 - i);
        }
        Resto = (Soma * 10) % 11;
        if (Resto === 10 || Resto === 11) Resto = 0;
        if (Resto !== parseInt(strCPF.charAt(9))) return false;

        Soma = 0;
        for (let i = 1; i <= 10; i++) {
            Soma += parseInt(strCPF.charAt(i - 1)) * (12 - i);
        }
        Resto = (Soma * 10) % 11;
        if (Resto === 10 || Resto === 11) Resto = 0;

        return Resto === parseInt(strCPF.charAt(10));
    }

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('paciente-form');
        const cpfInput = document.getElementById('cpf_paci');

        form.addEventListener('submit', function(event) {
            const cpfValue = cpfInput.value.replace(/\D/g, '');
            if (!TestaCPF(cpfValue)) {
                event.preventDefault();
                document.getElementById('cpf-error').textContent = 'CPF inválido!';
            } else {
                document.getElementById('cpf-error').textContent = '';
            }
        });

        cpfInput.addEventListener('input', function() {
            const cpfValue = cpfInput.value.replace(/\D/g, '');
            if (cpfValue.length < 11) {
                document.getElementById('cpf-error').textContent = '';
                return;
            }
            if (!TestaCPF(cpfValue)) {
                document.getElementById('cpf-error').textContent = 'CPF inválido!';
            } else {
                document.getElementById('cpf-error').textContent = '';
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const cpfResponsavelInput = document.getElementById('cpf_responsavel_paci');

        // Validação ao digitar no CPF do responsável
        cpfResponsavelInput.addEventListener('input', function() {
            const cpfValue = cpfResponsavelInput.value.replace(/\D/g, '');
            if (cpfValue.length < 11) {
                document.getElementById('cpf-error-responsavel').textContent = '';
                return;
            }
            if (!TestaCPF(cpfValue)) {
                document.getElementById('cpf-error-responsavel').textContent = 'CPF inválido!';
            } else {
                document.getElementById('cpf-error-responsavel').textContent = '';
            }
        });
    });
    // Função para alternar campos de responsável com base na idade
    document.addEventListener('DOMContentLoaded', function() {
        const dataNasciInput = document.getElementById('data_nasci_paci');
        const responsavelFields = document.getElementById('responsavel-fields');

        function toggleResponsavelFields() {
            const birthDate = new Date(dataNasciInput.value);
            const age = new Date().getFullYear() - birthDate.getFullYear();

            // Verificar se a idade é menor que 18 ou maior que 70 anos
            if (age < 18 || age > 69) {
                responsavelFields.style.display = 'flex';
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


    document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('fk_convenio_paci');
    const pacienteConvenioId = document.getElementById('paciente_fk_convenio_paci').value; // Pega o valor do paciente
    const carteiraConvenioField = document.getElementById('carteira-convenio-field');
    const carteiraConvenioInput = document.getElementById('carteira_convenio_paci');

    // Função para carregar convênios
    fetch('/convenio')
        .then(response => response.json())
        .then(data => {
            data.forEach(convenio => {
                if (convenio.status === 'ativo') { // Verifica se o convênio está ativo
                    const option = document.createElement('option');
                    option.value = convenio.pk_id_conv;
                    option.text = convenio.nome_conv;
                    
                    // Se o convênio do paciente for igual ao id do convênio, marque como selecionado
                    if (convenio.pk_id_conv == pacienteConvenioId) {
                        option.selected = true;
                    }

                    select.add(option);
                }
            });

            // Após carregar as opções, faça a verificação inicial
            verificarCarteiraConvenio();
        })
        .catch(error => console.error('Erro ao carregar convênios:', error));

    // Função para alternar campo da Carteira do Convênio
    function verificarCarteiraConvenio() {
        if (select.value === '1') { // Verifique se o convênio selecionado é "1"
            carteiraConvenioField.style.display = 'none';
            carteiraConvenioInput.removeAttribute('required');
        } else {
            carteiraConvenioField.style.display = 'block';
            carteiraConvenioInput.setAttribute('required', true);
        }
    }

    // Executa a verificação toda vez que o valor do select é alterado
    select.addEventListener('change', verificarCarteiraConvenio);
});


    // Função para aplicar máscara de telefone
    function aplicarMascaraTelefone(input) {
        let telefone = input.value.replace(/\D/g, '');
        telefone = telefone.replace(/(\d{2})(\d)/, '($1) $2');
        telefone = telefone.replace(/(\d{4})(\d)/, '$1-$2');
        input.value = telefone;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const telefoneInput = document.getElementById('telefone_paci');
        telefoneInput.addEventListener('input', function() {
            aplicarMascaraTelefone(telefoneInput);
        });
    });
</script>
<script>
    // Variável para rotação da imagem
    let anguloRotacao = 0;

    // Função para carregar imagem
    function carregarImagem(event) {
        const imagem = document.getElementById('img_paci');
        const arquivo = event.target.files[0];
        if (arquivo) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagem.src = e.target.result;
            }
            reader.readAsDataURL(arquivo);
        }
    }

    // Função para capturar imagem da câmera
    async function capturarImagem() {
        const video = document.getElementById('videoStream');
        const imagem = document.getElementById('img_paci');

        try {
            const stream = await navigator.mediaDevices.getUserMedia({ video: true });
            video.srcObject = stream;
            video.style.display = 'block';
            imagem.style.display = 'none';

            // Capturar a imagem do vídeo ao clicar nele
            video.addEventListener('click', function() {
                const canvas = document.createElement('canvas');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                canvas.getContext('2d').drawImage(video, 0, 0);
                imagem.src = canvas.toDataURL('image/png');
                imagem.style.display = 'block';
                video.style.display = 'none';

                // Parar o stream da câmera
                stream.getTracks().forEach(track => track.stop());
                
                // Convertendo a imagem capturada em Base64 e colocando no input de arquivo
                const base64Image = canvas.toDataURL('image/png');
                const input = document.getElementById('uploadImage');
                const dataUri = base64Image.split(',')[1]; // Remover o prefixo "data:image/png;base64,"
                const blob = dataURItoBlob(dataUri);

                // Criando um File para simular o upload da imagem
                const file = new File([blob], "captura.png", { type: "image/png" });
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                input.files = dataTransfer.files;
            });
        } catch (error) {
            console.error('Erro ao acessar a câmera:', error);
            alert('Não foi possível acessar a câmera.');
        }
    }

    // Função para converter base64 para Blob
    function dataURItoBlob(dataURI) {
        const byteString = atob(dataURI);
        const arrayBuffer = new ArrayBuffer(byteString.length);
        const uintArray = new Uint8Array(arrayBuffer);

        for (let i = 0; i < byteString.length; i++) {
            uintArray[i] = byteString.charCodeAt(i);
        }

        return new Blob([uintArray], { type: 'image/png' });
    }

    // Função para girar a imagem
    function girarImagem() {
        const imagem = document.getElementById('img_paci');
        anguloRotacao += 90;
        imagem.style.transform = `rotate(${anguloRotacao}deg)`;
    }

    // Função para enviar a rotação ao servidor
    function enviarRotacaoParaServidor() {
        const inputRotacao = document.createElement('input');
        inputRotacao.setAttribute('type', 'hidden');
        inputRotacao.setAttribute('name', 'angulo_rotacao');
        inputRotacao.setAttribute('value', anguloRotacao);
        document.getElementById('paciente-form').appendChild(inputRotacao);
    }

    // No envio do formulário, adiciona o ângulo da rotação
    document.getElementById('paciente-form').addEventListener('submit', function(event) {
        enviarRotacaoParaServidor();
    });
</script>
<script src="{{ asset('js/viacep.js') }}"></script>
@endsection