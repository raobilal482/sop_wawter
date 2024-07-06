<?php
error_reporting(E_ALL);
date_default_timezone_set('Asia/Karachi');
/*--------------Site Configuration--------------*/
$total_months=array(1=>'January',2=>'February',3=>'March',4=>'April',5=>'May',6=>'June',7=>'July',8=>'August',9=>'September',10=>'October',11=>'November',12=>'December');
$total_years=array(2020,2021,2022,2023,2024,2025);
$bed_list=array('B1','B2','B3');
function get_config($var){
	global $dblink;
	$sql="select value from panel_config_variable where `key`='".slash($var)."'";
	$resConfig=doquery($sql,$dblink);
	if(numrows($resConfig)>0){
		while($rowConfig=dofetch($resConfig))
			return unslash($rowConfig["value"]);
	}
}
$admin_email=get_config("admin_email");
$site_title=get_config("site_title");
$site_footer=get_config("site_footer");
$site_url=get_config("site_url");
$admin_logo=get_config("admin_logo");
function admin_logo(){
	global $admin_logo, $site_title, $site_url, $site_footer;
	echo '<a href="'.$site_url.'/admin">';
	if(!empty($admin_logo)){
		echo '<img src="../uploads/config/'.$admin_logo.'" alt="'.$site_title.'" title="'.$site_title.'" />';
	}
	else
		echo $site_title;
	echo '</a>';
}
function check_admin_cookie(){
	global $dblink;
	if(isset($_COOKIE["_admin_logged_in"])){
		$r=doquery("select * from panel_admin where id='".$_COOKIE["_admin_logged_in"]."'", $dblink);
		if(numrows($r)>0){
			$r=dofetch($r);
			$_SESSION["logged_in_admin"]=$r;
			return true;
		}
	}
	return false;
}
/*--------------Server Date--------------*/
$info = getdate();
$date = $info['mday'];
$month = $info['mon'];
$year = $info['year'];
$submit_date_server=$year."-".$month."-".$date;
/*------------------------------------------------*/
function change_pass_user($row){
   if($row['password'] == encryptpass('Stu%$PcasW@#')){
      header('Location: profile.php?err='.url_encode("Please change your password, 8-12 character long."));
	  exit;
   }
}
/*------------------------------------------------*/
function encryptpass($password) {
	return $password = hash('sha256', md5(base64_encode($password)));
}
/*-----------------------Check Password-------------------------*/
function checkpass($password) {
	return preg_match('#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#', $password);
}
/*--------------Image Type Validation--------------*/
$file_upload_root="../uploads/";
$file_upload_url=$site_url."/uploads/";
$imagetypes=array("image/bmp","image/x-windows-bmp","image/jpg","image/jpeg","image/png","image/x-png");
$filetypes=array("application/msword","application/pdf");
$ziptypes=array("rar","zip");
$month_array=array("Januray","February","March","April","May","June","July","August","September","October","November","December");
$videotypes=array("video/mpeg", "video/mpeg4", "video/avi", "video/flv", "video/mov", "video/avi", "video/mpg", "video/wmv", "video/vid");
$day_name=array('Zo', 'Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za');
$month_name=array('jan','feb','maa','apr','mei','juni','juli','aug','sep','oct','nov','dec');
/*--------------Send Mail Function--------------*/
require_once 'phpmailer/PHPMailerAutoload.php';

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->CharSet="UTF-8";
$mail->SMTPSecure = 'tls';
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->Username = 'no-reply@admissions.water.muet.edu.pk';
$mail->Password = 'lpdbp%UkU8p^';
$mail->SMTPAuth = true;

function sendmail($to, $subject, $message, $efrom){
	
	global $mail, $admin_email;
	$mail->ClearAllRecipients();
	$mail->setFrom($efrom);
	$mail->FromName = 'Admissions 2019';
	$mail->addReplyTo('admissions.uspcasw@admin.muet.edu.pk','Admissions 2019');
	$mail->addAddress($to);
	$mail->Subject = $subject;
	$mail->msgHTML($message);
	$mail->IsHTML(true);
	if (!$mail->send()) {
		@$headers  = 'MIME-Version: 1.0' . "\r\n";
		@$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		@$headers .= "From: ".$efrom;
		@mail($admin_email, "Email not sent through smtp: Email: ".$to." Subject: ".$subject, $message." <br/><br/><br/>ERROR MESSAGE: ".$mail->ErrorInfo,$headers);
	} else {
		//echo "Message sent!";
    }
}
//sendmail('engrmshahzad@hotmail.com','Testing','Admissions Email', $admin_email);

