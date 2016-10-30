<script type="text/javascript">
$(function(){
	
	function refresh(){
		$("#extrato").html("");
		$("#load").html("<img src='<?=Folder?>images/icons/uploader/throbber.gif'>");
		
		$.post("<?=URL?>Index/XML",
		{
			teste:true 
		},function(data){
			$("#load").html("<img src='<?=Folder?>images/icons/updateDone.png'>");
			$("#extrato").html(data);
			$(".topo").next().slideDown(500);
		});
	}

	refresh();
	
	$("#refresh").click(function(){
		refresh();
	});
});
</script>
<fieldset style="width: 50%; min-width: 200px; margin:0px auto; padding: 10px;">

	<div class="widget">
		<div class="title exp topo">
			<img src="<?php echo Folder ?>images/icons/dark/money2.png" alt="" class="titleIcon" />
			<h6>Extrato Banco do Brasil <span id="load"></span></h6>
			<span id='refresh' style="margin:0px auto;display:block;cursor:pointer; float:right;"><img src='<?=Folder?>images/icons/color/arrow-circle-double.png' style='margin:10px;'></span>
		</div> 
		
		<div id="extrato">

		</div>
	</div>

</fieldset>