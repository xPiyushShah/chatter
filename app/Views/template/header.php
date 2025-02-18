<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= (!empty($title)) ? $title : 'Dashboard'; ?> | Book </title>

    <!-- Include Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Include Toastr CSS and JS -->
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <!-- Include Bootstrap Select CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.1/dist/css/bootstrap-select.min.css"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.1/dist/js/bootstrap-select.min.js"></script>

    <!-- Include Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Include CSS for Date Range Picker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <!-- ApexCharts CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- Include jQuery (required for Date Range Picker) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include JS for Date Range Picker -->
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <!-- Bootstrap 5 JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.3.0/exceljs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/exceljs@4.0.0/dist/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/daterangepicker/3.1.0/daterangepicker.min.js"></script>
    <!-- Include JS for Date Range Picker -->
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.js"></script>


    <style>
        /* CSS for Library description */
        .library-description {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-top: 20px;
            color: #555;
            padding: 30px 50px
        }

        .library-description strong {
            color: #007bff;
        }

        /* CSS for circular profile image */
        .profile-img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ffe435;
            /* Optional: border to match your theme */
        }

        /* Navbar text styling */
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: #007bff;
        }

        .nav-link {
            font-size: 1.1rem;
        }
    </style>
    <style>
        .closebtn {
            position: absolute;
            right: 32px;
        }

        .modal-title {
            position: relative;
            left: 18px;
        }

        .navbar {
            margin-bottom: 30px;
        }

        .navbar-brand {
            color: #4e73df;
        }

        .navbar-nav .nav-link {
            color: #5a5c69;
        }

        .navbar-nav .nav-link:hover {
            color: #4e73df;
        }

        .form-container {
            width: 85%;
            margin: 0 auto;
            padding: 40px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .form-container h3 {
            margin-bottom: 30px;
            color: #34495e;
        }

        .form-group label {
            font-weight: bold;
            color: #6c757d;
        }

        .form-group input,
        .form-group textarea,
        .form-group select,
        .form-group button {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
            font-size: 16px;
        }

        .form-group input[type="file"] {
            padding: 0;
        }

        .form-group input[type="date"] {
            font-size: 16px;
        }

        .form-group button {
            background-color: #4e73df;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #2e59d9;
        }

        .form-group .invalid-feedback {
            color: red;
        }

        .accordion-button {
            background-color: #4e73df;
            color: white;
        }

        .accordion-button:focus {
            box-shadow: none;
        }

        .form-group input[type="checkbox"],
        .form-group input[type="radio"] {
            width: auto;
            margin-right: 8px;
        }

        .btn-submit {
            background-color: #4e73df;
            color: white;
            font-size: 16px;
            padding: 12px 20px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
        }

        .btn-submit:hover {
            background-color: #2e59d9;
        }

        /* Circle Image Style */
        .circle-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            background-color: black;
            /* Default background */
        }

        .cok {
            position: absolute;
            right: 76px;
            width: 200px;
            height: 64px;
            /* border-radius: 50%; */
            object-fit: cover;
        }
    </style>
    <style>
        .fa-cart-shopping {
            margin-top: 15px;
            margin-left: 8px;
            font-size: 18px;
            cursor: pointer;
        }

        .fa-cart-shopping:hover {
            color: blue;
        }
    </style>
    <style>
        .toastbox {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 9999;
            width: 300px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .maintoast {
            display: flex;
            align-items: center;
            background-color: #333;
            color: white;
            border-radius: 8px;
            padding: 10px 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            opacity: 0;
            transform: translateY(-20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
            width: 100%;
            justify-content: space-between;
            font-size: 16px;
        }

        .maintoast.show {
            opacity: 1;
            transform: translateY(0);
        }

        .icon {
            margin-right: 10px;
            font-size: 18px;
            font-weight: bold;
        }

        .msg {
            flex-grow: 1;
        }

        .offtoast {
            cursor: pointer;
            font-weight: bold;
            font-size: 18px;
            padding: 0 5px;
            background-color: transparent;
            border: none;
            color: white;
        }

        .success {
            background-color: #28a745;
        }

        .warning {
            background-color: #ffc107;
        }

        .error {
            background-color: #dc3545;
        }

        /* cart unum */
        .cart_num {
            border-radius: 22px;
            background: red;
            height: 17px;
            display: block;
            width: 16px;
            position: absolute;
            top: 5px;
            left: 26px;
            cursor: pointer;
        }

        .undercart_num {
            display: flex;
            width: 100%;
            height: 100%;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 13px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-weight: bold;
        }

        .cart-button {
            outline: none;
            background: transparent;
            border: none;
        }

        .cart-button i:hover {
            color: black;
        }
    </style>
    <!-- notification css -->
    <style>
        /* Message div styling */
        .message-div {
            position: fixed;
            top: 60px;
            /* Position it right below the navbar */
            right: 0px;
            background-color: #f1f1f1;
            width: 300px;
            /* Set a fixed width */
            max-height: 90vh;
            /* Make the div take up to 90% of the screen height */
            border-radius: 10px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.9);
            overflow-y: auto;
            display: none;
            z-index: 99999;
            /* Initially hidden */
            transition: all 0.3s ease-in-out;
        }

        /* Make the div expand when visible */
        .message-div.expanded {
            width: 350px;
            /* Optionally, make it a bit wider when expanded */
        }

        /* Header inside the message div */
        .message-header {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .message-header h5 {
            margin: 0;
        }

        /* Close button for the message div */
        .close-btn {
            background-color: transparent;
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
        }

        /* Message content area */
        .message-content {
            padding: 10px;
            font-size: 14px;
            color: #333;
        }

        .message-button i {
            font-size: 18px;
            margin-top: 12px;
        }

        .message-button :hover {
            background: transparent;
            outline: none;
            border: none;
        }

        .dropdown-menu {
            z-index: 1050 !important;
        }
    </style>
    <!-- nav bar -->
    <style>
        /* Hover effect on profile icon to show the dropdown */
        .profile-icon:hover .dropdown-menu {
            display: block;
            /* Show the dropdown when hovering over the profile icon */
        }

        /* Dropdown menu styling */
        .dropdown-menu {
            display: none;
            /* Hide the dropdown by default */
            position: absolute;
            top: 100%;
            right: -82px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        /* Optional styling for the profile image */
        .profile-img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            object-fit: cover;
        }

        #ses-check-time {
            display: flex;
            margin-right: 54px;
            right: 35px;
            position: absolute;
            align-items: center;
            justify-content: center;
        }

        .sidebardown>li>* {
            display: flex;
            align-items: center;
            justify-content: start;
        }

        .sidebardown>li>a {
            display: flex;
            gap: 14px;
        }

        .sidebardown>li>a {
            display: flex;
            align-items: center;
            justify-content: start;
        }
    </style>
</head>

<body>
    <?php
    $this->id = session("login")['id'];
    $this->db = \Config\Database::connect();
    ?>

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color: #e3f2fd;">
        <a class="navbar-brand" href="<?= base_url('dashboard') ?>" style="margin-left: 45px;">L-Book</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03"
            aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation"
            style="margin-right: 45px;">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse showbasebyurl" id="navbarNavDropdown">
            <?php if (session('login') != ""): ?>
                <?php
                $this->id = session("login")['id'];
                $this->db = \Config\Database::connect();
                $this->usr_sec = $this->db->table('user_details'); // Table instance
                ?>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="margin-left: 4px;">
                    <?php if (session("login")['admin'] == 2): ?>
                        <li class="nav-item active">
                            <a class="nav-link clos-nav" href="<?= base_url('/book') ?>">Books</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link clos-nav" href="<?= base_url('/rental') ?>">Rental</a>
                        </li>
                    <?php elseif (session("login")['admin'] == 3): ?>
                        <li class="nav-item active">
                            <a class="nav-link clos-nav" href="<?= base_url('/book') ?>">Books</a>
                        </li>
                    <?php elseif (session("login")['admin'] == 1): ?>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav ms-auto" id="ses-check-time">
                    <?php if (session("login")['admin'] == 3): ?>
                        <li class="nav-item dropdown">
                            <button role="button" onclick="showModal2('<?= base_url('/cart-modal') ?>', 'Cart')"
                                data-bs-toggle="tooltip" data-placement="bottom" data-bs-auto-close="outside"
                                class="cart-button">
                                <i class="fa-solid fa-cart-shopping"></i>
                                <span style="display:none;" class="cart_num"><span class="undercart_num"
                                        id="cart_num"></span></span>
                            </button>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <div class="message-icon-container">
                            <button class="btn btn-light message-button" onclick="toggleMessageDiv()">
                                <!-- <i class="fa-regular fa-message"></i> --><i class="fa-regular fa-bell"></i>
                            </button>
                        </div>
                    </li>
                    <!-- Profile Icon (Image or Placeholder) -->
                    <li class="nav-item dropdown profile-icon">
                        <a class="nav-link" href="#" id="navbarDropdownProfileLink" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <?php $img = $this->usr_sec->where('id', $this->id)->get()->getRow(); ?>
                            <?php if (!empty($img->file_loc)): ?>
                                <img src="<?= $img->file_loc ?>" alt="Profile" class="profile-img"
                                    style="width: 30px; height: 30px; border-radius: 50%;">
                            <?php else: ?>
                                <span><?= $img->first_name ?></span>
                            <?php endif; ?>
                            <span id="profile"></span>
                        </a>
                        <ul class="dropdown-menu sidebardown" aria-labelledby="navbarDropdownProfileLink">
                            <?php if (session("login")['admin'] == 3): ?>
                                <li><a class="dropdown-item disabled">User / Reader</a></li>
                                <li><a class="dropdown-item" href="<?= base_url('transaction') ?>">
                                        <i class="fa-solid fa-arrow-right-arrow-left"></i><span>Transaction</a></span></li>
                                <li><a class="dropdown-item" href="<?= base_url('book-wallet') ?>">
                                        <i class="fa-solid fa-wallet"></i><span>Book Wallet</span></a></li>
                            <?php elseif (session("login")['admin'] == 2): ?>
                                <li><a class="dropdown-item disabled">Librarian</a></li>
                                <li><a class="dropdown-item" href="<?= base_url('history') ?>">
                                        <i class="fa-solid fa-clock-rotate-left"></i><span>History</span></a></li>
                                <li><a class="dropdown-item" href="<?= base_url('help') ?>">
                                        <i class="fa-solid fa-money-check"></i><span>Funds</span></a></li>
                            <?php elseif (session("login")['admin'] == 1): ?>
                                <li><a class="dropdown-item disabled">Super Admin</a></li>
                                <li><a class="dropdown-item" href="<?= base_url('help') ?>">
                                        <i class="fa-solid fa-users"></i><span>Manage Users</span></a></li>
                                <li><a class="dropdown-item" href="<?= base_url('help') ?>">
                                        <i class="fa-solid fa-money-check"></i><span>Chareges</span></a></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item" href="<?= base_url('prof-section') ?>">
                                    <i class="fa-solid fa-user"></i><span>Profile</span></a></li>
                            <li><a class="dropdown-item" href="<?= base_url('help') ?>">
                                    <i class="fa-solid fa-question"></i><span>Help</span></a></li>
                            <li><a class="dropdown-item bg-danger text-white" href="" id="logout">
                                    <i class="fa-solid fa-right-from-bracket"></i><span>Log Out</span></a></li>
                        </ul>
                    </li>
                </ul>
            <?php elseif (session('login') == ""): ?>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0" style="margin-left: 54px; right: 35px; position: absolute;">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('panel') ?>">Login</a>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </nav>


    <!-- Message Div (Initially hidden) -->
    <div id="messageDiv" class="message-div" style="display: none;">
        <div class="message-header">
            <small>Messages</small>
            <button class="close-btn" onclick="toggleMessageDiv()"><i class="fa-solid fa-circle-xmark"></i></button>
        </div>
        <div class="message-content">
            <p>Your message content goes here. This will be dynamic.</p>
        </div>
    </div>
    <!-- Navbar End -->

    <!-- Toastbox (for notifications) -->
    <div class="toastbox" id="toast-container"></div>
    <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true" id="modal_md">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Loading.....</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Content from AJAX will be injected here -->
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> -->
            </div>
        </div>
    </div>
    <!--  -->

    <!-- JavaScript -->
    <script>
        $(document).ready(function () {
            $(window).click(function (event) {
                if ($(event.target).is("#myModal")) {
                    $("#myModal").hide();
                }
            });
        });
        function toggleMessageDiv() {
            var messageDiv = document.getElementById('messageDiv');
            // Toggle the visibility of the div
            if (messageDiv.style.display === "none" || messageDiv.style.display === "") {
                messageDiv.style.display = "block"; // Show the div
                messageDiv.classList.add('expanded'); // Optional: add class for expanded state
            } else {
                messageDiv.style.display = "none"; // Hide the div
                messageDiv.classList.remove('expanded'); // Optional: remove expanded class
            }
        }
    </script>

    <script>
        function showModal2(url, title) {
            // Bootstrap 5 modal initialization
            var modal = new bootstrap.Modal(document.getElementById('modal_md'));
            modal.show();

            // AJAX to load content into the modal
            $.ajax({
                url: url,
                success: function (response) {
                    $('#modal_md .modal-title').html(title);
                    $('#modal_md .modal-body').html(response);
                }
            });
        }
    </script>