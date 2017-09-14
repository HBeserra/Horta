<?php 
session_start();
include_once("conexao.php");

if(!empty($_SESSION["id"])){
//nao roda nada
}else{
	$_SESSION["msg"] = "Área restrita";
	header("Location: login.php");	
}

$Id_Page = (int) $_GET["id"];
if($Id_Page == 0){
	$horta = $_SESSION['dashboard'];
	$result_horta = "SELECT titulo, canal_dados, api_key_dados, canal_verificação, field_verificação, api_key_verificação FROM Hortas WHERE titulo='$horta' LIMIT 1";
}else{
	$verificar_acesso = "Horta_id_$Id_Page";
	if($_SESSION["$verificar_acesso"]){
		$result_horta = "SELECT titulo, canal_dados, api_key_dados, canal_verificação, field_verificação, api_key_verificação FROM Hortas WHERE ID='$Id_Page' LIMIT 1";
	}else{
		$_SESSION["msg"] = "Área restrita";
	header("Location: administrativo.php?id=0");	
	};
};

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

$canal = $_SESSION['canal_verificação'];
$field_verificação = 'field'.$_SESSION['field_verificação'];

$url = 'https://api.thingspeak.com/channels/'.$canal.'/feeds/last.xml';
$json = file_get_contents($url);
$data = json_decode($json);
$xml = new SimpleXMLElement($json);
$verifica = (int) strval($xml->$field_verificação);

$url = "https://api.thingspeak.com/channels/".$_SESSION['canal_dados']."/feeds/last.xml";
$json = file_get_contents($url);
$data = json_decode($json);
$xml = new SimpleXMLElement($json);

