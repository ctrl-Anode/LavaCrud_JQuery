<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .loading-spinner {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 9998;
        }
        .card {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border: none;
        }
        .card-header {
            background-color: #007bff;
            color: white;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .table th {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="#">User Management System</a>
    </div>
</nav>

<div class="container">
    <div id="alertContainer"></div>
    <div class="row mb-4">
        <div class="col-md-12">
            <button class="btn btn-primary" id="showAddForm">
                <i class="fas fa-user-plus me-2"></i>Add New User
            </button>
        </div>
    </div>

    <!-- Create Form -->
    <div class="row mb-4" id="createForm" style="display: none;">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Add New User</h5>
                </div>
                <div class="card-body">
                    <form id="addUserForm">
                        <div class="mb-3">
                            <label for="lname" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lname" name="lname" required>
                        </div>
                        <div class="mb-3">
                            <label for="fname" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="fname" name="fname" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Submit
                        </button>
                        <button type="button" class="btn btn-secondary" id="cancelAdd">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Form -->
    <div class="row mb-4" id="updateForm" style="display: none;">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Update User</h5>
                </div>
                <div class="card-body">
                    <form id="updateUserForm">
                        <input type="hidden" id="updateUserId" name="updateUserId">
                        <div class="mb-3">
                            <label for="update_lname" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="update_lname" name="lname" required>
                        </div>
                        <div class="mb-3">
                            <label for="update_fname" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="update_fname" name="fname" required>
                        </div>
                        <div class="mb-3">
                            <label for="update_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="update_email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="update_gender" class="form-label">Gender</label>
                            <select class="form-select" id="update_gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="update_address" class="form-label">Address</label>
                            <textarea class="form-control" id="update_address" name="address" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update
                        </button>
                        <button type="button" class="btn btn-secondary" id="cancelUpdate">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Users List</h5>
                    <div class="d-flex">
                        <select class="form-select me-2" id="columnFilter" style="width: auto;">
                            <option value="1">ID</option>
                            <option value="2">Last Name</option>
                            <option value="3">First Name</option>
                            <option value="4">Email</option>
                            <option value="5">Gender</option>
                            <option value="6">Address</option>
                        </select>
                        <input type="text" id="searchInput" class="form-control" placeholder="Search...">
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Last Name</th>
                                    <th>First Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Address</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="usersTableBody">
                                <!-- Dynamic Rows -->
                            </tbody>
                        </table>
                    </div>
                    <div id="paginationControls" class="d-flex justify-content-center mt-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Spinner and Overlay -->
<div class="loading-spinner">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
<div class="overlay"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function () {
    const rowsPerPage = 5; // Number of rows per page
    let currentPage = 1; // Current page

    // Function to paginate rows
    function paginateTable() {
        const rows = $("#usersTableBody tr");
        const totalRows = rows.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage);

        // Hide all rows
        rows.hide();

        // Show only rows for the current page
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        rows.slice(start, end).show();

        // Update pagination controls
        let paginationControls = `<button class="btn btn-sm btn-primary" id="prevPage" ${currentPage === 1 ? "disabled" : ""}>Previous</button>`;
        paginationControls += ` Page ${currentPage} of ${totalPages} `;
        paginationControls += `<button class="btn btn-sm btn-primary" id="nextPage" ${currentPage === totalPages ? "disabled" : ""}>Next</button>`;
        $("#paginationControls").html(paginationControls);
    }

    // Event listeners for pagination
    $(document).on("click", "#prevPage", function () {
        if (currentPage > 1) {
            currentPage--;
            paginateTable();
        }
    });

    $(document).on("click", "#nextPage", function () {
        const rows = $("#usersTableBody tr").length;
        if (currentPage < Math.ceil(rows / rowsPerPage)) {
            currentPage++;
            paginateTable();
        }
    });

    // Reload and paginate after AJAX
    function loadUsers() {
        showLoading();
        $.ajax({
            url: "<?= site_url('user/getUsers') ?>",
            type: "GET",
            success: function (response) {
                hideLoading();
                $("#usersTableBody").html(response);
                currentPage = 1; // Reset to the first page
                paginateTable();
            },
            error: function () {
                hideLoading();
                alert("Error loading users");
            }
        });
    }

    // Initial Load
    loadUsers();

    // Re-paginate on search
    $("#searchInput").on("keyup", function () {
        const columnIndex = $("#columnFilter").val();
        const searchValue = $(this).val().toLowerCase();

        $("#usersTableBody tr").filter(function () {
            $(this).toggle(
                $(this)
                    .children("td:nth-child(" + columnIndex + ")")
                    .text()
                    .toLowerCase()
                    .indexOf(searchValue) > -1
            );
        });

        currentPage = 1; // Reset to the first page
        paginateTable();
    });
});

    $(document).ready(function () {
    // Filter logic
    $("#searchInput").on("keyup", function () {
        var columnIndex = $("#columnFilter").val(); // Get selected column index
        var searchValue = $(this).val().toLowerCase();

        $("#usersTableBody tr").filter(function () {
            // Match the value in the specified column (nth-child)
            $(this).toggle(
                $(this).children("td:nth-child(" + columnIndex + ")")
                    .text()
                    .toLowerCase()
                    .indexOf(searchValue) > -1
            );
        });
    });
});

