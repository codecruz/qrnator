function submitForm() {
    var xhr = new XMLHttpRequest();
    var formData = new FormData();
    var urlTo = document.getElementById('urlTo').value;
    var imageInput = document.getElementById('image');
    var imageFile = imageInput.files[0];
    var qrColor = document.getElementById('hs-color-input-1').value;
    var bgColor = document.getElementById('hs-color-input-2').value;



    formData.append('urlTo', urlTo);
    formData.append('image', imageFile);
    formData.append('hs-color-input-1', qrColor);
    formData.append('hs-color-input-2', bgColor);

    

    xhr.onreadystatechange = function () {
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
    var interval = setInterval(function () {
        if (opacity < 1) {
            opacity += 0.1;
            element.style.opacity = opacity;
        } else {
            clearInterval(interval);
        }
    }, 50);
}