<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🎄 Lavalust User Management System 🎄</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #0a192f;
            color: #e6f1ff;
            font-family: 'Arial', sans-serif;
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
            background: rgba(10, 25, 47, 0.8);
            z-index: 9998;
        }
        .card {
            background-color: #172a45;
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        .card-header {
            background-color: #1d3557;
            color: #fca311;
            border-bottom: 2px solid #fca311;
        }
        .btn-primary {
            background-color: #fca311;
            border-color: #fca311;
            color: #0a192f;
        }
        .btn-primary:hover {
            background-color: #f77f00;
            border-color: #f77f00;
        }
        .table {
            color: #e6f1ff;
        }
        .table th {
            background-color: #1d3557;
            color: #fca311;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(29, 53, 87, 0.1);
        }
        .snowflake {
            position: fixed;
            top: -10px;
            font-size: 1.5rem;
            color: #ffffff;
            animation: snowfall 10s linear infinite;
            user-select: none;
            pointer-events: none;
            z-index: 9999;
        }
        @keyframes snowfall {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(100vh) rotate(360deg);
                opacity: 0;
            }
        }
        .navbar {
            background-color: #1d3557;
        }
        .navbar-brand {
            color: #fca311 !important;
            font-weight: bold;
            font-size: 1.5rem;
        }
        #alertContainer {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
        .game-element {
            position: absolute;
            font-size: 2rem;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        .game-element:hover {
            transform: scale(1.2);
        }
        #paginationControls{
            font-weight:500;
            color: #e6f1ff;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">🎄 Lavalust User Management System 🎄</a>
        </div>
    </nav>

    <div class="container mt-4">
        <div id="alertContainer"></div>
        <div class="row mb-4">
        <?php flash_alert(); ?>
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
                                <input type="text" class="form-control" placeholder="Last Name" id="lname" name="lname">
                            </div>
                            <div class="mb-3">
                                <label for="fname" class="form-label">First Name</label>
                                <input type="text" class="form-control" placeholder="First Name" id="fname" name="fname">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" placeholder="Email Name" id="email" name="email">
                            </div>
                            <div class="mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-select" id="gender" name="gender">
                                    <option value="">Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" id="address" placeholder="Address" name="address"></textarea>
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
                                <input type="text" class="form-control" id="update_lname" name="lname">
                            </div>
                            <div class="mb-3">
                                <label for="update_fname" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="update_fname" name="fname">
                            </div>
                            <div class="mb-3">
                                <label for="update_email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="update_email" name="email">
                            </div>
                            <div class="mb-3">
                                <label for="update_gender" class="form-label">Gender</label>
                                <select class="form-select" id="update_gender" name="gender">
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="update_address" class="form-label">Address</label>
                                <textarea class="form-control" id="update_address" name="address"></textarea>
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

    <!-- Snowflakes -->
    <div class="snowflake" style="left: 5%;">❄️</div>
    <div class="snowflake" style="left: 15%; animation-delay: 2s;">❄️</div>
    <div class="snowflake" style="left: 25%; animation-delay: 4s;">❄️</div>
    <div class="snowflake" style="left: 35%; animation-delay: 6s;">❄️</div>
    <div class="snowflake" style="left: 45%; animation-delay: 8s;">❄️</div>
    <div class="snowflake" style="left: 55%; animation-delay: 1s;">❄️</div>
    <div class="snowflake" style="left: 65%; animation-delay: 3s;">❄️</div>
    <div class="snowflake" style="left: 75%; animation-delay: 5s;">❄️</div>
    <div class="snowflake" style="left: 85%; animation-delay: 7s;">❄️</div>
    <div class="snowflake" style="left: 95%; animation-delay: 9s;">❄️</div>

    <!-- Game Elements -->
    <div class="game-element" style="top: 10%; left: 5%;">🎁</div>
    <div class="game-element" style="top: 20%; left: 95%;">🎄</div>
    <div class="game-element" style="top: 80%; left: 10%;">🦌</div>
    <div class="game-element" style="top: 70%; left: 90%;">🎅</div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {

            // Game animation
            let score = 0;
            $('.game-element').click(function() {
                $(this).fadeOut(300, function() {
                    $(this).css({
                        'top': Math.random() * 80 + 10 + '%',
                        'left': Math.random() * 90 + 5 + '%'
                    }).fadeIn(300);
                });
                score++;
                showAlert('Score: ' + score, 'success');
            });
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

            // Enhanced alert function
            function showAlert(message, type = 'info') {
                const alertHtml = `
                    <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                $('#alertContainer').append(alertHtml);
                setTimeout(() => {
                    $('.alert').alert('close');
                }, 3000);
            }

            // Form animations
            $('#showAddForm').click(function() {
                $('#createForm').slideDown(300);
                $('#updateForm').slideUp(300);
            });

            $('#cancelAdd, #cancelUpdate').click(function() {
                $(this).closest('.row').slideUp(300);
            });

            // Table row hover effect
            $(document).on('mouseenter', '#usersTableBody tr', function() {
                $(this).addClass('table-active');
            }).on('mouseleave', '#usersTableBody tr', function() {
                $(this).removeClass('table-active');
            });

            // Loading spinner animation
            function showLoading() {
                $('.loading-spinner, .overlay').fadeIn(200);
            }

            function hideLoading() {
                $('.loading-spinner, .overlay').fadeOut(200);
            }
        });
    </script>
</body>
</html>