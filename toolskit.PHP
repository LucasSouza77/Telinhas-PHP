<?php
# Pool de funções em PHP

function iniciaPagina($corDeFundo){
	printf("<html>\n");
	printf("<head>\n");
	printf("<title>Programa recursivo em PHP</title>\n");
	printf("</head>\n");
	printf("<body bgcolor='$corDeFundo'>\n");
}

function terminaPagina($prg,$nomeprg){
	printf("<hr>\nCodProg: $prg - NomeProg: $nomeprg\n");
	printf("</body>\n");
	printf("</html>\n");
}

function conecta($host,$user,$senha,$dbname)
{
  global $linkmy;
  $linkmy = mysqli_connect($host,$user,$senha,$dbname) or die ("A conexão nao deu certo");
  ##Esses 4 comandos fazem a calibragem de comandos acentuados
  mysqli_query($linkmy,"SET NAMES 'utf8'");
  mysqli_query($linkmy,"SET character_set_connection=utf8");
  mysqli_query($linkmy,"SET character_set_client=utf8");
  mysqli_query($linkmy,"SET character_set_results=utf8");
}

conecta('localhost','root','','el2')


?>