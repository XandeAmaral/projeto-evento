<?php
include_once 'model/Integrante.php';
$integrante = new Integrante();
$tela       = "telaIntegrante";

if (!empty(filter_input(INPUT_GET, 'operacao'))) {
  $operacao = filter_input(INPUT_GET, 'operacao');
  if(!empty(filter_input(INPUT_GET, 'id'))) {
    $id = filter_input(INPUT_GET, 'id');
    $valores = buscaID($integrante, $id);
  }
  else $valores = buscaUltimo($integrante);

  if (is_array($valores) && !empty($valores)) {
    $id         = $valores['id'];
    $personagem = $valores['personagem'];
    $nome       = $valores['nome'];
    $data       = $valores['data'];
    $cpf        = $valores['cpf'];
  } else echo "<div> nenhum dado no banco para retornar <div/>";

} elseif (!empty(filter_input(INPUT_GET, 'id'))) {

  $id = filter_input(INPUT_GET, 'id');
  $valores = buscaID($integrante, $id);
  if(is_array($valores)){
    $personagem = $valores['personagem'];
    $nome       = $valores['nome'];
    $data       = $valores['data'];
    $cpf        = $valores['cpf'];
  } else echo "<div> Não foi encontrado um ID correspondente <div/>";
} elseif (!empty(filter_input(INPUT_GET, 'cpf'))) {

  $cpf = filter_input(INPUT_GET, 'cpf');
  $valores = buscaCPF($integrante, $cpf);
  if(is_array($valores)){
    $id         = $valores['id'];
    $personagem = $valores['personagem'];
    $nome       = $valores['nome'];
    $data       = $valores['data'];
  } else echo "<div> Não foi encontrado um CPF correspondente <div/>";
} elseif (!empty(filter_input(INPUT_GET, 'del'))) {

  $id = filter_input(INPUT_GET,'id');
  $deletar = true;
  $mensagem = $integrante->crud($deletar);

}

function buscaCPF($integrante, $cpf) {
  $integrante->setCpf($cpf);
  $dados = $integrante->consultarPorCpf();

  if (is_array($dados)) {
    return atribuirValores($dados);
  } else
    echo "<div> Falha no retorno do método de buscar por cpf </div>";
};
function buscaID($integrante, $id){
  $integrante->setId($id);
  $dados = $integrante->consultarPorID();

  if (is_array($dados))
    return atribuirValores($dados);
  else
    echo "<div> Falha no retorno do método de buscar por id </div>";
};
function buscaUltimo($integrante){
  $dados = $integrante->consultarUltimo();

  if (is_array($dados))
    return atribuirValores($dados);
  else
    echo "<div> Falha no retorno do método de buscar pelo último integrante </div>";
}
function atribuirValores($valores){
  if (empty($valores)) {
    return "";
  }
  else {
    $id         = $valores[0]['id_int'];
    $personagem = $valores[0]['personagem_int'];
    $nome       = $valores[0]['nome_int'];
    $data       = $valores[0]['data_int'];
    $cpf        = $valores[0]['cpf_int'];

    return array(
      'id' => $id,
      'personagem' => $personagem,
      'nome' => $nome,
      'data' => $data,
      'cpf' => $cpf
    );
  }
};
?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
</head>

<body>
  <h1>Cadastro de integrante</h1>
  <form method="post">
    <?php 
    if (!empty($operacao)) {
      echo "<div>$operacao!!</div><br/><br/>";
    }
    ?>
    <b>ID: </b>
    <input type="text" placeholder="Insira o ID" name="txtId" value="<?= isset($id) ? $id : "" ?>" /><br /><br />
    <b>Personagem: </b>
    <input type="text" placeholder="Insira o nome do personagem" name="txtPersonagem" value="<?= isset($personagem) ? $personagem : "" ?>" /><br /><br />
    <b>Nome: </b>
    <input type="text" placeholder="Insira o nome do participante" name="txtNome" value="<?= isset($nome) ? $nome : "" ?>" /><br /><br />
    <b>Data: </b>
    <input type="text" placeholder="Insira a data" name="txtData" value="<?= isset($data) ? $data : "" ?>" /><br /><br />
    <b>CPF: </b>


    <input type="text" placeholder="Insira o cpf" name="txtCpf" value="<?= isset($cpf) ? $cpf : "" ?>" /><br /><br />
    <input type="submit" name="btnCadastroIntegrante" value="Cadastrar ou Atualizar Integrante">
    <?php
    if (!empty($id) || !empty($cpf)) {
      echo "<input type=\"submit\" name=\"btnDeletarIntegrante\" value=\"Deletar Integrante Selecionado\">";
    }
    ?>
    <br /><br />
    <input type="submit" name="btnBuscarId" value="Buscar por ID">
    <input type="submit" name="btnBuscarCPF" value="Buscar por CPF">
  </form>
</body>

</html>

<?php
if (filter_input(INPUT_POST, 'btnCadastroIntegrante')) {
  $id         = filter_input(INPUT_POST, 'txtId');
  $personagem = filter_input(INPUT_POST, 'txtPersonagem');
  $nome       = filter_input(INPUT_POST, 'txtNome');
  $data       = filter_input(INPUT_POST, 'txtData');
  $cpf        = filter_input(INPUT_POST, 'txtCpf');

  if (empty($personagem) || empty($nome) || empty($data) || empty($cpf)) {
    echo "Por favor, preencha todos os campos.\n Para atualizar é necessário um ID válido.";
  } else {
    include_once 'model/Integrante.php';
    $integrante = new Integrante();
    $deletar = false;

    $integrante->setId($id);
    $integrante->setPersonagem($personagem);
    $integrante->setNome($nome);
    $integrante->setData($data);
    $integrante->setCpf($cpf);
    $operacao       = $integrante->crud($deletar);

    if (empty($id)){
      header("Location: http://localhost/site%20evento/?p=$tela&operacao=$operacao");
      exit();
    }
    else {
      header("Location: http://localhost/site%20evento/?p=$tela&operacao=$operacao&id=$id");
      exit();
    }
  }
}

if (filter_input(INPUT_POST, 'btnBuscarId')) {
  $id = filter_input(INPUT_POST, 'txtId');
  header("Location:http://localhost/site%20evento/?p=$tela&id=$id");
  exit();
}

if (filter_input(INPUT_POST, 'btnBuscarCPF')) {
  $cpf = filter_input(INPUT_POST, 'txtCpf');
  header("Location: http://localhost/site%20evento/?p=$tela&cpf=$cpf");
  exit();
}

if (filter_input(INPUT_POST, 'btnDeletar')) {
  if (!empty($id)) {
    header("Location: http://localhost/site%20evento/?p=$tela&id=$id&del=1");
    exit();
  } else echo "<div>Falha erro ao pegar o ID para deletar<div/>";
}