$verifica_1 = (int) strval($xml->field1);
$verifica_2 = (int) strval($xml->field2);
$verifica_3 = (int) strval($xml->field3);
$verifica_4 = (int) strval($xml->field4);
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
				<a href="dashboard.php"><i class="material-icons">dashboard</i>dashboard</a>				
                <?php
					if($_SESSION['Horta_id_1'] == true){
						echo '<a href="administrativo.php?id=1"><i class="material-icons">dashboard</i>Alberto Torres</a>';
					};
					if($_SESSION['Horta_id_2'] == true){
						echo '<a href="administrativo.php?id=2"><i class="material-icons">dashboard</i>Horta 2</a>';
					};
					if($_SESSION['Horta_id_3'] == true){
						echo '<a href="administrativo.php?id=3"><i class="material-icons">dashboard</i>Horta 3</a>';
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
                </div>
<!--aviso site em manutenção-->
<?php 			
if($verifica == 3){
	echo '	<div class="row">
				<div class="col">
					<div id="bara_info"  class="Bara info">
						<i class="material-icons">info_outline</i>
						<p class="sobre">Sistema em manutenção</p>
						<div class="espaço"></div>
						<i onclick="FecharInfo()" class="material-icons close">close</i>
					</div>
				</div>
			</div>';
	
}elseif($verifica == 1){
	echo '	<div class="row">
				<div class="col">
					<div id="bara_info" style="background-color: #f2dede;" class="Bara info">
						<i class="material-icons">info_outline</i>
						<p class="sobre">Sistema desabilitado</p>
						<div class="espaço"></div>
						<i onclick="FecharInfo()" class="material-icons close">close</i>
					</div>  
				</div>
			</div>';
};
?>
						
<!-- Titulo Nome da escola ou projeto -->
                <div class="row">
                    <div class="col col-2">
                        <div class="Titulo">
                        <h1><?php echo $_SESSION["titulo"]; ?></h1>
                        </div>
                    </div>
                </div>
                <div class="row">
					<div class="col col-4">
                        <div class="Dados" style="">
	                        <div class="Layout_top" style="background-color: #5782b4; border-radius: 10px 10px 0 0; padding: 10px 10px">
	                            <h3>Umidade do Solo</h3>
	                        </div>
	                        <div style="border-style: solid; border-width: 0 0px 0px 0px;border-color: #7a7a7a; border-radius: 0 0 10px 10px; padding: 0 10px; background-color: #ffffff">
	                        	<div style="width: 200px; height: 200px; margin: 0 auto">
									<div id="container-speed" style="width: 200px; height: 200px; float: left"></div>
									<h4 style=" position: relative; top: -115px; left: calc(50% - 20px); font-size: 3em; color: #009CE8 ">%</h4>
								</div>
                        	</div>
               	    	</div>
                	</div>
                	<div class="col col-4">
                        <div class="Dados" style="">
	                        <div class="Layout_top" style="background-color: #5782b4; border-radius: 10px 10px 0 0; padding: 10px 10px">
	                            <h3>Umidade do Ar</h3>
	                        </div>
	                        <div style="border-style: solid; border-width: 0 0px 0px 0px;border-color: #7a7a7a; border-radius: 0 0 10px 10px; padding: 0 10px; background-color: #ffffff">
	                        	<div style="width: 200px; height: 200px; margin: 0 auto">
									<div id="container-speed1" style="width: 200px; height: 200px; float: left"></div>
									<h4 style=" position: relative; top: -115px; left: calc(50% - 20px); font-size: 3em; color: #009CE8 ">%</h4>
								</div>
                        	</div>
               	    	</div>
                	</div>
                	<div class="col col-4">
                        <div class="Dados" style="">
	                        <div class="Layout_top" style="background-color: #5782b4; border-radius: 10px 10px 0 0; padding: 10px 10px">
	                            <h3>Temperatura do Ar</h3>
	                        </div>
	                        <div style="border-style: solid; border-width: 0 0px 0px 0px;border-color: #7a7a7a; border-radius: 0 0 10px 10px; padding: 0 10px; background-color: #ffffff">
	                        	<div style="width: 200px; height: 200px; margin: 0 auto">
									<div id="container-speed2" style="width: 200px; height: 200px; float: left"></div>
									<h4 style=" position: relative; top: -115px; left: calc(50% - 25px); font-size: 3em; color: #009CE8 ">°c</h4>
								</div>

                        	</div>
               	    	</div>
                	</div>
					<div class="col col-4">
                        <div class="Dados" style="">
	                        <div class="Layout_top" style="background-color: #5782b4; border-radius: 10px 10px 0 0; padding: 10px 10px">
	                            <h3>Ph do Solo</h3>
	                        </div>
	                        <div style="border-style: solid; border-width: 0 0px 0px 0px;border-color: #7a7a7a; border-radius: 0 0 10px 10px; padding: 0 10px; background-color: #ffffff">
	                        	<div style="width: 200px; height: 200px; margin: 0 auto">
									<div id="container-speed3" style="width: 200px; height: 200px; float: left"></div>
									<h4 style=" position: relative; top: -115px; left: calc(50% - 26px); font-size: 3em; color: #009CE8 ">Ph</h4>
								</div>
                       			
                        	</div>
               	    	</div>
                	</div>
            	</div>
				<div class="row">
					<div class="col col-2">
						<div class="Layout_top" style="background-color: #5782b4; border-radius: 10px 10px 0 0; padding: 10px 10px"><h3>Grafico - Umidade do Solo</h3></div>
						<div style="border-style: solid; border-width: 0 0px 0px 0px;border-color: #7a7a7a; border-radius: 0 0 10px 10px; padding: 0 10px; background-color: #ffffff">
							<iframe src="https://aqui868-wixsite-com.usrfiles.com/html/2750a7_99ba1d131a70057f74ba32456313ecf3.html"></iframe>
						</div>
					</div>
					<div class="col col-2">
						<div class="Layout_top" style="background-color: #5782b4; border-radius: 10px 10px 0 0; padding: 10px 10px"><h3>Grafico - Umidade do Ar</h3></div>
						<div style="border-style: solid; border-width: 0 0px 0px 0px;border-color: #7a7a7a; border-radius: 0 0 10px 10px; padding: 0 10px; background-color: #ffffff">
							grafico-2
						</div>
					</div>
				</div>
           		<div class="row">
					<div class="col col-2">
						<div class="Layout_top" style="background-color: #5782b4; border-radius: 10px 10px 0 0; padding: 10px 10px"><h3>Grafico - Temperatura do Ar</h3></div>
						<div style="border-style: solid; border-width: 0 0px 0px 0px;border-color: #7a7a7a; border-radius: 0 0 10px 10px; padding: 0 10px; background-color: #ffffff">
							grafico-3
						</div>
					</div>
					<div class="col col-2">
						<div class="Layout_top" style="background-color: #5782b4; border-radius: 10px 10px 0 0; padding: 10px 10px"><h3>Grafico - Ph do Solo</h3></div>
						<div style="border-style: solid; border-width: 0 0px 0px 0px;border-color: #7a7a7a; border-radius: 0 0 10px 10px; padding: 0 10px; background-color: #ffffff">
							grafico-4
						</div>
					</div>
				</div>
            	
            	
<?php 
	if($_SESSION['acesso'] >= 3){
	echo '<div class="row">
			<div class="col">
				<div class="Layout_top" style="background-color: #5782b4; border-radius: 10px 10px 0 0; padding: 10px 10px"><h3 style="color: #ffffff">Configurações</h3></div>
				<div style="border-style: solid; border-width: 0 0px 0px 0px;border-color: #7a7a7a; border-radius: 0 0 10px 10px; padding: 0 10px; background-color: #ffffff">
				<h2>Estado do sitema</h2>';


	if($verifica == 3){
		echo '<div style="background-color: #f2dede; width: 130px; border-style: solid; border-radius: 10px; padding: 10px 20px; border-width: 0;" > Manutenção</div><br>';
	}elseif($verifica == 1){
		echo '<div style="background-color: #f2dede; width: 120px; border-style: solid; border-radius: 10px; padding: 10px 20px; border-width: 0;" > Desativado</div><br>';
	}elseif($verifica == 2){
		echo '<div style="background-color: #dff0d8; width: 95px; border-style: solid; border-radius: 10px; padding: 10px 20px; border-width: 0;" >Ativado</div><br>';
	};
	}


	if($_SESSION['acesso'] == 5){
		echo '
	<button style="background-color: #dff0d8; width: 120px; border-style: solid; border-radius: 10px; padding: 10px 20px; border-width: 0;" onclick="funcao_ativar()">Ativar</button>
	<button style="background-color: #f2dede; width: 120px; border-style: solid; border-radius: 10px; padding: 10px 20px; border-width: 0;" onclick="funcao_desativar()">Desativar</button>
	<button style="background-color: #f2dede; width: 120px; border-style: solid; border-radius: 10px; padding: 10px 20px; border-width: 0;"   onclick="funcao_manutenção()">Manutenção</button><br>
	<p></p><br><p> Aperte um botao para alterar o estado</p>
	<script>
	function funcao_manutenção(){
		var x;
		var r=confirm("Você deseja mesmo colocar a horta em manutenção!");
		if (r==true){window.open("https://api.thingspeak.com/update?api_key='.$_SESSION['api_key_verificação'].'&field'.$_SESSION['field_verificação'].'=3", "_blank");};
		setTimeout(window.location.reload(), 3000);
	};
	function funcao_ativar(){
		var x;
		var r=confirm("Você deseja mesmo ativar a horta!");
		if (r==true){window.open("https://api.thingspeak.com/update?api_key='.$_SESSION['api_key_verificação'].'&field'.$_SESSION['field_verificação'].'=2", "_blank");};
		setTimeout(window.location.reload(), 3000);
	};
	function funcao_desativar(){
		var x;
		var r=confirm("Você deseja mesmo desativar a horta!");
		if (r==true){window.open("https://api.thingspeak.com/update?api_key='.$_SESSION['api_key_verificação'].'&field'.$_SESSION['field_verificação'].'=1", "_blank");};
		setTimeout(window.location.reload(), 3000);
	};
	</script>';
	};
?>
						</div>	
					</div>
           		</div>
            </main>
       </div>
    </div>
<!-- Script JS Bara lateral -->
<script src="/Script/Scripts.js"></script>
<script type='text/javascript'>

	$(function () {

    var gaugeOptions = {

        chart: {
                type: 'solidgauge',
                    margin: [0, 0, 0, 0],
                    backgroundColor: 'transparent'
                },
                title: "2",
                yAxis: {
                    min: 0,
                    max: 100,
                    minColor: '#009CE8',
                    maxColor: '#009CE8',
                    lineWidth: 0,
                    tickWidth: 0,
                    minorTickLength: 0,
                    minTickInterval: 500,
                    labels: {
                        enabled: false
                    }
                },
                pane: {
                    size: '100%',
                    center: ['50%', '60%'],
                    startAngle: -130,
                    endAngle: 130,
                    background: {
                    borderWidth: 20,
                    backgroundColor: '#DBDBDB',
                    shape: 'arc',
                    borderColor: '#DBDBDB',
                        outerRadius: '90%',
                        innerRadius: '90%'
                    }
                },
                tooltip: {
                    enabled: false
                },
                plotOptions: {
                    solidgauge: {
                        borderColor: '#009CE8',
                        borderWidth: 20,
                        radius: 90,
                        innerRadius: '90%',
                        dataLabels: {
                            y: 5,
                            borderWidth: 0,
                            useHTML: true
                        }
                    }
                },
                series: [{
                    name: 'windSpeed',
                    data: [<?php echo $verifica_1; ?>],
                    dataLabels: {
                        format: '<div style="Width: 50px;text-align:center"><span style="font-size:30px;color:#009ce8">{y}</span></div>'
                    }
                    
                }],

            credits: {
                enabled: false
            },
    };

    // The speed gauge
    $('#container-speed').highcharts(gaugeOptions);
    
    // Tweak SVG
    var svg;
    svg = document.getElementsByTagName('svg');
    if (svg.length > 0) {
        var path = svg[0].getElementsByTagName('path');
        if (path.length > 1) {
            // First path is gauge background
            path[0].setAttributeNS(null, 'stroke-linejoin', 'round');
            // Second path is gauge value
            path[1].setAttributeNS(null, 'stroke-linejoin', 'round');
        }
    }

		
	setInterval(function () {
        // Speed
        var chart = $('#container-speed').highcharts(),
            point,
            newVal;

        if (chart) {
            point = chart.series[0].points[0];
			var myjson;
			$.getJSON("https://api.thingspeak.com/channels/<?php echo $_SESSION['canal_dados']; ?>/feed/last.json?callback=?", function(json){
				point = chart.series[0].points[0];
				var data = parseInt(json.field1);
				point.update(data);
			});
        }

    }, 5000);


});
	$(function () {

    var gaugeOptions = {

        chart: {
                type: 'solidgauge',
                    margin: [0, 0, 0, 0],
                    backgroundColor: 'transparent'
                },
                title: "2",
                yAxis: {
                    min: 0,
                    max: 100,
                    minColor: '#009CE8',
                    maxColor: '#009CE8',
                    lineWidth: 0,
                    tickWidth: 0,
                    minorTickLength: 0,
                    minTickInterval: 500,
                    labels: {
                        enabled: false
                    }
                },
                pane: {
                    size: '100%',
                    center: ['50%', '60%'],
                    startAngle: -130,
                    endAngle: 130,
                    background: {
                    borderWidth: 20,
                    backgroundColor: '#DBDBDB',
                    shape: 'arc',
                    borderColor: '#DBDBDB',
                        outerRadius: '90%',
                        innerRadius: '90%'
                    }
                },
                tooltip: {
                    enabled: false
                },
                plotOptions: {
                    solidgauge: {
                        borderColor: '#009CE8',
                        borderWidth: 20,
                        radius: 90,
                        innerRadius: '90%',
                        dataLabels: {
                            y: 5,
                            borderWidth: 0,
                            useHTML: true
                        }
                    }
                },
                series: [{
                    name: 'windSpeed1',
                    data: [<?php echo $verifica_2; ?>],
                    dataLabels: {
                        format: '<div style="Width: 50px;text-align:center"><span style="font-size:30px;color:#009ce8">{y}</span></div>'
                    }
                    
                }],

            credits: {
                enabled: false
            },
    };

    // The speed gauge
    $('#container-speed1').highcharts(gaugeOptions);
    
    // Tweak SVG
    var svg;
    svg = document.getElementsByTagName('svg');
    if (svg.length > 0) {
        var path = svg[0].getElementsByTagName('path');
        if (path.length > 1) {
            // First path is gauge background
            path[0].setAttributeNS(null, 'stroke-linejoin', 'round');
            // Second path is gauge value
            path[1].setAttributeNS(null, 'stroke-linejoin', 'round');
        }
    }
    
    // Bring life to the dials
	setInterval(function () {
        // Speed
        var chart = $('#container-speed1').highcharts(),
            point,
            newVal;

        if (chart) {
            point = chart.series[0].points[0];
			var myjson;
			$.getJSON("https://api.thingspeak.com/channels/<?php echo $_SESSION['canal_dados']; ?>/feed/last.json?callback=?", function(json){
				point = chart.series[0].points[0];
				var data = parseInt(json.field2);
				point.update(data);
			});
        }

    }, 5000);


});


$(function () {

    var gaugeOptions = {

        chart: {
                type: 'solidgauge',
                    margin: [0, 0, 0, 0],
                    backgroundColor: 'transparent'
                },
                title: null,
                yAxis: {
                    min: 0,
                    max: 100,
                    minColor: '#009CE8',
                    maxColor: '#009CE8',
                    lineWidth: 0,
                    tickWidth: 0,
                    minorTickLength: 0,
                    minTickInterval: 500,
                    labels: {
                        enabled: false
                    }
                },
                pane: {
                    size: '100%',
                    center: ['50%', '60%'],
                    startAngle: -130,
                    endAngle: 130,
                    background: {
                    borderWidth: 20,
                    backgroundColor: '#DBDBDB',
                    shape: 'arc',
                    borderColor: '#DBDBDB',
                        outerRadius: '90%',
                        innerRadius: '90%'
                    }
                },
                tooltip: {
                    enabled: false
                },
                plotOptions: {
                    solidgauge: {
                        borderColor: '#009CE8',
                        borderWidth: 20,
                        radius: 90,
                        innerRadius: '90%',
                        dataLabels: {
                            y: 5,
                            borderWidth: 0,
                            useHTML: true
                        }
                    }
                },
                series: [{
                    name: 'windSpeed2',
                    data: [<?php echo $verifica_3; ?>],
                    dataLabels: {
                        format: '<div style="Width: 50px;text-align:center"><span style="font-size:30px;color:#009ce8">{y}</span></div>'
                    }
                    
                }],

            credits: {
                enabled: false
            },
    };

    // The speed gauge
    $('#container-speed2').highcharts(gaugeOptions);
    
    // Tweak SVG
    var svg;
    svg = document.getElementsByTagName('svg');
    if (svg.length > 0) {
        var path = svg[0].getElementsByTagName('path');
        if (path.length > 1) {
            // First path is gauge background
            path[0].setAttributeNS(null, 'stroke-linejoin', 'round');
            // Second path is gauge value
            path[1].setAttributeNS(null, 'stroke-linejoin', 'round');
        }
    }
    
    // Bring life to the dials
	setInterval(function () {
        // Speed
        var chart = $('#container-speed2').highcharts(),
            point,
            newVal;

        if (chart) {
            point = chart.series[0].points[0];
			var myjson;
			$.getJSON("https://api.thingspeak.com/channels/<?php echo $_SESSION['canal_dados']; ?>/feed/last.json?callback=?", function(json){
				point = chart.series[0].points[0];
				var data = parseInt(json.field3);
				point.update(data);
			});
        }

    }, 5000);


});
	$(function () {

    var gaugeOptions = {

        chart: {
                type: 'solidgauge',
                    margin: [0, 0, 0, 0],
                    backgroundColor: 'transparent'
                },
                title: "2",
                yAxis: {
                    min: 0,
                    max: 14,
                    minColor: '#009CE8',
                    maxColor: '#009CE8',
                    lineWidth: 0,
                    tickWidth: 0,
                    minorTickLength: 0,
                    minTickInterval: 500,
                    labels: {
                        enabled: false
                    }
                },
                pane: {
                    size: '100%',
                    center: ['50%', '60%'],
                    startAngle: -130,
                    endAngle: 130,
                    background: {
                    borderWidth: 20,
                    backgroundColor: '#DBDBDB',
                    shape: 'arc',
                    borderColor: '#DBDBDB',
                        outerRadius: '90%',
                        innerRadius: '90%'
                    }
                },
                tooltip: {
                    enabled: false
                },
                plotOptions: {
                    solidgauge: {
                        borderColor: '#009CE8',
                        borderWidth: 20,
                        radius: 90,
                        innerRadius: '90%',
                        dataLabels: {
                            y: 5,
                            borderWidth: 0,
                            useHTML: true
                        }
                    }
                },
                series: [{
                    name: 'windSpeed3',
                    data: [<?php echo $verifica_4; ?>],
                    dataLabels: {
                        format: '<div style="Width: 50px;text-align:center"><span style="font-size:30px;color:#009ce8">{y}</span></div>'
                    }
                    
                }],

            credits: {
                enabled: false
            },
    };

    // The speed gauge
    $('#container-speed3').highcharts(gaugeOptions);
    
    // Tweak SVG
    var svg;
    svg = document.getElementsByTagName('svg');
    if (svg.length > 0) {
        var path = svg[0].getElementsByTagName('path');
        if (path.length > 1) {
            // First path is gauge background
            path[0].setAttributeNS(null, 'stroke-linejoin', 'round');
            // Second path is gauge value
            path[1].setAttributeNS(null, 'stroke-linejoin', 'round');
        }
    }

		
	setInterval(function () {
        // Speed
        var chart = $('#container-speed3').highcharts(),
            point,
            newVal;

        if (chart) {
            point = chart.series[0].points[0];
			var myjson;
			$.getJSON("https://api.thingspeak.com/channels/<?php echo $_SESSION['canal_dados']; ?>/feed/last.json?callback=?", function(json){
				point = chart.series[0].points[0];
				var data = parseInt(json.field4);
				point.update(data);
			});
        }

    }, 5000);


});

	

</script>
</body>