$(document).ready(function() {
    // Load users on page load
    loadUsers();

    // Show/Hide Forms
    $('#showAddForm').click(function() {
        $('#createForm').slideDown();
        $('#updateForm').slideUp();
    });

    $('#cancelAdd').click(function() {
        $('#createForm').slideUp();
        $('#addUserForm')[0].reset();
    });

    $('#cancelUpdate').click(function() {
        $('#updateForm').slideUp();
        $('#updateUserForm')[0].reset();
    });

    // Add User
    $('#addUserForm').submit(function(e) {
        e.preventDefault();
        showLoading();
        
        $.ajax({
            url: '<?= site_url('user/add') ?>',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                hideLoading();
                if(response.success) {
                    alert(response.message);
                    $('#createForm').slideUp();
                    $('#addUserForm')[0].reset();
                    loadUsers();
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                hideLoading();
                alert('An error occurred');
            }
        });
    });

    // Update User
    $('#updateUserForm').submit(function(e) {
        e.preventDefault();
        showLoading();
        
        const id = $('#updateUserId').val();
        $.ajax({
            url: '<?= site_url('user/update') ?>',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                hideLoading();
                if(response.success) {
                    alert(response.message);
                    $('#updateForm').slideUp();
                    $('#updateUserForm')[0].reset();
                    loadUsers();
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                hideLoading();
                alert('An error occurred');
            }
        });
    });

    // Delete User
    $(document).on('click', '.delete-user', function() {
        if(confirm('Are you sure you want to delete this user?')) {
            const id = $(this).data('id');
            showLoading();
            
            $.ajax({
                url: '<?= site_url('user/delete/') ?>' + id,
                type: 'GET',
                success: function() {
                    hideLoading();
                    loadUsers();
                },
                error: function() {
                    hideLoading();
                    alert('An error occurred');
                }
            });
        }
    });

    // Edit User
    $(document).on('click', '.edit-user', function() {
        const id = $(this).data('id');
        showLoading();
        
        $.ajax({
            url: '<?= site_url('user/getOne/') ?>' + id,
            type: 'GET',
            success: function(response) {
                hideLoading();
                $('#updateUserId').val(response.id);
                $('#update_lname').val(response.aza_last_name);
                $('#update_fname').val(response.aza_first_name);
                $('#update_email').val(response.aza_email);
                $('#update_gender').val(response.aza_gender);
                $('#update_address').val(response.aza_address);
                
                $('#updateForm').slideDown();
                $('#createForm').slideUp();
            },
            error: function() {
                hideLoading();
                alert('An error occurred');
            }
        });
    });
});

// Load Users Function
function loadUsers() {
    showLoading();
    $.ajax({
        url: '<?= site_url('user/getUsers') ?>',
        type: 'GET',
        success: function(response) {
            hideLoading();
            $('#usersTableBody').html(response);
        },
        error: function() {
            hideLoading();
            alert('Error loading users');
        }
    });
}

