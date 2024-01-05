<?php

use BaconQrCode\Encoder\QrCode;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\QrCode as QrCodeQrCode;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\Label\Label;



error_log("Pasa por uí");

require_once __DIR__ . '/vendor/autoload.php';

$writer = new PngWriter();

var_dump($_POST);

$qrCode = QrCodeQrCode::create($_POST['field1'])
    ->setEncoding(new Encoding('UTF-8'))
    ->setErrorCorrectionLevel(ErrorCorrectionLevel::Low)
    ->setSize(300)
    ->setMargin(10)
    ->setForegroundColor(new Color(45, 35, 125))
    ->setBackgroundColor(new Color(124, 200, 255));

$logo = Logo::create('logo.png')->setResizeToWidth(50);

error_log("Pasa por uí");
$result = $writer->write($qrCode, $logo);
return $result->getDataUri();
