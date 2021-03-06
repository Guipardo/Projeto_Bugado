<!DOCTYPE html>
<?php
    include '../acesso/DAOHabito.php';
    include '../usuario/validacoes.php';
    $dao = new DAOHabito();
    $mensagem = 1;
    session_start();
    $login = $_SESSION["login"];
?>
    <html lang="pt-br">

    <head>
        <meta charset="utf-8">
        <title>Novo Hábito</title>
        <link rel="stylesheet" type="text/css" href="design2.css"/>
        <script language="javascript">
            function sucesso() {
                setTimeout("window.location='../canvas/painelCanvas.php'", 3000);
            }
        </script>
    </head>

    <body>
        <?php
            $nome = $_POST["nome"];
            $categoria= $_POST["categoria"];
            $dificuldade = $_POST["dificuldade"];

            if(nomeValido($nome) == false){
            	echo "<a> Nome de hábito inválido: Digite apenas letras </a><br>";
                $mensagem = 0;
            }

            if(nomeValido($categoria) == false){
            	echo "<a> Categoria inválida: Digite apenas letras </a><br>";
                $mensagem = 0;
            }
        
            if($dao->habitoExiste($nome,$login) > 0){
                echo "<a> Este nome já existe, selecione outro </a><br>";
                $mensagem = 0;
            }

            if($mensagem > 0){
                $dao->setNomeHabito($nome);
                $dao->setCategoriaHabito($categoria);
                $dao->setDificuldadeHabito($dificuldade);
                $dao->setCodHabito(0);
                $dao->setContCicloHabito(0);
                $dao->setCodUsuario($login);
                $mensagem = $dao->novo();
                if($mensagem > 0){
                    echo "<a> Hábito criado com sucesso </a>";
                    echo "<script language='javascript'>sucesso()</script>";
                } else {
                    echo "<br><a> Erro no cadastro</a> <a href='../canvas/painelCanvas.php'> Voltar </a>";
                }
            } else {
                echo "<br><a> Erro no cadastro</a> <a href='../canvas/painelCanvas.php'> Voltar </a>";
            }
        ?>
    </body>

    </html>