// Loading Functions
function showLoading() {
    $('.loading-spinner, .overlay').show();
}

function hideLoading() {
    $('.loading-spinner, .overlay').hide();
}
</script>

</body>
</html>

////


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management with JQuery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .loading-spinner {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 9998;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <div id="alertContainer"></div>
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">User Management System CRUD with JQuery</h2>
            <button class="btn btn-primary mb-3" id="showAddForm">Add New User</button>
        </div>
    </div>

    <!-- Create Form -->
    <div class="row mb-4" id="createForm" style="display: none;">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Add New User</h5>
                </div>
                <div class="card-body">
                    <form id="addUserForm">
                        <div class="mb-3">
                            <label for="lname" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lname" name="lname" required>
                        </div>
                        <div class="mb-3">
                            <label for="fname" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="fname" name="fname" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" id="cancelAdd">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Form -->
    <div class="row mb-4" id="updateForm" style="display: none;">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Update User</h5>
                </div>
                <div class="card-body">
                    <form id="updateUserForm">
                        <input type="hidden" id="updateUserId" name="updateUserId">
                        <div class="mb-3">
                            <label for="update_lname" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="update_lname" name="lname" required>
                        </div>
                        <div class="mb-3">
                            <label for="update_fname" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="update_fname" name="fname" required>
                        </div>
                        <div class="mb-3">
                            <label for="update_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="update_email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="update_gender" class="form-label">Gender</label>
                            <select class="form-select" id="update_gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="update_address" class="form-label">Address</label>
                            <textarea class="form-control" id="update_address" name="address" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-secondary" id="cancelUpdate">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Users List</h5>
                </div>
                <div class="card-body">
                <div class="row mb-3">
    <div class="col-md-3">
        <select class="form-select" id="columnFilter">
            <option value="1">ID</option>
            <option value="2">Last Name</option>
            <option value="3">First Name</option>
            <option value="4">Email</option>
            <option value="5">Gender</option>
            <option value="6">Address</option>
        </select>
    </div>
    <div class="col-md-6">
        <input type="text" id="searchInput" class="form-control" placeholder="Search...">
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="usersTableBody">
            <!-- Dynamic Rows -->
        </tbody>
    </table>
    <div id="paginationControls" class="text-center mt-3"></div>
</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Spinner and Overlay -->
<div class="loading-spinner">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
<div class="overlay"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function () {
    const rowsPerPage = 5; // Number of rows per page
    let currentPage = 1; // Current page

    // Function to paginate rows
    function paginateTable() {
        const rows = $("#usersTableBody tr");
        const totalRows = rows.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage);

        // Hide all rows
        rows.hide();

        // Show only rows for the current page
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        rows.slice(start, end).show();

        // Update pagination controls
        let paginationControls = `<button class="btn btn-sm btn-primary" id="prevPage" ${currentPage === 1 ? "disabled" : ""}>Previous</button>`;
        paginationControls += ` Page ${currentPage} of ${totalPages} `;
        paginationControls += `<button class="btn btn-sm btn-primary" id="nextPage" ${currentPage === totalPages ? "disabled" : ""}>Next</button>`;
        $("#paginationControls").html(paginationControls);
    }

    // Event listeners for pagination
    $(document).on("click", "#prevPage", function () {
        if (currentPage > 1) {
            currentPage--;
            paginateTable();
        }
    });

    $(document).on("click", "#nextPage", function () {
        const rows = $("#usersTableBody tr").length;
        if (currentPage < Math.ceil(rows / rowsPerPage)) {
            currentPage++;
            paginateTable();
        }
    });

    // Reload and paginate after AJAX
    function loadUsers() {
        showLoading();
        $.ajax({
            url: "<?= site_url('user/getUsers') ?>",
            type: "GET",
            success: function (response) {
                hideLoading();
                $("#usersTableBody").html(response);
                currentPage = 1; // Reset to the first page
                paginateTable();
            },
            error: function () {
                hideLoading();
                alert("Error loading users");
            }
        });
    }

    // Initial Load
    loadUsers();

    // Re-paginate on search
    $("#searchInput").on("keyup", function () {
        const columnIndex = $("#columnFilter").val();
        const searchValue = $(this).val().toLowerCase();

        $("#usersTableBody tr").filter(function () {
            $(this).toggle(
                $(this)
                    .children("td:nth-child(" + columnIndex + ")")
                    .text()
                    .toLowerCase()
                    .indexOf(searchValue) > -1
            );
        });

        currentPage = 1; // Reset to the first page
        paginateTable();
    });
});

    $(document).ready(function () {
    // Filter logic
    $("#searchInput").on("keyup", function () {
        var columnIndex = $("#columnFilter").val(); // Get selected column index
        var searchValue = $(this).val().toLowerCase();

        $("#usersTableBody tr").filter(function () {
            // Match the value in the specified column (nth-child)
            $(this).toggle(
                $(this).children("td:nth-child(" + columnIndex + ")")
                    .text()
                    .toLowerCase()
                    .indexOf(searchValue) > -1
            );
        });
    });
});

