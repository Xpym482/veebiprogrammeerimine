<?php
	class Photoupload{
	private $tempname;
	private $imageFileType;
	private $myTempImage;
	private $myImage;
	
	
	function __construct($tmppic, $type){
		$this->tempname = $tmppic;
		$this->imageFileType = $type;
	
	}	
	
	//destruktor, mis kaivitab klassi eemaldamisel
	function __destruct(){		
	imagedestroy($this->myTempImage);
	imagedestroy($this->myImage);
	}
	
	private function createimgfromfile(){
	if($imageFileType == "jpg" or $imageFileType == "jpeg"){
		$myTempImage = imagecreatefromjpeg($this->tempname);
		}
	if($imageFileType == "png"){
		$myTempImage = imagecreatefrompng($this->tempname);
		}
	if($imageFileType == "gif"){
		$myTempImage = imagecreatefromgif($this->tempname);
		}	
	}
	
	public function resizeimage($width, $height){
		$this->createimgfromfile();
		//vaatame pildi originaalsuuruse
		$imageWidth = imagesx($myTempImage);
		$imageHeight = imagesy($myTempImage);
		//leian vajaliku suurendusfaktori
		if($imageWidth > $imageHeight){
			$sizeRatio = $imageWidth / 600;
		} else {
			$sizeRatio = $imageHeight / 400;
		}
		$newWidth = round($imageWidth / $sizeRatio);
		$newHeight = round($imageHeight / $sizeRatio);
		$this->myImage = $this->changepicsie($this->myTempImage, $imageWidth, $imageHeight, $newWidth, $newHeight);
	}
	
	private function changepicsize($image, $ow, $oh, $w, $h){
	$newImage = imagecreatetruecolor($w, $h);
    imagecopyresampled($newImage, $image, 0, 0 , 0, 0, $w, $h, $ow, $oh);
	return $newImage;
	}
		
	public addWaterMark()
	{
		//lisame vesimärgi
		$waterMark = imagecreatefrompng("../vp_picfiles/vp_logo_w100_overlay.png");
		$waterMarkWidth = imagesx($waterMark);
		$waterMarkHeight = imagesy($waterMark);
		$waterMarkPosX = imagesx($this->myImage) - $waterMarkWidth - 10;
		$waterMarkPosY = imagesy($this->myImage) - $waterMarkHeight - 10;
		//kopeerin vesimärgi pikslid pildile
		imagecopy($this->myImage, $waterMark, $waterMarkPosX, $waterMarkPosY, 0, 0, $waterMarkWidth, $waterMarkHeight);
	}
	
	public function addtext(){
		//lisame ka teksti
		$textToImage = "Veebiprogrammeerimine";
		$textColor = imagecolorallocatealpha($this->myImage, 255,255,255, 60);
		imagettftext($this->myImage, 20, 0, 10, 25, $textColor, "../vp_picfiles/ARIALBD.TTF", $textToImage);
	}
	
	public function savephoto($targetFile)
	{
		$notice = "";
		//muudetud suurusega pilt kirjutatakse pildifailiks
		if($this->imageFileType == "jpg" or $imageFileType == "jpeg"){
		  if(imagejpeg($this->myImage, $targetFile, 6)){
            $notice = 1;
			//kui pilt salvestati, siis lisame andmebaasi
			//addPhotoData($target_file_name, $_POST["altText"], $_POST["privacy"]);
		 } else {
				$notice = 0;
			}
		}		
		//imagepng($myImage, $target_file, 6)
		//imagegif($myImage, $target_file)
		if($this->imageFileType == "png"){
		  if(imagepng($this->myImage, $targetFile, 90)){
            $notice = 1;
			//kui pilt salvestati, siis lisame andmebaasi
			//addPhotoData($target_file_name, $_POST["altText"], $_POST["privacy"]);
		 } else {
				$notice = 0;
			}
		}
		if($this->imageFileType == "gif"){
		  if(imagegif($this->myImage, $targetFile)){
            $notice = 1;
			//kui pilt salvestati, siis lisame andmebaasi
			//addPhotoData($target_file_name, $_POST["altText"], $_POST["privacy"]);
		 } else {
			$notice = 0;
			  }
		}		

	}
}//class lopeb


?>