/*--------------Email Validation--------------*/
function emailok($email) {
  return preg_match('#^[a-z0-9.!\#$%&\'*+-/=?^_`{|}~]+@([0-9.]+|([^\s]+\.+[a-z]{2,6}))$#si', $email);
}
/*--------------CNIC Number Formate--------------*/
function formatCNICNumber($cnicNumber) {
    $cnicNumber = preg_replace('/[^0-9]/','',$cnicNumber);

    if(strlen($cnicNumber) == 13) {
        $firstFive = substr($cnicNumber, -13, 5);
        $nextSeven = substr($cnicNumber, -8, 7);
        $lastOne = substr($cnicNumber, -1, 1);

        $cnicNumber = $firstFive.'-'.$nextSeven.'-'.$lastOne;
    }
    return $cnicNumber;
}
/*--------------Phone Number Formate--------------*/
function formatPhoneNumber($phoneNumber) {
    $phoneNumber = preg_replace('/[^0-9]/','',$phoneNumber);

    if(strlen($phoneNumber) > 10) {
        $countryCode = substr($phoneNumber, 0, strlen($phoneNumber)-10);
        $areaCode = substr($phoneNumber, -10, 3);
        $nextThree = substr($phoneNumber, -7, 3);
        $lastFour = substr($phoneNumber, -4, 4);

        $phoneNumber = '+'.$countryCode.' ('.$areaCode.') '.$nextThree.'-'.$lastFour;
    }
    else if(strlen($phoneNumber) == 10) {
        $areaCode = substr($phoneNumber, 0, 3);
        $nextThree = substr($phoneNumber, 3, 3);
        $lastFour = substr($phoneNumber, 6, 4);

        $phoneNumber = '('.$areaCode.') '.$nextThree.'-'.$lastFour;
    }
    else if(strlen($phoneNumber) == 7) {
        $nextThree = substr($phoneNumber, 0, 3);
        $lastFour = substr($phoneNumber, 3, 4);

        $phoneNumber = $nextThree.'-'.$lastFour;
    }

    return $phoneNumber;
}
/*----------------------------------------*/
function slash($str){
	if(!is_array($str))
		return utf8_encode(addslashes($str));
	else{
		for($i=0; $i<count($str); $i++)
			$str[$i]=slash($str[$i]);
		return $str;
	}
}
function unslash($str){
	return stripslashes(utf8_decode($str));
	}
function url_encode($str){
	return base64_encode(urlencode($str));
	}
function url_decode($str){
	return urldecode(base64_decode($str));
	}			
/*--------------  Function--------------*/
function getrealip(){
    $ip = FALSE;
    if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
        if ($ip) {
            array_unshift($ips, $ip);
            $ip = FALSE;
        }
        for ($i = 0; $i < count($ips); $i++) {
            if (!eregi ("^(10|172\.16|192\.168)\.", $ips[$i])) {
                if (version_compare(phpversion(), "5.0.0", ">=")) {
                    if (ip2long($ips[$i]) != false) {
                        $ip = $ips[$i];
                        break;
                    }
                } else {
                    if (ip2long($ips[$i]) != -1) {
                        $ip = $ips[$i];
                        break;
                    }
                }
            }
        }
    }
    return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
}



/*--------------Create Thumb Function--------------*/
function createThumb($image_path,$image_type,$thumb_size,$thumb_path, $height=""){
	$img=$image_path;
	$newfilename=$thumb_path;
	$w=$thumb_size;
	$h=$thumb_size;
	if($height!="")
		$h=$height;
	//Check if GD extension is loaded
	if (!extension_loaded('gd') && !extension_loaded('gd2')) {
	    trigger_error("GD is not loaded", E_USER_WARNING);
        return false;
    }
    //Get Image size info
    $imgInfo = getimagesize($img);
    switch ($imgInfo[2]) {
        case 1: $im = imagecreatefromgif($img); break;

        case 2: $im = imagecreatefromjpeg($img);  break;

        case 3: $im = imagecreatefrompng($img); break;

        default:  trigger_error('Unsupported filetype!', E_USER_WARNING);  break;

    }
    //If image dimension is smaller, do not resize
    if ($imgInfo[0] <= $w && $imgInfo[1] <= $h) {
        $nHeight = $imgInfo[1];
        $nWidth = $imgInfo[0];
    }else{
    	if($height==""){
			if ($w/$imgInfo[0] < $h/$imgInfo[1]) {
				$nWidth = $w;
				$nHeight = $imgInfo[1]*($w/$imgInfo[0]);
	        }else{
				$nWidth = $imgInfo[0]*($h/$imgInfo[1]);
		        $nHeight = $h;
			}
		}
		else{
			$nWidth=$w;
			$nHeight=$h;
		}
	}
	$nWidth = round($nWidth);
	$nHeight = round($nHeight);
	$newImg = imagecreatetruecolor($nWidth, $nHeight);
	/* Check if this image is PNG or GIF, then set if Transparent*/  
	if(($imgInfo[2] == 1) OR ($imgInfo[2]==3)){
		imagealphablending($newImg, false);
		imagesavealpha($newImg,true);
        $transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
        imagefilledrectangle($newImg, 0, 0, $nWidth, $nHeight, $transparent);
	}
    imagecopyresampled($newImg, $im, 0, 0, 0, 0, $nWidth, $nHeight, $imgInfo[0], $imgInfo[1]);
	//Generate the file, and rename it to $newfilename
    switch ($imgInfo[2]) {
	    case 1: imagegif($newImg,$newfilename); break;

        case 2: imagejpeg($newImg,$newfilename);  break;

        case 3: imagepng($newImg,$newfilename); break;

        default:  trigger_error('Failed resize image!', E_USER_WARNING);  break;

    }
    return $newfilename;
}

