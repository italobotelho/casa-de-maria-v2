# 🏥 Casa de Maria: Sistema de Gestão Clínica e Agenda Médica

![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)
![Bootstrap](https://img.shields.io/badge/bootstrap-%238511FA.svg?style=for-the-badge&logo=bootstrap&logoColor=white)
![MySQL](https://img.shields.io/badge/mysql-4479A1.svg?style=for-the-badge&logo=mysql&logoColor=white)

Este projeto é um sistema web completo para automação e gestão clínica. Desenvolvido com o framework **Laravel**, o ecossistema gerencia consultas, cadastros de pacientes, médicos, convênios e procedimentos através de uma interface responsiva e dinâmica baseada em calendários interativos.

Este trabalho faz parte do TCC de **Desenvolvimento de Sistemas** da **ETEC João Belarmino (2024)**.

---

## 📅 Interface e Agenda Dinâmica

Abaixo, a central do sistema onde são gerenciados os horários, integrando o ecossistema clínico:

![Agenda Clínica](./assets/menu_principal.png)

---

## 🚀 Funcionalidades Principais

* **Controle de Agenda Interativo:**
    * Integração completa com **FullCalendar**.
    * Visualizações por Dia, Semana, Mês e Lista.
    * Agendamento simplificado com drag-and-drop.
* **Gestão de Cadastros:**
    * **Pacientes:** Dados pessoais, histórico de consultas e dados de convênio.
    * **Profissionais:** Cadastro de médicos com especialidades e CRM.
    * **Convênios & Procedimentos:** Controle de serviços ativos e inativos.
* **Módulo de Recados:** Mural interativo diretamente na home para comunicação interna rápida da equipe.
* **Filtro Inteligente:** Consulta de compromissos por profissional de saúde específico ou visão geral.

---

## 🧠 Engenharia e Arquitetura de Software

O projeto foi desenvolvido utilizando boas práticas modernas de desenvolvimento web:

* **Padrão MVC:** Separação limpa entre as lógicas de banco (Models), rotas/processamento (Controllers) e telas Blade (Views).
* **FullCalendar + AJAX:** Comunicação assíncrona para alteração, exclusão e inserção de consultas sem recarregar a página.
* **Segurança:** Autenticação nativa de usuários (Laravel Auth) e validações do lado do servidor para evitar conflitos de horários.

---

## 🛠️ Estrutura do Projeto

A organização principal dos diretórios segue a estrutura padrão do framework:

| Diretório / Arquivo | Descrição |
| :--- | :--- |
| `app/Http/Controllers/` | Controladores de fluxo (Pacientes, Médicos, Eventos). |
| `resources/views/` | Interfaces codificadas com a engine Blade (HTML/CSS). |
| `database/` | Migrations das tabelas do MySQL e Seeders com dados fictícios. |
| `public/assets/` | Recursos estáticos (Scripts do FullCalendar, Imagens, CSS). |
| `.env.example` | Estrutura das variáveis de ambiente para configuração local. |

---

## 💻 Como Configurar e Executar

Certifique-se de ter o **PHP**, **Composer** e **Node.js** instalados em sua máquina.

1.  **Clone o repositório:**
    ```bash
    git clone https://github.com/italobotelho/casa-de-maria-v2.git
    ```

2.  **Instale as dependências de backend e frontend:**
    ```bash
    composer install
    npm install
    ```

3.  **Configure o Ambiente:**
    * Crie o arquivo `.env` copiando a estrutura padrão:
      ```bash
      cp .env.example .env
      ```
    * Gere a chave da aplicação:
      ```bash
      php artisan key:generate
      ```

4.  **Configure o Banco de Dados (MySQL):**
    * No arquivo `.env`, preencha as credenciais do seu banco.
    * Crie o banco de dados e rode as migrations com as massas de teste:
      ```bash
      php artisan migrate:fresh --seed
      ```

5.  **Inicie a Aplicação:**
    ```bash
    npm run dev
    php artisan serve
    ```
    Acesse localmente pelo endereço gerado (ex: `http://127.0.0.1:8000` ou `.test` se usar o Herd).

---

## 📊 Credenciais de Acesso (Padrão Local)

* **Email:** `admin@admin`
* **Senha:** `admin123`

---

## 🎓 Autores e Créditos

Desenvolvido por **Ítalo Botelho** e equipe.
Focado em criar soluções práticas, escaláveis e automatizadas para a área da saúde.
