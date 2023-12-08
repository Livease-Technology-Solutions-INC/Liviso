$(document).ready(function () {
	$('.open-edit-modal').on('click', function (e) {
		e.preventDefault();

		// Get the edit URL from the data attribute
		var editUrl = $(this).data('edit-url');

		// Use Ajax to load the content from the edit URL
		$.ajax({
			url: editUrl,
			type: 'GET',
			success: function (response) {
				// Create a temporary div to hold the response
				var tempDiv = $('<div>').html(response);

				// Extract the modal content from the response
				var modalContent = tempDiv.find('.modal-content');

				// Check if the modal content is found
				if (modalContent.length > 0) {
					// Update the modal content with the extracted content
					$('#complaintsModal .modal-content').load(
						editUrl + ' .modal-content',
					);
					$('#complaintsModal').modal('show');

					// Show the modal
					$('#complaintsModal').modal('show');
				} else {
					console.error('Error: Modal content not found in the response');
				}
			},
			error: function () {
				// Handle errors if needed
				console.error('Error loading edit content');
			},
		});
	});
});