function get_image($img, $size, $folder){
	global $site_url;
	if(!empty($img)){
		$ext=explode(".", $img);
		$ext=$ext[count($ext)-1];
		$image_name=str_replace(".".$ext, "", $img);
		if(file_exists($folder."/thumbnails/".$image_name."_".$size.".".$ext)){
			return $folder."/thumbnails/".$image_name."_".$size.".".$ext;
		}
		else{
			switch($size){
				case "large": $width=800; break;
				case "medium": $width=240; break;
				case "thumbnail": $width=130; break;
				case "avatar": $width=56; break;
		}
			if(!is_dir($folder."/thumbnails"))
				mkdir($folder."/thumbnails");
			createThumb($folder."/".$img,"", $width, $folder."/thumbnails/".$image_name."_".$size.".".$ext);
			return $folder."/thumbnails/".$image_name."_".$size.".".$ext;
		}
	}
	return;
}


function get_image_mcp($img, $size, $folder){
	if(!empty($img)){
		$ext=explode(".", $img);
		$ext=$ext[count($ext)-1];
		$image_name=str_replace(".".$ext, "", $img);
		if(file_exists($folder."/thumbnails/".$image_name."_".$size.".".$ext)){
			unlink($folder."/thumbnails/".$image_name."_".$size.".".$ext);
		}
		switch($size){
			case "large": $width=800; break;
			case "medium": $width=240; break;
			case "thumbnail": $width=130; break;
			case "avatar": $width=56; break;
			
			if(!is_dir($folder."/thumbnails"))
				mkdir($folder."/thumbnails");
			createThumb($folder."/".$img,"", $width, $folder."/thumbnails/".$image_name."_".$size.".".$ext);
			return $folder."/thumbnails/".$image_name."_".$size.".".$ext;
		}
	}
	return;
}

/*-------------- Function--------------*/
function get_bitly( $url ){
    $options = array(
        CURLOPT_RETURNTRANSFER => true,     // return web page
        CURLOPT_HEADER         => false,    // don't return headers
        CURLOPT_FOLLOWLOCATION => true,     // follow redirects
        CURLOPT_ENCODING       => "",       // handle all encodings
        CURLOPT_USERAGENT      => "spider", // who am i
        CURLOPT_AUTOREFERER    => true,     // set referer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
        CURLOPT_TIMEOUT        => 120,      // timeout on response
        CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
    );
	$url='http://api.bit.ly/shorten?version=2.0.1&longUrl='.$url.'&login=sacom&apiKey=R_792325a8f2b7d40db961199f59672dfe';
    $ch      = curl_init( $url );
    curl_setopt_array( $ch, $options );
    $content = curl_exec( $ch );
    $err     = curl_errno( $ch );
    $errmsg  = curl_error( $ch );
    $header  = curl_getinfo( $ch );
    curl_close( $ch );
    $header['errno']   = $err;
    $header['errmsg']  = $errmsg;
    $header['content'] = $content;
	$sar=explode('"',$content);
	return $sar[17];
}

/*--------------getCountryCombo Function--------------*/
function getCountryCombo($country){
 	global $dblink;
 	$rs=doquery("select iso, printable_name from country",$dblink);
 	$str="<select name='country'><option value=''>Select Any</option>";
	 while($r=dofetch($rs)){
	 	if($country==$r["iso"])
			$selected="selected";
		else
			$selected="";
		$str.="<option value='".$r["iso"]."' ".$selected.">".$r["printable_name"]."</option>";
 	}
 	$str.="</select>";
 	return $str;
}

/*--------------getCountryName Function--------------*/
function getCountryname($country){
	global $dblink;
	$r=dofetch(doquery("select printable_name from country where iso='$country'",$dblink));
	return $r["printable_name"];
}

/*--------------getPaymentType Function--------------*/
function getPaymentType($value){
	if($value)
		return "Debit";
	else
		return "Credit";
}

