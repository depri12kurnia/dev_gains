<!-- Main Content -->
<section class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-credit-card mr-2"></i>
                    Data Payment
                </h3>
                <button type="button" id="btn_export_excel" class="btn btn-success btn-sm float-right">
                    <i class="fas fa-file-excel"></i> Export to Excel
                </button>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="data_payment" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Email</th>
                                <th>Name</th>
                                <th>Bank</th>
                                <th>Sender</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Preview -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">User Form</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id" />
                    <div class="form-body">
                        <div class="row">
                            <div class="col-lg-8 col-12">
                                <div class="form-group">
                                    <label class="control-label col-md-6">Proof of Payment</label>
                                    <div class="col-md-12">
                                        <div id="filePreviewContainer" class="d-flex flex-column align-items-center">
                                            <embed id="previewEmbed" src="" type="" class="img-fluid" style="max-width: 100%; height: auto; cursor: pointer; display: none;" onclick="previewFile(this.dataset.fileUrl, this.dataset.fileType)">
                                            <p id="noProofText" class="text-muted mt-2" style="display: none;">No proof file available</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-12">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Email</label>
                                    <div class="col-md-12">
                                        <input name="email" placeholder="Email" class="form-control" type="text" readonly>
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3">Bank</label>
                                    <div class="col-md-12">
                                        <input name="bank_name" placeholder="Bank" class="form-control" type="text" readonly>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Sender Name</label>
                                    <div class="col-md-12">
                                        <input name="sender_name" placeholder="Sender Name" class="form-control" type="text" readonly>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Status</label>
                            <div class="col-md-12">
                                <input type="radio" name="status" value="approved"> Approved
                                <input type="radio" name="status" value="rejected"> Rejected
                            </div>
                        </div>
                        <!-- if status rejected -->
                        <div class="form-group" id="reason_group" style="display: none;">
                            <label class="control-label col-md-3">Reason</label>
                            <div class="col-md-12">
                                <textarea name="comment" placeholder="Reason" class="form-control" rows="3" readonly></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <!-- end if status rejected -->
                    </div>
                    <div class="modal-footer justify-content-start">
                        <button type=" button" class="btn btn-primary" id="btnSave">Save</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="csrf_token" name="csrf_token_jkt3" value="<?= $this->security->get_csrf_hash(); ?>">

<script>
    var save_method;
    var table;

    function getCsrfToken() {
        let token = $('#csrf_token').val();
        if (token) {
            return token;
        }

        token = document.cookie.split('; ')
            .find(row => row.startsWith('csrf_cookie_jkt3='))
            ?.split('=')[1] || '';

        return token;
    }

    function getCookie(name) {
        let matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }

    $(document).ajaxSend(function(e, xhr, options) {
        let csrfToken = getCsrfToken() || $('meta[name="csrf-token"]').attr('content');
        if (csrfToken) {
            xhr.setRequestHeader('X-CSRF-Token', csrfToken);
        }
    });

    function viewPayment(id) {
        save_method = 'update';
        $('#form')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        $.ajax({
            url: "<?php echo site_url('admin/payment/ajax_view/') ?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="id"]').val(data.id);
                $('[name="email"]').val(data.email);
                $('[name="bank_name"]').val(data.bank_name);
                $('[name="sender_name"]').val(data.sender_name);
                $('[name="proof_file"]').val(data.proof_file || '');
                $('[name="comment"]').val(data.comment || '');

                $('input[name="status"]').prop('checked', false);
                if (data.status) {
                    $('input[name="status"][value="' + data.status + '"]').prop('checked', true);
                }

                updateProofPreview(data.proof_file);
                toggleReasonField();

                $('#modal_form').modal('show');
                $('.modal-title').text('View Payment');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error getting data from ajax');
            }
        });
    }


    $(document).ready(function() {
        // Cek apakah DataTable sudah diinisialisasi
        if (!$.fn.DataTable.isDataTable('#data_payment')) {
            table = $('#data_payment').DataTable({
                "processing": true,
                "serverSide": true,
                "responsive": false,
                "autoWidth": false,
                "lengthChange": true,
                "ordering": false,
                "ajax": {
                    "url": "<?php echo site_url('admin/payment/ajax_list') ?>",
                    "type": "POST",
                    "data": function(d) {
                        d.csrf_token_jkt3 = getCsrfToken(); // Kirim CSRF token sebagai data POST
                    },
                    "error": function(xhr) {
                        console.log("Error:", xhr.responseText);
                    }
                }

            });
        }

        $('input[name="status"]').on('change', toggleReasonField);
        $('#btnSave').on('click', function(e) {
            e.preventDefault();

            var id = $('[name="id"]').val();
            var status = $('input[name="status"]:checked').val();
            var comment = $('[name="comment"]').val();
            verifyPayment(id, status, comment);
        });

        // Export to Excel button event
        $('#btn_export_excel').click(function() {
            var url = "<?php echo site_url('admin/payment/export_excel') ?>";
            window.open(url, '_blank');
        });
    });


    function verifyPayment(id, status, comment) {
        if (status === 'rejected' && (!comment || !comment.trim())) {
            Swal.fire('Warning', 'Please provide a rejection reason.', 'warning');
            return;
        }

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
                    url: "<?= site_url('admin/payment/ajax_verify'); ?>",
                    type: "POST",
                    data: {
                        id: id,
                        status: status,
                        comment: comment,
                        csrf_token_jkt3: getCsrfToken()
                    },
                    dataType: "json",
                    success: function(res) {
                        if (!res.status) {
                            Swal.fire('Error', res.message || 'Unable to update status', 'error');
                            return;
                        }

                        if (res.csrf_token) {
                            $('#csrf_token').val(res.csrf_token);
                            document.cookie = 'csrf_cookie_jkt3=' + res.csrf_token + '; path=/';
                        }
                        Swal.fire('Success', 'Status updated!', 'success');
                        table.ajax.reload(null, false);
                        $('#modal_form').modal('hide');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire('Error', 'AJAX verify request failed: ' + textStatus, 'error');
                    }
                });
            }
        });
    }

    function getFileTypeFromUrl(url) {
        if (!url) {
            return '';
        }
        return url.split('.').pop().toLowerCase();
    }

    function isImageFile(fileType) {
        return ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg'].includes(fileType);
    }

    function isPdfFile(fileType) {
        return fileType === 'pdf';
    }

    function updateProofPreview(fileName) {
        var proofUrl = '';
        var fileType = getFileTypeFromUrl(fileName);

        if (fileName) {
            proofUrl = "<?= base_url('public/uploads/payment/'); ?>" + encodeURIComponent(fileName);
        }

        var isImage = isImageFile(fileType);
        var isPdf = isPdfFile(fileType);
        var mimeType = isPdf ? 'application/pdf' : (isImage ? 'image/' + fileType : '');

        $('#previewEmbed').attr('data-file-url', proofUrl).attr('data-file-type', fileType);

        if (proofUrl && mimeType) {
            $('#previewEmbed').attr('src', proofUrl).attr('type', mimeType).show();
            $('#noProofText').hide();
        } else {
            $('#previewEmbed').hide().attr('src', '').attr('type', '');
            $('#noProofText').show();
        }
    }

    function toggleReasonField() {
        var selected = $('input[name="status"]:checked').val();
        if (selected === 'rejected') {
            $('#reason_group').show();
            $('[name="comment"]').prop('readonly', false);
        } else {
            $('#reason_group').hide();
            $('[name="comment"]').prop('readonly', true);
        }
    }

    function previewFile(url, fileType) {
        if (!url) {
            return;
        }

        window.open(url, '_blank');
    }
</script>