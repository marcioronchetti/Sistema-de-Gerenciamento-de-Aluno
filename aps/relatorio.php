<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Relatório</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
        .wrapper{
            width: 80%;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Relatório de Notas e Alunos</h2>
						<a href="menuPrincipal.php" class="btn btn-success pull-right">Voltar</a>
                    </div>
                   
                    <?php
                    // Incluir arquivo de configuração
                    require_once "config.php";
                    
                    // Tentativa de selecionar a execução da consulta
                    $sql = "SELECT a.cod_aluno
                                    , a.nome
                                    , d.cod_disciplina
                                    , d.nome as disciplina
                                    , n.aval1
                                    , n.aval2
                                    , n.aval3
                                    , ((n.aval1 + n.aval2 + n.aval3)/ 3) as media
                                    , CASE WHEN ((n.aval1 + n.aval2 + n.aval3)/ 3) BETWEEN 8.5 AND 10 THEN 'A'
                                           WHEN ((n.aval1 + n.aval2 + n.aval3)/ 3) BETWEEN 7 AND 8.5 THEN 'B'
                                           WHEN ((n.aval1 + n.aval2 + n.aval3)/ 3) BETWEEN 6 AND 7 THEN 'C'
                                           WHEN ((n.aval1 + n.aval2 + n.aval3)/ 3) BETWEEN 4 AND 6 THEN 'D'
                                           WHEN ((n.aval1 + n.aval2 + n.aval3)/ 3)  < 4 THEN 'F'
                                           ELSE 'nota inválida'
                                    END AS conceito
                            FROM `alunos` a 
                            JOIN notas n on n.cod_aluno = a.cod_aluno
                            JOIN disciplinas d on n.cod_disciplina = d.cod_disciplina";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Código do Aluno</th>";
                                        echo "<th>Nome</th>";
                                        echo "<th>Disciplina</th>";
                                        echo "<th>Av1</th>";
                                        echo "<th>Av2</th>";
                                        echo "<th>Av3</th>";
                                        echo "<th>Media</th>";
                                        echo "<th>Conceito</th>";
                                        echo "<th>Ação</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['cod_aluno'] . "</td>";
                                        echo "<td>" . $row['nome'] . "</td>";
                                        echo "<td>" . $row['disciplina'] . "</td>";
                                        echo "<td>" . $row['aval1'] . "</td>";
                                        echo "<td>" . $row['aval2'] . "</td>";
                                        echo "<td>" . $row['aval3'] . "</td>";
                                        echo "<td>" . $row['media'] . "</td>";
                                        echo "<td>" . $row['conceito'] . "</td>";
                                        echo "<td>";
                                        echo "<a href='alterarNota.php?cod_disciplina=". $row['cod_disciplina'] ."&cod_aluno=". $row['cod_aluno'] ."' title='Alterar Nota' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                        echo "</td>";
                            }
                                echo "</tbody>";                            
                            echo "</table>";
                            
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>Não há dados para serem apresentados.</em></p>";
                        }
                    } else{
                        echo "ERRO: Não foi possível executar $sql. " . mysqli_error($link  );
                    }
 
                    // Fecha conexão
                    mysqli_close($link);
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>