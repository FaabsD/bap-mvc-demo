<?php
// Dit bestand hoort bij de router, enb bevat nog een aantal extra functiesdie je kunt gebruiken
// Lees meer: https://github.com/skipperbent/simple-php-router#helper-functions
require_once __DIR__ . '/route_helpers.php';

// Hieronder kun je al je eigen functies toevoegen die je nodig hebt
// Maar... alle functies die gegevens ophalen uit de database horen in het Model PHP bestand

/**
 * Verbinding maken met de database
 * @return \PDO
 */
function dbConnect() {

	$config = get_config('DB');

	try {
		$dsn = 'mysql:host=' . $config['HOSTNAME'] . ';dbname=' . $config['DATABASE'] . ';charset=utf8';

		$connection = new PDO( $dsn, $config['USER'], $config['PASSWORD'] );

		$connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$connection->setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC );

		return $connection;

	} catch ( \PDOException $e ) {
		echo 'Fout bij maken van database verbinding: ' . $e->getMessage();
		exit;
	}

}

/**
 * Geeft de juiste URL terug: relatief aan de website root url
 * Bijvoorbeeld voor de homepage: echo url('/');
 *
 * @param $path
 *
 * @return string
 */
function site_url( $path = '' ) {
	return get_config( 'BASE_URL' ) . $path;
}

function get_config( $name ) {
	$config = require __DIR__ . '/config.php';
	$name = strtoupper( $name );

	if ( isset( $config[ $name ] ) ) {
		return $config[$name];
	}

	throw new \InvalidArgumentException( 'Er bestaat geen instelling met de key: ' . $name );
}

/**
 * Hier maken we de template engine en vertellen de template engine waar de templates/views staan
 * @return \League\Plates\Engine
 */
function get_template_engine() {

	$templates_path = get_config( 'PRIVATE' ) . '/views';

	return new League\Plates\Engine( $templates_path );

}


function validateRegisterData($data){
	$errors = [];
        // check op echt e-mailadres
        $email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
        $password = trim($data['password']);
        $fullname = $data['fullname'];
        $username = $data['username'];

        if ( $email === false ){
            $errors['email'] = "Geen geldig e-mailadres ingevuld";
        }
        // check of wachtwoord minstens 6 tekens bevat
        if ( strlen( $password ) < 6 ){
            $errors['password'] = "Wachtwoord is te kort (moet minstens 6 tekens bevatten)";
		}
		//Result array
		$data = [
			'email'=>$data['email'],
			'password'=>$password,
			'fullname'=>$fullname,
			'username'=>$username
		];

		return [
			'data'=>$data,
			'errors'=>$errors
		];
		
}
function userNotRegistered($email){
	    //Check of het email al in gebruik is
        $connection = dbConnect();
        $sql = "SELECT * FROM users WHERE email = :email";
        $statement = $connection->prepare( $sql );
		$statement->execute( [ 'email' => $email ] );
		
		return ($statement->rowCount() === 0);
}

function createUser($email, $password, $fullname, $username){
    $connection = dbConnect();
	 //geen gebruiker gevonden? Verder met opslaan
                $sql = "INSERT INTO users (email, full_name, user_name, password) 
                VALUES (:email, :fullname, :username, :password)";
                $statement = $connection->prepare( $sql );
                $safe_password = password_hash( $password, PASSWORD_DEFAULT );
                $params = [
                    'email' => $email,
                    'fullname' => $fullname,
                    'username' => $username,
                    'password' => $safe_password
                ];
                $statement->execute( $params );
               
}