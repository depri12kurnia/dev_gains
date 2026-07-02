<section class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-file-alt mr-2"></i>
                    Data Submission & Weighted Screenings
                </h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="data_screenings" class="table table-bordered table-striped w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Country</th>
                                <th>Category</th>
                                <th>Total Score</th>
                                <th>Decision</th>
                                <th style="width: 110px;">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

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
                            <div class="col-lg-4 col-12">
                                <div class="form-group">
                                    <label class="control-label col-md-12">Team Leader (full name)</label>
                                    <div class="col-md-12">
                                        <input name="team_leader" placeholder="Team Leader" class="form-control" type="text" style="filter: blur(4px); pointer-events: none;" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-12">Academic/Professional Titles *</label>
                                    <div class="col-md-12">
                                        <input name="leader_titles" placeholder="Leader Titles" class="form-control" type="text" style="filter: blur(4px); pointer-events: none;" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-12">Institution</label>
                                    <div class="col-md-12">
                                        <input name="institution" placeholder="Institution" class="form-control" type="text" style="filter: blur(4px); pointer-events: none;" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-6">Country</label>
                                    <div class="col-md-12">
                                        <input name="country" placeholder="Country" class="form-control" type="text" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-12">
                                <div class="form-group">
                                    <label class="control-label col-md-6">Participation Type</label>
                                    <div class="col-md-12">
                                        <input name="partType" placeholder="Participation Type" class="form-control" type="text" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-6">Cross Collaboration</label>
                                    <div class="col-md-12">
                                        <input name="crossCollab" placeholder="Cross Collaboration" class="form-control" type="text" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-12">Team Members</label>
                                    <div class="col-md-12">
                                        <textarea name="team_members" placeholder="Team Members" class="form-control" rows="4" style="filter: blur(4px); pointer-events: none;" readonly></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-12">
                                <div class="form-group">
                                    <label class="control-label col-md-6">Category</label>
                                    <div class="col-md-12">
                                        <input name="category" placeholder="Category" class="form-control" type="text" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-6">Title</label>
                                    <div class="col-md-12">
                                        <input name="title" placeholder="Title" class="form-control" type="text" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-6">Focus Area</label>
                                    <div class="col-md-12">
                                        <input name="focus_area" placeholder="Focus Area" class="form-control" type="text" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="control-label col-md-12">Main Document</label>
                                    <div class="col-md-12">
                                        <a href="#" id="previewLink" target="_blank" style="display: none;"><button type="button" class="btn btn-warning btn-sm"><i class="fas fa-link text-primary"></i> Preview Link Main Document</button></a>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-6">Supporting Links</label>
                                    <div class="col-md-12">
                                        <a href="#" id="previewSupportLink" target="_blank" style="display: none;"><button type="button" class="btn btn-default btn-sm"><i class="fas fa-link text-primary"></i> Preview Link Supporting Documents</button></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="control-label col-md-6">Alignment Theme</label>
                                    <div class="col-md-12">
                                        <textarea name="alignment_theme" placeholder="Alignment Theme" class="form-control" rows="3" readonly></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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

    $(document).ajaxSend(function(e, xhr, options) {
        let csrfToken = getCsrfToken() || $('meta[name="csrf-token"]').attr('content');
        if (csrfToken) {
            xhr.setRequestHeader('X-CSRF-Token', csrfToken);
        }
    });

    // 1. AJAX View Info Submission
    function viewSubmission(id) {
        $('#form')[0].reset();
        $('#previewLink').hide();
        $('#previewSupportLink').hide();
        $.ajax({
            url: "<?php echo site_url('admin/screenings/ajax_view/') ?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="id"]').val(data.id);
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

                if (data.link && data.link.trim()) {
                    $('#previewLink').attr('href', data.link).show();
                }
                if (data.supporting_links && data.supporting_links.trim()) {
                    $('#previewSupportLink').attr('href', data.supporting_links).show();
                }

                $('#modal_form').modal('show');
                $('.modal-title').text('View Submission Info');
            },
            error: function() {
                Swal.fire('Error', 'Error getting submission detail data via AJAX', 'error');
            }
        });
    }

    $(document).ready(function() {
        // Inisialisasi Server Side DataTables
        if (!$.fn.DataTable.isDataTable('#data_screenings')) {
            table = $('#data_screenings').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?php echo site_url('admin/screenings/ajax_list') ?>",
                    "type": "POST",
                    "data": function(d) {
                        d.csrf_token_jkt3 = getCsrfToken();
                    }
                }
            });
        }

        // Export To Excel Handle
        $('#btn_export_excel').click(function() {
            var category = $('#filter_category').val();
            var status = $('#filter_status').val();
            var url = "<?php echo site_url('admin/screenings/export_excel') ?>?category=" + encodeURIComponent(category) + "&status=" + encodeURIComponent(status);
            window.open(url, '_blank');
        });
    });
</script>