<?php

session_start(); //iniciar sessao 

//Incluir a conexao com o banco de dados
include_once "conexao.php";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIT - Sistema Interno de Talentos</title>
</head>

<body>
    <main>
        <nav>
            <a href="cadastro.php">Cadastrar</a>
            <a href="consulta.php">Listar</a>
        </nav>
        <header>
            <h1>REGISTROS</h1>
        </header>

        <section>
            <h2>Concedentes cadastradas</h2>
            <?php
            //Apresentar variavel global, caso exista
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                //Destruir a variavel global (não exibir mais)
                unset($_SESSION['msg']);
            }
            $query_concedentes = "SELECT empresa.id, 
                                        empresa.nome AS nome_empresa, 
                                        empresa.cnpj, 
                                        empresa.telefone, 
                                        empresa.email, 
                                        empresa.convenio, 
                                        empresa.data_convenio, 
                                        endress.endereco, 
                                        endress.numero, 
                                        endress.cep, 
                                        endress.bairro, 
                                        endress.cidade, 
                                        endress.uf, 
                                        empresa.id_representante, 
                                        /* person.nome AS nome_representante, 
                                        person.cpf AS cpf_representante, 
                                        person.rg AS rg_representante, 
                                        person.orgao_expedidor AS orgao_exp_representante,  */
                                        representant.cargo_representante, 
                                        /* person.telefone AS tel_representante, 
                                        person.email AS mail_representante,  */
                                        empresa.id_supervisor, 
                                        /* person.nome AS nome_supervisor, 
                                        person.cpf AS cpf_supervisor, 
                                        person.rg AS rg_supervisor, 
                                        person.orgao_expedidor AS orgao_exp_supervisor, */
                                        superv.cargo_supervisor
                                        /* person.telefone AS tel_supervisor, 
                                        person.email AS mail_supervisor */

                                    FROM concedente empresa
                                    LEFT JOIN endereco AS endress ON endress.id=empresa.id_endereco
                                    LEFT JOIN pessoa AS person ON person.id=empresa.id
                                    LEFT JOIN representante AS representant ON representant.id=person.id
                                    LEFT JOIN supervisor AS superv ON superv.id=person.id
                                    ORDER BY empresa.id ";
            
            //Preparar a query
            $resultado_concedentes = $conn->prepare($query_concedentes);
            
            //Executar a query
            $resultado_concedentes->execute();
            

            while ($row_concedente = $resultado_concedentes->fetch(PDO::FETCH_ASSOC)) {
                //imprime os resultados de cada volta do laço
                //var_dump($row_concedente);
                extract($row_concedente);

                echo "Id Concedente: $id <br>"; 
                echo "Razão Social: $nome_empresa <br>";
                echo "CNPJ: $cnpj <br>";
                echo "Telefone: $telefone <br>";
                echo "E-mail: $email <br>";
                echo "Convênio: $convenio <br>";
                echo "Data do Convênio: $data_convenio <br>";
                echo "Endereço: $endereco";
                echo ", nº: $numero <br>";
                echo "CEP: $cep <br>";
                echo "Bairro: $bairro <br>";
                echo "Cidade: $cidade";
                echo "/$uf <br>";
                echo "Id Representante: $id_representante <br>";
                /*echo "Nome Representante: $nome_representante <br>";
                echo "CPF Representante: $cpf_representante <br>";
                echo "RG Representante: $rg_representante <br>";
                echo "Órgão Expedidor: $orgao_exp_representante <br>";*/
                echo "Cargo Representante: $cargo_representante <br>";
                /*echo "Telefone Representante: $tel_representante <br>";
                echo "E-mail Representante: $mail_representante <br>";*/
                echo "Id Supervisor: $id_supervisor <br>";
                /*echo "Nome Supervisor: $nome_supervisor <br>";
                echo "CPF Supervisor: $cpf_supervisor <br>";
                echo "RG Supervisor: $rg_supervisor <br>";
                echo "Órgão Expedidor: $orgao_exp_supervisor <br>";*/
                echo "Cargo Supervisor: $cargo_supervisor <br>";
               /*echo "Telefone Supervisor: $tel_supervisor <br>";
                echo "E-mail Supervisor: $mail_supervisor <br>";*/
                echo "<hr>";
            }
            ?>


        </section>

    </main>
</body>

</html>