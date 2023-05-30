<?php
include_once 'model/Integrante.php';
$integrante = new Integrante();
$tela       = "telaIntegrante";
$msg        = "";

if (!empty(filter_input(INPUT_GET, 'msg'))) {
  $msg   = filter_input(INPUT_GET, 'msg');
  $dados = $integrante->consultarUltimo();

  if (is_array($dados) && !empty($dados)) {
    $id  = $dados[0]['id_int'];
    $integrante->setId($id);

    if (!empty($id)) {
      $dados = $integrante->consultarPorID();

      if (is_array($dados) && !empty($dados)) {
        $linha      = $dados[0];
        $id         = $linha['id_int'];
        $personagem = $linha['personagem_int'];
        $nome       = $linha['nome_int'];
        $data       = $linha['data_int'];
        $cpf        = $linha['cpf_int'];
      } else echo '<div> Falha no retorno do método de buscar por id <div/>';
    } else echo "<div> falha ao tentar retornar o usuario aslvo <div/>";
  } else echo '<div> Falha no retorno do método de buscar por id <div/>';
}

if (!empty(filter_input(INPUT_GET, 'id'))) {
  $id    = filter_input(INPUT_GET, 'id');
  $integrante->setId($id);
  $dados = $integrante->consultarPorID();

  if (is_array($dados)) {
    $linha      = $dados[0];
    $id         = $linha['id_int'];
    $personagem = $linha['personagem_int'];
    $nome       = $linha['nome_int'];
    $data       = $linha['data_int'];
    $cpf        = $linha['cpf_int'];
  } else echo '<div> Falha no retorno do método de buscar por id <div/>';
} else {
  if (!empty(filter_input(INPUT_GET, 'cpf'))) {
    $cpf   = filter_input(INPUT_GET, 'cpf');
    $integrante->setCpf($cpf);
    $dados = $integrante->consultarPorCpf();

    if (is_array($dados)) {
      $linha      = $dados[0];
      $id         = $linha['id_int'];
      $personagem = $linha['personagem_int'];
      $nome       = $linha['nome_int'];
      $data       = $linha['data_int'];
      $cpf        = $linha['cpf_int'];
    }
  }
}
?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
</head>

<body>
  <h1>Cadastro de integrante</h1>
  <form method="post">
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
    <input type="submit" name="btnCadastroIntegrante" value="Cadastrar Integrante">
    <input type="submit" name="btnBuscarId" value="Buscar por ID">
    <input type="submit" name="btnBuscarCPF" value="Buscar por CPF">
    <?php
    if (!empty($msg)) {
      echo "<br/><br/><div>$msg!!</div>";
    }
    if (!empty($id) || !empty($cpf)) {
      echo "<input type=\"submit\" name=\"btnDeletar\" value=\"Deletar Integrante Selecionado\">";
    }
    ?>
  </form>
</body>

</html>

<?php
if (filter_input(INPUT_POST, 'btnCadastroIntegrante')) {
  $id = filter_input(INPUT_POST, 'txtId');
  $personagem = filter_input(INPUT_POST, 'txtPersonagem');
  $nome = filter_input(INPUT_POST, 'txtNome');
  $data = filter_input(INPUT_POST, 'txtData');
  $cpf = filter_input(INPUT_POST, 'txtCpf');

  include_once 'model/Integrante.php';
  $integrante = new Integrante();

  $integrante->setId($id);
  $integrante->setPersonagem($personagem);
  $integrante->setNome($nome);
  $integrante->setData($data);
  $integrante->setCpf($cpf);
  $msg = $integrante->salvar();

  header("Location: http://localhost/site%20evento/?p=$tela&msg=$msg");
  exit();
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
    header("Location: http://localhost/site%20evento/?id=$id&del=1");
    exit();
  } else echo "<div>Falha erro ao pegar o ID para deletar<div/>";
}
