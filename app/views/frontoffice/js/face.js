// JavaScript for webcam functionality
const video = document.getElementById('video');
const captureButton = document.getElementById('capture-button');
const capturedImage = document.getElementById('captured-image');
const faceImageInput = document.getElementById('faceImage');
const webcamContainer = document.getElementById('webcam-container');
let capturedImageData = null; // Variable to store captured image data

// Access the webcam
navigator.mediaDevices.getUserMedia({ video: true })
    .then(stream => {
        video.srcObject = stream;
        webcamContainer.style.display = 'block'; // Show the webcam container
    })
    .catch(err => {
        console.error("Error accessing webcam: ", err);
        alert("Impossible d'accéder à la webcam. Veuillez vérifier vos paramètres.");
    });

captureButton.addEventListener('click', () => {
    const context = capturedImage.getContext('2d');
    capturedImage.width = video.videoWidth;
    capturedImage.height = video.videoHeight;
    context.drawImage(video, 0, 0, capturedImage.width, capturedImage.height);
    capturedImageData = capturedImage.toDataURL('image/png'); // Store the image data
});

// Handle form submission
document.getElementById('signupForm').addEventListener('submit', (event) => {
    event.preventDefault();
    const formData = new FormData(event.target);
    if (capturedImageData) {
        const base64Data = capturedImageData.split(',')[1];
        formData.append('image', base64Data);
    }
    fetch('../PHP/save_image.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Inscription réussie et image sauvegardée !');

            } else {
                alert('Erreur lors de l\'inscription ou de la sauvegarde de l\'image: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Une erreur est survenue lors de l\'inscription.');
        });
});
document.getElementById('loginFaceId').addEventListener('click', function() {
    // Implement face ID login logic here
});