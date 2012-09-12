<?php

class Download extends CI_Controller{

    public function __construct()
    {
       parent::__construct();
       $this->load->helper('download');
    }

	function download_file($path)
	{		
		$data = file_get_contents(BASEPATH."/files/".$path); // Read the file's contents
		$name = 'myphoto.jpg';
		force_download($name, $data);
	}
}

?>