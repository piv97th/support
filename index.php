<!DOCTYPE html>
	
	
	<head>

		<?php require_once("blocks/head.php"); ?>

		<title>Стартовая страница</title>
		
	</head>
	
	
	<body>
		
		<?php
			require_once("blocks/header.php");
			require_once("blocks/navbar.php");
		?>
		
		<div class="container-fluid text-center" id="content">    
			<div class="row content">
				<div class="col-sm text-left"> 
					<h1>Welcome</h1>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
					<hr>
					<h3>Test</h3>
					<p>Lorem ipsum...</p>
				</div>
			</div>
		</div>

		<?php require_once("blocks/footer.php"); ?>
		
	</body>
</html>