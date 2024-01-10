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


require_once __DIR__ . '/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $folderPath = '/tmp';  // Cambia esto al directorio que estás utilizando para los archivos temporales


    $urlTo = isset($_POST['urlTo']) ? $_POST['urlTo'] : '';

    // Verificar si se subió el archivo y si es una imagen
    if (isset($_FILES['image']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
        $image = $_FILES['image']['tmp_name'];

        // Ruta del directorio temporal del script o proyecto
        $tmp_dir = __DIR__ . '\tmp';

        error_log($tmp_dir);
        // Crear directorio temporal



        try {
            echo createQR($urlTo, $image, $tmp_dir);
        } catch (Exception $e) {
            error_log("Error al generar el QR: " . $e->getMessage());
        } finally {
            // Eliminar directorio temporal
        }

        exit();
    } else {
        error_log("Error: No se subió el archivo correctamente.");
        // Puedes agregar más detalles del error según sea necesario.
        exit();
    }

    if (is_writable($folderPath)) {
        error_log('La carpeta tiene permisos de escritura.');
    } else {
        error_log('La carpeta NO tiene permisos de escritura.');
    }
}

function createQR($urlTo, $image, $tmp_dir)
{


    // Obtener el componente rojo (r)
    $redComponent = hexToComponent($_POST['hs-color-input-1'], 'r');
    // Obtener el componente verde (g)
    $greenComponent = hexToComponent($_POST['hs-color-input-1'], 'g');
    // Obtener el componente azul (b)
    $blueComponent = hexToComponent($_POST['hs-color-input-1'], 'b');

        // Obtener el componente rojo (r)
        $redComponent1 = hexToComponent($_POST['hs-color-input-2'], 'r');
        // Obtener el componente verde (g)
        $greenComponent1 = hexToComponent($_POST['hs-color-input-2'], 'g');
        // Obtener el componente azul (b)
        $blueComponent1 = hexToComponent($_POST['hs-color-input-2'], 'b');



    $writer = new PngWriter();

    $qrCode = QrCodeQrCode::create($urlTo)
        ->setForegroundColor(new Color($redComponent,$greenComponent,$blueComponent))
        ->setBackgroundColor(new Color($redComponent1,$greenComponent1,$blueComponent1));

    $logo = Logo::create($image)->setResizeToWidth(50);

    $result = $writer->write($qrCode, $logo);

    // Guardar el QR en el directorio temporal
    file_put_contents($tmp_dir . '/qr.png', $result->getString());

    return $result->getDataUri();
}

function hexToComponent($hex, $component = 'rgb')
{
    // Eliminar el caracter # si está presente
    $hex = str_replace("#", "", $hex);

    // Verificar si es un formato válido de 6 o 3 caracteres
    if (strlen($hex) == 6) {
        list($r, $g, $b) = sscanf($hex, "%02x%02x%02x");
    } elseif (strlen($hex) == 3) {
        list($r, $g, $b) = sscanf($hex, "%1x%1x%1x");
        // Duplicar cada dígito en el caso de un formato de 3 caracteres
        $r = hexdec($r . $r);
        $g = hexdec($g . $g);
        $b = hexdec($b . $b);
    } else {
        // Si el formato no es válido, devolver un valor por defecto o manejar el error según tu necesidad
        return false;
    }

    // Devolver el componente solicitado
    switch (strtolower($component)) {
        case 'r':
        case 'red':
            return $r;
        case 'g':
        case 'green':
            return $g;
        case 'b':
        case 'blue':
            return $b;
        default:
            // Si se especifica un componente no válido, devolver false o manejar el error según tu necesidad
            return false;
    }
}
