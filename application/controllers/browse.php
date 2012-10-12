<?php

class Browse extends CI_Controller
{

	public function __construct()
	{
		session_start();
	    parent::__construct();
	    if ( !isset($_SESSION['email']) ) {
	        redirect('login');
	    }
	}
 
	public function index()
	{
		$config['hostname'] = 'server.local';
		$config['username'] = 'kent';
		$config['password'] = 'indiglo';
		$config['port']     = 21;
		$config['passive']  = FALSE;
		$config['debug']    = TRUE;

		$this->ftp->connect($config);
		$data['file_list'] = $this->ftp->list_files('files/');
		$data['map'] = $this->directory_listing(directory_map('files/', 2));

		$this->load->view('includes/header', $data);
		$this->load->view('browse', $data);
		$this->load->view('includes/footer', $data);
		//var_dump ($_SESSION);
	}

	public function directory_listing($map, $current_directory = "", $directory_only = false){
		$string = "<ul>";
		if($current_directory != "" && substr($current_directory , -1) != "/"){
			 $current_directory .= "/";
		}
		$files_string = ""; //I want to list all the folders first, files after, so I'll save the files here
		$files_array = array();
		$directories_array = array();
		foreach($map as $key => $file){
			 if(is_array($file)){
					if(strlen($key)> 25){
						 $file_name = substr($key,0,15)."...".substr($key,-5,5);
					}
					else
						 $file_name = $key;
					$string.= "<li class='directory'><a class='directory-link' href='files/".$current_directory.$key."'>$file_name</a>";
					//$string.= $this->directory_listing($file, $current_directory.$key."/" );
					$string.= "</li>";
					array_push($directories_array, array('path' => $current_directory.$key, 'name' => $file_name));
			 }else{
					$type = end(explode(".", $file)); 
					//var_dump($type);
					if(strlen($file)> 25){
						 $file_name = substr($file,0,15)."...".substr($file,-5,5);
					}
					else
						 $file_name = $file;
					$files_string.= "<li class='file $type'><a href='files/".$current_directory.$file."'>$file_name</a></li>";
					if(!$directory_only)
						array_push($files_array, array('path' => $current_directory.$file, 'name' => $file_name, 'type' => $type)); 
			 }
		};
		$string .= $files_string;
		$string .= "</ul>";
		$result = array("files" => $files_array, "directories" => $directories_array);
		return json_encode($result);
	}

	public function directory_listing_partial($map, $current_directory = "", $directory_only = false){
		$string = "<ul>";
		if($current_directory != "" && substr($current_directory , -1) != "/"){
			 $current_directory .= "/";
		}
		$files_string = ""; //I want to list all the folders first, files after, so I'll save the files here
		$files_array = array();
		$directories_array = array();
		foreach($map as $key => $file){
			 if(is_array($file)){
					if(strlen($key)> 25){
						 $file_name = substr($key,0,15)."...".substr($key,-5,5);
					}
					else
						 $file_name = $key;
					$string.= "<li class='directory'><a class='directory-link' href='files/".$current_directory.$key."'>$file_name</a>";
					//$string.= $this->directory_listing($file, $current_directory.$key."/" );
					$string.= "</li>";
					array_push($directories_array, array('path' => $current_directory.$key, 'name' => $file_name));
			 }else{
					$type = end(explode(".", $file)); 
					//var_dump($type);
					if(strlen($file)> 25){
						 $file_name = substr($file,0,15)."...".substr($file,-5,5);
					}
					else
						 $file_name = $file;
					$files_string.= "<li class='file $type'><a href='files/".$current_directory.$file."'>$file_name</a></li>";
					if(!$directory_only)
						array_push($files_array, array('path' => $current_directory.$file, 'name' => $file_name, 'type' => $type)); 
			 }
		};
		$string .= $files_string;
		$string .= "</ul>";
		$result = array("files" => $files_array, "directories" => $directories_array);
		//return json_encode($result);
		$this->load->view("_BrowseLevel", $result);
	}

	public function directory_map(){
		$dir = "";
		if(isset($_GET['directory']))
			 $dir = $_GET['directory'];
		$path = "files/".$dir;
		echo $this->directory_listing(directory_map($path, 2), $dir);
	}

	public function directory_map2(){
		$dir = "";
		if(isset($_GET['directory']))
			 $dir = $_GET['directory'];
		$path = "files/".$dir;
		echo $this->directory_listing_partial(directory_map($path, 2), $dir);
	}

	public function index_files($current_directory = "files/", $parent = NULL, $level = 0){
 		$map = directory_map($current_directory,2);
 		$this->load->model('files_index_model');
		if($current_directory != "" && substr($current_directory , -1) != "/"){
			 $current_directory .= "/";
		}
		foreach($map as $key => $file){
			if(strlen($key)> 25){
					 $shortened_file_name = substr($key,0,15)."...".substr($key,-5,5);
			}
			else{
					 $shortened_file_name = $key;
			}
			 if(is_array($file)){ //directory
			 	if(strlen($key)> 25){
					$shortened_file_name = substr($key,0,15)."...".substr($key,-5,5);
				}
				else{
					$shortened_file_name = $key;
				}
				$dir_id = $this->files_index_model->insert_file($key, $current_directory.$key, "directory", $shortened_file_name, $parent, $level);
				$this->index_files($current_directory.$key."/", $dir_id, $level+1 );
			 }else{ //file
			 	if(strlen($file)> 25){
					$shortened_file_name = substr($file,0,15)."...".substr($key,-5,5);
				}
				else{
					$shortened_file_name = $file;
				}
			 	$type = end(explode(".", $file)); 
				$this->files_index_model->insert_file($file, $current_directory.$file, $type, $shortened_file_name, $parent, $level );
			 }
		};
	}

	public function search(){
	 	$term = $this->input->post('term');
	 	$this->load->model('files_index_model');
	 	//$term = str_replace(' ', '%', $term);
	 	$results = $this->files_index_model->search($term);
	 	$files_array = array();
	 	$directory_array = array();
	 	foreach($results as $result){
	 		if(strstr($result->file_name, ".")){
	 			$files_array[] = $result;
	 		}
	 		else{
	 			$directory_array[]=$result;
	 		}
	 	}
	 	$results_array = array();
	 	$results_array['files'] = $files_array;
	 	$results_array['directory'] = $directory_array;
	 	echo json_encode($results_array);
	}

	public function get_similar_terms($term){
		$term = urldecode($term); 
		$term_array = str_split($term);
		for($i = 1; $i < sizeof($term_array); $i++){ // I want to check for cases where if the user types cs32 i wanna search for cs32 and cs 32
			if(is_numeric ($term_array[$i]) && !is_numeric($term_array[$i-1])){
				if(($term_array[$i-1] == ' ') && ctype_alpha($term_array[$i-2])){ //this is the case for cs 32-> cs32
					$first_half = substr($term, 0, $i-1);
					$second_half = substr($term, $i);
					echo $new_string = $first_half.$second_half;
				}
				else{
					$first_half = substr($term, 0, $i); //cs32 -> cs 32
					$second_half = substr($term, $i);
					echo $new_string = $first_half." ".$second_half;
				}
				break;
			}
		}
	}

	public function zip_file(){
		$this->load->library('zip');
		$this->zip->read_dir("files/Soc/"); 

		// Download the file to your desktop. Name it "my_backup.zip"
		$this->zip->download('my_backup.zip');
		echo "hello";
	}


}