/*--------------Sorttable Function--------------*/
function sorttable($table,$id,$sort,$type,$more_cond=''){
	global $dblink;
	if($more_cond!="")
		$more_cond=' and '.$more_cond;
	if($type=="add"){
		$res=doquery("select sortorder from ".$table." where sortorder>=".$sort.$more_cond,$dblink);
		if(numrows($res)>0){
			doquery("update ".$table." set sortorder=sortorder+1 where sortorder >=".$sort.$more_cond,$dblink);
		}
		doquery("update ".$table." set sortorder=".$sort." where id=".$id,$dblink);
	}
	if($type=="edit"){
		$rs=doquery("select sortorder from $table where id='$id'",$dblink);
		if(numrows($rs)>0){
			$r=dofetch($rs);
			if($r["sortorder"]>$sort){
				doquery("update $table set sortorder=sortorder+1 where sortorder>=$sort and sortorder<".$r["sortorder"].$more_cond,$dblink);
			}
			elseif($r["sortorder"]<$sort){
				doquery("update $table set sortorder=sortorder-1 where sortorder<=$sort and sortorder>".$r["sortorder"].$more_cond,$dblink);
			}
			doquery("update $table set sortorder=$sort where id='".$id."'",$dblink);		
		}
	}
	if($type=="delete"){
		$rs=doquery("select sortorder from $table where id='$id'",$dblink);
		if(numrows($rs)>0){
			$r=dofetch($rs);
			doquery("update $table set sortorder=sortorder-1 where sortorder>".$r["sortorder"].$more_cond, $dblink);
		}
	}
}

/*--------------getCMS Function--------------*/
function getCMS($id){
	global $dblink;
	$rs=doquery("select title, body from cms where id='$id'",$dblink);
	if(numrows($rs)>0){
		$r=dofetch($rs);
		$r["title"]=stripslashes($r["title"]);
		$r["body"]=stripslashes($r["body"]);
	}
	else{
		$r["title"]="Oops Page not found";
		$r["body"]="The page you requested is not found on this server.";
	}
	return $r;
}

/*--------------generate_seo_link Function--------------*/
function generate_seo_link($input,$replace = '-',$remove_words = true,$words_array = array()){
	$return = trim(preg_replace('/[^a-zA-Z0-9\s]/','',strtolower($input)));
	if($remove_words){
		$return = remove_words($return,$replace,$words_array);
	}
	return str_replace(' ',$replace,$return);
}

/*--------------Remove_words Function--------------*/
function remove_words($input,$replace,$words_array = array(),$unique_words = true){
	$input_array = explode(' ',$input);
	$return = array();
	foreach($input_array as $word){
		if(!in_array($word,$words_array) && ($unique_words ? !in_array($word,$return) : true)){
			$return[] = $word;
		}
	}
	return implode($replace,$return);
}

/*--------------getFilename Function--------------*/
function getFilename($originalname, $title){
	$ext=explode(".", $originalname);
	$ext=$ext[count($ext)-1];
	return generate_seo_link($title).".".$ext;
}

/*--------------getSortCombo Function--------------*/
function getSortCombo($table,$selected,$type,$more_cond='')
{
	global $dblink;
	if($more_cond!="")
		$more_cond=' and '.$more_cond;
	$sql="select count(id) from $table where 1".$more_cond;
	$res=doquery($sql,$dblink);
	$row=dofetch($res);
	if($type=="add")
		$cnt=$row[0]+1;
	else
		$cnt=$row[0];
	echo "<select name='sortorder' class='form-control col-md-4'>";
	for($i=1;$i<=$cnt;$i++)
	{
		if($selected>0)
		{
			if($i==$selected)
				echo "<option value='$i' selected>$i</option>";
			else
				echo "<option value='$i'>$i</option>";
		}
		else
		{
			if($i==$cnt)
				echo "<option value='$i' selected>$i</option>";
			else
				echo "<option value='$i'>$i</option>";
		}
	}
	echo "</select>";
}

/*--------------getInputBox Function--------------*/
function getInputBox($type, $value, $id, $class,$default_values){
	global $file_upload_url;
	switch($type){
		case "text":
				echo '<input type="text" size="62%" name="text_'.$id.'" class="'.$class.'" value="'.$value.'" />';
        break;
		case "submit":
			echo '<input type="submit" name="submit_'.$id.'" class="'.$class.'" value="'.$value.'" />';
	    break;
		case "button":
			echo '<input type="button" name="submit_'.$id.'" class="'.$class.'" value="'.$value.'" />';
	    break;
		case "file":
			if ($value != "") {
			echo '<input type="file" size="50%" name="file_'.$id.'" class="'.$class.'" /><a href="'.$file_upload_url.'/config/'.$value.'" target="_blank" style=" color:#000;">&nbsp;&nbsp;Previous File</a>';
			}
			else{
				echo '<input type="file" size="50%" name="file_'.$id.'" class="'.$class.'" />&nbsp;&nbsp;No File Exist';
				}
        break;
		case "textarea":
			echo '<textarea name="textarea_'.$id.'" class="'.$class.'" cols="80" rows="5">'.$value.'</textarea>';
        break;
		case "editor";
			echo '<textarea name="editor_'.$id.'" id="editor_'.$id.'" class="'.$class.' summernote">'.$value.'</textarea>';
        break;
		case "radio":
			$radioarray=explode(";",$default_values);
			foreach($radioarray as $radio){
			if(strpos($radio, ":selected")!== FALSE){
				$selected='checked="checked"';
				$radio=str_replace(":selected", "", $radio);
			}
			else
				$selected="";
			echo '<input type="radio" name="radio_'.$id.'" value="'.$radio.'" '.$selected.' class="'.$class.'" />'.$radio.'';
			}
        break;
		case "checkbox":
			$checkarray=explode(";",$default_values);
			foreach($checkarray as $check){
			if(strpos($check, ":selected")!== FALSE){
				$selected='checked="checked"';
				$check=str_replace(":selected", "", $check);
			}
			else
				$selected="";
			echo '<input type="checkbox" name="checkbox_'.$id.'[]" value="'.$check.'" '.$selected.' class="'.$class.'" />'.$check.'';
			}
		break;
		case "combobox":
			$optionsarray=explode(";",$default_values);
			echo '<select name="combobox_'.$id.'" class="'.$class.'">';
			foreach($optionsarray as $option){
			if(strpos($option, ":selected")!== FALSE){
				$selected='selected="selected"';
				$option=str_replace(":selected", "", $option);
			}
			else
				$selected="";
			echo '<option value="'.$option.'" '.$selected.'>'.$option.'</option>';
			}
			echo '</select>';
		break;
	}
}
/////////////////////////Date Convert///////////////////////////

