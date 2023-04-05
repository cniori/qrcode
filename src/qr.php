<?php
require_once "phpqrcode.php";

// 生成带 logo 的二维码并保存
function generateQRCodeWithLogo($data, $report_id){
    //设置二维码参数
    $errorCorrectionLevel = 'L';//容错级别
    $matrixPointSize = 5 ;//生成图片大小
    QRcode::png($data, 'qrcode.png', $errorCorrectionLevel, $matrixPointSize, 2);

    //生成带logo的二维码
    $QR = imagecreatefrompng('qrcode.png');
    $logo = imagecreatefrompng('./src/logo.png');
    $QR_width = imagesx($QR);
    $QR_height = imagesy($QR);
    $logo_width = imagesx($logo);
    $logo_height = imagesy($logo);
    $logo_qr_width = $QR_width / 5;
    $scale = $logo_width / $logo_qr_width;
    $logo_qr_height = $logo_height / $scale;
    $from_width = ($QR_width - $logo_qr_width) / 2;
    imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);

    //保存带logo的二维码
    $filename = 'info/'.$report_id.'.png';
    imagepng($QR, $filename);

    return $filename;
}
?>
