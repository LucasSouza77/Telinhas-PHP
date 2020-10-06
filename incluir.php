<?php
#####################################################################################################################################################
# Programa...: Incluir.php
# Autor......: Lucas Souza da Silva
#####################################################################################################################################################

require_once("./toolskit.php");
require_once("./funcoes.php");
require_once("./menu.php");

iniciapagina("#FFDEAD");

$bloco=( ISSET($_REQUEST['bloco']) ) ? $_REQUEST['bloco'] : 1;


switch (TRUE)
{
  case ( $bloco==1 ):
  {
    printf("<form action='incluir.php' method='post'>\n
             <input type='hidden' name='bloco' value='2'>\n");
    printf("<font color=Black><strong>Logradouros</strong> - Inclusão</font>\n");
    printf("<table border='0'>\n");
    printf("<tr><td>Código:</td><td>Será gerado pelo sistema</td></tr>\n");
    printf("<tr><td>Nome:</td><td><input type='text' name='txnomelogradouro' size=70 maxlength=200></td></tr>\n");
    printf("<tr><td>Tipo de Logradouros:</td><td>");
   
    $cdmsql="SELECT logradourostipos.cptipologradouro, logradourostipos.txnometipologradouro FROM logradourostipos ORDER BY txnometipologradouro";
    
    $execsql=mysqli_query($linkmy,$cdmsql);
   
    printf("  <select name='cetipologradouro'>");
    
    while ( $reg=mysqli_fetch_array($execsql) )
    {
      printf("<option value='$reg[cptipologradouro]'>$reg[txnometipologradouro]-($reg[cptipologradouro])</option>");
    }
   
    printf("</select></td></tr>\n");
    printf("<tr><td>Cidade:</td><td>");
    
    $cdmsql="SELECT cidades.cpcidade, cidades.txnome FROM cidades ORDER BY txnome;";
    
    $execsql=mysqli_query($linkmy,$cdmsql);
    
    printf("  <select name='cecidade'>");
   
    while ( $reg=mysqli_fetch_array($execsql) )
    {
      printf("<option value='$reg[cpcidade]'>$reg[txnome]-($reg[cpcidade])</option>");
    }
   
    printf("</select></td></tr>\n");
    printf("<tr><td>Data de Cadastro:</td><td><input type='date' name='dtcadlogradouro'></td></tr>\n");
    printf("<tr><td>&nbsp;</td><td><input type='submit' value='Enviar'></td></tr>\n");
    printf("</table>\n");
    
    printf("       </form>");
    break;
  }
  case ( $bloco==2 ):
  { 
    $tentativa=TRUE;
    while ( $tentativa )
    { 
      mysqli_query($linkmy,"START TRANSACTION");
      
      $ultimacp=mysqli_fetch_array(mysqli_query($linkmy,"SELECT MAX(cplogradouro) AS CpMAX FROM logradouros"));
      $CP=$ultimacp['CpMAX']+1;
      $cmdsql="INSERT INTO logradouros (cplogradouro,txnomelogradouro,cetipologradouro,cecidade,dtcadlogradouro)
                      VALUES ('$CP',
                              '$_REQUEST[txnomelogradouro]',
                              '$_REQUEST[cetipologradouro]',
                              '$_REQUEST[cecidade]',
                              '$_REQUEST[dtcadlogradouro]')";
      $execsql=mysqli_query($linkmy,$cmdsql);
      
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
      printf("Registro Incluído com SUCESSO!");
      
      mostraregistro("$CP");
    }
    else
    { 
      printf("Registro NÃO foi Incluído!<br>ERRO: $txterro");
    }
    break;
  }
}
terminapagina("incluir.php","inclusao na tabela logradouros");
?>