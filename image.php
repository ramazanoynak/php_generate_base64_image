<?php


$img_base64 = generate_image("R","#1bce84","#000000");

echo '<img src="'.$img_base64.'">';

function generate_image($text,$bg_color,$text_color)
{

$height = 225;
$width = 225;
$font="c:/windows/fonts/arial.ttf";
$size = 55;
$angle = 0;

$bg_color =  hexrgb ($bg_color);
$txt_color =  hexrgb ($text_color);

$image = imagecreate($height, $width);
$background_color = imagecolorallocate ($image, $bg_color["r"], $bg_color["g"], $bg_color["b"]);
$text_color = imagecolorallocate($image, $txt_color["r"], $txt_color["g"], $txt_color["b"]);


$txt_location = get_txt_location($size,$angle,$font,$text,$height,$width);
imagettftext($image, $size, $angle, $txt_location["x"], $txt_location["y"], $text_color, $font , $text);

//write the image to a variable
ob_start();
imagejpeg($image);
$imGjpeg = ob_get_contents();
ob_end_clean();

//base64 encode
$imageData = base64_encode($imGjpeg);

return 'data:image/jpeg;base64,'.$imageData;

// Header("Content-type: image/jpeg");

// imagejpeg($image);
// imagedestroy($image);
	
}

function hexrgb ($hexstr)
{
	$hexstr = substr($hexstr, 1);
	$hexstr = "0x".$hexstr;
    $int = hexdec($hexstr);

    return array("r" => 0xFF & ($int >> 0x10),
                 "g" => 0xFF & ($int >> 0x8),
                 "b" => 0xFF & $int);
}

function get_txt_location($font_size,$angle,$font,$text,$image_height,$image_width)
{
$result = array();
	// Get Bounding Box Size
$text_box = imagettfbbox($font_size,$angle,$font,$text);

// Get your Text Width and Height
$text_width = $text_box[2]-$text_box[0];
$text_height = $text_box[7]-$text_box[1];

// Calculate coordinates of the text
$result["x"] = ($image_width/2) - ($text_width/2);
$result["y"] = ($image_height/2) - ($text_height/2);

return $result;
}

?>