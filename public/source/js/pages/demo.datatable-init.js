/**
 * Theme: Jidox - Responsive Bootstrap 5 Admin Dashboard
 * Author: Coderthemes
 * Module/App: Data tables
 */

document.addEventListener('DOMContentLoaded', () => {
	'use strict';

	// Default Datatable
	const basicDatatable = document.querySelector('#basic-datatable');
	if (basicDatatable) {
		const basicDatatableInstance = new DataTable(basicDatatable, {
			keys: true,
			language: {
				paginate: {
					previous: "<i class='ri-arrow-left-s-line'></i>",
					next: "<i class='ri-arrow-right-s-line'></i>",
				},
				emptyTable: 'No data found',
			},
			drawCallback: () => {
				document
					.querySelector('.dataTables_paginate > .pagination')
					.classList.add('pagination-rounded');
			},
		});
	}
	// Default Datatable
	const iprestrictionDatatable = document.querySelector(
		'#iprestriction-datatable',
	);
	if (iprestrictionDatatable) {
		const iprestrictionDatatableInstance = new DataTable(
			iprestrictionDatatable,
			{
				keys: true,
				language: {
					paginate: {
						previous: "<i class='ri-arrow-left-s-line'></i>",
						next: "<i class='ri-arrow-right-s-line'></i>",
					},
					emptyTable: 'No data found',
				},
				drawCallback: () => {
					document
						.querySelector('.dataTables_paginate > .pagination')
						.classList.add('pagination-rounded');
				},
			},
		);
	}

	document
		.getElementById('useradd-side')
		.addEventListener('click', function (event) {
			// Check if the clicked element is an anchor tag
			if (event.target.tagName === 'A') {
				// Remove 'active' class from all links
				document.querySelectorAll('#useradd-side a').forEach(function (item) {
					item.classList.remove('active');
				});

				// Add 'active' class to the clicked link
				event.target.classList.add('active');
			}
		});

	// Fixed Header Datatable
	const fixedHeaderDatatable = document.querySelector(
		'#fixed-header-datatable',
	);
	if (fixedHeaderDatatable) {
		const fixedHeaderDatatableInstance = new DataTable(fixedHeaderDatatable, {
			responsive: true,
			language: {
				paginate: {
					previous: "<i class='ri-arrow-left-s-line'></i>",
					next: "<i class='ri-arrow-right-s-line'></i>",
				},
			},
			drawCallback: () => {
				document
					.querySelector('.dataTables_paginate > .pagination')
					.classList.add('pagination-rounded');
			},
		});
		new DataTable.FixedHeader(fixedHeaderDatatableInstance);
	}
});
