<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    /*
    * this class is created by: mohammad tareq alam
    * email: tareq.mist@gmail.com
    * web:commitmentsoft.com
    * blog: tareqalam.wordpress.com
    */
class Captcha {

    var $CI = null;

    function Captcha()
    {
		$this->CI =& get_instance();
		$this->CI->load->library('session');
    }

    function captchaImg()
    {
		session_start();
		header("Content-type: image/png");

		$captcha_image = imagecreatefrompng(APPPATH."captcha/blue-captcha.png");
		$captcha_font = imageloadfont(APPPATH."captcha/font.gdf");
		$captcha_text = substr(md5(uniqid('')),-6,6);
		
		$newdata = array(
		'captchaKey' =>$captcha_text
		);

		$this->CI->session->set_userdata($newdata);
		
		//$_SESSION['captcha_session'] = $captcha_text;

		$captcha_color = imagecolorallocate($captcha_image,0,0,0);
		imagestring($captcha_image,$captcha_font,15,5,$captcha_text,$captcha_color);
		imagepng($captcha_image);
		imagedestroy($captcha_image);
    }

    function captchaText()
    {	
		$captcha_text = substr(md5(uniqid('')),-6,6);

		$newdata = array(
		'captchaKey' =>$captcha_text
		);

		$this->CI->session->set_userdata($newdata);

		return $captcha_text;	
    }

    function validateCaptcha()
    {
		if ($_SERVER['REQUEST_METHOD'] == 'POST'):
			//$key=substr($_SESSION['key'],0,5);
			$key = $this->CI->session->userdata('captchaKey');
			$number = $_REQUEST['verification'];
			//$number = $this->input->post('verification');
			if($number!=$key){
				$msg = '<center><font face="Verdana, Arial, Helvetica, sans-serif" color="#FF0000>
				String not valid! Please try again!</font></center>';
				return $msg;
			}else{ 
				return 'success';
			}
		endif;
    }

}