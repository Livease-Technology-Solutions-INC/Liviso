document.addEventListener("DOMContentLoaded", function() {
    // Get all sidebar items
    var sidebarItems = document.querySelectorAll("#useradd-sidenav a");

    sidebarItems.forEach(function(item) {
        item.addEventListener("click", function(event) {
            event.preventDefault();

            // Remove "active" class from all sidebar items
            sidebarItems.forEach(function(item) {
                item.classList.remove("active");
            });

            // Add "active" class to the clicked sidebar item
            this.classList.add("active");

            // Get the ID of the table to show
            var tableId = this.getAttribute("data-table");

            // Hide all tables
            hideAllTables();

            // Show the table corresponding to the clicked sidebar item
            document.getElementById(tableId).style.display = "block";
        });
    });

    // Function to hide all tables except the initially active one
    function hideAllTables() {
        var tables = document.querySelectorAll(".dataTable-container table");
        tables.forEach(function(table) {
            table.style.display = "none";
        });
        
        // Get the initially active sidebar item
        var initiallyActiveItem = document.querySelector("#useradd-sidenav a.active");
        
        var initiallyActiveTableId = initiallyActiveItem.getAttribute("data-table");
        
        // Show the table corresponding to the initially active sidebar item
        document.getElementById(initiallyActiveTableId).style.display = "block";
    }
    
    // Hide all tables initially except the one corresponding to the initially active sidebar item
    hideAllTables();
});
