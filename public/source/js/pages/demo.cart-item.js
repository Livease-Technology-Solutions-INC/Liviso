document.addEventListener('DOMContentLoaded', function() {
    var widgetIconBoxes = document.querySelectorAll('.card.widget-icon-box');

    widgetIconBoxes.forEach(function(box) {
        box.addEventListener('click', function() {
            var itemName = this.querySelector('.text-muted').children[0].textContent.trim();
            var itemPrice = this.querySelector('.text-muted .badge').textContent.trim();
            var itemImage = this.querySelector('img').getAttribute('src');

            var tbody = document.getElementById('tbody');

            // Check if the item already exists in the cart
            var existingItem = findItemInCart(itemName);

            if (existingItem) {
                // If the item already exists in the cart, just increment its quantity
                var quantityElement = existingItem.querySelector('.quantity');
                var quantity = parseInt(quantityElement.textContent);
                quantity++;
                quantityElement.textContent = quantity;
            } else {
                // If the item is not in the cart, append a new row for it
                tbody.insertAdjacentHTML('beforeend', `
                    <tr>
                        <td><img src="${itemImage}" alt="${itemName}" style="height: 50px;"></td>
                        <td class="text-left">${itemName}</td>
                        <td class="d-flex flex-row justify-content-between align-items-center text-center">
                            <button type="button" class="btn btn-sm btn decrement-qty">-</button>
                            <span class="quantity">1</span>
                            <button type="button" class="btn btn-sm btn increment-qty">+</button>
                        </td>
                        <td>Tax</td>
                        <td class="text-center table-item-price">${itemPrice}</td>
                        <td class="text-center table-item-subprice">${itemPrice}</td>
                        <td><button type="button" class="btn btn-danger btn-sm remove-item">Remove</button></td>
                    </tr>`
                );
            }

            // Check if there are rows in the tbody, if so, remove the "No Data Found" row
            if (tbody.querySelectorAll('tr').length > 0) {
                var noFoundRow = tbody.querySelector('.no-found');
                if (noFoundRow) {
                    noFoundRow.remove();
                }
            }

            updateSubtotal();
            updateTotalAmount();
        });
    });
    function findItemInCart(itemName) {
        var tableRows = document.querySelectorAll('.table tbody tr');
        for (var i = 0; i < tableRows.length; i++) {
            var textLeftElement = tableRows[i].querySelector('.text-left');
            if (textLeftElement && textLeftElement.textContent.trim() === itemName) {
                return tableRows[i];
            }
        }
        return null;
    }
    
    // Remove item from cart
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-item')) {
            event.target.closest('tr').remove();
            updateSubtotal();
            updateTotalAmount();
        }
    });

    // Increment quantity
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('increment-qty')) {
            var quantityElement = event.target.previousElementSibling;
            var quantity = parseInt(quantityElement.textContent);
            quantity++;
            quantityElement.textContent = quantity;
            updateSubtotal();
            updateTotalAmount();
        }

        if (event.target.classList.contains('decrement-qty')) {
            var quantityElement = event.target.nextElementSibling;
            var quantity = parseInt(quantityElement.textContent);
            if (quantity > 1) {
                quantity--;
                quantityElement.textContent = quantity;
                updateSubtotal();
                updateTotalAmount();
            }
        }
    });

    // Calculate and update total amount
    function updateTotalAmount() {
        var totalAmount = 0;
        var tableRows = document.querySelectorAll('.table tbody tr');
        tableRows.forEach(function(row) {
            var subprice = parseFloat(row.querySelector('.table-item-subprice').textContent.replace('$', ''));
            totalAmount += subprice;
        });
        document.querySelector('.totalamount').textContent = '$' + totalAmount.toFixed(2);
    }

    // Update subtotal and total amount
    function updateSubtotal() {
        var subtotal = 0;
        var totalQuantity = 0;
        var tableRows = document.querySelectorAll('.table tbody tr');
        tableRows.forEach(function(row) {
            var price = parseFloat(row.querySelector('.table-item-price').textContent.replace('$', ''));
            var quantity = parseInt(row.querySelector('.quantity').textContent);
            var totalForItem = price * quantity;
            row.querySelector('.table-item-subprice').textContent = '$' + totalForItem.toFixed(2);
            subtotal += totalForItem;
            totalQuantity += quantity;
        });
        document.querySelector('.subtotal_price').textContent = '$' + subtotal.toFixed(2);
        document.querySelector('.totalamount').textContent = '$' + subtotal.toFixed(2); 
        var discount = parseFloat(document.querySelector('.discount').value);
        if (!isNaN(discount)) {
            var total = subtotal - discount;
            document.querySelector('.totalamount').textContent = '$' + total.toFixed(2); 
        }
    }

    // Update subtotal and total amount when discount input changes
    document.querySelector('.discount').addEventListener('input', function() {
        updateSubtotal();
        updateTotalAmount();
    });
});
