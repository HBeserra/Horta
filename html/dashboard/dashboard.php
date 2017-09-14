<?php
session_start();
include_once("conexao.php");		
if(!empty($_SESSION['id'])){
}else{
	$_SESSION['msg'] = "Área restrita";
	header("Location: login.php");	
}
$horta = $_SESSION['dashboard'];
	$result_horta = "SELECT titulo, canal_dados, api_key_dados, canal_verificação, field_verificação, api_key_verificação FROM Hortas WHERE titulo='$horta' LIMIT 1";
$resultado_horta = mysqli_query($conn, $result_horta);
if($resultado_horta){
	$row_horta = mysqli_fetch_assoc($resultado_horta);
	
	$_SESSION['titulo'] = $row_horta['titulo'];
	$_SESSION['canal_dados'] = $row_horta['canal_dados'];
	$_SESSION['api_key_dados'] = $row_horta['api_key_dados'];
	$_SESSION['canal_verificação'] = $row_horta['canal_verificação'];
	$_SESSION['field_verificação'] = $row_horta['field_verificação'];
	$_SESSION['api_key_verificação'] = $row_horta['api_key_verificação'];
}else{
	echo $_SESSION["msg"] = "Erro interno!";
	header("Location: login.php");	
}
?>


<!doctype html>
<html lang="pt-br">
<head>
    <TITLE>E-HORTA - <?php echo $_SESSION["titulo"]; ?></TITLE>    <!-- Coloque 1 a 3 palavras/frase-chave que façam sentido; fique em cerca de 67 caracteres -->

    <link rel="stylesheet" type="text/css" href="/Css/normalize.css"/> 
    <link rel="stylesheet" href="/Css/Desing.css">
    <link rel="stylesheet" type="text/css" href="/Css/Grid.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
    <link rel="shortcut icon" href="/images/HORTA.png" />
    

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="/Script/Scripts.js"></script>
    <script src="chart.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-git.js"></script>
	<script src="http://code.highcharts.com/highcharts.js"></script>
	<script src="http://code.highcharts.com/highcharts-more.js"></script>
	<script src="http://code.highcharts.com/modules/solid-gauge.js"></script>

</head>
<body style="margin: 0px; background-color: #f0f0f0;">
    <div class="Layout_Conteiner">
        <div class="Layout_Base">
<!-- Cabeçario -->
            <header class="Layout_Header" id='header'>
               <!-- botao menu lateral -->
                <div style="height: 100%" onclick="ReverseNav()" >
                    <svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" class="style-scope yt-icon" style="pointer-events: none; display: block;     fill: rgba(17, 17, 17, 0.4); height: 100%;"><g><path style="color: rgba(17, 17, 17, 0.4);" d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"></path></g>
                    </svg>
                </div>
                <!-- Logo E-horta -->
                <img class="link" href="/index.html" src="/images/e-horta%20home.png" alt="Smiley face" width="auto" height="42">
                <div style="position: absolute;  top: 3px; margin: 0px 10px; right: 60px; <50px></50px>; height: 50px;">
                    <svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" class="style-scope yt-icon" style="pointer-events: none; display: block; fill: rgba(17, 17, 17, 0.4);  height: 100%;">
                        <g class="style-scope yt-icon"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" class="style-scope yt-icon"></path></g>
                   </svg>
                </div>
                <a href="sair.php"  style="position: absolute;  top: 5px; margin: 0px 10px; right: 15px; border-radius: 12px; background-color: #4CAF50; /* Green */    border: none;    color: white;    padding: 15px 15px;    text-align: center;    text-decoration: none;    display: inline-block;    font-size: 16px;">Sair</a>
           </header>
<!-- Bara lateral -->
            <div class="Layout_Bara-lateral sidenav" id="mySidenav" style="width: 0px;">
                <div class="Layout_Login">
                <img style="width: 200px; height: 200px;" src="<?php if($_SESSION["foto_perfil"]){
								echo '/Fotos_perfil/'.$_SESSION["id"].'.jpg';
								}else{
								echo "/images/default-avatar.png";
								};
						  ?>">
                <p class="usuario"><?php echo $_SESSION["email"]; ?></p>
                </div>
                <a href="http://horta.tk/"><i class="material-icons">home</i>Inicio</a>
                <?php 
				if($Id_Page != 0){
					echo '<a href="administrativo.php?id=0"><i class="material-icons">dashboard</i>'.$_SESSION['dashboard'].'</a>';	
				};
				?>
                
                <?php
					if($_SESSION['Horta_id_1'] == true){
						echo '<a href="administrativo.php?id=1"><i class="material-icons">dashboard</i>Alberto Torres</a>';
					};
					if($_SESSION['Horta_id_2'] == true){
						echo '<a href="administrativo.php?id=2"><i class="material-icons">dashboard</i>Horta 2</a>';
					};
				?>
         	 	<a href="http://horta.tk/sobre/"><i class="material-icons">info</i>Sobre</a>
           </div>
           
           
