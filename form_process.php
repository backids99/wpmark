<?php
if (get_option('captcha_submit') == "yes" || get_option('captcha_submit') == "") {
require_once dirname( __FILE__ ) . '/includes/recaptchalib.php';
	// Get a key from http://recaptcha.net/api/getkey
	$publickey = get_option("pub_key");
	$privatekey = get_option("pvt_key");
}

if (isset($_POST['action']) && $_POST['action'] == 'post') {

	check_admin_referer( 'new-post' );
	$err = ""; $ok = "";
	$user_id 		= $current_user->user_id;
	$post_title 	= wpm_filter($_POST['post_title']);
	$post_cat 		= (int)wpm_filter($_POST['cat']);
	$post_cat_array	= array("$post_cat");

	if ( get_option('filter_html') == "yes" ) {
		$description 	= trim($_POST['description']);
		// $description 	= addslashes($_POST['description']);
		// $description	= str_replace("javascript", "", $description);
	} else {
		$description 	= wpm_filter($_POST['description']);
	}

	$name_ad 		= wpm_filter($_POST['name_ad']);
	$name 			= wpm_filter($_POST['name_owner']);
	$email 			= wpm_filter($_POST['email']);
//	$title 			= wpm_filter($_POST['title']);
	$URL	 		= wpm_filter($_POST['URL']);
	$post_tags 		= wpm_filter($_POST['post_tags']);
	$post_tags 		= wpm_filter($_POST['hidden-post_tags']);
	$wpm_adURL 		= wpm_filter($_POST['wpm_adURL']);
	$images 		= strip_tags($_POST['images']);

    $name = $current_user->user_login;
    $email = $current_user->user_email;
	
	if ( validLink($wpm_adURL) != true ) {
		$wpm_adURL = 'http://'.$wpm_adURL;
		$wpm_adURL = str_replace(array("https://http://","http://https://"), array("http://","https://"), $wpm_adURL);
	}

	$total = (int)$_POST['total'];
	$nr1 = (int)$_POST['nr1']; $nr1 = str_replace("892347", "", $nr1);
	$nr2 = (int)$_POST['nr2']; $nr2 = str_replace("234543", "", $nr2);
	$nr1nr2 = $nr1 + $nr2;

	if (get_option('captcha_submit') == "yes" || get_option('captcha_submit') == "") {
    $response = recaptcha_check_answer($privatekey,
	    $_SERVER["REMOTE_ADDR"],
	    $_POST["recaptcha_challenge_field"],
	    $_POST["recaptcha_response_field"]); 
			if (!$response->is_valid) {
               $err .= __("You didn't correctly enter the captcha, please try again.",'wpm') . "<br />";
			}
	}
        
	if ($post_title == "" || $post_cat == "" || $wpm_adURL == "" || $description == "") {
		$err .= __('Please fill in all mandatory * fields','wpm') . "<br />";
	} else {

		if (get_option("max_title") == "") { 
			$post_title = substr($post_title, 0, 30); 
		} else { 
			$post_title = substr($post_title, 0, get_option("max_title")); 
		}

		if (get_option('min_des') == "") {
			if(strlen($description) < 300) {
				$err .=__('Description is too short.','cp') . "<br />";
			}
		} else {
			if(strlen($description) < get_option('min_des')) {
				$err .=__('Description is too short.','cp') . "<br />";
			}
		}
			
		if (!get_option('bad') == ""){
			$bad = get_option('bad');
			$stringall = $description . $post_title . $post_tags;
			$badwords = explode (", ", $bad);
			$find = strposa($stringall, $badwords, 0);
				if ($find !== false) {
					$err .= __('The words not allowed, please remove the bad words.','wpm') . "<br />";
				}
			}

			$find_url = "http://, https://, ftp://";
			$ex_find_url = explode (", ", $find_url);
			if (get_option('filter_content_url') == "yes" || get_option('filter_content_url') == "" ){
			$result_find_url = strposa($post_title, $ex_find_url, 0);
				if ($result_find_url !== false) {
					$err .= __('URL not allowed in Title.','wpm') . "<br />";
				}
			}
			
			if (get_option('filter_title_url') == "yes" || get_option('filter_title_url') == "" ){
			$result_find_url = strposa($description, $ex_find_url, 0);
				if ($result_find_url !== false) {
					$err .= __('URL not allowed in Description','wpm') . "<br />";
				}
			}
			
			if (!get_option('ban') == ""){
				$find_ban = get_option('ban');
				$ex_ban = explode (", ", $find_ban);
				$res_ban = strposa($URL, $ex_ban, 0);
					if ($res_ban !== false ) {
						$err .= __('Your Domain has been banned.','wpm') . "<br />";
					}
			}
			
			if ( $post_cat == "-1") {
				$err .= __('Please select a category','wpm') . "<br />";
			} else {
				global $wpdb;
				$cat_ids = (array) $wpdb->get_col("SELECT `term_id` FROM $wpdb->terms");
					if ( !in_array($post_cat, $cat_ids) && $post_cat != "-1") {
						$err .= __('This category does not exist','wpm') . "<br />";
					}
			}	

	//result duplicate title
	if (get_option('dup_title') == "yes" || get_option('dup_title') == "") {
	$filterpost = $wpdb->get_results("SELECT ID, post_title 
			FROM $wpdb->posts WHERE post_status = 'publish'");

	foreach ( $filterpost as $filterp );
		if ($filterp->post_title == $_POST['post_title']) {
			$err .= __('Duplicate Title','wpm') . "<br />";
		}
	}
	
	//result duplicate content
	if (get_option('dup_desc') == "yes" || get_option('dup_desc') == "") {
	$filtercontent = $wpdb->get_results("SELECT ID, post_content 
			FROM $wpdb->posts WHERE post_status = 'publish'");

	foreach ( $filtercontent as $filterc );
		if ($filterc->post_content == $_POST['description']) {
			$err .= __('Duplicate Description','wpm') . "<br />";
		}
	}
	
	//result duplicate meta value wpm_adURL
	if (get_option('dup_url') == "yes" || get_option('dup_url') == "") {
	$values = $wpdb->get_col("SELECT meta_value
				FROM $wpdb->postmeta WHERE meta_key = 'wpm_adURL'" );
	foreach ( $values as $value );
		if ($value == $_POST['wpm_adURL']) {
			$err .= __('Duplicate URL','wpm') . "<br />";
		}
	}
	}

	if ( $err == "" ) {
   //1024 bytes = 1kb
   //1024000 bytes = 1mb
   if ( get_option('size') == "" ) {
	   $img_size = 1;
	   $img_size_1 = 100*1;
   } else {
	   $img_size = get_option('size');
	   $img_size_1 = 100*get_option('size');
   }
   $image_folder_name = "wpmarks";
   $size_bytes = 102400 * $img_size;
   $size_mb = $size_bytes / 102400;
   $limitedext = array(".gif",".png",".jpg",".jpeg");

		// http://codex.wordpress.org/Function_Reference/wp_upload_dir
		$upload_arr = wp_upload_dir();
		$dir_to_make = trailingslashit($upload_arr['basedir']) . $image_folder_name;
		// $dir_to_make = "images/upload";
		$image_baseurl = trailingslashit($upload_arr['baseurl']) . $image_folder_name;
		$image_name = substr(sanitize_title(alphanumericAndSpace($post_title)), 0, 20);
		
		$i = rand();
		$images = "";
		$err2 = "";
		while(list($key,$value) = each($_FILES['images']['name'])) {
			if(!empty($value)) {
				$filename = strtolower($value);
				$filename = str_replace(" ", "-", $filename);
				//get image extension
				$tipul = strrchr($filename,'.');
				$filename = $image_name."-$i".$tipul;
				$add = "$dir_to_make/$filename";
				$image = "$image_baseurl/$filename";
				//$add = "$filename";

           //Make sure that file size is correct
				$file_size = $_FILES['images']['size'][$key]; //getting the right size that coresponds with the image uploaded
           		if ($file_size == "0"){
              		$err2 .= __("The file $value has 0 bytes.",'wpm') . "<br />";
           		} else {
					if ($file_size > $size_bytes){
              			$err .= __("The file $value is bigger than $img_size_1 kB.",'wpm') . "<br />";
           			}
           		}
           		//check file extension
           		$ext = strrchr($filename,'.');
           		if ( (!in_array(strtolower($ext),$limitedext)) ) {
              		$err2 .= __("The file $value is not an image.",'wpm') . "<br />";
           		}


				//echo $_FILES['images']['type'][$key];
				if ( $err2 == "" ) {
					if (!file_exists($dir_to_make)) { mkdir($dir_to_make, 0777); }
					copy($_FILES['images']['tmp_name'][$key], $add);
					chmod("$add",0777);

					//$images .= get_option('home')."/".$add.",";
					$images .= $image . ",";

				}
				$err2 = "";
				$i++;
			}//if empty $value
		}//end while

	$hanya = $wpm_adURL;
	$hanya = strtolower($hanya);
	$parse = parse_url($hanya);
	$URL = $parse['host'];
	
		$post_status = get_option('post_status');	
		$post_id = wp_insert_post( array(
			'post_author'	=> $user_id,
			'post_title'	=> $post_title,
			'post_content'	=> $description,
			'post_category'	=> $post_cat_array,
			'post_status'	=> $post_status,
			'tags_input'	=> $post_tags
		) );
		
		wp_set_post_terms($post_id, $URL ,'URL', true);

		add_post_meta($post_id, 'name', $name, true);
		add_post_meta($post_id, 'email', $email, true);
		add_post_meta($post_id, 'images', $images, true);
		add_post_meta($post_id, 'wpm_adURL', $wpm_adURL, true);
		
				
		$ok = "ok";


		// send notification email
		if ( get_option('notif_ad') == "yes" || get_option('notif_ad') == "" ) {
			$user_info = get_userdata(1);
			$admin_email = $user_info->user_email;
			$subject2 = __('New ad submission','wpm');
			$email2 = __('Admin','wpm');
			$body = __('Someone has submitted a new link. Go to your admin panel to view it.','wpm') . "\n\n" . get_option('home')."/wp-admin/edit.php";
			
	    	wp_mail($admin_email,$subject2,$body,"From: $email2");
	    }

		if (get_option("post_status") == "draft") {
			wp_redirect( get_bloginfo( 'url' ) . '/?ok=ok' );
		} else {
			wp_redirect( get_bloginfo( 'url' ) . '/?ok=ok' );
		}
		exit;
	}
}

?>
