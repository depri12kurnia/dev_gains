<!-- Main Content -->
<section class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-file-alt mr-2"></i>
                    Data Submission
                </h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="data_submission" class="table table-bordered table-striped small">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Email</th>
                                <th>Institution</th>
                                <th>Country</th>
                                <th>Category</th>
                                <th>Title</th>
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
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Email</label>
                                    <div class="col-md-12">
                                        <input name="email" placeholder="Email" class="form-control" type="email" readonly>
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3">Institution</label>
                                    <div class="col-md-12">
                                        <input name="institution" placeholder="Institution" class="form-control" type="text" readonly>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Country</label>
                                    <div class="col-md-12">
                                        <input name="country" placeholder="Country" class="form-control" type="text" readonly>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Category</label>
                                    <div class="col-md-12">
                                        <input name="category" placeholder="Category" class="form-control" type="text" readonly>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Title</label>
                                    <div class="col-md-12">
                                        <input name="title" placeholder="Title" class="form-control" type="text" readonly>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Link</label>
                                    <div class="col-md-12">
                                        <input name="link" id="link" placeholder="Link" class="form-control" type="url" readonly>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-12">Click Here to Preview</label>
                                    <div class="col-md-12">
                                        <a href="#" id="previewLink" target="_blank" style="display: none;"><button type="button" class="btn btn-warning"><i class="fas fa-link text-primary" aria-hidden="true"></i> Preview Link</button></a>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Status</label>
                            <div class="col-md-12">
                                <input type="radio" name="status" value="finalist"> Finalist
                                <input type="radio" name="status" value="not selected"> Not Selected
                            </div>
                        </div>
                        <!-- if status rejected -->
                        <div class="form-group" id="reason_group" style="display: none;">
                            <label class="control-label col-md-3">Reason</label>
                            <div class="col-md-12">
                                <textarea name="comment" placeholder="Reason" class="form-control" rows="3"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <!-- end if status rejected -->
                    </div>
                    <div class="modal-footer justify-content-start">
                        <button type="button" class="btn btn-primary" id="btnSave">Save Verification</button>
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

    function viewSubmission(id) {
        save_method = 'update';
        $('#form')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();

        // Hide preview link on modal open
        $('#previewLink').hide();
        $.ajax({
            url: "<?php echo site_url('admin/submissions/ajax_view/') ?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="id"]').val(data.id);
                $('[name="email"]').val(data.email);
                $('[name="institution"]').val(data.institution);
                $('[name="country"]').val(data.country);
                $('[name="category"]').val(data.category);
                $('[name="title"]').val(data.title);
                $('[name="link"]').val(data.link);
                $('[name="proof_file"]').val(data.proof_file || '');
                $('[name="comment"]').val(data.comment || '');

                // Update preview link
                updatePreviewLink(data.link);

                $('input[name="status"]').prop('checked', false);
                if (data.status) {
                    $('input[name="status"][value="' + data.status + '"]').prop('checked', true);
                }

                updateProofPreview(data.proof_file);
                toggleReasonField();

                $('#modal_form').modal('show');
                $('.modal-title').text('View Submission');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error getting data from ajax');
            }
        });
    }

    function verifySubmission(id, status, comment) {
        if (status === 'rejected' && (!comment || !comment.trim())) {
            Swal.fire('Warning', 'Please provide a rejection reason.', 'warning');
            return;
        }

        Swal.fire({
            title: 'Konfirmasi',
            text: 'Update status submission?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('admin/submissions/ajax_verify'); ?>",
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
            proofUrl = "<?= base_url('public/uploads/submissions/'); ?>" + encodeURIComponent(fileName);
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

    function updatePreviewLink(linkValue) {
        if (linkValue && linkValue.trim()) {
            $('#previewLink').attr('href', linkValue).show();
        } else {
            $('#previewLink').attr('href', '#').hide();
        }
    }

    function toggleReasonField() {
        var selected = $('input[name="status"]:checked').val();
        if (selected === 'not selected') {
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

    $(document).ready(function() {
        // Cek apakah DataTable sudah diinisialisasi
        if (!$.fn.DataTable.isDataTable('#data_submission')) {
            table = $('#data_submission').DataTable({
                "processing": true,
                "serverSide": true,
                "responsive": false,
                "autoWidth": false,
                "lengthChange": true,
                "ajax": {
                    "url": "<?php echo site_url('admin/submissions/ajax_list') ?>",
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

        // Update preview link when link input changes
        $('[name="link"]').on('input', function() {
            updatePreviewLink($(this).val());
        });

        $('#btnSave').on('click', function() {
            var id = $('[name="id"]').val();
            var status = $('input[name="status"]:checked').val();
            var comment = $('[name="comment"]').val();
            verifySubmission(id, status, comment);
        });
    });
</script>