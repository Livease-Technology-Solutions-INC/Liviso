document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.edit-webhook-link').forEach(link => {
        link.addEventListener('click', async function () {
            const webhookId = this.dataset.webhookId;

            // Store the webhook ID in the hidden input field
            document.getElementById('webhook-id-input').value = webhookId;
            // Update modal title or any other elements as needed
            const valit = document.getElementById('webhookModalLabel').innerHTML = 'Edit Webhook';
            console.log(valit)
            try {
                // Fetch data for the webhook using an asynchronous request
                const response = await fetch(`{{ path("webhook_fetch", {'id': webhookId}) }}`);
                const data = await response.json();
                console.log("in")

                // Update modal content with the fetched data
                document.getElementById('webhook_module').value = data.module;
                document.getElementById('webhook_URL').value = data.URL;
                document.getElementById('webhook_method').value = data.method;

                // You might also need to trigger a select update if using a select library
                document.querySelector('.module_select').selectpicker('val', data.module);


                // Add logic to handle form submission for updating existing data
                document.getElementById('webhook-form').action = `{{ path("webhook_edit", {'id': webhookId}) }}`;
            } catch (error) {
                console.error('Failed to fetch webhook data', error);
            }
        });
    });
});
