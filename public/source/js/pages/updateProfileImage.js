function uploadFileAndRedirect(id) {
    // Assuming you are using vanilla JavaScript, adjust if using a framework like jQuery

    var fileInput = document.getElementById('fileInput');
    var uploadForm = document.getElementById('uploadForm');

    // You may want to perform additional validation on the file here

    // Submit the form (upload the file)
    uploadForm.submit();

    // Retrieve the user ID from the data attribute
    var userId = fileInput.getAttribute('data-user-id');

    // Redirect to your desired route after the form is submitted
    window.location.href = "/upload-image/" + userId;
}