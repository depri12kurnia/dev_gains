<section class="content pt-3">
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="<?= base_url('admin/report/combined_scores'); ?>" class="btn btn-default btn-sm font-weight-bold shadow-sm">
                <i class="fas fa-arrow-left mr-1"></i> Back To Report
            </a>
            <span class="text-muted text-xs font-weight-bold uppercase">GAINS 2026 Audit System</span>
        </div>

        <div class="card card-widget widget-user-2 shadow-sm">
            <div class="widget-user-header bg-light border-bottom p-3">
                <div class="d-flex align-items-center flex-wrap gap-3">
                    <div class="bg-primary p-3 rounded-lg text-white shadow-sm mr-3">
                        <i class="fas fa-file-invoice fs-4" style="font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <span class="badge badge-info text-xxs font-weight-bold text-uppercase mb-1"><?= strtoupper($submission->category); ?> Category</span>
                        <h4 class="widget-user-username font-weight-bold text-md text-dark mb-1"><?= htmlspecialchars($submission->title); ?></h4>
                        <h6 class="widget-user-desc text-muted text-xs mb-0">
                            <i class="fas fa-user-tie mr-1" style="filter: blur(4px); pointer-events: none;"> Team Leader: <strong><?= htmlspecialchars($submission->team_leader); ?></strong></i>
                            <i class="fas fa-university mr-1" style="filter: blur(4px); pointer-events: none;"> Institution: <strong><?= htmlspecialchars($submission->institution); ?></strong></i>
                        </h6>
                    </div>
                </div>
            </div>
        </div>

        <?php if (empty($evaluations)): ?>
            <div class="alert alert-warning shadow-sm small p-4">
                <h5><i class="icon fas fa-exclamation-triangle"></i> No Ratings Yet!</h5>
                This proposal has passed the committee's administrative screening stage, but no reviewers have yet submitted their digital assessment sheets.
            </div>
        <?php endif; ?>

        <?php $no = 1;
        foreach ($evaluations as $eval): ?>
            <div class="card card-outline card-primary shadow-sm mb-4">

                <div class="card-header bg-light d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h3 class="card-title font-weight-bold text-sm text-dark mb-0">
                        <span class="badge badge-primary rounded-circle mr-2" style="width:24px; height:24px; line-height:16px; font-size:0.8rem;"><?= $no; ?></span>
                        Juri Panelist: <span class="text-primary"><?= htmlspecialchars($eval['first_name'] . ' ' . $eval['last_name']); ?></span>
                        <span class="text-muted text-xs font-weight-normal ml-1">(<?= htmlspecialchars($eval['email']); ?>)</span>
                    </h3>

                    <div class="card-tools d-flex align-items-center style" style="gap: 15px;">
                        <span class="text-xs font-weight-bold text-muted uppercase">Jury Decision Recommendation:</span>
                        <?php if ($eval['recommendation_status'] == 'Qualified for the Final Round'): ?>
                            <span class="badge badge-success px-3 py-1 font-weight-bold shadow-sm" style="font-size:0.75rem;"><i class="fas fa-trophy mr-1"></i> Final Round</span>
                        <?php elseif ($eval['recommendation_status'] == 'Qualified with Minor Revisions'): ?>
                            <span class="badge badge-warning text-dark px-3 py-1 font-weight-bold shadow-sm" style="font-size:0.75rem;"><i class="fas fa-tools mr-1"></i> Revision Required</span>
                        <?php else: ?>
                            <span class="badge badge-danger px-3 py-1 font-weight-bold shadow-sm" style="font-size:0.75rem;"><i class="fas fa-times-circle mr-1"></i> Not Qualified</span>
                        <?php endif; ?>

                        <div class="bg-dark text-white font-weight-bold px-3 py-2 rounded shadow-sm text-center" style="min-width: 110px;">
                            <span class="d-block text-xxs text-gray uppercase" style="font-size:0.65rem; opacity:0.7; letter-spacing:0.5px;">Weighted Score</span>
                            <span class="text-md font-weight-bold text-warning"><?= number_format($eval['total_score'], 2); ?></span>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="row m-0 align-items-stretch border-bottom">

                        <div class="col-md-7 col-12 p-3 border-right bg-white">
                            <span class="text-xs font-weight-bold text-muted uppercase d-block mb-3 border-bottom pb-1"><i class="fas fa-th-list mr-1"></i> Assessment Component Matrix Score Details:</span>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm text-xs mb-0 align-middle">
                                    <thead class="bg-light text-muted font-weight-bold text-center">
                                        <tr>
                                            <th>Criterion Component Name</th>
                                            <th style="width: 80px;">Weight (%)</th>
                                            <th style="width: 80px;">Score (1-5)</th>
                                            <th style="width: 100px;">Weighted Score</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($eval['score_details'])): ?>
                                            <?php foreach ($eval['score_details'] as $detail):
                                                // Hitung ulang bobot per kriteria secara live murni: (Skor / 5) * Bobot_Kriteria
                                                $calculated_weighted = ($detail['score'] / 5) * $detail['weight'];
                                            ?>
                                                <tr>
                                                    <td>
                                                        <strong class="text-dark d-block"><?= htmlspecialchars($detail['component_name']); ?></strong>
                                                    </td>
                                                    <td class="text-center font-weight-bold text-muted"><?= $detail['weight']; ?>%</td>
                                                    <td class="text-center font-weight-bold text-md text-info"><?= $detail['score']; ?></td>
                                                    <td class="text-right font-weight-bold pr-2 bg-light text-dark"><?= number_format($calculated_weighted, 2); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="4" class="text-center font-italic p-3 text-muted">Details of the assessment component score figures were not found.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-5 col-12 p-3 bg-light d-flex flex-column" style="gap: 12px;">
                            <span class="text-xs font-weight-bold text-muted uppercase d-block border-bottom pb-1 mb-1"><i class="fas fa-comments mr-1"></i> Jury Qualitative Review Text:</span>

                            <div>
                                <span class="d-block font-weight-bold text-success uppercase text-xxs mb-1" style="letter-spacing:0.5px;"><i class="fas fa-plus-circle"></i> Key Strengths:</span>
                                <div class="bg-white p-2 border rounded text-xs text-dark shadow-xs" style="min-height: 55px; max-height: 120px; overflow-y:auto; line-height:1.4;">
                                    <?= !empty($eval['key_strengths']) ? nl2br(htmlspecialchars($eval['key_strengths'])) : '<span class="text-muted font-italic text-xxs">Tidak ada catatan strengths.</span>'; ?>
                                </div>
                            </div>

                            <div>
                                <span class="d-block font-weight-bold text-danger uppercase text-xxs mb-1" style="letter-spacing:0.5px;"><i class="fas fa-minus-circle"></i> Key Weaknesses:</span>
                                <div class="bg-white p-2 border rounded text-xs text-dark shadow-xs" style="min-height: 55px; max-height: 120px; overflow-y:auto; line-height:1.4;">
                                    <?= !empty($eval['key_weaknesses']) ? nl2br(htmlspecialchars($eval['key_weaknesses'])) : '<span class="text-muted font-italic text-xxs">Tidak ada catatan weaknesses.</span>'; ?>
                                </div>
                            </div>

                            <div>
                                <span class="d-block font-weight-bold text-primary uppercase text-xxs mb-1" style="letter-spacing:0.5px;"><i class="fas fa-lightbulb"></i> Recommendations:</span>
                                <div class="bg-white p-2 border rounded text-xs text-dark shadow-xs" style="min-height: 55px; max-height: 120px; overflow-y:auto; line-height:1.4;">
                                    <?= !empty($eval['recommendations']) ? nl2br(htmlspecialchars($eval['recommendations'])) : '<span class="text-muted font-italic text-xxs">Tidak ada catatan rekomendasi perbaikan.</span>'; ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        <?php $no++;
        endforeach; ?>
    </div>
</section>