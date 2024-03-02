// function uploadFileAndRedirect() {
//     console.log("clicked")
//     // Assuming you are using vanilla JavaScript, adjust if using a framework like jQuery

//     var fileInput = document.getElementById('fileInput');
//     var uploadForm = document.getElementById('uploadForm');

//     // You may want to perform additional validation on the file here

//     // Submit the form (upload the file)
//     uploadForm.submit();

//     // Retrieve the user ID from the data attribute
//     var userId = fileInput.getAttribute('data-user-id');

//     // Redirect to your desired route after the form is submitted
//     window.location.href = "/upload-image/" + userId;
// }
document.addEventListener("DOMContentLoaded", () => {
    const imageInput = document.getElementById("fileInput");

    // Add event listener to listen for changes in the input
    imageInput.addEventListener("change", (event) => {
        const file = event.target.files[0];

        // Check if a file is selected
        if (file) {
            // Create a FormData object to send the file to the server
            const formData = new FormData();
            formData.append("image", file);

            // Make an API request to save the image to the database
            saveImage(formData)
                .then((response) => {
                    console.log("Image saved successfully:", response);
                })
                .catch((error) => {
                    console.error("Error saving image:", error);
                });
        }
    });
})
function simple(){
    console.log("uploaded")
}
simple()