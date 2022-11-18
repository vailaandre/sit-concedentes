<?php

session_start(); //iniciar sessao 

//Limpar o buffer de saida para redirecionar usuario
ob_start();

//Incluir a conexao com o banco de dados
include_once "conexao.php";

//Recebe os dados do formulário

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

//confere se os dados estão sendo recebidos
var_dump($dados);

//verifica se clicou em "Cadastrar"
if (!empty($dados['CadConcedente'])) {
    $query_endereco = "INSERT INTO endereco
                (cep, endereco, numero, bairro, uf, cidade) VALUES 
                (:cep, :endereco, :numero, :bairro, :uf, :cidade)";
    $cad_endereco = $conn->prepare($query_endereco);
    $cad_endereco->bindParam(':cep', $dados['cep']);
    $cad_endereco->bindParam(':endereco', $dados['endereco']);
    $cad_endereco->bindParam(':numero', $dados['numero']);
    $cad_endereco->bindParam(':bairro', $dados['bairro']);
    $cad_endereco->bindParam(':uf', $dados['uf']);
    $cad_endereco->bindParam(':cidade', $dados['cidade']);
    $cad_endereco->execute();
    var_dump($conn->lastInsertId());
    $id_endereco = $conn->lastInsertId();

    $query_representante = "INSERT INTO pessoa
                (nome, cpf, rg, orgao_expedidor, telefone, email) VALUES 
                (:nome_representante, :cpf_representante, :rg_representante, :orgao_exp_representante, :telefone_representante, :email_representante)";
    $cad_representante = $conn->prepare($query_representante);
    $cad_representante->bindParam(':nome_representante', $dados['nome_representante']);
    $cad_representante->bindParam(':cpf_representante', $dados['cpf_representante']);
    $cad_representante->bindParam(':rg_representante', $dados['rg_representante']);
    $cad_representante->bindParam(':orgao_exp_representante', $dados['orgao_exp_representante']);
    $cad_representante->bindParam(':telefone_representante', $dados['telefone_representante']);
    $cad_representante->bindParam(':email_representante', $dados['email_representante']);
    $cad_representante->execute();
    $id_representante = $conn->lastInsertId();

    $query_cargo_representante = "INSERT INTO representante
                (cargo_representante, id_pessoa) VALUES 
                (:cargo_representante, :id_pessoa)";  
    $cad_cargo_representante = $conn->prepare($query_cargo_representante);
    $cad_cargo_representante->bindParam(':cargo_representante', $dados['cargo_representante']);
    $cad_cargo_representante->bindParam(':id_pessoa', $id_representante);
    $cad_cargo_representante->execute();

    $query_supervisor = "INSERT INTO pessoa
                (nome, cpf, rg, orgao_expedidor, telefone, email) VALUES 
                (:nome_supervisor, :cpf_supervisor, :rg_supervisor, :orgao_exp_supervisor, :telefone_supervisor, :email_supervisor)";  
    $cad_supervisor = $conn->prepare($query_supervisor);
    $cad_supervisor->bindParam(':nome_supervisor', $dados['nome_supervisor']);
    $cad_supervisor->bindParam(':cpf_supervisor', $dados['cpf_supervisor']);
    $cad_supervisor->bindParam(':rg_supervisor', $dados['rg_supervisor']);
    $cad_supervisor->bindParam(':orgao_exp_supervisor', $dados['orgao_exp_supervisor']);
    $cad_supervisor->bindParam(':telefone_supervisor', $dados['telefone_supervisor']);
    $cad_supervisor->bindParam(':email_supervisor', $dados['email_supervisor']);
    $cad_supervisor->execute();
    $id_supervisor = $conn->lastInsertId();

    $query_cargo_supervisor = "INSERT INTO supervisor
                (cargo_supervisor, id_pessoa) VALUES 
                (:cargo_supervisor, :id_pessoa)";  
    $cad_cargo_supervisor = $conn->prepare($query_cargo_supervisor);
    $cad_cargo_supervisor->bindParam(':cargo_supervisor', $dados['cargo_supervisor']);
    $cad_cargo_supervisor->bindParam(':id_pessoa', $id_supervisor);
    $cad_cargo_supervisor->execute();

    $query_concedente = "INSERT INTO concedente
                (nome, cnpj, telefone, email, convenio, data_convenio, id_endereco, id_representante, id_supervisor) VALUES 
                (:nome_concedente, :cnpj, :telefone_concedente, :email_concedente, :convenio, :data_convenio, :id_endereco, :id_representante, :id_supervisor)";
    $cad_concedente = $conn->prepare($query_concedente);
    $cad_concedente->bindParam(':nome_concedente', $dados['nome_concedente']);
    $cad_concedente->bindParam(':cnpj', $dados['cnpj']);
    $cad_concedente->bindParam(':telefone_concedente', $dados['telefone_concedente']);
    $cad_concedente->bindParam(':email_concedente', $dados['email_concedente']);
    $cad_concedente->bindParam(':convenio', $dados['convenio']);
    $cad_concedente->bindParam(':data_convenio', $dados['data_convenio']);
    $cad_concedente->bindParam(':id_endereco', $id_endereco);
    $cad_concedente->bindParam(':id_representante', $id_representante);
    $cad_concedente->bindParam(':id_supervisor', $id_supervisor);
    $cad_concedente->execute();

    //Criar variavel global para mensagem de sucesso
    $_SESSION['msg'] = "<p style='color: green;'>Cadastro realizado com sucesso!</p>";

    //Redireciona o usuário
    header("Location: cadastro.php");

} else {
        //Criar variavel global para mensagem de erro
        $_SESSION['msg'] = "<p style='color: red;'>Erro: Cadastro não realizado!</p>";

        //Redireciona o usuário
        header("Location: cadastro.php");
}

?>