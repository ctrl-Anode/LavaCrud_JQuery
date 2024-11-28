$(document).ready(function() {
    // Hide update form initially
    $("#updateForm").hide();
    
    // Toggle forms
    $("#showAddForm").click(function() {
        $("#createForm").slideDown();
        $("#updateForm").slideUp();
        clearForms();
    });

    // Handle Create Form Submit
    $("#createForm").submit(function(e) {
        e.preventDefault();
        const formData = $(this).serialize();
        
        $.ajax({
            url: 'user/add',
            type: 'POST',
            data: formData,
            beforeSend: function() {
                $("#loadingSpinner").show();
                $("#createSubmitBtn").prop('disabled', true);
            },
            success: function(response) {
                if(response.success) {
                    showAlert('success', 'User added successfully!');
                    loadUsers();
                    clearForms();
                } else {
                    showAlert('danger', response.message);
                }
            },
            error: function() {
                showAlert('danger', 'Error occurred while adding user');
            },
            complete: function() {
                $("#loadingSpinner").hide();
                $("#createSubmitBtn").prop('disabled', false);
            }
        });
    });

    // Handle Update Form Submit
    $("#updateUserForm").submit(function(e) {
        e.preventDefault();
        const formData = $(this).serialize();
        console.log('Update form data:', formData); // Debug log
        
        $.ajax({
            url: 'user/update',
            type: 'POST',
            data: formData,
            dataType: 'json',
            beforeSend: function() {
                $(".loading-spinner, .overlay").show();
            },
            success: function(response) {
                console.log('Update response:', response);
                if(response.success) {
                    showAlert('success', 'User updated successfully!');
                    loadUsers();
                    $("#updateForm").slideUp();
                    $("#updateUserForm")[0].reset();
                } else {
                    showAlert('danger', response.message || 'Error updating user');
                    console.error('Update failed:', response);
                }
            },
            error: function() {
                showAlert('danger', 'Error occurred while updating user');
            },
            complete: function() {
                $(".loading-spinner, .overlay").hide();
            }
        });
    });

    // Load users function
    function loadUsers() {
        $.ajax({
            url: 'user/getUsers',
            type: 'GET',
            success: function(response) {
                $("#usersTable tbody").html(response);
            }
        });
    }

    // Edit user function
    $(document).on('click', '.edit-user', function() {
        const userId = $(this).data('id');
        console.log('Editing user ID:', userId); // Debug log
        
        $.ajax({
            url: 'user/getOne/' + userId,
            type: 'GET',
            dataType: 'json',
            success: function(user) {
                console.log('Received user data:', user); // Debug log
                $("#updateUserId").val(userId);
                $("#update_lname").val(user.dvg_last_name);
                $("#update_fname").val(user.dvg_first_name);
                $("#update_email").val(user.dvg_email);
                $("#update_gender").val(user.dvg_gender);
                $("#update_address").val(user.dvg_address);
                $("#createForm").slideUp();
                $("#updateForm").slideDown();
            },
            error: function() {
                showAlert('danger', 'Error loading user data');
            }
        });
    });

    // Delete user function
    $(document).on('click', '.delete-user', function() {
        if(confirm('Are you sure you want to delete this user?')) {
            const userId = $(this).data('id');
            
            $.ajax({
                url: 'user/delete/' + userId,
                type: 'GET',
                success: function(response) {
                    if(response.success) {
                        showAlert('success', 'User deleted successfully!');
                        loadUsers();
                    } else {
                        showAlert('danger', 'Error deleting user');
                    }
                }
            });
        }
    });

    // Helper functions
    function clearForms() {
        $("#createForm")[0].reset();
        $("#updateForm")[0].reset();
    }

    function populateUpdateForm(user) {
        $("#updateUserId").val(user.id);
        $("#lname").val(user.dvg_last_name);
        $("#fname").val(user.dvg_first_name);
        $("#email").val(user.dvg_email);
        $("#gender").val(user.dvg_gender);
        $("#address").val(user.dvg_address);
    }

    function showAlert(type, message) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;
        if (!$("#alertContainer").length) {
            $(".container").prepend('<div id="alertContainer"></div>');
        }
        $("#alertContainer").html(alertHtml);
        setTimeout(() => {
            $(".alert").alert('close');
        }, 5000);
    }
});