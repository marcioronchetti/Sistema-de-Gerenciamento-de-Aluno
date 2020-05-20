<?php
// Verifique a existência do parâmetro id antes de processar mais
if(isset($_GET["cod_disciplina"]) && !empty(trim($_GET["cod_disciplina"]))){
    // Incluir arquivo de configuração
    require_once "config.php";
    
    // Prepare uma declaração de seleção

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
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Dados da Disciplina</h2>
                        <a href="vizualizarDiscip.php" class="btn btn-default pull-right">Voltar</a>
                        <div>
                            <?php 
                                $sql = "SELECT a.cod_aluno
                                              ,d.nome
                                              ,d.cod_disciplina
                                        FROM disciplinas d
                                        JOIN alunos a ON a.disciplina = d.cod_disciplina WHERE cod_disciplina = ?";
                                
                                if($stmt = mysqli_prepare($link, $sql)){
                                    // Vincular variáveis ​​à instrução preparada como parâmetros
                                    mysqli_stmt_bind_param($stmt, "i", $param_id);
                                    
                                    // Definir parâmetros
                                    $param_id = trim($_GET["cod_disciplina"]);
                                    
                                    // Tentativa de executar a declaração preparada
                                    if(mysqli_stmt_execute($stmt)){
                                        $result = mysqli_stmt_get_result($stmt);
                                
                                        if(mysqli_num_rows($result) > 0){
                                                        echo "<table class='table table-bordered table-striped'>";
                                                            echo "<thead>";
                                                                echo "<tr>";
                                                                     echo "<th>Codigo do aluno</th>";
                                                                    echo "<th>Materia</th>";
                                                                    echo "<th>Ação</th>";
                                                                echo "</tr>";
                                                            echo "</thead>";
                                                            echo "<tbody>";
                                                            while($row = mysqli_fetch_array($result)){
                                                                echo "<tr>";
                                                                    echo "<td>" . $row['cod_aluno'] . "</td>";
                                                                    echo "<td>" . $row['nome'] . "</td>";
                                                                    echo "<td>";
                                                                        echo "<a href='nota.php?cod_disciplina=". $row['cod_disciplina'] ."&cod_aluno=". $row['cod_aluno'] ."' title='Lançar Notas' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                                                    echo "</td>";
                                                                echo "</tr>";
                                                            }
                                                            echo "</tbody>";                            
                                                        echo "</table>";
                                                        
                                                        mysqli_free_result($result);
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
                        </div>
                    </div>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>