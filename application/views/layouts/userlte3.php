<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('layouts/parts_user/head'); ?>

</head>

<body>

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

    <!-- JavaScript Application Logic -->
    <script src="<?= base_url('assets/js/app.js') ?>"></script>
</body>

</html>