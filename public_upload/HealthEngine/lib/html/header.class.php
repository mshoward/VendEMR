<?php
	
	class HE_header
	{
		public static function get()
		{
			return <<<HEADER
<div class='well well-lg'>
	<div class='row'>
		<div class='col-md-2'>
			<img src="./webroot/HealthEngine/ui/res/red_cross.png"
				alt="HealthEngine Red Cross"
				style="width:25px; height:25px;">
		</div>
		<div class='col-md-3'>
			<h1>HealthEngine</h1>
		</div>
		<div class='col-md-1'>
			<h5>Tools</h5>
		</div>
		<div class='col-md-6'>
			<div class='well'>
				<p class='lead'>Search Bar in progress...</p>
			</div>
		</div>
		
	</div>
</div>
HEADER;
;;
		}
	}
?>
