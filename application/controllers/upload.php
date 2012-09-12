<?php

class Upload extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();
      $this->load->model('files_model');
      $this->load->database();
      $this->load->helper('url');
   }
 
   public function index()
   {
      $this->load->view('upload');
   }


   public function subject_search(){
      $term = $this->input->post('term');
      $this->load->model('files_index_model');
      //$term = str_replace(' ', '%', $term);
      $results = $this->files_index_model->subject_search($term);
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
      echo json_encode($results);
      //echo $this->db->last_query();

   }


   public function upload_file($course_subject, $course_number)
   {
      $path = $course_subject."/".$course_number;
      $status = "";
      $msg = "";
      $file_element_name = 'userfile';

      $config['hostname'] = 'server.local';
      $config['username'] = 'kent';
      $config['password'] = 'indiglo';
      $config['port']     = 21;
      $config['passive']  = FALSE;
      $config['debug']    = TRUE;

      $this->ftp->connect($config);

      /*$path_array = explode("/", $path);
      $course_subject = $path_array[0];
      $course_number = $path_array[1]; */     
      //$file_list = $this->ftp->list_files('./files/'.$course_subject); //list of all the files in the  directory
      $file_list = $this->ftp->list_files('files/');
      var_dump($file_list);
      if(!(in_array('./files/'.$path, $file_list)))
      {
         $this->ftp->mkdir('./files/'.$path, DIR_WRITE_MODE);
      }
      if (empty($_POST['title']))
      {
         $status = "error";
         $msg = "Please enter a title";
      }
    
      if ($status != "error")
      {
         if($path != "")
            $path.="/"; 
         $config['upload_path'] = './files/'.$path;
         $config['allowed_types'] = '*';
         $config['encrypt_name'] = FALSE;
    
         $this->load->library('upload', $config);
    
         if (!$this->upload->do_upload($file_element_name))
         {
            $status = 'error';
            $msg = $this->upload->display_errors('', '');
         }
         else
         {
            $data = $this->upload->data();
            $raw_name = $data['raw_name'];
            if($raw_name != $_POST['title'])
            {
               $list = $this->ftp->list_files('./files/'.$path); //list of all the files in the directory
               if(in_array('./files/'.$path.$_POST['title'].$data['file_ext'], $list)) // check to see if file name already exists
               {
                  unlink($data['full_path']);
                  $status = "error";
                  $msg = "The name has already been taken. Please choose another name for the file.";
               }
               else{
                  $this->ftp->rename('./files/'.$path.$data['file_name'], './files/'.$path.$_POST['title'].$data['file_ext'] );
               }
            }
            $file_id = $this->files_model->insert_file($data['file_name'], $_POST['title']);
            if($status != "error"){
               if($file_id)
               {
                  $status = "success";
                  $msg = "File successfully uploaded";
               }
               else
               {
                  unlink($data['full_path']);
                  $status = "error";
                  $msg = "Something went wrong when saving the file, please try again.";
               }
            }
         }
         @unlink($_FILES[$file_element_name]);
      }
      echo json_encode(array('status' => $status, 'msg' => $msg));
   }

   public function files()
   {
      $files = $this->files_model->get_files();
      $this->load->view('files_old', array('files' => $files));
   }

   public function delete_file($file_id)
   {
      if ($this->files_model->delete_file($file_id))
      {
         $status = 'success';
         $msg = 'File successfully deleted';
      }
      else
      {
         $status = 'error';
         $msg = 'Something went wrong when deleteing the file, please try again';
      }
      echo json_encode(array('status' => $status, 'msg' => $msg));
   }
}


