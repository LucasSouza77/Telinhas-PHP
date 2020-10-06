<?php
#####################################################################################################################################################
# Programa...: Funções.php
# Autor......: Lucas Souza da Silva
#####################################################################################################################################################
function escolheregistro($PRG)
{
  global $linkmy;

  $cdmsql="SELECT logradouros.cplogradouro, logradouros.txnomelogradouro FROM logradouros ORDER BY txnomelogradouro";
  $execsql=mysqli_query($linkmy,$cdmsql);
  printf("<form action='$PRG' method='post'>\n
           <input type='hidden' name='bloco' value='2'>\n");
  printf("  <select name='cplogradouro'>");
  
  while ( $reg=mysqli_fetch_array($execsql) )
  {
    printf("<option value='$reg[cplogradouro]'>$reg[txnomelogradouro]-($reg[cplogradouro])</option>\n");
  }
   printf("</select>\n<input type='submit' value='Enviar'>\n<form>");
}
function mostraregistro($CP)
{
  global $linkmy;
  $cdmsql="SELECT logradouros.*, cptipologradouro, cidades.txnome 
       FROM logradouros INNER JOIN  logradourostipos 
                        ON logradouros.cplogradouro=logradourostipos.cptipologradouro
                        INNER JOIN cidades
                        ON logradouros.cecidade=cidades.cpcidade
           Where cplogradouro='$CP';";



	$execsql=mysqli_query($linkmy,$cdmsql);
	$reg=mysqli_fetch_array($execsql);
    printf ("Exibindo os Registros:<br>\n");
    printf("<table>\n");
    printf("<tr><td>Codigo:</td><td>$reg[cplogradouro]-$reg[cptipologradouro]</td></tr>\n");
    printf("<tr><td>Nome:</td><td>$reg[txnomelogradouro]</td></tr>\n");
    printf("<tr><td>Tipo:</td><td>$reg[cetipologradouro]</td></tr>\n");
    printf("<tr><td>Cidade:</td><td>$reg[cecidade]-$reg[txnome]</td></tr>\n");
    printf("<tr><td>Data:</td><td>$reg[dtcadlogradouro]</td></tr>\n");
    printf("</table>\n");
	printf ("Fim da Execução<br>\n");
}
?>