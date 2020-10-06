<?php
#####################################################################################################################################################
# Programa...: Alterar.php
# Autor......: Lucas Souza da Silva
#####################################################################################################################################################
require_once("./toolskit.php");
require_once("./funcoes.php");
require_once("./menu.php");

iniciapagina("#FFDEAD");
    
$bloco= (ISSET($_REQUEST['bloco']) ) ? $_REQUEST['bloco'] : 1;
switch (true)
{
	case ($bloco==1):
	{
	escolheregistro("alterar.php");
	break;
	}
	case ($bloco==2):
	$cdmsql= "SELECT * FROM logradouros WHERE logradouros.cplogradouro='$_REQUEST[cplogradouro]'";
	$regalt=mysqli_fetch_array(mysqli_query($linkmy,$cdmsql));
	{
	printf("<form action='alterar.php' method='post'>\n
             <input type='hidden' name='bloco' value='3'>
			 <input type='hidden' name='cplogradouro' value='$_REQUEST[cplogradouro]'>\n");
    printf("<font color=Black><strong>Logradouros</strong> - Alteração</font>\n");
    printf("<table border='0'>\n");
    printf("<tr><td>Código:</td><td>$regalt[cplogradouro] - NÃO Será Alterado pelo sistema</td></tr>\n");
    printf("<tr><td>Nome:</td><td><input type='text' name='txnomelogradouro' value='$regalt[txnomelogradouro]' size=70 maxlength=200></td></tr>\n");
    printf("<tr><td>Tipo de Logradouros:</td><td>");
   
    $cdmsql="SELECT logradourostipos.cptipologradouro, logradourostipos.txnometipologradouro FROM logradourostipos ORDER BY txnometipologradouro";
    
    $execsql=mysqli_query($linkmy,$cdmsql);
   
    printf("  <select name='cetipologradouro'>");
    
    while ( $reg=mysqli_fetch_array($execsql) )
    {
	  $selected=($reg['cptipologradouro']==$regalt['cetipologradouro']) ? " selected": "" ;	
      printf("<option value='$reg[cptipologradouro]'$selected>$reg[txnometipologradouro]-($reg[cptipologradouro])</option>");
    } 
   
    printf("</select></td></tr>\n");
    printf("<tr><td>Cidade:</td><td>");
    
    $cdmsql="SELECT cidades.cpcidade, cidades.txnome FROM cidades ORDER BY txnome;";
    
    $execsql=mysqli_query($linkmy,$cdmsql);
    
    printf("  <select name='cecidade'>");
   
    while ( $reg=mysqli_fetch_array($execsql) )
    {
	  $selected=($reg['cpcidade']==$regalt['cecidade']) ? " selected": "" ;		
      printf("<option value='$reg[cpcidade]'$selected>$reg[txnome]-($reg[cpcidade])</option>");
    }
   
    printf("</select></td></tr>\n");
    printf("<tr><td>Data de Cadastro:</td><td><input type='date' name='dtcadlogradouro' value='$regalt[dtcadlogradouro]'></td></tr>\n");
    printf("<tr><td>&nbsp;</td><td><input type='submit' value='Enviar'></td></tr>\n");
    printf("</table>\n");
    
    printf("       </form>");
	break;
	}
	case ( $bloco==3 ):
  {
	  $cdmsql="UPDATE logradouros SET txnomelogradouro='$_REQUEST[txnomelogradouro]',
	                                   cetipologradouro='$_REQUEST[cetipologradouro]',
									   cecidade='$_REQUEST[cecidade]',
									   dtcadlogradouro='$_REQUEST[dtcadlogradouro]'
                      WHERE logradouros.cplogradouro='$_REQUEST[cplogradouro]'";
					  
    printf("$cdmsql<br>\n");
    $mostra=TRUE;
   
    $tentativa=TRUE;
    while ( $tentativa )
    {
      mysqli_query($linkmy,"START TRANSACTION");
      
      $execsql=mysqli_query($linkmy,$cdmsql);
      
      if ( mysqli_errno($linkmy)==0 )
      {
        
        mysqli_query($linkmy,"COMMIT");
        $tentativa=FALSE;
        $mostra=TRUE;
      }
      else
      { 
        if ( mysqli_errno($linkmy)==1213 )
        {
          $tentativa=TRUE;
        }
        else
        { 
           $tentativa=FALSE;
           $txterro=mysqli_error($linkmy);
           $mostra=FALSE;
        }
        
        mysqli_query($linkmy,"ROLLBACK");
      }
    } 
    if ( $mostra )
    { 
      printf("Registro Alterado com SUCESSO!<br>");
	  mostraregistro("$_REQUEST[cplogradouro]");
    }
    else
    { 
      printf("Registro NÃO foi Alterado!<br>ERRO: $txterro");
    }
    break;
  }
 }
 terminapagina("alterar.php","alteração na tabela logradouros");
?>
	
	
	
	 
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	