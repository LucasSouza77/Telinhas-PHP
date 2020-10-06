<?php
#####################################################################################################################################################
# Programa...: Listar.php
# Autor......: Lucas Souza da Silva
#####################################################################################################################################################

require_once("./toolskit.php");
require_once("./funcoes.php");
require_once("./menu.php");

$bloco= (ISSET($_REQUEST['bloco']) ) ? $_REQUEST['bloco'] : 1;
$cordefundo=($bloco<3) ? '#FFDEAD' : '#FFFFFF';
iniciapagina($cordefundo );
    

switch (true)
{
	case ($bloco==1):
	{
	   printf("<font color=Black><strong>Logradouros</strong> - Listagem</font><br>\nEscolha a Ordenção Dados na Listagem ");	
	   printf("<form action='listar.php' method='post'>\n
                 <input type='hidden' name='bloco' value='2'>\n
				 <table>
				 <tr><td>Codigo do Logradouros</td>          <td><input type='radio' name='ordem' value='logradouros.cplogradouro' checked> </td></tr>
				 <tr><td>Nome do Logradouros</td>            <td><input type='radio' name='ordem' value='logradouros.txnomelogradouro'></td></tr>
				 <tr><td>Data de Cadastro do Logradouros</td><td><input type='radio' name='ordem' value='logradouros.dtcadlogradouro'></td></tr>
				 <tr><td></td><td><input type='submit' value='Gerar Listagem'></td></tr>
				 </table>\n");
			
    printf("</form>");
	
	break;
	}
    case ($bloco==2|| $bloco==3):
	{
		$cdmsql="SELECT logradouros.*, cptipologradouro, cidades.txnome 
       FROM logradouros INNER JOIN  logradourostipos 
                        ON logradouros.cplogradouro=logradourostipos.cptipologradouro
                        INNER JOIN cidades
                        ON logradouros.cecidade=cidades.cpcidade
						ORDER BY $_REQUEST[ordem]";					
	$execdm=mysqli_query($linkmy,$cdmsql);
	printf("<table border=1>");
	printf("<tr bgcolor='lightblue'><td>Código</td>\n
                  <td>Nome</td>\n
                  <td>Tipo.Logradouro</td>\n
                  <td>Cidade</td>\n
                  <td>Data</td></tr>");
	$cor="lightgreen";			  			  
	while($l=mysqli_fetch_array($execdm))
		
	{
		     $cor=($cor=='white') ? "lightgreen": "white" ;
                  printf("<tr bgcolor='$cor'><td>$l[cplogradouro]</td>\n
                  <td>$l[txnomelogradouro]</td>\n
                  <td>$l[cetipologradouro]-($l[cptipologradouro])</td>\n
                  <td>$l[cecidade]-($l[txnome])</td>\n
                  <td>$l[dtcadlogradouro]</td></tr>\n");
	}
	printf("</table>");
	if( $bloco==2 )
	{
		printf("<form action='./listar.php' method='POST' target='_NEW'>\n");
		printf("<input type='hidden' name='bloco' value=3>\n");
		printf("<input type='hidden' name='ordem' value='$_REQUEST[ordem]'>\n");
		printf("Gerar copia para <button type='submit'>impressão</button>"); 
		printf("</form>\n");
	}
	else
    {
      printf("<button type='submit' onclick='window.print();'>Imprimir</button> - Corte a folha abaixo da linha no final da página<br>\n<hr>\n");
    }
	break;
	}
}
terminapagina("Listar","Programa Logadouros Listar");
?> 

