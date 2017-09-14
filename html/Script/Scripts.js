var stado = false;
var VWidth = window.innerWidth;

function openNav() {
	document.getElementById("mySidenav").style.width = "250px";
	

	stado = true;
}

/* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
function closeNav() {
	document.getElementById("mySidenav").style.width = "0";
	stado = false;
}

function Size() {	//indentifica a largura da janela do navegador
	VWidth = window.innerWidth;
	console.log(VWidth);
	if (VWidth > 1670) {	// se ajanela for maior que 1670 ele abre o menu de navegação automaticamente 
		openNav();
	} else {				// se a janela for menor ele nao abre
		closeNav();
	}};

Size();

window.addEventListener('resize', function(){
	Size();		// se a janela for ajustada o programa sera chamado novamente e abrira ou fechara o menu
});

function ReverseNav() {
	if(stado == true){
		closeNav();
	}else{
		openNav();
	}
}

function FecharInfo() {
	document.getElementById("bara_info").style.top = "0";
	document.getElementById("bara_info").style.height = "0";
	document.getElementById("bara_info").style.zIndex = "1";
}
function Login() {
	document.getElementById("bara_info").style.top = "65px";
	
	document.getElementById("Login_Fundo").style.height = "100%";
	document.getElementById("Login_Fundo").style.width = "100%";
	
	document.getElementById("Login").style.height = "540px";
	document.getElementById("Login").style.width = "480px";
	
	document.getElementById("close_login").style.fontSize = "24px";
	
	document.getElementById("bara_info").style.zIndex = "10";
}

function FecharLogin() {
	document.getElementById("Login_Fundo").style.height = "0";
	document.getElementById("Login_Fundo").style.width = "0";
	
	document.getElementById("Login").style.height = "0";
	document.getElementById("Login").style.width = "0";
	
	document.getElementById("close_login").style.fontSize = "0";
	document.getElementById("bara_info").style.zIndex = "1";
}

FecharLogin()

