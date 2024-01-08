<?php

use Endroid\QrCode\QrCode as QrCodeQrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\Color\Color;

require_once __DIR__ . '/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $folderPath = '/tmp';  // Cambia esto al directorio que estás utilizando para los archivos temporales


    $imageUrl = isset($_POST['imageUrl']) ? $_POST['imageUrl'] : '';

    // Verificar si se subió el archivo y si es una imagen
    if (isset($_FILES['image']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
        $image = $_FILES['image']['tmp_name'];

        // Ruta del directorio temporal del script o proyecto
        $tmp_dir = __DIR__ . '\tmp';

        error_log($tmp_dir);
        // Crear directorio temporal



        try {
            echo createQR($imageUrl, $image, $tmp_dir);
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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tailwind CSS Form</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .fade-enter-active,
        .fade-leave-active {
            transition: opacity 0.5s;
        }

        .fade-enter,
        .fade-leave-to {
            opacity: 0;
        }
    </style>
</head>

<body class="flex items-center justify-center h-screen bg-gray-100">

    <div id="app" class="bg-white p-8 rounded shadow-md">
        <form id="myForm" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="imageUrl" class="block text-gray-700 text-sm font-bold mb-2">URL de la imagen:</label>
                <input type="text" id="imageUrl" name="imageUrl" class="w-full p-2 border rounded">
            </div>
            <div class="mb-4">
                <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Seleccionar imagen:</label>
                <input type="file" id="image" name="image" accept="image/*" class="w-full p-2 border rounded">
            </div>
            <button type="button" onclick="submitForm()" class="bg-blue-500 text-white py-2 px-4 rounded">Submit</button>
        </form>

        <div id="result" class="mt-4"></div>

        <script>
            function submitForm() {
                var xhr = new XMLHttpRequest();
                var formData = new FormData();
                var imageUrl = document.getElementById('imageUrl').value;
                var imageInput = document.getElementById('image');
                var imageFile = imageInput.files[0];

                formData.append('imageUrl', imageUrl);
                formData.append('image', imageFile);

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var resultDiv = document.getElementById('result');
                        resultDiv.innerHTML = "<img src='" + xhr.responseText + "' alt='QR Code'>";
                        fadeIn(resultDiv);
                    }
                };

                xhr.open('POST', window.location.href, true);
                xhr.send(formData);
            }

            function fadeIn(element) {
                var opacity = 0;
                var interval = setInterval(function() {
                    if (opacity < 1) {
                        opacity += 0.1;
                        element.style.opacity = opacity;
                    } else {
                        clearInterval(interval);
                    }
                }, 50);
            }
        </script>
    </div>

</body>

</html>

<?php

function createQR($imageUrl, $image, $tmp_dir)
{
    $writer = new PngWriter();

    $qrCode = QrCodeQrCode::create($imageUrl)
        ->setForegroundColor(new Color(45, 35, 125))
        ->setBackgroundColor(new Color(124, 200, 255));

    $logo = Logo::create($image)->setResizeToWidth(50);

    $result = $writer->write($qrCode, $logo);

    // Guardar el QR en el directorio temporal
    file_put_contents($tmp_dir . '/qr.png', $result->getString());

    return $result->getDataUri();
}


?>