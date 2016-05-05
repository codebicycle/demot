<div class="navigation">

<?php
if(!isset($_SESSION)) 
        { 
            session_start(); 
        }
		
		if (isset($_SESSION['user_id']))
		{?>
			<a href="<?php echo URL ?>">home</a>
			
			<a href="<?php echo URL . 'appointments/index' ?>">appointments</a>
			<a href="<?php echo URL . 'visits/index' ?>">visits</a>
			<a href="<?php echo URL . 'visitors/editaccount' ?>">profile </a>
			<a href="<?php echo URL . 'visitors/logout' ?>">logout</a>
			
			<?php
		}
		 else if(isset($_SESSION['admin_id']) && $_SESSION['rank'] == 0) 
				{
					?>
					<a href="<?php echo URL ?>">home</a>
					<a href="<?php echo URL . 'inmates/index' ?>">inmates</a>
					<a href="<?php echo URL . 'appointments/index' ?>">appointments</a>
					<a href="<?php echo URL . 'visits/index' ?>">visits</a>
					<a href="<?php echo URL . 'admins/index' ?>">admins</a>
					<a href="<?php echo URL . 'statistics/index' ?>">stats</a>
					<a href="<?php echo URL . 'visitors/logout' ?>">logout</a>
					<?php
				}
		else if(isset($_SESSION['admin_id']) && $_SESSION['rank'] == 1) 
				{?>
					<a href="<?php echo URL ?>">home</a>
					<a href="<?php echo URL . 'inmates/index' ?>">inmates</a>
					<a href="<?php echo URL . 'appointments/index' ?>">appointments</a>
					<a href="<?php echo URL . 'visits/index' ?>">visits</a>
					<a href="<?php echo URL . 'admins/index' ?>">admins</a>
					<a href="<?php echo URL . 'statistics/index' ?>">stats</a>
					<a href="<?php echo URL . 'visitors/logout' ?>">logout</a>
					<?php
				}
		else if(isset($_SESSION['admin_id']) && $_SESSION['rank'] == 2) 
				{?>
					<a href="<?php echo URL ?>">home</a>
					<a href="<?php echo URL . 'appointments/index' ?>">appointments</a>			
					<a href="<?php echo URL . 'visitors/logout' ?>">logout</a>
					<?php
				}				
			
				echo $_SESSION['username']??null;
				echo " ";
				echo $_SESSION['rank']??null;
?>
  
</div>