<!-- Corpo da Pagina -->
            <main class="container">
               <!-- Espaçamento do Cabeçario do site -->
                <div class="row">
                    <div class="col">
                        <div style="height: 75px;">
                        </div>
                    </div>
<?php


//loop de hortas
	
$x = 1;
while($x <= 3) {
	$Id_Page = $x;
	$verificar_acesso = "Horta_id_$Id_Page";
	if($_SESSION["$verificar_acesso"]){

		$result_horta = "SELECT titulo, canal_dados, api_key_dados, canal_verificação, field_verificação, api_key_verificação, Coluna_Max_1, Coluna_Max_2, Coluna_Max_3, Coluna_Max_4 FROM Hortas WHERE ID='$Id_Page' LIMIT 1";
		$resultado_horta = mysqli_query($conn, $result_horta);

		if($resultado_horta){
			$row_horta = mysqli_fetch_assoc($resultado_horta);
			$_SESSION['titulo'] = $row_horta['titulo'];
			$_SESSION['canal_dados'] = $row_horta['canal_dados'];
			$_SESSION['api_key_dados'] = $row_horta['api_key_dados'];
			$_SESSION['canal_verificação'] = $row_horta['canal_verificação'];
			$_SESSION['field_verificação'] = $row_horta['field_verificação'];
			$_SESSION['api_key_verificação'] = $row_horta['api_key_verificação'];
			$_SESSION['Coluna_Max_1'] = $row_horta['Coluna_Max_1'];
			$_SESSION['Coluna_Max_2'] = $row_horta['Coluna_Max_2'];
			$_SESSION['Coluna_Max_3'] = $row_horta['Coluna_Max_3'];
			$_SESSION['Coluna_Max_4'] = $row_horta['Coluna_Max_4'];
			
			$url = "https://api.thingspeak.com/channels/".$_SESSION['canal_dados']."/feeds/last.xml";
			$json = file_get_contents($url);
			$data = json_decode($json);
			$xml = new SimpleXMLElement($json);

			$verifica_1 = (int) strval($xml->field1);
			$verifica_2 = (int) strval($xml->field2);
			$verifica_3 = (int) strval($xml->field3);
			$verifica_4 = (int) strval($xml->field4);

			//titulo h1
			echo '<div class="row"><div class="col col-2"><div class="Titulo"><h1>'.$_SESSION["titulo"].'</h1></div></div></div>';		
			
			
			echo '<div class="row">';
			echo '<div class="col col-4">
                        <div class="Dados" style="">
	                        <div class="Layout_top" style="background-color: #5782b4; border-radius: 10px 10px 0 0; padding: 10px 10px">
	                            <h3>Umidade do Solo</h3>
	                        </div>
	                        <div style="border-style: solid; border-width: 0 0px 0px 0px;border-color: #7a7a7a; border-radius: 0 0 10px 10px; padding: 0 10px; background-color: #ffffff">
	                        	<h4 style="  font-size: 3em; color: #009CE8 ">'.$verifica_1.' %</h4>
                        	</div>
               	    	</div>
                	</div>';
			echo '<div class="col col-4">
                        <div class="Dados" style="">
	                        <div class="Layout_top" style="background-color: #5782b4; border-radius: 10px 10px 0 0; padding: 10px 10px">
	                            <h3>Umidade do Ar</h3>
	                        </div>
	                        <div style="border-style: solid; border-width: 0 0px 0px 0px;border-color: #7a7a7a; border-radius: 0 0 10px 10px; padding: 0 10px; background-color: #ffffff">
	                        	<h4 style="font-size: 3em; color: #009CE8 ">'.$verifica_2.' %</h4>
                        	</div>
               	    	</div>
                	</div>';
			echo '<div class="col col-4">
                        <div class="Dados" style="">
	                        <div class="Layout_top" style="background-color: #5782b4; border-radius: 10px 10px 0 0; padding: 10px 10px">
	                            <h3>Temperatura do Ar</h3>
	                        </div>
	                        <div style="border-style: solid; border-width: 0 0px 0px 0px;border-color: #7a7a7a; border-radius: 0 0 10px 10px; padding: 0 10px; background-color: #ffffff">
	                        	<h4 style="font-size: 3em; color: #009CE8 ">'.$verifica_3.' °c</h4>
                        	</div>
               	    	</div>
                	</div>';
			echo '<div class="col col-4">
                        <div class="Dados" style="">
	                        <div class="Layout_top" style="background-color: #5782b4; border-radius: 10px 10px 0 0; padding: 10px 10px">
	                            <h3>Ph do Solo</h3>
	                        </div>
	                        <div style="border-style: solid; border-width: 0 0px 0px 0px;border-color: #7a7a7a; border-radius: 0 0 10px 10px; padding: 0 10px; background-color: #ffffff">
	                        	<h4 style="font-size: 3em; color: #009CE8 ">'.$verifica_4.' Ph</h4>
                        	</div>
               	    	</div>
                	</div>';
			
			echo '</div>';
			
		}else{
		echo 'erro 1';	
		}
	}else{
	
	}
	$x++;
} 
 