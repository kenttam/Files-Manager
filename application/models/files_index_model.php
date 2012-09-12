<?php 
class Files_Index_Model extends CI_Model {
 
	public function insert_file($filename, $filepath, $filetype, $shortened_name, $parent, $level)
	{
		$data = array(
			'file_name'     => $filename,
			'file_path'        => $filepath,
			'file_type' => $filetype,
			'shortened_name' => $shortened_name,
			'parent' => $parent,
			'level' => $level
		);
		$this->db->where('file_path', $filepath);
		$this->db->from('files_index'); 
		if( $this->db->count_all_results() ==  0){
			$this->db->insert('files_index', $data);
			return $this->db->insert_id();
		}
		else{
			$this->db->where('file_path', $filepath);
			$this->db->from('files_index'); 
			return $this->db->get()->first_row()->id;
		}
		//return $this->db->insert_id();
	}

	public function search($term, $limit = 10){
		$term_array = str_split($term);
		for($i = 1; $i < sizeof($term_array); $i++){ // I want to check for cases where if the user types cs32 i wanna search for cs32 and cs 32
			if(is_numeric ($term_array[$i]) && !is_numeric($term_array[$i-1])){
				if(($term_array[$i-1] == ' ') && ctype_alpha($term_array[$i-2])){ //this is the case for cs 32-> cs32
					$first_half = substr($term, 0, $i-1);
					$second_half = substr($term, $i);
					$new_string = $first_half.$second_half;
				}
				else{
					$first_half = substr($term, 0, $i); //cs32 -> cs 32
					$second_half = substr($term, $i);
					$new_string = $first_half." ".$second_half;
				}
				break;
			}
		}
		$this->db->like('file_name', $term);
		if(isset($new_string)){
			$this->db->or_like('file_name', $new_string);
		}
		$query = $this->db->get('files_index', $limit);
		return $query->result();
		//$this->db->last_query();
	}

	public function subject_search($term, $limit = 10){
		$term_array = str_split($term);
		for($i = 1; $i < sizeof($term_array); $i++){ // I want to check for cases where if the user types cs32 i wanna search for cs32 and cs 32
			if(is_numeric ($term_array[$i]) && !is_numeric($term_array[$i-1])){
				if(($term_array[$i-1] == ' ') && ctype_alpha($term_array[$i-2])){ //this is the case for cs 32-> cs32
					$first_half = substr($term, 0, $i-1);
					$second_half = substr($term, $i);
					$new_string = $first_half.$second_half;
				}
				else{
					$first_half = substr($term, 0, $i); //cs32 -> cs 32
					$second_half = substr($term, $i);
					$new_string = $first_half." ".$second_half;
				}
				break;
			}
		}
		/*$this->db->where('level', 0); 
		$this->db->like('file_name', $term);
		if(isset($new_string)){
			$this->db->or_like('file_name', $new_string);
		}*/
		if(isset($new_string)){
			$query = $this->db->query(
				"SELECT * 
				FROM (`files_index`) 
				WHERE `level` = 0 
				AND `file_type` = 'directory'
				AND (`file_name` LIKE '%$term%' OR `file_name` LIKE '%$new_string%')"
			);
		}
		else{
			$query = $this->db->query(
				"SELECT * 
				FROM (`files_index`) 
				WHERE `level` = 0 
				AND `file_type` = 'directory'
				AND (`file_name` LIKE '%$term%')"
			);
		}
		//$query = $this->db->get('files_index', $limit);
		return $query->result();
		//$this->db->last_query();
	}



	public function get_files()
	{
		return $this->db->select()
				->from('files')
				->get()
				->result();
	}


	public function delete_file($file_id)
	{
		$file = $this->get_file($file_id);
		if (!$this->db->where('id', $file_id)->delete('files'))
		{
			return FALSE;
		}
		unlink('./files/' . $file->filename);
		return TRUE;
	}
 
	public function get_file($file_id)
	{
		return $this->db->select()
				->from('files')
				->where('id', $file_id)
				->get()
				->row();
	}
 
}

?>