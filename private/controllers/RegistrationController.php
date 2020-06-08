<?php

    namespace Website\Controllers;

use function DI\create;

/**
     * Hier wordt de registratie afgehandeld
     * - de registratie pagina
     * - afhandelen formulier
     * - misschien de bevestigingslink?
     */
    class RegistrationController {
    	public function registrationPage() {

		$template_engine = get_template_engine();
		echo $template_engine->render('register');

//		$template_engine = get_template_engine();
//		echo $template_engine->render('homepage');

    }
    public function handleRegistration(){
        // hier wordt het formulier afgehandeld

        $result = validateRegisterData($_POST);
    
    
        if ( count( $result['errors'] ) === 0 ) {
            //Sla gebruiker op

            if ( userNotRegistered($result['data']['email']) ){
               createUser($result['data']['email'], $result['data']['password'], $result['data']['fullname'], $result['data']['username']);
                // Doorsturen naar bedankpagina
                $bedanktUrl = url('register.bedankpagina');
                redirect($bedanktUrl);


            } else{
                //anders aangeven dat het e-mail al wordt gebruikt
                $result['errors']['email'] = "Dit e-mailadres is al in gebruik";
            }
        }
        $template_engine = get_template_engine();
        echo $template_engine->render('register', ['errors' => $result['errors']]);
    }
    public function registrationThanks(){
        $template_engine = get_template_engine();
        echo $template_engine->render('bedankpagina');
    }
    }
    /*
    TODO Ervoor zorgen dat je wordt doorverwezen naar een bedanktpagina:
    http://bap.mediadeveloper.amsterdam/covid-19/gebruikers-registratie/06-redirect-bedankt-pagina/
    */
?>