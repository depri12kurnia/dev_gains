<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('layouts/parts_user/head'); ?>

</head>

<body>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {

            <?php if ($this->session->userdata('login')) { ?>

                $('#nav-auth-buttons').addClass('hidden');
                $('#nav-user-buttons').removeClass('hidden').addClass('flex');

            <?php } else { ?>

                $('#nav-auth-buttons').removeClass('hidden');
                $('#nav-user-buttons').addClass('hidden');

            <?php } ?>

        });
    </script>
    <!-- Navbar -->
    <?php $this->load->view('layouts/parts_user/navbar'); ?>

    <!-- MAIN CONTENT AREA -->
    <main class="flex-grow">
        <!-- Dynamic Page Content -->
        <?php
        if (isset($content) && !empty($content)) {
            // Cek apakah file view-nya benar-benar ada
            $view_path = APPPATH . 'views/' . $content . '.php';

            if (file_exists($view_path)) {
                $this->load->view($content, isset($data) ? $data : array());
            } else {
                echo "Error: File view tidak ditemukan di: " . $view_path;
            }
        } else {
            echo "Error: Variabel \$content belum didefinisikan di Controller.";
        }
        ?>
    </main>

    <!-- Footer -->
    <?php $this->load->view('layouts/parts_user/footer'); ?>


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/2.3.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.8/js/dataTables.bootstrap5.min.js"></script>
    <!-- JavaScript Application Logic -->
    <script src="https://cdn.jsdelivr.net/gh/depri12kurnia/dev_gains@74545b357d2dd7c4e5fcd7478bad28d9775747ac/assets/js/app.js"></script>

</body>

</html>