function date_dbconvert($date){
	return date("Y-m-d", strtotime($date));
}
function date_convert($date_added){
	if($date_added != '1970-01-01' && $date_added != '0000-00-00' ){
		return date("d-m-Y", strtotime($date_added));
	}
}
function get_title($table_id, $table){
 global $dblink;
 $rs=doquery("select title from $table where id=$table_id", $dblink);
 if(numrows($rs)>0){
  $r=dofetch($rs);
  return unslash($r["title"]);
 }
}
function get_field($table_id, $table, $field_name='title'){
 	global $dblink;
 	$rs=doquery("select ".$field_name." from $table where id='".$table_id."'", $dblink);
 	if(numrows($rs)>0){
 		$r=dofetch($rs);
 		return unslash($r[$field_name]);
 	}
}

function get_country($table_id, $table){
	global $dblink;
	$rs=doquery("select country from $table where id=$table_id", $dblink);
	if(numrows($rs)>0){
		$r=dofetch($rs);
		return unslash($r["country"]);
	}
}

function get_page_url($page_id){
	global $dblink, $site_url;
	$page=doquery("select seo_url_path, seo_url from pages where id='".$page_id."'", $dblink);
	$url="";
	if(numrows($page)>0){
		$page=dofetch($page);
		$path=unslash($page["seo_url_path"]);
		$seo_url=unslash($page["seo_url"]);
		$url=$site_url."/".($path!=""? $path."/":"").$seo_url.".html";
	}
	return $url;
}
function get_name($table_id, $table){
	global $dblink;
	$rs=doquery("select name from $table where id=$table_id", $dblink);
	if(numrows($rs)>0){
		$r=dofetch($rs);
		return unslash($r["name"]);
	}
}

function get_username($table_id, $table){
	global $dblink;
	$rs=doquery("select username from $table where id=$table_id", $dblink);
	if(numrows($rs)>0){
		$r=dofetch($rs);
		return unslash($r["username"]);
	}
}

function get_menu($position, $parent=0){
	global $dblink, $site_url;
	$rs=doquery("select * from frontmenus where position='".$position."' and status=1 and parentid='".$parent."' order by sortorder", $dblink);
	if(numrows($rs)>0){
		$str='<ul>';
		while($r=dofetch($rs)){
			if(unslash($r["url"])=="#age-group"){
				$str.='<li><a href="#">'.unslash($r["title"]).'</a>';
				$rs1=doquery("select title, seo_url from age_group where status='1' order by sortorder", $dblink);
				if(numrows($rs1)>0){
					$str.='<ul>';
					while($r1=dofetch($rs1)){
						$str.='<li><a href="'.$site_url."/".unslash($r1["seo_url"]).'.html">'.unslash($r1["title"]).'</a></li>';
					}
					$str.='</ul>';
				}
				$str.='</li>';
			}
			else{
				$str.='<li><a href="'.(strpos($r["url"], "//")!==false? unslash($r["url"]):$site_url."/".unslash($r["url"])).'">'.unslash($r["title"]).'</a>';
				$str.=get_menu($position, $r["id"]);
				$str.='</li>';
			}
		}
		$str.='</ul><div class="clr"></div>';
		return $str;
	}
}
function curr_format($amount){
	return get_config("currency_symbol").number_format($amount, 0, '.',',')." ".get_config("currency_code");
}
$all_sites_array=array();
function get_site($site_name){
	global $dblink;
	if(!isset($all_sites_array[$site_name])){
		$rs=doquery("select * from auction_site where title='".slash($site_name)."'", $dblink);
		if(numrows($rs)>0){
			$r=dofetch($rs);
			$all_sites_array[$site_name]=$r;
		}
	}
	if(isset($all_sites_array[$site_name]))
		return $all_sites_array[$site_name];
}
function file_content($url, $site_name){
	$filename=generate_seo_link($url).".html";
	if(is_file("module/".$site_name."/cache/".$filename) && (time()-filemtime("module/".$site_name."/cache/".$filename))<3600){
		$content=file_get_contents("module/".$site_name."/cache/".$filename);
	}
	else{
		$site=get_site($site_name);
		if(isset($_SESSION["current_running_site"][$site_name]["total_pages"]) && $site["batch_size"]<=$_SESSION["current_running_site"][$site_name]["total_pages"]){
			sleep($site["batch_delay"]);
			$_SESSION["current_running_site"][$site_name]["total_pages"]=0;
		}
		if(!isset($_SESSION["current_running_site"][$site_name]["total_pages"]))
			$_SESSION["current_running_site"][$site_name]["total_pages"]=1;
		else
			$_SESSION["current_running_site"][$site_name]["total_pages"]++;
		$content=file_get_contents($url);
		file_put_contents("module/".$site_name."/cache/".$filename, $content);
	}
	return $content;
}

