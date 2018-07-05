<?php

	/*

		GCaptcha - by Gabriel Silva
		Version 0.1alpha
		http://gabrielsilva.tk/gcaptcha

		This is an open source software
		Please read documentation before using it!!!

		---- (Please edit only where indicated) ----

	*/

	// #################
	// # MAIN SETTINGS #
	// #################

	// Sets the method used when generating the code
	// (0 - Random code | 1 - Math problem | 2 - Word list code)
	$GCAP_method = 0;

	// Sets if the code is case-sensitive
	$GCAP_case = false;

    // ########################
	// # RANDOM CODE SETTINGS #
	// ########################

	// Sets the number of characters in the code
	$GCAP_length = 6;

	// Uncomment next line for using lowercase letters
	@$GCAP_elements .= "abcdefghijklmnopqrstuwxyz";

	// Uncomment next line for using uppercase letters
	@$GCAP_elements .= "ABCDEFGHIJKLMNOPQRSTUWXYZ";

	// Uncomment next line for using numbers
	@$GCAP_elements .= "0123456789";

	// Uncomment next line for using special characters
//	@$GCAP_elements .= "!@#$%^&*_+=-?";

	// #########################
	// # MATH PROBLEM SETTINGS #
	// #########################

	// Sets the range of the numbers when generating math problems
	$GCAP_mathMin = 1; // minimum
	$GCAP_mathMax = 10; // maximum

	// Sets the desired math operation
	// (0 - Addition | 1 - Subtraction | 2 - Multiplication)
	$GCAP_mathOp = 0;

	// ############################
	// # AUDIBLE CAPTCHA SETTINGS #
	// ############################

	// Sets the volume of the background noise
	// (0 [muted] to 1 [maximum])
	$GCAP_noiseVol = 0.4;

	// Sets the speed rate of the background noise
	// (0.5 [slowest] to 2.0 [fastest])
	$GCAP_noiseSpeed = 1;

	// Sets the volume of the reading voice
	// (0 [muted] to 1 [maximum])
	$GCAP_voiceVol = 0.8;

	// Sets the speed rate of the reading voice
	// (0.1 [slowest] to 10 [fastest])
	$GCAP_speed = 0.3;

	// Sets the pitch of the reading voice
	// (0 [lowest] to 2 [highest])
	$GCAP_pitch = 0;

	// Sets the pause between each character read (in milliseconds, random code method only)
	$GCAP_pause = 900;

	// ---- (Do not edit below this line) ----

	session_start();

	function generateRandomCaptcha(){
	    $pass = array();
	    $alphaLength = strlen($GLOBALS['GCAP_elements']) - 1;
	    for ($i = 0; $i < $GLOBALS['GCAP_length']; $i++) {
	        $n = rand(0, $alphaLength);
	        $pass[] = $GLOBALS['GCAP_elements'][$n];
	    }
	    return implode($pass);
	}

	function generateMathCaptcha(){
		$num1 = rand($GLOBALS['GCAP_mathMin'], $GLOBALS['GCAP_mathMax']);
		$num2 = rand($GLOBALS['GCAP_mathMin'], $GLOBALS['GCAP_mathMax']);
		switch ($GLOBALS['GCAP_mathOp']) {
			case 0:
				$result = array($num1 + $num2, $num1 . ' + ' . $num2);
				break;
			case 1:
				$result = array($num1 - $num2, $num1 . ' - ' . $num2);
				break;
			case 2:
				$result = array($num1 * $num2, $num1 . ' * ' . $num2);
				break;
		}
		return $result;
	}

	function generateWordCaptcha(){
		$f_contents = file("words.txt");
		$line = $f_contents[array_rand($f_contents)];
		return trim($line);
	}

	function setAndShowCaptcha(){
		switch ($GLOBALS['GCAP_method']) {
			case 0:
				$code = generateRandomCaptcha();
				if($GLOBALS['GCAP_case']){
					$_SESSION['captcha'] = md5($code);
				}else{
					$_SESSION['captcha'] = md5(strtolower($code));
				}
				echo $code;
				break;
			case 1:
				$code = generateMathCaptcha();
				$_SESSION['captcha'] = md5($code[0]);
				echo $code[1];
				break;
			case 2:
				$code = generateWordCaptcha();
				if($GLOBALS['GCAP_case']){
					$_SESSION['captcha'] = md5($code);
				}else{
					$_SESSION['captcha'] = md5(strtolower($code));
				}
				echo htmlspecialchars($code);
				break;
		}
	}

	function validateCaptcha($input){
		if($GLOBALS['GCAP_case']){
			if(md5(trim($input)) == trim($_SESSION['captcha'])){
				return true;
			}else{
				return false;
			}
		}else{
			if(md5(strtolower(trim($input))) == trim($_SESSION['captcha'])){
				return true;
			}else{
				return false;
			}
		}
	}
?>