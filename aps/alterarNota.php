<?php
isset($_GET["cod_disciplina"]) ? $disciplina=$_GET["cod_disciplina"] : $disciplina=""; 
isset($_GET["cod_aluno"]) ? $cod_aluno=$_GET["cod_aluno"] : $cod_aluno = "";
// Incluir arquivo de configuração
require_once "config.php";

// Definir variáveis ​​e inicializar com valores vazios
$a1 = $a2 = $a3 = $media = $conceito = "";
$a1_erro = $disciplina_erro = $a2_erro = $a3_erro = $media_erro = "";
$input_a1 = $input_a2 = $input_a3 = $input_media = $input_disciplina = "";

 
// Processando dados do formulário quando o formulário é enviado
if($_SERVER["REQUEST_METHOD"] == "POST"){


    // Validate a1
    $input_a1 = trim($_POST["a1"]);
    if(empty($input_a1)){
        $a1_erro = "Por favor, entre com um valor numérico.";     
    } elseif(!ctype_digit($input_a1)){
        $a1_erro = "Por favor, entre com um valor positivo inteiro.";
    } else{
        $a1 = $input_a1;
    }

    // Validate a2
    $input_a2 = trim($_POST["a2"]);
    if(empty($input_a2)){
        $a2_erro = "Por favor, entre com um valor numérico.";     
    } elseif(!ctype_digit($input_a2)){
        $a2_erro = "Por favor, entre com um valor positivo inteiro.";
    } else{
        $a2 = $input_a2;
    }

    // Validate a3
    $input_a3 = trim($_POST["a3"]);
    if(empty($input_a3)){
        $a3_erro = "Por favor, entre com um valor numérico.";     
    } elseif(!ctype_digit($input_a3)){
        $a3_erro = "Por favor, entre com um valor positivo inteiro.";
    } else{
        $a3 = $input_a3;
    }

    // Validate media
    $input_media = trim($_POST["media"]);
    if(empty($input_media)){
        $media_erro = "Por favor, entre com um valor numérico.";     
    } elseif(!ctype_digit($input_media)){
        $media_erro = "Por favor, entre com um valor positivo inteiro.";
    } else{
        $media = $input_media;
    }


    // Verifique os erros de entrada antes de inserir no banco de dados
    if(empty($disciplina_erro) && empty($a1_erro) && empty($a2_erro) && empty($a3_erro)){
        // Prepare uma instrução de inserção
        $sql = "UPDATE notas SET cod_disciplina=?, aval1=?, aval2=?, aval3=?, media=?, conceito=? WHERE cod_aluno='$cod_aluno'";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Vincular variáveis ​​à instrução preparada como parâmetros
            mysqli_stmt_bind_param($stmt, 'iiiiis', $param_disciplina, $param_a1, $param_a2, $param_a3, $param_media, $param_conceito);
            
            // Definir parâmetros
            $param_disciplina = $disciplina;
            $param_a1 = $a1;
            $param_a2 = $a2;
            $param_a3 = $a3;
            $param_media = $media;
            $param_conceito = $conceito;

            // Tentativa de executar a declaração preparada
            if(mysqli_stmt_execute($stmt)){
                // Registros criados com sucesso. Redirecionar para a página de destino
                header("location: relatorio.php");
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
    <title>Inserir Notas</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script>        
        function Calculo() {

        
        var a1 = parseFloat(document.getElementById('a1').value);
        var a2 = parseFloat(document.getElementById('a2').value);
        var a3 = parseFloat(document.getElementById('a3').value);
        
        var resultado = parseFloat((a1+a2+a3)/3).toFixed(1);
        document.getElementById('media').setAttribute("value", resultado);

        if (resultado >= 8.5) {
            var aux = "A";
            var conceito = document.getElementById('conceito').setAttribute("value", aux);
        } else if (resultado >= 7.0 && resultado <= 8.4) {
            var aux = "B";
            var conceito = document.getElementById('conceito').setAttribute("value", aux);
        } else if (resultado >= 6.0 && resultado <= 6.9) {
            var aux = "C";
            var conceito = document.getElementById('conceito').setAttribute("value", aux);
        } else if (resultado >= 4 && resultado <= 5.9) {
            var aux = "D";
            var conceito = document.getElementById('conceito').setAttribute("value", aux);
        } else {
            var aux = "F";
            var conceito = document.getElementById('conceito').setAttribute("value", aux);
        }
        } 
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Inserir Notas do Aluno</h2>
                    </div>
                    <p>Preencha este formulário e envie-o para adicionar um registro de um novo aluno ao banco de dados.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group ">
                            <label>Codigo do Aluno</label>
                            <input type="text" name="cod_aluno" class="form-control" value="<?php echo $cod_aluno;?>" id="cod_aluno">
                        </div>
                        <div class="form-group <?php echo (!empty($a1_erro)) ? 'has-error' : ''; ?>">
                            <label>A1</label>
                            <input type="text" name="a1" class="form-control" value="" id="a1">
                            <span class="help-block"><?php echo $a1_erro;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($a2_erro)) ? 'has-error' : ''; ?>">
                            <label>A2</label>
                            <input name="a2" class="form-control" id="a2" value="">
                            <span class="help-block"><?php echo $a2_erro;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($a3_erro)) ? 'has-error' : ''; ?>">
                            <label>A3</label>
                            <input type="text" name="a3" class="form-control" id="a3" value="">
                            <span class="help-block"><?php echo $a3_erro;?></span>
                        </div>
                        <div class="form-group">
                            <label>Media</label>
                            <input type="text" name="media" class="form-control" id="media" value="">
                        </div>
                        <div>
                            <label>Conceito</label>
                            <input type="text" name="conceito" class="form-control" value="" id="conceito">
                        </div>
                        <div class="form-group">
                            <label>Disciplinas</label>
                            <input type="text" name="disciplina" class="form-control" value="<?php echo $disciplina;?>" id="disciplina" >
                        </div>
                        <input type="submit" class="btn btn-primary" value="Enviar">
                        <input type="button" class="btn btn-primary" value="Calcular Media" onclick="Calculo()">
                        <a href="menuPrincipal.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>