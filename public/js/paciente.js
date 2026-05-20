// paciente.js
// Encapsulando todo o código para evitar poluição do escopo global (IIFE)
(function ($) {
    "use strict";

    // --- FUNÇÕES UTILITÁRIAS ---
    
    function abrirModalPaciente(
        id, nome, dataNasci, convenio, carteira_convenio,
        telefone, cpf, cidade, responsavel, cpfResponsavel
    ) {
        console.log("Dados do Paciente:", { id, nome, dataNasci, convenio, carteira_convenio, telefone, cpf, cidade, responsavel, cpfResponsavel });

        $("#nome-paciente").text(nome);
        $("#data-nascimento").text(dataNasci);
        $("#convenio").text(convenio);
        $("#carteira_convenio").text(carteira_convenio);
        $("#telefone").text(telefone);
        $("#cpf").text(cpf);
        $("#cidade").text(cidade);
        $("#responsavel").text(responsavel);
        $("#cpf-responsavel").text(cpfResponsavel);
        
        $("#pacienteModal").modal("show");
    }

    // Expondo globalmente apenas se estritamente necessário (ex: chamado no onchange do HTML)
    window.buscarConvenios = function() {
        return $.ajax({
            type: "GET",
            url: "/covenios",
            success: function (data) {
                console.log(data);
            },
        });
    };

    function aplicarMascaraCPF(input) {
        let cpf = input.value.replace(/\D/g, "");
        if (cpf.length <= 11) {
            cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
            cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
            cpf = cpf.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
        }
        input.value = cpf;
    }

    function aplicarMascaraTelefone(input) {
        let telefone = input.value.replace(/\D/g, "");
        telefone = telefone.replace(/(\d{2})(\d)/, "($1) $2");
        telefone = telefone.replace(/(\d{4})(\d)/, "$1-$2");
        input.value = telefone;
    }

    // --- EVENTOS (DELEGAÇÃO DE EVENTOS E INIT) ---
    $(document).ready(function () {
        
        // Delegação de Eventos para a visualização do paciente
        $(document).on("click", ".nome-paciente", function () {
            const $this = $(this);
            abrirModalPaciente(
                $this.data("id"),
                $this.data("nome"),
                $this.data("data-nasci"),
                $this.data("convenio"),
                $this.data("carteira-convenio"),
                $this.data("telefone"),
                $this.data("cpf"),
                $this.data("cidade"),
                $this.data("responsavel"),
                $this.data("cpf-responsavel")
            );
        });

        // Delegação de Eventos para edição do paciente
        $(document).on("click", ".editar-paciente", function () {
            const $this = $(this);
            const id = $this.data("id");
            const nome = $this.data("nome");
            const email = $this.data("email");
            const dataNasci = $this.data("data-nasci");
            const telefone = $this.data("telefone");
            const cpf = $this.data("cpf");
            const cidade = $this.data("cidade");
            const responsavel = $this.data("responsavel");
            const cpfResponsavel = $this.data("cpf-responsavel");
            const convenioId = $this.data("convenio-id");
            const carteiraConvenio = $this.data("carteira-convenio");

            console.log("Carteira do convênio:", carteiraConvenio);

            $("#editar-id").val(id);
            $("#editar-nome").val(nome);
            $("#editar-email").val(email);
            $("#editar-data-nasci").val(dataNasci);
            $("#editar-telefone").val(telefone);
            $("#editar-cpf").val(cpf);
            $("#editar-cidade").val(cidade);
            $("#editar-responsavel").val(responsavel);
            $("#editar-cpf-responsavel").val(cpfResponsavel);
            $("#fk_convenio_paci").val(convenioId);
            $("#editar-carteira-convenio").val(carteiraConvenio);

            // Validação de maioridade
            const birthDate = new Date(dataNasci);
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }

            const $respGroup = $("#editar-responsavel").closest(".form-group");
            const $cpfRespGroup = $("#editar-cpf-responsavel").closest(".form-group");

            if (age >= 18) {
                $respGroup.hide();
                $cpfRespGroup.hide();
                $("#editar-responsavel, #editar-cpf-responsavel").prop("required", false);
            } else {
                $respGroup.show();
                $cpfRespGroup.show();
                $("#editar-responsavel, #editar-cpf-responsavel").prop("required", true);
            }

            $("#editarPacienteModal").modal("show");
        });

        // Ajax Setup
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        // Envio do formulário de edição
        $("#formEditarPaciente").on("submit", function (event) {
            event.preventDefault();

            const formData = $(this).serializeArray();
            const data = {};
            
            $.each(formData, function (index, field) {
                if (
                    (field.name !== "responsavel" && field.name !== "cpf_responsavel") ||
                    $("#editar-responsavel").closest(".form-group").is(":visible")
                ) {
                    data[field.name] = field.value;
                }
            });

            const convenioSelecionado = $("#fk_convenio_paci").val();
            data["email"] = $("#editar-email").val();
            data["fk_convenio_paci"] = convenioSelecionado;

            if (convenioSelecionado === "1") { 
                data["carteira_convenio_paci"] = ""; 
            } else {
                data["carteira_convenio_paci"] = $("#editar-carteira-convenio").val();
            }

            $.ajax({
                type: "POST",
                url: "/update-paciente",
                data: JSON.stringify(data), 
                contentType: "application/json",
                success: function (response) {
                    if (response.success) {
                        const $pacienteRow = $('tr[data-id="' + $("#editar-id").val() + '"]');
                        $pacienteRow.find("td:eq(1)").text($("#editar-nome").val());
                        $pacienteRow.find("td:eq(2)").text($("#editar-data-nasci").val());
                        $pacienteRow.find("td:eq(3)").text($("#fk_convenio_paci").val());
                        $pacienteRow.find("td:eq(4)").text($("#editar-telefone").val());
                        $pacienteRow.find("td:eq(5)").text($("#editar-cpf").val());
                        $pacienteRow.find("td:eq(6)").text($("#editar-cidade").val());
                        $pacienteRow.find("td:eq(7)").text($("#editar-responsavel").val());
                        $pacienteRow.find("td:eq(8)").text($("#editar-cpf-responsavel").val());
                        $pacienteRow.find("td:eq(9)").text($("#editar-email").val());
                        $pacienteRow.find("td:eq(10)").text($("#editar-carteira-convenio").val());
                        
                        $("#editarPacienteModal").modal("hide");
                        alert(response.message);
                    } else {
                        alert(response.error);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Erro na atualização:", error);
                    alert("Erro ao atualizar dados do paciente!");
                },
            });
        });

        // Máscaras e Event Listeners de Input
        const cpfInput = document.getElementById("editar-cpf");
        if(cpfInput) {
            cpfInput.addEventListener("input", function () {
                aplicarMascaraCPF(this);
            });
        }

        const telefoneInput = document.getElementById("editar-telefone");
        if(telefoneInput) {
            telefoneInput.addEventListener("input", function () {
                aplicarMascaraTelefone(this);
            });
        }

        // Regras visuais da Carteira do Convênio
        const convenioSelect = document.getElementById("fk_convenio_paci");
        const carteiraConvenioField = document.getElementById("carteira-convenio-field");

        if(convenioSelect) {
            $(convenioSelect).on("change", function () {
                if (carteiraConvenioField) {
                    if (this.value === "1") {
                        carteiraConvenioField.style.display = "none";
                        document.getElementById("editar-carteira-convenio").removeAttribute("required");
                    } else {
                        carteiraConvenioField.style.display = "block";
                        document.getElementById("editar-carteira-convenio").setAttribute("required", true);
                    }
                }
            });
        }
    });
})(jQuery);
