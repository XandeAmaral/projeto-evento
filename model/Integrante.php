<?php

include_once 'control/Conectar.php';

class Integrante {
  private $id;
  private $personagem;
  private $nome;
  private $data;
  private $cpf;

  public function getId() {
    return $this->id;
  }
  public function getPersonagem() {
    return $this->personagem;
  }
  public function getNome() {
    return $this->nome;
  }
  public function getData() {
    return $this->data;
  }
  public function getCpf() {
    return $this->cpf;
  }

  public function setId($id) {
    $this->id = $id;
  }
  public function setPersonagem($personagem) {
    $this->personagem = $personagem;
  }

  public function setNome($nome) {
    $this->nome = $nome;
  }
  public function setData($data) {
    $this->data = $data;
  }
  public function setCpf($cpf) {
    $this->cpf = $cpf;
  }

  function consultarPorCpf() {
    try {
      $this->con = new Conectar();
      if (!empty($this->getCpf())) {
        $sql = "SELECT id_int, personagem_int, nome_int, data_int, cpf_int FROM integrante WHERE cpf_int = ?";
        $ligacao = $this->con->prepare($sql);
        $ligacao->bindValue(1, $this->cpf, PDO::PARAM_STR);

        if ($ligacao->execute())
          return $ligacao->fetchAll();
        else 
          return false;
      }
      return false;
    } catch(PDOException $exc) { echo $exc->getMessage(); }
  }

  function consultarPorID() {
    try{
      $this->con = new Conectar();
      if (!empty($this->getId())) {
          $sql = "SELECT id_int, personagem_int, nome_int, data_int, cpf_int FROM integrante WHERE id_int = ?";
          $ligacao = $this->con->prepare($sql);
          $ligacao->bindValue(1, $this->id, PDO::PARAM_INT);
      }
      if ($ligacao->execute())
        return $ligacao->fetchAll();
      else
        return false;
    } catch(PDOException $exc) { echo $exc->getMessage(); }
  }

  function consultarAll() {
    try {
      $this->con = new Conectar();
      $sql = "SELECT id_int, personagem_int, nome_int, data_int, cpf_int FROM integrante";
      $ligacao = $this->con->prepare($sql);
      if ($ligacao->execute()) 
        return $ligacao->fetchAll();
      else 
        return false;
    } catch (PDOException $exc) { echo $exc->getMessage(); }
  }

  function consultarUltimo() {
    try {
      $limiteUm = 1;
      $this->con = new Conectar();
      $sql = "SELECT * FROM integrante ORDER BY id_int DESC LIMIT ?";
      $ligacao = $this->con->prepare($sql);
      $ligacao->bindValue(1, $limiteUm, PDO::PARAM_INT);
      if ($ligacao->execute()) 
        return $ligacao->fetchAll();
      else 
        return false;
    } catch (PDOException $exc) { echo $exc->getMessage(); }
  }


  function salvar() {
    //CALL salvar_integrante(null, 'Arvore', 'Maria', '04/05/2023' , '12345678906');
    try{
      $this->con = new Conectar();
      $sql = "CALL salvar_integrante(?, ?, ?, ? , ?)";
      $ligacao = $this->con->prepare($sql);

      if(empty($this->getId())) {
        $ligacao->bindValue(1, null, PDO::PARAM_NULL);
        $mensagem = "Integrante salvo com sucesso";
      }
      else {
        $ligacao->bindValue(1, $this->id, PDO::PARAM_INT);
        $mensagem = "Integrante atualizado com sucesso";
      }

      $ligacao->bindValue(2, $this->personagem, PDO::PARAM_STR);
      $ligacao->bindValue(3, $this->nome, PDO::PARAM_STR);
      $ligacao->bindValue(4, $this->data, PDO::PARAM_STR);
      $ligacao->bindValue(5, $this->cpf, PDO::PARAM_STR);

      if($ligacao->execute() == 1)
        return $mensagem;
      else
        return "Erro ao cadastrar.";
    }
    catch(PDOException $exc) { echo $exc->getMessage(); }
  }

  function excluir() {
    try {
      $this->con = new Conectar();
      if (!empty($this->getCpf())) {
        $sql = "DELETE FROM integrante WHERE cpf_int = ?";
        $ligacao = $this->con->prepare($sql);
        $ligacao->bindValue(1, $this->cpf, PDO::PARAM_STR);
      }
      else if (!empty($this->id)) {
        $sql = "DELETE FROM integrante WHERE id_int = ?";
        $ligacao = $this->con->prepare($sql);
        $ligacao->bindValue(1, $this->id, PDO::PARAM_INT);
      }
      if ($ligacao->execute() == 1)
        return "Excluído com sucesso.";
      else
        return "Erro ao excluir.";
    } 
    catch (PDOException $exc) { echo $exc->getMessage(); }
  }
}

