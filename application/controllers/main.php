<?php

class Main extends Sippy_controller {
	
	public function index() {	

		$template = $this->View('main_view');
		$template->render();
		
	}


}

