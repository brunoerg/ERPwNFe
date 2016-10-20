<?php 
/*

	@Charts CLass  - Criacão de graficos google
	
*/

	class Charts {
	/// VARIAVEIS DE CABECALHO
		var $top;
		var $chart;
		var $sub;
	/// VARIAVEIS DE DADOS
		var $vars;
		var $values;


		function __construct(){

			$this->top = "
			<script type='text/javascript'>
			
			function drawVisualization() {
		 	
				";

			$this->sub = "
					
					}
				google.setOnLoadCallback(drawVisualization);
				</script>";
			}

			public function data(){

				/* 
				CHAMA FUNCAO DE ENVIAR ARRAY 
				*/
				$script = "var data = google.visualization.arrayToDataTable([\n";
					/* 
					DEFINE AS CATEGORIAS 
					*/

					$script.= $this->vars();

					/* 
					DEFINE OS VALORES 
					*/
					$script.= $this->values();


					/* 
					DEFINE FIM DO ARRAY
					*/
					$script.="]);\n";

			$this->chart .= $script;
		}

		protected function vars(){


			/*
				VAR this->vars = array("nomedavariaveldalinha")
			*/

			$script = "['x'";
			foreach ($this->vars as $value) {
				$script .= ", '".$value."'";
			}

			$script .= "],\n";

			return $script;
		}



		protected function values(){

			
			/*
				VAR this->vars = array("nomedavariaveldalinha")
			*/

				$keys = $this->keys();

				//print_r($this->values);
			$count = count($this->values);
			$chaves = array_keys($this->values);
			foreach ($this->values as $values) {

				
				foreach ($values as $key=>$value) {
				if ($cary==0) {
						$script.="['".$key."'";
					}	
					$script .= ", ".$value;
					
					$cary++;				
				}

				

				unset($cary);
				if ($key==$chaves[$count-1]) {
						$script.="]\n";
					}else{
						$script.="],\n";
					}
				
				
			}



			return $script;
		}

		protected function keys(){

			$this->values;

		}


		public function options($options){
		
		$script = "var options = {";
        	$count = count($options);
			$chaves = array_keys($options);
			foreach ($options as $option => $value) {
				if ($option==$chaves[$count-1]) {
						$script .= $option.":".$value;
					}else{
						$script .= $option.":".$value.", ";
					}
				
			}
          			
        
        $script.="};\n";
			$this->chart .= $script; 

		}

		public function lineChart($div){

			$script = "
			new google.visualization.LineChart(document.getElementById('".$div."')).
			draw(data, options);\n";
			$this->chart .= $script; 
		}

		public function getChart(){

			$chart = $this->top;
			$chart.= $this->chart;
			$chart.= $this->sub;

			return $chart;
		}

	}