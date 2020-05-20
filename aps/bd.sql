SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `aps`
--

-- --------------------------------------------------------

--
-- 
--

CREATE TABLE IF NOT EXISTS disciplinas ( 
cod_disciplina int(4) NOT NULL AUTO_INCREMENT, 
nome varchar(255) NOT NULL, 
PRIMARY KEY (cod_disciplina)  
) 
ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT = 1111

CREATE TABLE IF NOT EXISTS alunos ( 
cod_aluno int(11) NOT NULL AUTO_INCREMENT, 
nome varchar(100) NOT NULL, 
endereco varchar(255) NOT NULL,
cep int (8) NOT NULL,
numero int(10) NOT NULL, 
bairro varchar(255) NOT NULL  
cidade varchar(50) NOT NULL,
uf int(2) NOT NULL, 
email varchar(255) NOT NULL, 
telefone int(9), 
disciplina varchar(255), 
PRIMARY KEY (cod_aluno)
) 
ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT= 222222
 
CREATE TABLE IF NOT EXISTS notas ( 
cod_nota int(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY (cod_nota),
cod_disciplina (4) INT NOT NULL,
cod_aluno int(11) NOT NULL,
aval1 int (8) NOT NULL,
aval2 int(8) NOT NULL, 
aval3 int(8) NOT NULL  
media int(8) NOT NULL,
conceito int(1) NOT NULL,    
CONSTRAINT fk_disciplina FOREIGN KEY(cod_disciplina) REFERENCES disciplinas (cod_disciplina),
CONSTRAINT fk_aluno FOREIGN KEY(cod_aluno) REFERENCES alunos (cod_aluno)  
) 


SELECT a.cod_aluno
		, a.nome
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
JOIN disciplinas d on n.cod_disciplina = d.cod_disciplina



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
