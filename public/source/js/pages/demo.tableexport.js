document.addEventListener("DOMContentLoaded", function() {
    const exportBtns = document.querySelectorAll(".export-btn");

    exportBtns.forEach(btn => {
        btn.addEventListener("click", function() {
            const tableId = this.getAttribute("data-table-id");
            const tableName = this.getAttribute("data-table-name");
            const table = document.getElementById(tableId);
            exportTableToExcel(table, `${tableName}.xlsx`);
        });
    });

    function exportTableToExcel(table, filename) {
        const wb = XLSX.utils.table_to_book(table, {sheet: "Sheet JS"});
        XLSX.writeFile(wb, filename);
    }
});
