<html lang = "en">
   <head>
      <title>Login</title>
   </head>
	
   <body>
      <h2>Enter Username and Password</h2> 

         <?php

            $msg = '';
            
            if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {

               $dbname = $_SERVER['DB_NAME'];
               $dbuser = $_SERVER['DB_USER'];
               $dbpassword = $_SERVER['DB_PASSWORD'];
               $dbhost = $_SERVER['DB_HOST'];
               $dbport = $_SERVER['DB_PORT'];
         		$pdo = new PDO('pgsql:dbname=' . $dbname . ';user=' . $dbuser . ';password=' . $dbpassword . ';host=' . $dbhost . ';port=' . $dbport);
				
				$sql = "SELECT username, password
				FROM users
				WHERE username = :username
				AND password = :pass";
				
				$sth = $pdo->prepare($sql);
				$sth->execute(array(':username' => $_POST['username'], ':pass' => $_POST['password']));
				$result = $sth->fetchAll();

				
				if (pg_num_rows($result) > 0) {
               $sql = "SELECT current_database() as name, version() as version";
               $sth = $pdo->prepare($sql);
               $sth->execute();
               $result = $sth->fetch();

				   $msg = 'Correct login, database name is ' . $result[0] . ', version is ' . $result[1];
				} else {
				   $msg = 'Wrong username or password';
               $sql = "SELECT current_database() as name, version() as version";
               $sth = $pdo->prepare($sql);
               $sth->execute();
               $result = $sth->fetch();

               $msg = 'Correct login, database name is ' . $result[0] . ', version is ' . $result[1];
				}
            }
         ?>
      
      <div>
         <form role = "form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method = "post">
            <h4><?php echo $msg; ?></h4>
            <input type = "text" name = "username" placeholder = "Username" required></br>
            <input type = "password" name = "password" placeholder = "Password" required>
            <button type = "submit" name = "login">Login</button>
         </form>
      </div> 
   </body>
</html>