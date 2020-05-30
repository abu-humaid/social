<?php  


	/**
	 * File Upload System 
	 */
	function fileUpload($file, $location = '', $file_format = ['jpg','png','gif'], $file_type = null){

		// File info 
		$file_name = $file['name'];
		$file_name_tmp = $file['tmp_name'];

		// file name extension 
		$file_array = explode('.',$file_name);
		$file_extension = strtolower(end($file_array));

		// File type defautl value 
		if ( !isset($file_type['type']) ) {
			$file_type['type'] = 'image';
		}

		if ( !isset($file_type['file_name']) ) {
			$file_type['file_name'] = '';
		}

		if ( !isset($file_type['fname']) ) {
			$file_type['fname'] = '';
		}

		if ( !isset($file_type['lname']) ) {
			$file_type['lname'] = '';
		}




		// file name with type 
		if ( $file_type['type'] == 'image' ) {
			
			// file name generate
			$file_name = md5(time().rand()) .'.'. $file_extension;

		}elseif($file_type['type'] == 'file'){

			$file_name = date('d_m_Y_g_h_s') .'_'.$file_type['file_name'] .'_'. $file_type['fname'] .'_'.$file_type['lname'] .'.'. $file_extension;
		}

		
		$mess = '';
		if( in_array($file_extension,  $file_format ) == false ){
			$mess =  '<p class="alert alert-danger"> Invalid File Format  ! <button class="close" data-dismiss="alert">&times;</button> </p>';
		}else{
			
			// file upload to dir
			move_uploaded_file( $file_name_tmp, $location .$file_name );

		}

		return [
			'mess'		=> $mess,
			'file_name'	=> $file_name
		];
		



	}




	// data check 
	function  dataCheck( $conn, $col_name, $data, $table ){

		$sql = "SELECT $col_name FROM $table WHERE $col_name='$data' ";
		$data = $conn -> query($sql);

		$num = $data -> num_rows;

		if ( $num > 0 ) {
			return false;
		}else{
			return true;
		}

	}



	// Form old data refill 
	function old($field_name){

		if ( isset($field_name) ) {
			
			if( isset($_POST[$field_name]) ){
				echo $_POST[$field_name];
			}

		}



	}


	// Flash message 
	function setMsg($msg){
		setcookie('msg', $msg, time() + 10);
	}

	function getMsg(){

		if ( isset($_COOKIE['msg']) ) {
			echo "<p class='alert alert-success'>". $_COOKIE['msg'] . '<button class="close" data-dismiss="alert">&times;</button> </p>';
		}
		

	}





