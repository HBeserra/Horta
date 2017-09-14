<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Projeto - E-Horta</title>
	<META NAME="DESCRIPTION" CONTENT="Projeto de autônomação criado na E.E Alberto Torres em parceria com o Instituto Butantan na Eletiva de iniciação cientifica. "></META>    <!-- Meta tag de DESCRIÇÃO - Até 150 caracteres -->
    <META NAME="ABSTRACT" CONTENT="Projeto de horta autônoma do E.E Alberto Torres e Instituto Butantan."></META>    <!-- Meta tag de SINTESE - Até 70 caracteres -->
    <META NAME="KEYWORDS" CONTENT="horta, autônoma, web, app, Alberto, torres, iniciação, cientifica, instituto, Butantan, projeto" ></META>    <!-- PALAVRAS CHAVES - Até 12 palavras e/ou frases de 2-3 palavras, separads por vírgulas - limitar em 255 CARACTERES -->
    <META NAME="ROBOT" CONTENT="Index,Follow" ></META> <!-- verificar para cada pagina -->
    <META NAME="LANGUAGE" CONTENT="PT" ></META>
    <meta name="author" content="Herbert Feliciano Beserra">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet">
    <link href="http://horta.tk/images/icone.png" rel="shortcut icon">
	<style>
		*{
			margin: 0;
			padding: 0;
		}
		.links{
			width: 100%;
			height: 50px; 
			position: fixed;
			display: flex;
			display: flex;
			background-color: rgb(255,255,255);
		}
		.links label{
			padding: 10px 0;
			flex-grow: 1;
			cursor: pointer;
			transition: all .4s;
			text-align: center;
			font-family: 'Arial';
		}
		.link:hover{
			background-color: rgb(55,55,55);
			color: #ffffff;
		}
		.scroll input{

		}
		.bloco{
			width: 100vw;
			height: 100vh;
			justify-content: center;
			align-items: center;
			display: flex;
		}
		.bloco img{
			width: 40%;
		}
		#nodejs{
			background-color: #ffffff;
			background-image: url(http://horta.tk/images/back1.png);
			background-position: center center;
			background-repeat: no-repeat;
			background-attachment: fixed;
			background-size: cover;
			background-color: #464646;
		}
		
		.scroll{
			width: 100vw;
			height: 100vh;
			
		}
		.scroll-1{
			width: 100%;
			width: 100vw;
			
			
		}
		.input{
			display: none;
		}
		.link{
			padding: 5px 0;
			flex-grow: 1;
			cursor: pointer;
			transition: all .4s;
			text-align: center;
			font-weight: 200; 
			font-family: 'Roboto', sans-serif;
			text-decoration: none;
			color: black;
			font-size: 2em;
				

		}
		#link-6{
			padding: 10px 0 0 0 ;
			flex-grow: 1;
			cursor: pointer;
			transition: all .4s;
			text-align: center;
			font-weight: 400; 
			font-family: 'Roboto', sans-serif;
			background-color: rgba(12,12,12,.1);
			color: black;
			text-decoration: none;
			font-size: 25px;
		}
		#link-6:hover {
			background-color: rgba(55,55,55,.2);
		}
		.espaço{
			width: 10%;
		}
		.space{
			height: 50px;
		}
		.Baner{
			background-color: #00aeef;
		}
		@media (min-width: 960px){
			.text{
				width: 960px;
			}
		}
		.text{
				padding: 0 10px 0 0;
			}
		
		@media (max-width: 960px) {
			.ce {
				width: 100%;
			}
			
			.bloco img{
				width: 70%;
			}
			.Baner{
				font-size: .5em;
			}
			
		}
		@media (max-width: 425px) {	
			.bloco img{
				width: 100%;
			}
		}
		nav{
			box-shadow:  0px 5px 10px 0 rgba(0, 0, 0, 0.3);		
		}
		
	</style>
