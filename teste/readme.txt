1. Abrir o Xampp
2. clicar em configurações e selecionar a primeira opção "Apache (httpd.config)"
3. procurar por "AddHandler" até encontrar a linha "AddHandler cgi-script .cgi .pl .asp"
4. no final da linha adicionar ".py" e salvar
5. iniciar o apache e o mysql



$dados = $integrante->consultarPorID();;

foreach($dados as $pessoa){
  $id = $pessoa['id'];
  $personagem = $pessoa['personagem'];
  $nome = $pessoa['nome'];
  $data = $pessoa['data'];
  $cpf = $pessoa['cpf'];
}



$dados = $integrante->consultarPorID();

$id = $dados['id'];
$personagem = $dados['personagem'];
$nome = $dados['nome'];
$data = $dados['data'];
$cpf = $dados['cpf'];