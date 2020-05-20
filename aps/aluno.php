<?php
// Incluir arquivo de configuração
require_once "config.php";

// Função para buscar cep
 
// Definir variáveis ​​e inicializar com valores vazios
$nome = $cep = $numero = $disciplina = $input_disciplina ="";
$nome_erro = $disciplina_erro = $cep_erro = $numero_erro = "";
 
// Processando dados do formulário quando o formulário é enviado
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Valida nome
    $input_nome = trim($_POST["nome"]);
    if(empty($input_nome)){
        $nome_erro = "Por favor, entre com um nome.";
    } elseif(!filter_var($input_nome, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $nome_erro = "Por favor, entre com um nome válido.";
    } else{
        $nome = $input_nome;
    }
    
    // Validate cep
    $input_cep = trim($_POST["cep"]);
    if (empty($input_cep)) {
        $cep_erro = "Por favor, entre com um CEP válido.";
    } elseif (!ctype_digit($input_cep)) {
        $cep_erro = "Por favor entre com um valor numérico";
    } else{
        $cep = $input_cep;
    }

    // Validate numero
    $input_numero = trim($_POST["numero"]);
    if(empty($input_numero)){
        $numero_erro = "Por favor, entre com um valor numérico referente a número da casa.";     
    } elseif(!ctype_digit($input_numero)){
        $numero_erro = "Por favor, entre com um valor positivo inteiro.";
    } else{
        $numero = $input_numero;
    }
    
    // Validate disciplina
    $input_disciplina = trim($_POST["disciplina"]);
    if(empty($input_disciplina)){
        $disciplina_erro = "Por favor, selecione uma disciplina, caso não haja, adicione uma.";     
    } elseif(!ctype_digit($input_disciplina)){
        $disciplina_erro = "Por favor, selecione uma disciplina, caso não haja, adicione uma.";
    } else{
        $disciplina = $input_disciplina;
    }
    
    // Verifique os erros de entrada antes de inserir no banco de dados
    if(empty($nome_erro) && empty($endereco_erro) && empty($cep_erro) && empty($numero_erro) && empty($disciplina_erro)){
        // Prepare uma instrução de inserção
        $sql = "INSERT INTO alunos (cod_aluno, nome, endereco, cep, numero, bairro, cidade, uf, email, telefone, disciplina) VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Vincular variáveis ​​à instrução preparada como parâmetros
            mysqli_stmt_bind_param($stmt, 'ssssssssss', $param_nome, $param_endereco, $param_cep, $param_numero, $param_bairro, $param_cidade, $param_uf, $param_email, $param_telefone, $param_disciplina);
            
            // Definir parâmetros
            $param_nome = $nome;
            $param_endereco = $_POST['endereco'];
            $param_bairro = $_POST['bairro'];
            $param_email = $_POST['email'];
            $param_telefone = $_POST['telefone'];
            $param_disciplina = $disciplina;
            $param_cidade = $_POST['cidade'];
            $param_uf = $_POST['uf'];
            $param_cep = $cep;
            $param_numero = $numero;
            // Tentativa de executar a declaração preparada
            if(mysqli_stmt_execute($stmt)){
                // Registros criados com sucesso. Redirecionar para a página de destino
                header("location: vizualizaAluno.php");
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
    <title>Insere dados</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
    <script type="text/javascript" >
    function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('rua').value=("");
            document.getElementById('bairro').value=("");
            document.getElementById('cidade').value=("");
            document.getElementById('uf').value=("");
    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('rua').value=(conteudo.logradouro);
            document.getElementById('bairro').value=(conteudo.bairro);
            document.getElementById('cidade').value=(conteudo.localidade);
            document.getElementById('uf').value=(conteudo.uf);
        } //end if.
        else {
            //CEP não Encontrado.
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }
        
    function pesquisacep(valor) {

        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                document.getElementById('rua').value="...";
                document.getElementById('bairro').value="...";
                document.getElementById('cidade').value="...";
                document.getElementById('uf').value="...";

                //Cria um elemento javascript.
                var script = document.createElement('script');

                //Sincroniza com o callback.
                script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);

            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    };

    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Inserir Dados do Aluno</h2>
                    </div>
                    <p>Preencha este formulário e envie-o para adicionar um registro de um novo aluno ao banco de dados.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($nome_erro)) ? 'has-error' : ''; ?>">
                            <label>Nome</label>
                            <input type="text" name="nome" class="form-control" value="">
                            <span class="help-block"><?php echo $nome_erro;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($cep_erro)) ? 'has-error' : ''; ?>">
                            <label>CEP</label>
                            <input type="text" name="cep" class="form-control" value="" id="cep" onblur="pesquisacep(this.value);">
                            <span class="help-block"><?php echo $cep_erro;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($endereco_erro)) ? 'has-error' : ''; ?>">
                            <label>Endereco</label>
                            <input name="endereco" class="form-control" id="rua"></input>
                            <span class="help-block"></span>
                        </div>
                        <div>
                            <label>Bairro</label>
                            <input type="text" name="bairro" class="form-control" id="bairro" >
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group <?php echo (!empty($numero_erro)) ? 'has-error' : ''; ?>">
                            <label>Número</label>
                            <input type="text" name="numero" class="form-control">
                            <span class="help-block"><?php echo $numero_erro;?></span>
                        </div>
                        <div>
                            <label>Cidade</label>
                            <input type="text" name="cidade" class="form-control" value="" id="cidade">
                            <span class="help-block"></span>
                        </div>
                        <div>
                            <label>UF</label>
                            <input type="text" name="uf" class="form-control" value="" id="uf">
                            <span class="help-block"></span>
                        </div>
                        <div>
                            <label>E-mail</label>
                            <input type="text" name="email" class="form-control" value="" id="email">
                            <span class="help-block"></span>
                        </div>
                        <div>
                            <label>Telefone</label>
                            <input type="text" name="telefone" class="form-control" value="" id="telefone">
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group <?php echo (!empty($disciplina_erro)) ? 'has-error' : ''; ?>">
                            <label>Disciplinas</label>
                            <select name="disciplina" class="form-control">
                                <?php
                                $result_disciplinas = "SELECT * FROM disciplinas";
                                $resultado_disciplinas = mysqli_query($link, $result_disciplinas);
                                while ($row_disciplinas = mysqli_fetch_assoc($resultado_disciplinas)) { ?>
                                    <option value="<?php echo $row_disciplinas['cod_disciplina']; ?>">
                                     <?php echo $row_disciplinas ['nome']; ?>
                                     </option> <?php
                                }
                            ?>                                 
                            </select>
                            <span class="help-block"><?php echo $disciplina_erro;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Enviar">
                        <a href="vizualizaAluno.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>