function clean_text($str){
	return trim(preg_replace('/\s+/', ' ', strip_tags($str)));
}
/*-----------------------------Get Image--------------------------*/
function deleteFile($filepath){
	if(is_file($filepath)){
		unlink($filepath);
	}
	global $site_url;
	$ext=substr($filepath, strrpos($filepath, '.')+1);
	$filepath=substr($filepath, 0, strrpos($filepath, '.'));
	$image_path=substr($filepath, 0, strrpos($filepath, '/'));
	$image_name=substr($filepath, strrpos($filepath, '/')+1);
	$image_name=$image_path."/thumbnails/".$image_name;
	if(file_exists($image_name."_large.".$ext)){
		unlink($image_name."_large.".$ext);
	}
	if(file_exists($image_name."_medium.".$ext)){
		unlink($image_name."_medium.".$ext);
	}
	if(file_exists($image_name."_thumbnails.".$ext)){
		unlink($image_name."_thumbnail.".$ext);
	}
	if(file_exists($image_name."_avatar.".$ext)){
		unlink($image_name."_avatar.".$ext);
	}
}
function get_category_id($str){
	global $dblink;
	$str=explode(" - ", $str);
	$str=$str[0];
	$rs=doquery("select id from auction_category where title='".slash($str)."'", $dblink);
	if(numrows($rs)>0){
		$r=dofetch($rs);
		$category_id=$r["id"];
	}
	else{
		$rs=doquery("select auction_category_id from auction_category_acronym where title='".slash($str)."'", $dblink);
		if(numrows($rs)>0){
			$r=dofetch($rs);
			$category_id=$r["auction_category_id"];
		}
		else{
			/*if(!empty($str)){
				doquery("insert into auction_category(title) values('".slash($str)."')", $dblink);
				$category_id=mysql_insert_id();
			}
			else*/
				$category_id=0;
		}
	}
	return $category_id;
}

function get_location_id($str){
	global $dblink;
	$rs=doquery("select id from auction_location where title='".slash($str)."'", $dblink);
	if(numrows($rs)>0){
		$r=dofetch($rs);
		$location_id=$r["id"];
	}
	else{
		$rs=doquery("select auction_location_id from auction_location_acronym where title='".slash($str)."'", $dblink);
		if(numrows($rs)>0){
			$r=dofetch($rs);
			$location_id=$r["auction_location_id"];
		}
		else{
			if(!empty($str)){
				doquery("insert into auction_location(title) values('".slash($str)."')", $dblink);
				$location_id=mysql_insert_id();
			}
			else
				$location_id=0;
		}
	}
	return $location_id;
}

function get_category_name($category_id){
	$title=get_title($category_id, "auction_category");
	return empty($title)?"Uncategorized":$title;
}
function get_location_name($location_id){
	$title=get_title($location_id, "auction_location");
	return empty($title)?"Unknown":$title;
}
function submission_count($cat_id=0){
	global $dblink;
	$sql="select count(1) from submission where status=1";
	if($cat_id!=0)
		$sql.=" and (category_id='".$cat_id."' or category_id in (select id from category where parent_id='".$cat_id."'))";
	$rs=dofetch(doquery($sql, $dblink));
	return $rs["count(1)"];
}
function get_the_excerpt($str){
	if(strlen($str)>35)
		return substr($str, 0, 35)."...";
	else
		return $str;
}
function user_link($user_id, $return=0, $extra=""){
	global $dblink, $site_url;
	$rs=doquery("select username from users where id='".$user_id."'", $dblink);
	if(numrows($rs)>0){
		$r=dofetch($rs);
		$username=unslash($r["username"]);
	}
	else
		$username='Anonymous';
	$link=$site_url.'/profile/'.$username;
	if($extra!="")
		$link.="?".$extra;
	if($return)
		return $link;
	else
		echo 'by <a href="'.$link.'">'.$username.'</a>';
}
function post_link($post_id, $extra=""){
	global $site_url;
	$link='post/'.$post_id."/".generate_seo_link(get_title($post_id, "submission")).".html";
	if($extra!="")
		$link.='?'.$extra;
	return $site_url."/".$link;
}
function blog_post_link($post_id, $extra=""){
	global $site_url;
	$link='blog/post/'.$post_id."/".generate_seo_link(get_title($post_id, "blog_post")).".html";
	if($extra!="")
		$link.='?'.$extra;
	return $site_url."/".$link;
}
function submission_link($submission_id, $extra="",$page){
	$link=$page.'?id='.$submission_id;
	if($extra!="")
		$link.='&'.$extra;
	return $link;
}

