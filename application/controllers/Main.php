<?php

defined('ROOT_DIR') OR exit('No direct script access allowed');

class Main extends Sippy_controller {


    public function __construct() {
        parent::__construct();
    }
	
	public function index() {	

		$template = $this->View('main_view');
		$template->render();
		
	}

    public function hello() {

        echo "Database Testing:<br />";

        $example = $this->Model('Example_model');
        $user = $example->getUser(2);
        echo $user->email;

    }

    public function test() {

        //use html helpers in controller too
        $data['foo'] = $this->html->splits("12345","");

        $template = $this->View('test_view', $data);
        $template->render();
    }


}

