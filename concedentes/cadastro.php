<?php

session_start(); //iniciar sessao 

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIT - Sistema Interno de Talentos</title>

    <!-- Adicionando Javascript -->
    <script>
        function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('endereco').value = ("");
            document.getElementById('bairro').value = ("");
            document.getElementById('cidade').value = ("");
            document.getElementById('uf').value = ("");
        }

        function meu_callback(conteudo) {
            if (!("erro" in conteudo)) {
                //Atualiza os campos com os valores.
                document.getElementById('endereco').value = (conteudo.logradouro);
                document.getElementById('bairro').value = (conteudo.bairro);
                document.getElementById('cidade').value = (conteudo.localidade);
                document.getElementById('uf').value = (conteudo.uf);
            } //end if.
            else {
                //CEP não Encontrado.
                limpa_formulário_cep();
                alert("CEP não encontrado.");
            }
        }

        function pesquisacep(valor) {

            //Nova variável "cep" somente com dígitos.
            var cep = valor.replace(/\D/g, '');

            //Verifica se campo cep possui valor informado.
            if (cep != "") {

                //Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;

                //Valida o formato do CEP.
                if (validacep.test(cep)) {

                    //Preenche os campos com "..." enquanto consulta webservice.
                    document.getElementById('endereco').value = "...";
                    document.getElementById('bairro').value = "...";
                    document.getElementById('cidade').value = "...";
                    document.getElementById('uf').value = "...";

                    //Cria um elemento javascript.
                    var script = document.createElement('script');

                    //Sincroniza com o callback.
                    script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

                    //Insere script no documento e carrega o conteúdo.
                    document.body.appendChild(script);

                } //end if.
                else {
                    //cep é inválido.
                    limpa_formulário_cep();
                    alert("Formato de CEP inválido.");
                }
            } //end if.
            else {
                //cep sem valor, limpa formulário.
                limpa_formulário_cep();
            }
        };
    </script>

</head>

