<?php

class Main extends Sippy_controller {
	
	public function index() {	

		$template = $this->View('main_view');
		$template->render();
		
	}

    public function hello() {

        echo "hello World!";

        $example = $this->Model('Example_model');
        $something = $example->getSomething($id);

    }


}

