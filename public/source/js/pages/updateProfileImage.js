document.getElementById('profileImage').addEventListener('click', function() {
    document.getElementById('fileInput').click();
});

// Show selected image preview
document.getElementById('fileInput').addEventListener('change', function() {
    var input = this;
    var img = document.getElementById('profileImage');
    
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            img.src = e.target.result;
        };

        reader.readAsDataURL(input.files[0]);
    }
});