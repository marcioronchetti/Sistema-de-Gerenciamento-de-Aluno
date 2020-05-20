<?php
// Incluir arquivo de configuração
require_once "config.php";
 
// Definir variáveis ​​e inicializar com valores vazios
$nome= $nome_erro = "";
 
// Processando dados do formulário quando o formulário é enviado
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Valida nome 
    $input_nome = trim($_POST["nome"]);
    if(empty($input_nome)){
        $nome_erro = "Por favor, entre com um nome.";
    } elseif(!filter_var($input_nome, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $nome_erro = "Por favor, entre com uma disciplina válida.";
    } else{
        $nome = $input_nome;
    }

    
    // Verifique os erros de entrada antes de inserir no banco de dados
    if(empty($nome_erro))  {
        // Prepare uma instrução de inserção
        $sql = "INSERT INTO disciplinas (cod_disciplina, nome) VALUES (null,?)"; 
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Vincular variáveis ​​à instrução preparada como parâmetros
            mysqli_stmt_bind_param($stmt, "s", $param_nome);   
           
            // Definir parâmetros
            $param_nome = $nome;

            // Tentativa de executar a declaração preparada
            if(mysqli_stmt_execute($stmt)){
                // Registros criados com sucesso. Redirecionar para a página de destino
                header("location: vizualizarDiscip.php");
                exit();
            } else{
                echo "Algo deu errado. Por favor, tente novamente mais tarde.";

            }
       
        }

        // Fecha declaração
        mysqli_stmt_close($stmt);
         
    }
    
    // Fecha conexão
    mysqli_close($link);
}

?>
 
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Cadastre Disciplina</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Cadastra Disciplina</h2>
                    </div>
                    <p>Preencha este formulário para adicionar uma nova Disciplina.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($nome_erro)) ? 'has-error' : ''; ?>">
                            <label>Disciplina</label>
                            <input type="text" name="nome" class="form-control" value="">
                            <span class="help-block"><?php echo $nome_erro;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Enviar">
                        <a href="vizualizarDiscip.php" class="btn btn-warning">Vizualizar Disciplinas</a>
                        <a href="menuPrincipal.php" class="btn btn-default">Voltar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>