<body>
    <main>
        <nav>
            <a href="cadastro.php">Cadastrar</a>
            <a href="consulta.php">Listar</a>
        </nav>
        <header>
            <h1>CADASTRO</h1>
        </header>

        <?php
        //Apresentar variavel global, caso exista
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            //Destrui a variavel global (não exibir mais)
            unset($_SESSION['msg']);
        }
        ?>

        <section>
            <h2>Dados cadastrais</h2>
            <form name="cad_concedente" method="POST" action="processa.php">
                <section>
                    <fieldset>
                        <legend><strong>Concedente</strong></legend>
                        <p>

                        <p>
                            <label for="nome_concedente">Razão Social:</label> <input type="text" id="nome_concedente" name="nome_concedente" value="">
                        </p>

                        <label for="cnpj">CNPJ:</label> <input type="text" id="cnpj" name="cnpj" value="">
                        <p>
                            <label for="telefone_concedente">Telefone:</label> <input type="text" id="telefone_concedente" name="telefone_concedente" value="">
                        </p>
                        <p>
                            <label for="email_concedente">E-mail:</label> <input type="email" id="email_concedente" name="email_concedente" value="">
                        </p>

                        <label for="convenio">Convênio:</label> <input type="text" id="convenio" name="convenio" value="">
                        <p>
                            <label for="data_convenio">Data do Convênio:</label> <input type="text" id="data_convenio" name="data_convenio" value="">
                        </p>

                        <p>
                            <label for="cep">CEP:</label>
                            <input type="text" id="cep" name="cep" onblur="pesquisacep(this.value);" value="">
                            Ao digitar o CEP alguns campos serão preenchidos.
                        </p>
                        <p>
                            <label for="endereco">Logradouro:</label>
                            <input type="text" id="endereco" name="endereco" value="">
                        </p>
                        <p>
                            <label for="numero">Número:</label>
                            <input type="text" id="numero" name="numero" value="">
                        </p>

                        <p>
                            <label for="bairro">Bairro:</label>
                            <input type="text" id="bairro" name="bairro" value="">
                        </p>
                        <p>
                            <label for="uf">Escolha o estado:</label>
                            <select name="uf" id="uf">
                                <option value="">------------</option>
                                <option value="AC">Acre</option>
                                <option value="AL">Alagoas</option>
                                <option value="AP">Amapá</option>
                                <option value="AM">Amazonas</option>
                                <option value="BA">Bahia</option>
                                <option value="CE">Ceará</option>
                                <option value="DF">Distrito Federal</option>
                                <option value="ES">Espírito Santo</option>
                                <option value="GO">Goiás</option>
                                <option value="MA">Maranhão</option>
                                <option value="MT">Mato Grosso</option>
                                <option value="MS">Mato Grosso do Sul</option>
                                <option value="MG">Minas Gerais</option>
                                <option value="PA">Pará</option>
                                <option value="PB">Paraíba</option>
                                <option value="PR">Paraná</option>
                                <option value="PE">Pernambuco</option>
                                <option value="PI">Piauí</option>
                                <option value="RJ">Rio de Janeiro</option>
                                <option value="RN">Rio Grande do Norte</option>
                                <option value="RS">Rio Grande do Sul</option>
                                <option value="RO">Rondônia</option>
                                <option value="RR">Roraima</option>
                                <option value="SE">Sergipe</option>
                                <option value="SC">Santa Catarina</option>
                                <option value="SP">São Paulo</option>
                                <option value="TO">Tocantins</option>
                            </select>
                        </p>
                        <p>
                            <label for="cidade">Cidade:</label>
                            <input type="text" id="cidade" name="cidade" value="">
                        </p>
                        </p>
                    </fieldset>
                </section>
                <section>
                    <fieldset>
                        <legend><strong>Representante</strong></legend>
                        <p>
                        <p>
                            <label for="nome_representante">Nome:</label> <input type="text" id="nome_representante" name="nome_representante" value="">
                        </p>
                        <p>
                            <label for="cpf_representante">CPF/MF:</label> <input type="text" id="cpf_representante" name="cpf_representante" value="">
                        </p>
                        <p>
                            <label for="rg_representante">RG:</label> <input type="text" id="rg_representante" name="rg_representante" value="">
                        </p>
                        <p>
                            <label for="orgao_exp_representante">Órgão Expedidor:</label> <input type="text" id="orgao_exp_representante" name="orgao_exp_representante" value="">
                        </p>
                        <p>
                            <label for="cargo_representante">Cargo:</label> <input type="text" id="cargo_representante" name="cargo_representante" value="">
                        </p>
                        <p>
                            <label for="telefone_representante">Telefone:</label> <input type="text" id="telefone_representante" name="telefone_representante" value="">
                        </p>
                        <p>
                            <label for="email_representante">E-mail:</label> <input type="email" id="email_representante" name="email_representante" value="">
                        </p>
                        </p>
                    </fieldset>
                </section>
                <section>
                    <fieldset>
                        <legend><strong>Supervisor(a)</strong></legend>
                        <p>
                        <p>
                            <label for="nome_supervisor">Nome:</label> <input type="text" id="nome_supervisor" name="nome_supervisor" value="">
                        </p>
                        <p>
                            <label for="cpf_supervisor">CPF/MF:</label> <input type="text" id="cpf_supervisor" name="cpf_supervisor" value="">
                        </p>
                        <p>
                            <label for="rg_supervisor">RG:</label> <input type="text" id="rg_supervisor" name="rg_supervisor" value="">
                        </p>
                        <p>
                            <label for="orgao_exp_supervisor">Órgão Expedidor:</label> <input type="text" id="orgao_exp_supervisor" name="orgao_exp_supervisor" value="">
                        </p>
                        <p>
                            <label for="cargo_supervisor">Cargo:</label> <input type="text" id="cargo_supervisor" name="cargo_supervisor" value="">
                        </p>
                        <p>
                            <label for="telefone_supervisor">Telefone:</label> <input type="text" id="telefone_supervisor" name="telefone_supervisor" value="">
                        </p>
                        <p>
                            <label for="email_supervisor">E-mail:</label> <input type="email" id="email_supervisor" name="email_supervisor" value="">
                        </p>
                        </p>
                    </fieldset>
                </section>
                <p>
                    Confira atentamente os dados antes de finalizar
                    <input type="submit" value="Cadastrar" name="CadConcedente">
                    <input type="reset" value="Limpar" name="limpar">
                </p>
            </form>
        </section>

    </main>
</body>

</html>