<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Gerenciamento de Aluno</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
        .wrapper{
            width: 650px;
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
                    <div class="page-header clearfix"> <div class="btn-group-vertical">
                        <h2 class="text-center">Menu Principal</h2>
                        <a href="disciplina.php" class="btn btn-success pull-right">CADASTRAR DISCIPLINA</a> 
                        <a href="aluno.php" class="btn btn-success pull-right">CADASTRAR ESTUDANTE</a>
                        <a href="relatorio.php" class="btn btn-success pull-right">MOSTRAR RELATÓRIO DOS ESTUDANTES</a >
                    </div>
                  
                </div>
            </div>        
        </div>
    </div>
</body>
</html>