function get_parent_cat($id){
	global $dblink;
	$r=doquery("select parent_id from category where id='".$id."'", $dblink);
	if(numrows($r)>0){
		$r=dofetch($r);
		return $r["parent_id"]==0?$id:$r["parent_id"];
	}
	else
		return 0;
}
function user_avatar($user){
	global $site_url;
	if(isset($user["avatar"]) && !empty($user["avatar"]))
		echo '<img class="avatar" src="'.$site_url."/".get_image(unslash($user["avatar"]), 'avatar', 'uploads/user_avatar').'" alt="'.$user["username"].'" width="56" height="56">';
	else
		echo '<img class="avatar" src="'.$site_url.'/images/default-user.png" alt="'.$user["username"].'" width="56" height="56">';
}
function get_user($user_id){
	global $dblink;
	$r=doquery("select * from users where id='".$user_id."'", $dblink);
	if(numrows($r)>0){
		$r=dofetch($r);
		return $r;
	}
	return false;
}
function get_time_diff($time){
	$periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
   	$lengths = array("60","60","24","7","4.35","12","10");
	$now = time();
	$difference     = $now - strtotime($time);
    $tense         = "ago";
   	for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
		$difference /= $lengths[$j];
   	}
	$difference = round($difference);
	if($difference != 1) {
    	$periods[$j].= "s";
   	}
   	if($j==0)
   		$difference="few";
   	return "$difference $periods[$j] ago";
}
function follow_link($user_id){
	global $dblink;
	$is_follower=false;
	if(isset($_SESSION["user"])){
		$rs=doquery("select * from user_followers where user_id='".$user_id."' and follower_id='".$_SESSION["user"]["id"]."'", $dblink);
		if(numrows($rs)>0)
			$is_follower=true;
	}
	if($is_follower)
		echo '<a href="'.user_link($user_id, 1, "follow=1").'" class="bttn mini sub follow green"><i class="fa fa-check"></i> Following</a>';
	else
		echo '<a href="'.user_link($user_id, 1, "follow=1").'" class="bttn mini sub follow"><i class="fa fa-rss"></i> Follow</a>';
}
function comments_count($post_id){
	global $dblink;
	$r=dofetch(doquery("select count(1) as total from post_comments where status=1 and post_id='".$post_id."'", $dblink));
	if($r["total"]==1)
		$rtn="<strong>1</strong> Comment";
	else
		$rtn="<strong>".$r["total"]."</strong> Comments";
	echo $rtn;
}
function blog_comments_count($post_id){
	global $dblink;
	$r=dofetch(doquery("select count(1) as total from blog_post_comments where status=1 and post_id='".$post_id."'", $dblink));
	if($r["total"]==1)
		$rtn="<strong>1</strong> Comment";
	else
		$rtn="<strong>".$r["total"]."</strong> Comments";
	echo $rtn;
}
function rand_str($length){
	$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
	$str='';
	for($i=0; $i<$length; $i++){
		$str.=$chars[rand(0, strlen($chars))];
	}
	return $str;
}
function put_random_link($content, $url){
	$paragraphs=explode("\n", $content);
	$paragraph=rand(1, count($paragraphs));
	$paragraph=$paragraphs[$paragraph-1];
	if(strpos($paragraph, '<')!==false){
		$raw_sentenses=explode("<", $paragraph);
		$sentenses=array();
		foreach($raw_sentenses as $k=>$v){
			$temp_sentense=rtrim(trim(substr($v, strpos($v, ">")), ">"));
			if($temp_sentense!="")
				$sentenses[]=$temp_sentense;
		}
		if(count($sentenses)>0){
			$sentense=rand(1, count($sentenses));
			$sentense=$sentenses[$sentense-1];
		}
	}
	if(isset($sentense)){
		$words=explode(" ", $sentense);
		if(count($words)>7)
			$total_words=7;
		else
			$total_words=count($words);
		$word_count=rand(1, $total_words);
		$start_word=rand(1, count($words)-$word_count);
		$word="";
		for($i=$start_word; $i<=$start_word+$word_count-1; $i++)
			$word.=$words[$i-1]." ";
		$word=trim($word);
		return str_replace($word, '<a href="'.$url.'">'.$word.'</a>', $content);		
	}
	return $content;
}
function put_random_tag($content, $tag){
	$paragraphs=explode("\n", $content);
	$paragraph=rand(1, count($paragraphs));
	$paragraph=$paragraphs[$paragraph-1];
	if(strpos($paragraph, '<')!==false){
		$raw_sentenses=explode("<", $paragraph);
		$sentenses=array();
		foreach($raw_sentenses as $k=>$v){
			$temp_sentense=rtrim(trim(substr($v, strpos($v, ">")), ">"));
			if($temp_sentense!="")
				$sentenses[]=$temp_sentense;
		}
		if(count($sentenses)>0){
			$sentense=rand(1, count($sentenses));
			$sentense=$sentenses[$sentense-1];
		}
	}
	if(isset($sentense)){
		$words=explode(" ", $sentense);
		if(count($words)>7)
			$total_words=7;
		else
			$total_words=count($words);
		$word_count=rand(1, $total_words);
		$start_word=rand(1, count($words)-$word_count);
		$word="";
		for($i=$start_word; $i<=$start_word+$word_count-1; $i++)
			$word.=$words[$i-1]." ";
		$word=trim($word);
		return str_replace($word, '<'.$tag.'>'.$word.'</'.$tag.'>', $content);		
	}
	return $content;
}
function put_random_video($content, $video){
	$paragraphs=explode("\n", $content);
	$paragraph=rand(1, count($paragraphs));
	$paragraph=$paragraphs[$paragraph-1];
	return str_replace($paragraph, $paragraph.'<div class="random_video">'.$video.'</div>', $content);		
}

