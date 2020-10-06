<?php
#####################################################################################################################################################
# Programa...: Excluir.php
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
  escolheregistro("excluir.php");
  { 
    break;
  }
  case ( $bloco==2 ):
  { 	   
    mostraregistro("$_REQUEST[cplogradouro]");
    printf("<form action='excluir.php' method='post'>\n
             <input type='hidden' name='bloco' value='3'>\n
             <input type='hidden' name='cplogradouro' value='$_REQUEST[cplogradouro]'>");
    printf("  <input type='submit' value='Confirmar a Exclusão'>\n
             </form>");
    break;
  }
  case ( $bloco==3 ):
  {
    $cmdsql="DELETE FROM logradouros where logradouros.cplogradouro='$_REQUEST[cplogradouro]'";
    
    $mostra=TRUE;
   
    $tentativa=TRUE;
    while ( $tentativa )
    {
      mysqli_query($linkmy,"START TRANSACTION");
      
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
      printf("Registro Excluído com SUCESSO!");
    }
    else
    { 
      printf("Registro NÃO foi Excluído!<br>ERRO: $txterro");
    }
    break;
  }
}
terminapagina("excluir.php","Programa Logadouros Exclusão ");
?>
























