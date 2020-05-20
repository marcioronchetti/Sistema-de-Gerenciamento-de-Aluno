<?php
// Verifique a existência do parâmetro id antes de processar mais
if(isset($_GET["cod_aluno"]) && !empty(trim($_GET["cod_aluno"]))){
    // Incluir arquivo de configuração
    require_once "config.php";
    
    // Prepare uma declaração de seleção
    $sql = "SELECT * FROM alunos WHERE cod_aluno = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Vincular variáveis ​​à instrução preparada como parâmetros
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Definir parâmetros
        $param_id = trim($_GET["cod_aluno"]);
        
        // Tentativa de executar a declaração preparada
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Busque a linha de resultados como uma matriz associativa. Desde o conjunto de resultados
                contém apenas uma linha, não precisamos usar o loop while */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Recuperar valor do campo individual
                $cod_aluno = $row["cod_aluno"];
                $nome = $row["nome"];
                $endereco = $row["endereco"];
                $numero = $row["numero"];
                $bairro = $row["bairro"];
                $cep = $row["cep"];
                $cidade = $row["cidade"];
                $uf = $row["uf"];
                $email = $row["email"];
                $telefone = $row["telefone"];
                $disciplina = $row["disciplina"];
            } else{
                // O URL não contém um parâmetro de identificação válido. Redirecionar para a página de erro
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Opa! Algo deu errado. Por favor, tente novamente mais tarde.";
        }
    }
     
    // Fecha declaração
    mysqli_stmt_close($stmt);
    
    // Fecha conexão
    mysqli_close($link);
} else{
    // O URL não contém o parâmetro id. Redirecionar para a página de erro
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Visualizar Dados</title>
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
                        <h1>Dados do Aluno</h1>
                    </div>
                    <div class="form-group">
                        <label>RA</label>
                        <p class="form-control-static"><?php echo $row["cod_aluno"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Nome</label>
                        <p class="form-control-static"><?php echo $row["nome"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Endereço</label>
                        <p class="form-control-static"><?php echo $row["endereco"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>CEP</label>
                        <p class="form-control-static"><?php echo $row["cep"]; ?></p>
                    </div>
                     <div class="form-group">
                        <label>Cidade</label>
                        <p class="form-control-static"><?php echo $row["cidade"]; ?></p>
                    </div>
                     <div class="form-group">
                        <label>UF</label>
                        <p class="form-control-static"><?php echo $row["uf"]; ?></p>
                    </div>
                     <div class="form-group">
                        <label>E-mail</label>
                        <p class="form-control-static"><?php echo $row["email"]; ?></p>
                    </div>
                     <div class="form-group">
                        <label>Telefone</label>
                        <p class="form-control-static"><?php echo $row["telefone"]; ?></p>
                    </div>
                     <div class="form-group">
                        <label>Disciplina</label>
                        <p class="form-control-static"><?php echo $row["disciplina"]; ?></p>
                    </div>
                    <p><a href="vizualizaAluno.php" class="btn btn-primary">Voltar</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>