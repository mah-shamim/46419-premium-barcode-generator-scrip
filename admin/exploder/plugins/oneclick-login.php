<?php
/** 
 * Display a list of predefined database servers to login with just one click.
 * Don't use this in production enviroment unless the access is restricted
 *
 * @link https://www.adminer.org/plugins/#use
 * @author Gio Freitas, https://www.github.com/giofreitas
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */
class OneClickLogin {
	/** @access protected */
	var $servers, $driver;
	
	/** 
	 *
	 * Set supported servers
	 * @param array $servers
	 * @param string $driver
	 */
	function __construct($servers, $driver = "server") {

		$this->servers = $servers;
		$this->driver = $driver;
	}

	function login($login, $password) {
		// check if server is allowed
		return isset($this->servers[SERVER]);
	}
	
	function databaseValues($server){
		$databases = $server['databases'];
		if(is_array($databases))
			foreach($databases as $database => $name){
				if(is_string($database))
					continue;
				unset($databases[$database]);
				if(!isset($databases[$name]))
					$databases[$name] = $name;
			}
		return $databases;
	}
	
	function loginForm() {
		?>
		</form>
		<table>
			<tr>
				<th><?php echo lang('Server') ?></th>
				<th><?php echo lang('User') ?></th>
				<th><?php echo lang('Database') ?></th>
			</tr>
			
			<?php
			foreach($this->servers as $host => $server):
			
			
				$databases = isset($server['databases']) ? $server['databases'] : "";
				if (!is_array($databases))
					$databases = array($databases => $databases);
				
				foreach(array_keys($databases) as $i => $database):
					?>
					<tr>
						<?php if( $i === 0): ?>
							<td style="vertical-align:middle" rowspan="<?php echo count($databases) ?>"><?php echo isset($server['label']) ? "{$server['label']} ($host)" : $host; ?></td>
							<td style="vertical-align:middle" rowspan="<?php echo count($databases) ?>"><?php echo $server['username'] ?></td>
						<?php endif; ?>
						<td style="vertical-align:middle"><?php echo $databases[$database] ?></td>	
						<td>
							<form action="" method="post">
								<input type="hidden" name="auth[driver]" value="<?php echo $this->driver; ?>">
								<input type="hidden" name="auth[server]" value="<?php echo $host; ?>">
								<input type="hidden" name="auth[username]" value="<?php echo h($server["username"]); ?>">
								<input type="hidden" name="auth[password]" value="<?php echo h($server["pass"]); ?>">
								<input type='hidden' name="auth[db]" value="<?php echo h($database); ?>"/>
								<input type='hidden' name="auth[permanent]" value="1"/>
								<input type="submit" value="<?php echo lang('Enter'); ?>">
							</form>
						</td>
					</tr>
					<?php
				endforeach;
			endforeach;	
			?>
		</table>	
		<form action="" method="post">		
		<?php
		return true;
	}
	
}
