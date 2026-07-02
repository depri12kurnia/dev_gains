<section class="content pt-3">
    <div class="container-fluid">

        <div class="card card-default shadow-sm">
            <div class="card-header bg-light">
                <h3 class="card-title text-sm font-weight-bold text-muted"><i class="fas fa-filter mr-1"></i> Filter Report</h3>
            </div>
            <div class="card-body p-3">
                <form method="GET" action="<?= base_url('admin/report/combined_scores'); ?>" class="row align-items-end">
                    <div class="col-md-4 col-12">
                        <label class="font-weight-bold text-xs text-dark text-uppercase">Competition Competency Categories</label>
                        <select name="category" class="form-control form-control-sm font-weight-bold">
                            <option value="">-- Show All Categories --</option>
                            <option value="IRPC" <?= $current_category == 'IRPC' ? 'selected' : ''; ?>>International Research Pitch (IRPC)</option>
                            <option value="AHIC" <?= $current_category == 'AHIC' ? 'selected' : ''; ?>>Health Innovation Challenge (AHIC)</option>
                            <option value="E2IPBC" <?= $current_category == 'E2IPBC' ? 'selected' : ''; ?>>Evidence to Impact Policy Brief (E2I-PBC)</option>
                        </select>
                    </div>
                    <div class="col-md-2 col-12 mt-2 mt-md-0">
                        <button type="submit" class="btn btn-primary btn-sm btn-block font-weight-bold shadow-sm">
                            <i class="fas fa-search mr-1"></i> Apply Filters
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card card-primary card-outline shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title font-weight-bold text-sm text-dark mb-0">
                    <i class="fas fa-trophy mr-2 text-warning"></i>
                    Recapitulation of the Judges' Combined Average Score
                </h3>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="data_result" class="table table-striped table-hover mb-0 align-middle text-sm">
                        <thead class="bg-light text-muted font-weight-bold">
                            <tr>
                                <th class="text-center">Rank</th>
                                <th>Work / Group Details</th>
                                <th class="text-center">Category</th>
                                <th class="text-center">Appraiser Progress</th>
                                <th class="text-right">Final Average Value</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($report_data)): ?>
                                <?php $rank = 1;
                                foreach ($report_data as $row): ?>
                                    <tr>
                                        <td class="text-center font-weight-bold">
                                            <?php if ($rank == 1 && !empty($current_category)): ?>
                                                <span class="badge badge-warning p-2 shadow-sm" style="border-radius: 50%; width: 26px; height: 26px;" title="Juara 1"><i class="fas fa-medal text-white"></i></span>
                                            <?php elseif ($rank == 2 && !empty($current_category)): ?>
                                                <span class="badge badge-secondary p-2 shadow-sm" style="border-radius: 50%; width: 26px; height: 26px;" title="Juara 2"><i class="fas fa-medal text-white"></i></span>
                                            <?php elseif ($rank == 3 && !empty($current_category)): ?>
                                                <span class="badge badge-danger p-2 shadow-sm" style="border-radius: 50%; width: 26px; height: 26px;" title="Juara 3"><i class="fas fa-medal text-white"></i></span>
                                            <?php else: ?>
                                                <span class="text-muted text-xs"><?= $rank; ?></span>
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <h6 class="font-weight-bold mb-0 text-dark"><?= htmlspecialchars($row['title']); ?></h6>
                                            <span class="text-muted text-xxs">
                                                <i class="fas fa-user-circle mr-1" style="filter: blur(4px); pointer-events: none;"> <?= htmlspecialchars($row['team_leader']); ?> </i>|
                                                <i class="fas fa-university mr-1" style="filter: blur(4px); pointer-events: none;"> <?= htmlspecialchars($row['institution']); ?> </i>
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            <span class="badge badge-info font-weight-bold text-xxs px-2 py-1"><?= strtoupper($row['category']); ?></span>
                                        </td>

                                        <td class="text-center">
                                            <span class="badge <?= $row['total_juri_menilai'] >= 3 ? 'badge-success' : 'badge-warning'; ?> px-2 py-1 text-xxs font-weight-bold" style="border-radius: 8px;">
                                                <i class="fas fa-user-edit mr-1"></i> <?= $row['total_juri_menilai']; ?> Jury Voted
                                            </span>
                                        </td>

                                        <td class="text-right font-weight-bold text-md text-primary" style="padding-right: 20px;">
                                            <?= $row['nilai_rata_rata'] !== null ? number_format($row['nilai_rata_rata'], 2) : '0.00'; ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" style="gap: 4px;">
                                                <a href="<?= base_url('admin/report/detail_scores/' . $row['submission_id']); ?>" title="View Detail" class="btn btn-xs btn-info shadow-sm font-weight-bold p-2" title="View Detail Scores per Juri">
                                                    <i class="fas fa-info-circle"></i>
                                                </a>

                                                <?php if ($row['global_status'] == 'finalist' || $row['global_status'] == 'not_selected'): ?>
                                                    <button type="button" title="Reset Status" class="btn btn-xs btn-secondary btn-change-decision shadow-sm font-weight-bold p-2" data-id="<?= $row['submission_id']; ?>" data-action="submitted" data-title="<?= htmlspecialchars($row['title'], ENT_QUOTES); ?>">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </button>
                                                <?php else: ?>
                                                    <button type="button" title="Qualified Final Round" class="btn btn-xs btn-success btn-change-decision shadow-sm font-weight-bold p-2" data-id="<?= $row['submission_id']; ?>" data-action="finalist" data-title="<?= htmlspecialchars($row['title'], ENT_QUOTES); ?>">
                                                        <i class="fas fa-trophy"></i>
                                                    </button>
                                                    <button type="button" title="Not Qualified" class="btn btn-xs btn-danger btn-change-decision shadow-sm font-weight-bold p-2" data-id="<?= $row['submission_id']; ?>" data-action="not_selected" data-title="<?= htmlspecialchars($row['title'], ENT_QUOTES); ?>">
                                                        <i class="fas fa-ban"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php $rank++;
                                endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center p-4 text-muted font-italic">There is no combined value recapitulation data that meets the qualifications.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(function() {
        $('#data_result').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
    $(document).ready(function() {

        $(document).on('click', '.btn-change-decision', function() {
            const submissionId = $(this).data('id');
            const actionType = $(this).data('action'); // 'finalist', 'not_selected' atau reset 'submitted'
            const workTitle = $(this).data('title');

            let confirmTitle = 'Approve as Finalist?';
            let confirmText = 'Submission "' + workTitle + '" will be registered as a Main Finalist for GAINS 2026.';
            let confirmBtnColor = '#28a745';

            if (actionType === 'not_selected') {
                confirmTitle = 'Not Qualified?';
                confirmText = 'Submission "' + workTitle + '" will be registered as Not Qualified.';
                confirmBtnColor = '#dc3545';
            }
            if (actionType === 'submitted') {
                confirmTitle = 'Cancel Status / Reset?';
                confirmText = 'Submission "' + workTitle + '" will be reset back to review queue (Submitted).';
                confirmBtnColor = '#ffc107';
            }

            Swal.fire({
                title: confirmTitle,
                text: confirmText,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: confirmBtnColor,
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Execution!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // cookie hash token CSRF terbaru agar bypass anti-csrf sukses
                    let cookieToken = document.cookie.split('; ').find(row => row.startsWith('csrf_cookie_jkt3='))?.split('=')[1] || '';
                    let currentToken = cookieToken ? decodeURIComponent(cookieToken) : '<?= $this->security->get_csrf_hash(); ?>';

                    $.ajax({
                        url: '<?= base_url('admin/report/set_status_finalist'); ?>',
                        type: 'POST',
                        headers: {
                            'X-CSRF-Token': currentToken
                        },
                        data: {
                            submission_id: submissionId,
                            decision_type: actionType,
                            csrf_token_jkt3: currentToken
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire('Success!', response.message, 'success').then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Gagal!', response.message, 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error!', 'Terjadi kegagalan komunikasi token dengan server.', 'error');
                        }
                    });
                }
            });
        });

    });
</Script>