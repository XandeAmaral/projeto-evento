<?php
include_once 'model/Integrante.php';
$integrante = new Integrante();
$tela       = "telaIntegrante";

if (!empty(filter_input(INPUT_GET, 'operacao'))) {
  $operacao   = filter_input(INPUT_GET, 'operacao');
  $dados      = $integrante->consultarUltimo();

  if (is_array($dados) && !empty($dados)) {
    $id = $dados[0]['id_int'];

    if (!empty($id)) {
      $valores = buscaID($integrante, $id);

      $personagem = $valores['personagem'];
      $nome       = $valores['nome'];
      $data       = $valores['data'];
      $cpf        = $valores['cpf'];

    } else echo "<div> falha ao tentar retornar o usuario salvo <div/>";
  }
  else echo "<div> nenhum dado no banco para retornar <div/>";
} elseif (!empty(filter_input(INPUT_GET, 'id'))) {
  $id = filter_input(INPUT_GET, 'id');

  $valores = buscaID($integrante, $id);

  $personagem = $valores['personagem'];
  $nome       = $valores['nome'];
  $data       = $valores['data'];
  $cpf        = $valores['cpf'];
} elseif (!empty(filter_input(INPUT_GET, 'cpf'))) {
  $cpf = filter_input(INPUT_GET, 'cpf');

  $valores = buscaCPF($integrante, $cpf);

  $id         = $valores['id'];
  $personagem = $valores['personagem'];
  $nome       = $valores['nome'];
  $data       = $valores['data'];
}


function buscaCPF($integrante, $cpf) {
  $integrante->setCpf($cpf);
  $dados = $integrante->consultarPorCpf();

  if (is_array($dados)) {
    return atribuirValores($dados[0]);
  } else
    echo "<div> Falha no retorno do método de buscar por cpf </div>";
};
function buscaID($integrante, $id){
  $integrante->setId($id);
  $dados = $integrante->consultarPorID();

  if (is_array($dados))
    atribuirValores($dados[0]);
  else
    echo "<div> Falha no retorno do método de buscar por id </div>";
};
function atribuirValores($colunas){
  $id         = $colunas['id_int'];
  $personagem = $colunas['personagem_int'];
  $nome       = $colunas['nome_int'];
  $data       = $colunas['data_int'];
  $cpf        = $colunas['cpf_int'];

  return array(
    'id' => $id,
    'personagem' => $personagem,
    'nome' => $nome,
    'data' => $data,
    'cpf' => $cpf
  );
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
    if (!empty($operacao)) {
      echo "<br/><br/><div>$operacao!!</div>";
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
  $id         = filter_input(INPUT_POST, 'txtId');
  $personagem = filter_input(INPUT_POST, 'txtPersonagem');
  $nome       = filter_input(INPUT_POST, 'txtNome');
  $data       = filter_input(INPUT_POST, 'txtData');
  $cpf        = filter_input(INPUT_POST, 'txtCpf');

  include_once 'model/Integrante.php';
  $integrante = new Integrante();

  $integrante->setId($id);
  $integrante->setPersonagem($personagem);
  $integrante->setNome($nome);
  $integrante->setData($data);
  $integrante->setCpf($cpf);
  $operacao       = $integrante->salvar();

  header("Location: http://localhost/site%20evento/?p=$tela&operacao=$operacao");
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
