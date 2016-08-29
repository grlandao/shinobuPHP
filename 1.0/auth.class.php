<?php
/*
Shinobu - 2016
Versão 1.0 - Alfa
*/
class login {
    public $login;
    public $senha;
    function getLogin() {
        return $this->login;
    }

    function getSenha() {
        return $this->senha;
    }

    function setLogin($login) {
        $this->login = $login;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }
    
    function signin(){
        $usuario    = $this->getLogin();
        $senha      = md5($this->getSenha());
        $login = DBRead(LOGIN_TABLE, "WHERE login = {$usuario} AND senha = {$senha} AND status = 1");
        if($login){
            session_start();
            $_SESSION['login']= $usuario;
            $_SESSION['senha']= $senha;
            setcookie('login', $_SESSION['login'],time()+3600);
            setcookie('senha', $_SESSION['senha'],time()+3600);
            header('Location: painel.php');
        }else{
            echo "<script> alert('Usuario ou senha invalido ou usuario desativado') </script>";
        } 
	
    }
}
class logoff {
    function Logout(){
        session_start();
        setcookie('email', $_SESSION['login'],time()-3600);
        setcookie('senha', $_SESSION['senha'],time()-3600);
        session_destroy();
        echo "<script> alert('Deslogado com sucesso!!') </script>";
        header("Location: index.php");
    }
}
class protect{
    public $login;
    public $senha;
    function getLogin() {
        return $this->login;
    }
    function getSenha() {
        return $this->senha;
    }
    function setLogin($login) {
        $this->login = $login;
    }
    function setSenha($senha) {
        $this->senha = $senha;
    }
    function protege(){
        $usuario    = $this->getLogin();
        $senha      = md5($this->getSenha());
        $login = DBRead(LOGIN_TABLE, "WHERE login = {$usuario} AND senha = {$senha} AND status = 1");
        if(!$login){
            header('HTTP/1.0 401 Unauthorized');
        }
    }
}
