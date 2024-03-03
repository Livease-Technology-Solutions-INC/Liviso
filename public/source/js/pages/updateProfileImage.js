// function uploadFileAndRedirect() {
//     var fileInput = document.getElementById('fileInput');
//     var userId = fileInput.getAttribute('data-user-id');
    
//     // Check if a file is selected
//     if (fileInput.files.length > 0) {
//         var form = document.getElementById('profileImage');
//         var formData = new FormData(form);

//         // Make an asynchronous request to the server to submit the form
//         var xhr = new XMLHttpRequest();
//         xhr.open('POST', form.action, true);

//         xhr.onload = function () {
//             window.location.href = "{{ path('my_account', {user_id: app.user.id}) }}";
//         };

//         // Send the form data
//         xhr.send(formData);
//     }
// }