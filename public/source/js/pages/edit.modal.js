document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.open-edit-modal');
    const deleteButtons = document.querySelectorAll('.delete-leave');
    const createButton = document.getElementById("createButton");
    const saveButton = document.getElementById("saveButton");
    const createLeaveButton = document.querySelector(".create-leave");
    let leaveId, userId;
    
    createLeaveButton.addEventListener("click", function () {
        saveButton.style.display = "none";
        createButton.style.display = "inline-block";
    });

    saveButton.addEventListener('click', function () {
        const leaveType = document.getElementById('manage_leave_leaveType').value;
        const employee = document.getElementById('manage_leave_employee').value;
        const startDate = document.getElementById('manage_leave_startDate').value;
        const endDate = document.getElementById('manage_leave_endDate').value;
        const leaveReason = document.getElementById('manage_leave_leaveReason').value;
        const remark = document.getElementById('manage_leave_remark').value;
        const method = leaveId ? 'PUT' : 'POST';
        const url = leaveId ? `/hrmsystem/manage_leave/${leaveId}/edit/${userId}` : `/hrmsystem/manage_leave/${userId}`;

        const data = {
            employee: employee,
            leaveType: leaveType,
            startDate: startDate,
            endDate: endDate,
            leaveReason: leaveReason,
            remark: remark,
        };

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data),
        })
            .then(response => {
                if (response.ok) {
                    window.location.reload();
                } else {
                    console.error('Form submission failed');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });

    editButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            createButton.style.display = "none";
            saveButton.style.display = "inline-block";
            event.preventDefault();
            userId = button.getAttribute('user-id');
            leaveId = button.getAttribute('data-leave-id');
            const row = button.closest('tr');
            const employee = row.querySelector('.manage_leave_employee').innerText;
            const leaveType = row.querySelector('.manage_leave_leaveType').innerText;
            const startDate = row.querySelector('.manage_leave_startDate').innerText;
            const endDate = row.querySelector('.manage_leave_endDate').innerText;
            const leaveReason = row.querySelector('.manage_leave_leaveReason').innerText;
            const remark = row.querySelector('.manage_leave_remark').innerText;

            document.getElementById('manage_leave_employee').value = employee;
            document.getElementById('manage_leave_leaveType').value = leaveType;
            document.getElementById('manage_leave_startDate').value = startDate;
            document.getElementById('manage_leave_endDate').value = endDate;
            document.getElementById('manage_leave_leaveReason').value = leaveReason;
            document.getElementById('manage_leave_remark').value = remark;

            var resignationModal = new bootstrap.Modal(document.querySelector('.special'), {});
            resignationModal.show();
        }
        );
    });

    deleteButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const leaveId = button.getAttribute('data-leave-id');
            const userId = button.getAttribute('user-id');
            fetch(`/hrmsystem/manage_leave/${leaveId}/delete/${userId}`, {
                method: 'POST',
            })
                .then(response => {
                    if (response.ok) {
                        window.location.reload();
                    } else {
                        console.error('Failed to delete leave');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });

})