</head>
<body style="overflow-x: hidden;">
	<nav class="links">
		<a class="link" style="padding: 5px;" href="http://horta.tk/"><img src="http://horta.tk/images/e-horta%20home.png" style="height: 45px"></a>
		<a class="link" href="http://Projeto.horta.tk/">Projeto</a>
		<a class="link" href="http://projeto.horta.tk/sobre.php">Sobre</a>
		<a class="espaço" href=""></a>
		<a id="link-6" href="http://horta.tk/dashboard/login.php">Login</a>
	</nav>
	<div class="scroll-1">
		<div class="space"></div>
		<div class="Baner">
			<center><h1 style="font-size: 4.5em;font-weight: 100; font-family: 'Roboto', sans-serif;color: #ffffff;">Sobre</h1></center>
		</div>
		<div class="space"></div>
		<center>
			<h2 style="font-size: 4em;font-weight: 100; font-family: 'Roboto', sans-serif;">O que é o e-HORTA?</h2>
		</center>
		<div class="space"></div>
		<center>
			<div class="text">
				<a style="font-size: 1.5em;font-weight: 300; font-family: 'Roboto', sans-serif; ">E-horta é um projeto de pre-iniciação cientifica que vem sendo desenvolvido com o intuito de facilitar a produção em pequena escala de alimentos, oferecendo uma solução tecnologica para a produção de alimentos em ambientes menores exigindo pouca manutenção</a>
			</div>
		</center>
		<div class="space"></div>
		<center>
			<h2 style="font-size: 4em;font-weight: 100; font-family: 'Roboto', sans-serif;">Pre-iniciação cientifica</h2>
		</center>
		<div class="space"></div>
		<center>
			<div class="text">
				<a style="font-size: 1.5em;font-weight: 300; font-family: 'Roboto', sans-serif; ">A Pre-iniciação cientifica é uma eletiva da Escola Estadual Alberto Torres em parceria com o Instituto Butantan, que incentiva os alunos a pesquisarem e desenvolverem projetos utilizando metodos cientificos</a>
			</div>
		</center>
		<div class="space"></div>
		<center>
			<h2 style="font-size: 4em;font-weight: 100; font-family: 'Roboto', sans-serif;">Contato</h2>
		</center>
		<div class="space"></div>
		<center><a style="font-size: 1.5em;font-weight: 400; font-family: 'Roboto', sans-serif; text-decoration: none; color: black;" href="https://www.facebook.com/E-E-Alberto-Torres-303811146464708/"><img class="icon" style="width: 5em" src="http://horta.tk/images/fb-art.png"><p>E.E. Alberto Torres</p></a></center>
		<div class="space"></div>
		<center><a style="font-size: 1.5em;font-weight: 400; font-family: 'Roboto', sans-serif; text-decoration: none; color: black;"><img class="icon" style="width: 5em" src="http://horta.tk/images/email-envelope-outline-shape-with-rounded-corners_318-49938.jpg"><p>e004157a@educacao.sp.gov.br</p></a></center>
		<div class="space"></div>
		<center><a style="font-size: 1.5em;font-weight: 400; font-family: 'Roboto', sans-serif; text-decoration: none; color: black;"><img   class="icon" style="width: 5em" src="http://horta.tk/images/simbolo-de-telefone-auricular-em-um-circulo_318-50200.jpg"><p>(11)37264360</p><p>(11)37262594</p></a></center>
		<div class="space"></div>
		<center><a style="font-size: 1.5em;font-weight: 400; font-family: 'Roboto', sans-serif; text-decoration: none; color: black;" href="http://www.butantan.gov.br"><img   class="icon" style="width: 5em" src="http://horta.tk/images/c2KT3V_G_400x400.jpg"><p>butantan.gov.br</p></a></center>
		<div class="space"></div>
		<div class="Baner">
			<center><h1 style="font-size: 4.5em;font-weight: 100; font-family: 'Roboto', sans-serif;color: #ffffff;">Apoio</h1></center>
		</div>
		<center><img class="ce" src="http://horta.tk/images/Alberto%20Torres%20inicia%C3%A7ao%20logos.png"></center>
	</div>										
</body>
</html>