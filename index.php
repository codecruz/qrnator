<?php require_once __DIR__ . '/qr.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QRNator - QR Code Generator</title>
    <link href="./src/output.css" rel="stylesheet">

    <script src="./functions.js"></script>
</head>

<body class="flex items-center justify-center h-screen bg-gray-100">

    <div id="app" class="bg-white p-8 rounded shadow-md">
        <form id="myForm" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="urlTo" class="block text-gray-700 text-sm font-bold mb-2">Destination URL:</label>
                <input type="url" id="urlTo" name="urlTo" class="w-full p-2 border rounded">
            </div>
            <div class="mb-4">
                <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Upload an image:</label>
                <input type="file" id="image" name="image" accept="image/*" class="w-full p-2 border rounded">
            </div>
            <div class="mb-4 flex">
                <div class="w-1/2 flex justify-center items-center">
                    <div>
                        <label for="hs-color-input-1" class="block text-sm font-medium mb-2">QR color</label>
                        <input type="color" class="w-24 p-1 h-10 w-14 block bg-white border border-gray-200 cursor-pointer w-10 rounded-lg disabled:opacity-50 disabled:pointer-events-none" id="hs-color-input-1" value="#000000" title="Choose your color">
                    </div>
                </div>
                <div class="w-1/2 flex justify-center items-center">
                    <div>
                        <label for="hs-color-input-2" class="block text-sm font-medium mb-2">QR background</label>
                        <input type="color" class="w-24 p-1 h-10 w-14 block bg-white border border-gray-200 cursor-pointer w-10 rounded-lg disabled:opacity-50 disabled:pointer-events-none " id="hs-color-input-2" value="#2563eb" title="Choose your color">
                    </div>
                </div>
            </div>

            <div class="text-center"><button type="button" onclick="submitForm()" class="bg-blue-500 text-white py-2 px-4 rounded">Submit</button></div>
        </form>

        <div id="result" class="mt-4"></div>

    </div>

</body>

</html>