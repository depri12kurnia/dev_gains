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
                <!-- Filter Form -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="filter_category">Category:</label>
                        <select id="filter_category" class="form-control form-control-sm">
                            <option value="">All Categories</option>
                            <option value="ahic">AHIC</option>
                            <option value="e2ipbc">E2IPBC</option>
                            <option value="irpc">IRPC</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="filter_status">Status:</label>
                        <select id="filter_status" class="form-control form-control-sm">
                            <option value="">All Status</option>
                            <option value="submitted">Submitted</option>
                            <option value="not selected">Not Selected</option>
                            <option value="finalist">Finalist</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>&nbsp;</label><br>
                        <button type="button" id="btn_filter" class="btn btn-primary btn-sm">Filter</button>
                        <button type="button" id="btn_reset" class="btn btn-secondary btn-sm">Reset</button>
                    </div>
                    <div class="col-md-3 text-right">
                        <label>&nbsp;</label><br>
                        <button type="button" id="btn_export_excel" class="btn btn-success btn-sm">
                            <i class="fas fa-file-excel"></i> Export to Excel
                        </button>
                    </div>
                </div>
                <!-- End Filter Form -->
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
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Preview submission-->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Submission View</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id" />
                    <div class="form-body">
                        <div class="row">
                            <!-- SECTION A: Participant Data -->
                            <div class="col-lg-4 col-12">
                                <div class="form-group">
                                    <label class="control-label col-md-12">Team Leader (full name)</label>
                                    <div class="col-md-12">
                                        <input name="team_leader" placeholder="Team Leader" class="form-control" type="text" readonly>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-12">Academic/Professional Titles *</label>
                                    <div class="col-md-12">
                                        <input name="leader_titles" placeholder="Leader Titles" class="form-control" type="text" readonly>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-12">Institution</label>
                                    <div class="col-md-12">
                                        <input name="institution" placeholder="Institution" class="form-control" type="text" readonly>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-6">Country</label>
                                    <div class="col-md-12">
                                        <input name="country" placeholder="Country" class="form-control" type="text" readonly>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-12">
                                <div class="form-group">
                                    <label class="control-label col-md-6">Participation Type</label>
                                    <div class="col-md-12">
                                        <input name="partType" placeholder="Participation Type" class="form-control" type="text" readonly>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-6">Cross Collaboration</label>
                                    <div class="col-md-12">
                                        <input name="crossCollab" placeholder="Cross Collaboration" class="form-control" type="text" readonly>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-12">Team Members</label>
                                    <div class="col-md-12">
                                        <textarea name="team_members" placeholder="Team Members" class="form-control" rows="4" readonly></textarea>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-12">
                                <div class="form-group">
                                    <label class="control-label col-md-6">Category</label>
                                    <div class="col-md-12">
                                        <input name="category" placeholder="Category" class="form-control" type="text" readonly>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-6">Title</label>
                                    <div class="col-md-12">
                                        <input name="title" placeholder="Title" class="form-control" type="text" readonly>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-6">Focus Area</label>
                                    <div class="col-md-12">
                                        <input name="focus_area" placeholder="Focus Area" class="form-control" type="text" readonly>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="control-label col-md-12">Main Document</label>
                                    <div class="col-md-12">
                                        <a href="#" id="previewLink" target="_blank" style="display: none;"><button type="button" class="btn btn-warning"><i class="fas fa-link text-primary" aria-hidden="true"></i> Preview Link Main Document</button></a>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-6">Supporting Links</label>
                                    <div class="col-md-12">
                                        <a href="#" id="previewSupportLink" target="_blank" style="display: none;"><button type="button" class="btn btn-default"><i class="fas fa-link text-primary" aria-hidden="true"></i> Preview Link Supporting Documents</button></a>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="control-label col-md-6">Alignment Theme</label>
                                    <div class="col-md-12">
                                        <textarea name="alignment_theme" placeholder="Alignment Theme" class="form-control" rows="3" readonly></textarea>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="form-group">
                            <label class="control-label col-md-6">Status</label>
                            <div class="col-md-12">
                                <input type="radio" name="status" value="finalist"> Finalist
                                <input type="radio" name="status" value="under review"> Under Review
                                <input type="radio" name="status" value="not selected"> Not Selected
                            </div>
                        </div> -->
                        <!-- if status rejected -->
                        <div class="form-group" id="reason_group" style="display: none;">
                            <label class="control-label col-md-6">Reason</label>
                            <div class="col-md-12">
                                <textarea name="comment" placeholder="Reason" class="form-control" rows="3"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <!-- end if status rejected -->
                    </div>
                    <div class="modal-footer justify-content-start">
                        <!-- <button type="button" class="btn btn-primary" id="btnSave">Save Verification</button> -->
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
                $('[name="team_leader"]').val(data.team_leader);
                $('[name="leader_titles"]').val(data.leader_titles);
                $('[name="institution"]').val(data.institution);
                $('[name="country"]').val(data.country);
                $('[name="partType"]').val(data.partType);
                $('[name="crossCollab"]').val(data.crossCollab);
                $('[name="team_members"]').val(data.team_members);
                $('[name="category"]').val(data.category);
                $('[name="title"]').val(data.title);
                $('[name="focus_area"]').val(data.focus_area);
                $('[name="alignment_theme"]').val(data.alignment_theme);
                $('[name="link"]').val(data.link);
                $('[name="supporting_links"]').val(data.supporting_links);
                $('[name="proof_file"]').val(data.proof_file || '');
                $('[name="comment"]').val(data.comment || '');

                // Update preview link
                updatePreviewLink(data.link);
                updatePreviewSupportLink(data.supporting_links);

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

    function updatePreviewSupportLink(supportLinkValue) {
        if (supportLinkValue && supportLinkValue.trim()) {
            $('#previewSupportLink').attr('href', supportLinkValue).show();
        } else {
            $('#previewSupportLink').attr('href', '#').hide();
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
                        d.category = $('#filter_category').val();
                        d.status = $('#filter_status').val();
                    },
                    "error": function(xhr) {
                        console.log("Error:", xhr.responseText);
                    }
                }

            });
        }

        // Filter button event
        $('#btn_filter').click(function() {
            table.ajax.reload();
        });

        // Reset button event
        $('#btn_reset').click(function() {
            $('#filter_category').val('');
            $('#filter_status').val('');
            table.ajax.reload();
        });

        // Export to Excel button event
        $('#btn_export_excel').click(function() {
            var category = $('#filter_category').val();
            var status = $('#filter_status').val();
            var url = "<?php echo site_url('admin/submissions/export_excel') ?>?category=" + encodeURIComponent(category) + "&status=" + encodeURIComponent(status);
            window.open(url, '_blank');
        });

        $('input[name="status"]').on('change', toggleReasonField);

        // Update preview link when link input changes
        $('[name="link"]').on('input', function() {
            updatePreviewLink($(this).val());
        });

        // Update preview supporting link when supporting_links input changes
        $('[name="supporting_links"]').on('input', function() {
            updatePreviewSupportLink($(this).val());
        });

        $('#btnSave').on('click', function() {
            var id = $('[name="id"]').val();
            var status = $('input[name="status"]:checked').val();
            var comment = $('[name="comment"]').val();
            verifySubmission(id, status, comment);
        });
    });
</script>