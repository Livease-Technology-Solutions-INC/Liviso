/**
 * Theme: Jidox - Responsive Bootstrap 5 Admin Dashboard
 * Author: Coderthemes
 * Module/App: Data tables
 */

$(document).ready(function () {
	"use strict";
        // Default Datatable
        $("#basic-datatable").DataTable({
            keys: true,
            language: {
                paginate: {
                    previous: "<i class='ri-arrow-left-s-line'>",
                    next: "<i class='ri-arrow-right-s-line'>",
                },
                emptyTable: "No data found",

            },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
        });   
	});

$(document).ready(function () {
	var table = $("#fixed-header-datatable").DataTable({
		responsive: true,
		language: {
			paginate: {
				previous: "<i class='ri-arrow-left-s-line'>",
				next: "<i class='ri-arrow-right-s-line'>",
			},
		},
		drawCallback: function () {
			$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
		},
	});

	new $.fn.dataTable.FixedHeader(table);
});
