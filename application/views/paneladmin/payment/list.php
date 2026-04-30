<div class="content-wrapper">

    <!-- Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Payment Verification</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card card-primary card-outline">

                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-credit-card mr-2"></i>
                        Data Payment Peserta
                    </h3>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Bank</th>
                                    <th>Sender</th>
                                    <th width="10%">Proof</th>
                                    <th width="10%">Status</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </section>
</div>

<script>
    let csrfName = 'csrf_token_jkt3';
    let csrfHash = '<?= $this->security->get_csrf_hash(); ?>';

    let table = $('#table').DataTable({
        processing: true,
        serverSide: false,
        responsive: true,
        autoWidth: false,

        ajax: {
            url: "<?= site_url('payment/ajax_list'); ?>",
            type: "POST",
            data: function(d) {
                d[csrfName] = csrfHash;
            },
            dataSrc: function(json) {
                csrfHash = json.csrf_token;
                return json.data;
            }
        },

        columnDefs: [{
            targets: [0, 5, 6, 7],
            className: 'text-center'
        }]
    });
</script>

<!-- Modal Preview -->
<div class="modal fade" id="modalPreview" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Preview Payment Proof</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body text-center">
                <img id="previewImg" src="" class="img-fluid" style="max-height:500px;">
            </div>

        </div>
    </div>
</div>

<script>
    function verifyPayment(id, status) {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Update status payment?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({
                    url: "<?= site_url('payment/ajax_verify'); ?>",
                    type: "POST",
                    data: {
                        id: id,
                        status: status,
                        [csrfName]: csrfHash
                    },
                    dataType: "json",
                    success: function(res) {
                        csrfHash = res.csrf_token;

                        Swal.fire('Success', 'Status updated!', 'success');
                        table.ajax.reload(null, false);
                    }
                });

            }
        });
    }

    // Preview gambar
    function previewImage(url) {
        $('#previewImg').attr('src', url);
        $('#modalPreview').modal('show');
    }
</script>