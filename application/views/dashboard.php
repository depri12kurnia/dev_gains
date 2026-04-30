<style>
    .modal-header {
        background: #17a2b8;
        color: white;
    }

    table.dataTable thead th {
        text-align: center;
    }

    table.dataTable tbody td {
        vertical-align: middle;
    }
</style>
<div id="page-dashboard" class="page-section active" style="padding:0;">
    <div class="dashboard-layout">
        <!-- Participant -->
        <?php $this->load->view('dashboard/participant') ?>
    </div>
</div>