$(document).ready(function() {
    // Load users on page load
    loadUsers();

    // Show/Hide Forms
    $('#showAddForm').click(function() {
        $('#createForm').slideDown();
        $('#updateForm').slideUp();
    });

    $('#cancelAdd').click(function() {
        $('#createForm').slideUp();
        $('#addUserForm')[0].reset();
    });

    $('#cancelUpdate').click(function() {
        $('#updateForm').slideUp();
        $('#updateUserForm')[0].reset();
    });

    // Add User
    $('#addUserForm').submit(function(e) {
        e.preventDefault();
        showLoading();
        
        $.ajax({
            url: '<?= site_url('user/add') ?>',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                hideLoading();
                if(response.success) {
                    alert(response.message);
                    $('#createForm').slideUp();
                    $('#addUserForm')[0].reset();
                    loadUsers();
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                hideLoading();
                alert('An error occurred');
            }
        });
    });

    // Update User
    $('#updateUserForm').submit(function(e) {
        e.preventDefault();
        showLoading();
        
        const id = $('#updateUserId').val();
        $.ajax({
            url: '<?= site_url('user/update') ?>',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                hideLoading();
                if(response.success) {
                    alert(response.message);
                    $('#updateForm').slideUp();
                    $('#updateUserForm')[0].reset();
                    loadUsers();
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                hideLoading();
                alert('An error occurred');
            }
        });
    });

    // Delete User
    $(document).on('click', '.delete-user', function() {
        if(confirm('Are you sure you want to delete this user?')) {
            const id = $(this).data('id');
            showLoading();
            
            $.ajax({
                url: '<?= site_url('user/delete/') ?>' + id,
                type: 'GET',
                success: function() {
                    hideLoading();
                    loadUsers();
                },
                error: function() {
                    hideLoading();
                    alert('An error occurred');
                }
            });
        }
    });

    // Edit User
    $(document).on('click', '.edit-user', function() {
        const id = $(this).data('id');
        showLoading();
        
        $.ajax({
            url: '<?= site_url('user/getOne/') ?>' + id,
            type: 'GET',
            success: function(response) {
                hideLoading();
                $('#updateUserId').val(response.id);
                $('#update_lname').val(response.aza_last_name);
                $('#update_fname').val(response.aza_first_name);
                $('#update_email').val(response.aza_email);
                $('#update_gender').val(response.aza_gender);
                $('#update_address').val(response.aza_address);
                
                $('#updateForm').slideDown();
                $('#createForm').slideUp();
            },
            error: function() {
                hideLoading();
                alert('An error occurred');
            }
        });
    });
});

// Load Users Function
function loadUsers() {
    showLoading();
    $.ajax({
        url: '<?= site_url('user/getUsers') ?>',
        type: 'GET',
        success: function(response) {
            hideLoading();
            $('#usersTableBody').html(response);
        },
        error: function() {
            hideLoading();
            alert('Error loading users');
        }
    });
}

// Loading Functions
function showLoading() {
    $('.loading-spinner, .overlay').show();
}

function hideLoading() {
    $('.loading-spinner, .overlay').hide();
}
</script>

</body>
</html>