function removedir($dir) {
   	$files = array_diff(scandir($dir), array('.','..'));
   	foreach ($files as $file) {
   		(is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
}
function get_new_sort_order($table){
	global $dblink;
	$sort=dofetch(doquery("select count(id) from ".$table,$dblink));
	$sort=$sort["count(id)"];
	$sort=$sort+1;
	return $sort;
}
function get_fontawesome_icons(){
	$icons_array=array();
	$str=file_get_contents("font-awesome/css/font-awesome.css");
	if(preg_match_all('/fa-(.*):before\s*{\s*(.*)"/', $str, $matches)){
		$icons=$matches[1];
		$icon_codes=$matches[2];	
		for($i=0; $i<count($icons); $i++){
			$code=str_replace("content: \"\\", '', $icon_codes[$i]);
			$icons_array[]=array($icons[$i], $code);
		}
	}
	return $icons_array;
}
function update_meta($table, $table_id, $meta_key, $meta_value){
	global $dblink;
	$rs=doquery("select id from ".$table."_meta where ".$table."_id='".$table_id."' and meta_key='".slash($meta_key)."'", $dblink);
	if(numrows($rs)>0){
		$r=dofetch($rs);
		$id=$r["id"];
		doquery("update ".$table."_meta set meta_value='".slash($meta_value)."' where id='".$id."'", $dblink);
	}
	else{
		doquery("insert into ".$table."_meta(".$table."_id, meta_key, meta_value) values('".$table_id."', '".slash($meta_key)."', '".slash($meta_value)."')", $dblink);
	}
}
function get_meta($table, $table_id, $meta_key, $meta_value=""){
	global $dblink;
	$rtn="";
	$rs=doquery("select meta_value from ".$table."_meta where ".$table."_id='".$table_id."' and meta_key='".slash($meta_key)."'", $dblink);
	if(numrows($rs)>0){
		$r=dofetch($rs);
		$rtn=unslash($r["meta_value"]);
	}
	else{
		$rtn=$meta_value;
	}
	return $rtn;
}
/*--------------  Defference Date --------------*/	
date_default_timezone_set("UTC");
function dateDiff($time1, $time2, $precision = 5) {
    // If not numeric then convert texts to unix timestamps
    if (!is_int($time1)) {
      $time1 = strtotime($time1);
    }
    if (!is_int($time2)) {
      $time2 = strtotime($time2);
    }
 
    // If time1 is bigger than time2
    // Then swap time1 and time2
    if ($time1 > $time2) {
      $ttime = $time1;
      $time1 = $time2;
      $time2 = $ttime;
    }
 
    // Set up intervals and diffs arrays
    // $intervals = array('year','month','day','hour','minute','second');
	$intervals = array('year','month');
    $diffs = array();
 
    // Loop thru all intervals
    foreach ($intervals as $interval) {
      // Create temp time from time1 and interval
      $ttime = strtotime('+1 ' . $interval, $time1);
      // Set initial values
      $add = 1;
      $looped = 0;
      // Loop until temp time is smaller than time2
      while ($time2 >= $ttime) {
        // Create new temp time from time1 and interval
        $add++;
        $ttime = strtotime("+" . $add . " " . $interval, $time1);
        $looped++;
      }
 
      $time1 = strtotime("+" . $looped . " " . $interval, $time1);
      $diffs[$interval] = $looped;
    }
    
    $count = 0;
    $times = array();
    // Loop thru all diffs
    foreach ($diffs as $interval => $value) {
      // Break if we have needed precission
      if ($count >= $precision) {
        break;
      }
      // Add value and interval 
      // if value is bigger than 0
      if ($value > 0) {
        // Add s if value is not 1
        if ($value != 1) {
          $interval .= "s";
        }
        // Add value and interval to times array
        $times[] = $value . " " . $interval;
        $count++;
      }
    }
 
    // Return string with times
    return implode(", ", $times);
  }