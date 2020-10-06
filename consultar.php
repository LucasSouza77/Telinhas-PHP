<?php
#####################################################################################################################################################
# Programa...: Consultar.php
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
	escolheregistro("consultar.php");
	break;
	}
    case ($bloco==2):
	{
	mostraregistro("$_REQUEST[cplogradouro]");
	break;
	}
}
terminapagina("Consultar","Programa Logadouros Consulta");
?> 

