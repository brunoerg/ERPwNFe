</div>
<!-- Footer line -->
<div id="footer">
	<div class="wrapper">
		<b>BRUNO GARCIA - OpenSource</b> 
		<br> &copy;
		<?php echo date("Y")?>
		Todos os direitos reservados.<br>
                
	</div>
</div>

</div>
<script type="text/javascript">


$(function(){

	/*
	function buscarEmail(){
		$.ajax({
			type: "GET",
			url: '<?=URL?>Index/Gmail',
			dataType: "JSON",
			success: function(email){
				//alert(email);
				if (email) {
					var htmls = "";
					var qnt = 0;
					$.each(email,function(x,y){
						htmls += "<ul class='msgObj'>"
						+"<li class='msgTitle'><i>Assunto:</i> "+email[x].title+"</li>"
						+"<li class='msgAutor'><i>Autor:</i> "+email[x].autor+"</li>"
						+"<li class='msgData'><i>Data/Hora:</i> "+email[x].data+" / "+email[x].hora+"</li>"
						+"<span class='btStyle'><a target='_blank' href='"+email[x].link+"'> Ir para Mensagem </a></span>"
						//+"<span class='btStyle btMsg'> Mostrar Mensagem </span>"
						//+"<li class='msg'><i>Resumo da Mensagem:</i> "+email[x].msg+"</li>"
						+"<hr>"
						+"</ul>";
						qnt++;
					});

					$(".numeroMsgs").text(qnt);
					$(".listMsgs").html(htmls);
					
					aparecer(false);	
					//alert(1);
				}else{
					//alert(0);
					$("#emailView").fadeOut(500);
				}
				setTimeout(function() {
					buscarEmail();
				}, 10000);
			}
		});
	}

	buscarEmail();

	$(".numeroMsgs").click(function(){
		aparecer(true);
	});

	$("#fechaEmailView").click(function(){
		desaparecer();
	});

	$(".msgHide").hide();

	function aparecer(clicou){

		if (clicou==false) {

			if ($("#emailView").css("display")=="none") {

				$("#fechaEmailView").show(500,function(){
					$("#emailView").show();
					$(".txtTitle").fadeIn(500);
					$(".msgTitle").animate({"marginLeft":"0px"},500);
					$("#emailView").animate({"width":"400px"},1000);	
					setTimeout(function() {
						desaparecer();
					}, 15000);
				});
			}else{

				var width = $("#emailView").width();
				if (width=!400) {
					desaparecer();
				}
			}
		}else{
			$("#fechaEmailView").show(500,function(){
				$(".txtTitle").fadeIn(500);
				$(".msgTitle").animate({"marginLeft":"0px"},500);
				$("#emailView").animate({"width":"400px"},1000);	
			});
		}

	}

	function desaparecer(){
		$(".listMsgs ul").slideUp(500);
		$("#fechaEmailView").hide(500);
		$(".txtTitle").fadeOut(500,function(){
			$(".msgTitle").animate({"marginLeft":"-15px"},500);
			$("#emailView").animate({"width":"20px"},500);
		});
	}
	*/


	function launchFullScreen(element) {
		if(element.requestFullScreen) {
			element.requestFullScreen();
		} else if(element.mozRequestFullScreen) {
			element.mozRequestFullScreen();
		} else if(element.webkitRequestFullScreen) {
			element.webkitRequestFullScreen();
		}
	}
	$(".FullScreen").click(function(){
		launchFullScreen(document.documentElement);
	});

	$("#bgDark").css({"background":"#000","opacity":0.7}).hide(); 	


	$('.listMsgs ul').hide();
	$('.msg').hide();

	$('.btListar').click(function(){
		$('.listMsgs ul').slideToggle(500);
	});
	$('.btMsg').click(function(){
		$(this).next().slideToggle(500);
	});


});
</script>

<div class="clear"></div>

<div id="bgDark" style="top:0;left:0;width:100%;height:100%;position:absolute;z-index:1000;"></div>
<div id="pageView">
	<iframe src="" name="iframeView" id="iframeView"></iframe>
</div>

<div id="emailView">
	<div id="fechaEmailView">X</div>
	<div class="msgTitle">
		<h6> <span class="txtTitle">Você tem </span>
			<span style="width:15px;height:10px;color:red; margin-left:0px;font-size:18px;cursor:pointer;" class="numeroMsgs">0</span>
			<span class="txtTitle">nova(s) mensagem(ns) de E-mail </span>
			<span class="btStyle btListar txtTitle"> Listar </span>
		</h6>
	</div>
	<div class="listMsgs">
		
	</div>
</div>

</body>
</html>
