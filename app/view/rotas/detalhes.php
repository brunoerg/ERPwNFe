<script type="text/javascript">
	$(function(){

		var rendererOptions = {
			draggable: true
		};
		var directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);;
		var directionsService = new google.maps.DirectionsService();
		var map;

		var pos = new google.maps.LatLng(-16,654786, -49,277999);



		var mapOptions = {
			zoom: 7,
			mapTypeId: google.maps.MapTypeId.TERRAIN,
			center: pos
		};
		map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
		directionsDisplay.setMap(map);
		directionsDisplay.setPanel(document.getElementById("trageto"));

		google.maps.event.addListener(directionsDisplay, "directions_changed", function() {
			computeTotalDistance(directionsDisplay.directions);
		});

		

		calcRoute();

		function calcRoute() {
			var geocoder = new google.maps.Geocoder();

			var request = {
				origin: "Goiania, Go",
				destination: "Goiania, Go",
				waypoints:[
				<?php echo $this->waypoints; ?>
				],
				optimizeWaypoints: true,
				travelMode: google.maps.TravelMode.DRIVING
			};
			directionsService.route(request, function(response, status) {
				if (status == google.maps.DirectionsStatus.OK) {
					directionsDisplay.setDirections(response);
				}
			});
		}

		function computeTotalDistance(result) {
			var total = 0;
			var myroute = result.routes[0];
			for (i = 0; i < myroute.legs.length; i++) {
				total += myroute.legs[i].distance.value;
			}
			total = total / 1000.
			$("#total").html(total + " km");
		}


	});
</script>
<!-- Validation form -->
<fieldset>
	<div class="widget">
		<div class="title">
			<img src="<?php echo Folder ?>images/icons/dark/map.png" alt="" class="titleIcon" />
			<h6>Detalhes da Rota</h6>
		</div>
		<div class="title">
			<img src="<?php echo Folder ?>images/icons/dark/map.png" alt="" class="titleIcon" />
			<h6>Cidades</h6>
		</div>
		<div class="formRow">
			<div>
				<ol style='list-style:decimal inside;'>
					<?php echo $this->cidades?>
					<ol>
					</div>
					<div class="clear"></div>
				</div>

				<div class="title">
					<img src="<?php echo Folder ?>images/icons/dark/map.png" alt="" class="titleIcon" />
					<h6>Mapa</h6>
				</div>
				<div class="formRow">
					<div id="map_canvas" style='width:100%;height:500px;'>

					</div>
					<div class="clear"></div>
				</div>
				<div class="title trageto">
					<img src="<?php echo Folder ?>images/icons/dark/map.png" alt="" class="titleIcon" />
					<h6 >Trageto - Total: <span id='total'> </span></h6>
				</div>
				<div class="formRow trageto">
					<div class="formRight" id="trageto">

					</div>
					<div class="clear"></div>
				</div>


			</div>
		</form>

	</fieldset>
	<a href="<?php echo URL ?>Rotas/Editar/<?php echo $_GET["var3"]?>" title="" class="wButton redwB ml15 m10" style="margin: 18px 18px 0 0; float: right;"> 
		<span>Editar Cidades</span> 
	</a>
	<a href="<?php echo URL ?>Rotas" title="" class="wButton bluewB ml15 m10" style="margin: 18px 18px 0 0; float: right;"> 
		<span>Voltar</span> 
	</a>
