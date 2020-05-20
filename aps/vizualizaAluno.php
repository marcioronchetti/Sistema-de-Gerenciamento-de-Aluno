<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
        .wrapper{
            margin: 0 auto;
            width: 90%;
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
                        <h2 class="pull-left">Detalhe sobre os Alunos</h2>
                        <a href="aluno.php" class="btn btn-success pull-right">Adicionar novo Aluno</a>
                    </div>
                    <?php
                    // Incluir arquivo de configuração
                    require_once "config.php";
                    
                    // Tentativa de selecionar a execução da consulta
                    $sql = "SELECT * FROM alunos";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>RA</th>";
                                        echo "<th>Nome</th>";
                                        echo "<th>Endereço</th>";
                                        echo "<th>Numero</th>";
                                        echo "<th>Bairro</th>";
                                        echo "<th>CEP</th>";
                                        echo "<th>Cidade</th>";
                                        echo "<th>UF</th>";
                                        echo "<th>E-mail</th>";
                                        echo "<th>Telefone</th>";
                                        echo "<th>Disciplinas</th>";
                                        echo "<th>Ação</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['cod_aluno'] . "</td>";
                                        echo "<td>" . $row['nome'] . "</td>";
                                        echo "<td>" . $row['endereco'] . "</td>";
                                        echo "<td>" . $row['numero'] . "</td>";
                                        echo "<td>" . $row['bairro'] . "</td>";
                                        echo "<td>" . $row['cep'] . "</td>";
                                        echo "<td>" . $row['cidade'] . "</td>";
                                        echo "<td>" . $row['uf'] . "</td>";
                                        echo "<td>" . $row['email'] . "</td>";
                                        echo "<td>" . $row['telefone'] . "</td>";
                                        echo "<td>" . $row['disciplina'] . "</td>";
                                        echo "<td>";
                                            echo "<a href='read.php?cod_aluno=". $row['cod_aluno'] ."' title='Visualizar Dados' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                            echo "<a href='delete.php?cod_aluno=". $row['cod_aluno'] ."' title='Deletar Dados' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>Não há dados para serem apresentados.</em></p>";
                        }
                    } else{
                        echo "ERRO: Não foi possível executar $sql. " . mysqli_error($link);
                    }
 
                    // Fecha conexão
                    mysqli_close($link);
                    ?>
                    <div>
                        <a href="menuPrincipal.php" class="btn btn-default">Voltar</a>
                    </div>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>