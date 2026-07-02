<section class="content">
    <div class="container-fluid">
        <div class="row align-items-stretch" style="min-height: 80vh;">
            <div class="col-md-6 d-flex flex-column mb-3 mb-md-0" style="gap: 1rem;">
                <div class="card card-info w-100 h-20 shadow-sm mb-0 flex-fill d-flex flex-column">
                    <div class="card-header">
                        <h3 class="card-title text-sm"><i class="fas fa-file-alt mr-1"></i> Data Submission</h3>
                    </div>
                    <div class="card-body d-flex justify-content-between align-items-center p-3 flex-fill">
                        <div style="flex: 1; padding-right: 15px;">
                            <span class="text-xs text-muted d-block font-weight-bold text-uppercase mb-1" style="letter-spacing: 0.5px;">Lead Author / Team</span>
                            <h5 class="text-md font-weight-bold text-dark mb-1"><?= htmlspecialchars($submission->title); ?></h5>
                            <p class="mb-0 text-xs text-muted font-weight-bold">
                                <i class="fas fa-university mr-1"></i> <span style="filter: blur(4px); pointer-events: none;"><?= htmlspecialchars($submission->team_leader); ?> | <?= htmlspecialchars($submission->institution); ?></span>
                            </p>
                        </div>
                        <div class="text-right" style="min-width: 120px;">
                            <span class="text-xs text-muted d-block mb-1"><i class="fab fa-google-drive text-primary mr-1"></i> Support File:</span>
                            <?php if (!empty($submission->supporting_links)): ?>
                                <a href="<?= $submission->supporting_links ?>" target="_blank" class="btn btn-dark btn-sm px-3 font-weight-bold shadow-sm" style="border-radius: 6px;">
                                    <i class="fa fa-link" aria-hidden="true"></i> Open Folder
                                </a>
                            <?php else: ?>
                                <span class="badge badge-secondary">No Link</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="card card-info w-100 h-100 shadow-sm mb-0 flex-fill d-flex flex-column">
                    <div class="card-header">
                        <h3 class="card-title text-sm"><i class="fas fa-folder-open mr-1"></i> Main Link</h3>
                    </div>
                    <div class="card-body p-3 flex-fill d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div style="flex: 1; padding-right: 15px;">
                                <span class="text-xs text-muted d-block font-weight-bold text-uppercase mb-1" style="letter-spacing: 0.5px;">Main Documents</span>
                                <p class="text-xs text-muted mb-0">
                                    <i class="fas fa-info-circle mr-1"></i> Open the participant folder to review additional manuscripts, sheets, or pitch videos.
                                </p>
                            </div>

                            <div class="text-right" style="min-width: 140px;">
                                <span class="text-xs text-muted d-block mb-1"><i class="fab fa-google-drive text-primary mr-1"></i> Directory Folder:</span>
                                <?php if (!empty($submission->link)): ?>
                                    <a href="<?= $submission->link ?>" target="_blank" class="btn btn-primary btn-sm px-3 font-weight-bold shadow-sm" style="border-radius: 6px; background-color: #e8f0fe; color: #1a73e8; border: none;">
                                        <i class="fas fa-folder-open mr-1"></i> Open File
                                    </a>
                                <?php else: ?>
                                    <span class="badge badge-secondary">No Link</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php
                        // Mengubah /view menjadi /preview secara otomatis
                        $embed_link = str_replace('/view?usp=sharing', '/preview', $submission->link);
                        $embed_link = str_replace('/view', '/preview', $embed_link); // Berjaga-jaga jika tanpa query string
                        ?>

                        <iframe src="<?= $embed_link ?>" width="100%" height="300px"></iframe>

                    </div>
                </div>
            </div>

            <div class="col-md-6 d-flex flex-column">
                <div class="card card-primary shadow-sm mb-0 d-flex flex-column flex-fill" style="height: 100%;">

                    <div class="card-header" style="flex-shrink: 0;">
                        <h3 class="card-title font-weight-bold text-sm">
                            <i class="fas fa-calculator mr-2"></i> Evaluation Form Select a score (1-5) to view its specific descriptor.
                        </h3>
                    </div>

                    <form action="<?= base_url('admin/category/ahic/store'); ?>" method="POST" class="d-flex flex-column flex-fill mb-0" style="height: calc(100% - 40px); overflow: hidden;">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="submission_id" value="<?= $submission->id; ?>">

                        <div class="card-body" style="overflow-y: auto; flex: 1; max-height: 65vh; padding-right: 10px;">

                            <?php if (empty($components)): ?>
                                <div class="alert alert-warning mb-0">There are no active assessment components for this category in the master database.</div>
                            <?php endif; ?>

                            <?php foreach ($components as $item): ?>
                                <?php $saved_val = isset($saved_scores[$item['id']]) ? $saved_scores[$item['id']] : ''; ?>

                                <div class="form-group row border-bottom pb-4 pt-3 mb-0 align-items-start">
                                    <div class="col-md-7 col-12">
                                        <label class="mb-1 text-md text-dark font-weight-bold"><?= htmlspecialchars($item['component_name']); ?></label>
                                        <p class="text-muted text-xs mb-2" style="line-height: 1.4;"><?= htmlspecialchars($item['description']); ?></p>
                                    </div>
                                    <div class="col-md-5 col-12 mt-3 mt-md-0">
                                        <!-- Adjusted container with bottom margin for perfect spacing -->
                                        <div class="d-flex justify-content-end mb-2">
                                            <!-- Removed duplicate mixed paddings for crisp text centering -->
                                            <span class="badge badge-secondary px-2 text-xs" style="border-radius: 4px; padding-top: 4px; padding-bottom: 4px;">
                                                Weight: <?= $item['weight']; ?>%
                                            </span>
                                        </div>

                                        <!-- 5-Button Flex Group -->
                                        <div class="d-flex justify-content-between score-radio-group" style="gap: 8px;">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <?php $descriptor_text = isset($item['score_' . $i . '_desc']) ? $item['score_' . $i . '_desc'] : ''; ?>
                                                <label class="score-btn flex-fill text-center p-2 mb-0 <?= $saved_val == $i ? 'active' : ''; ?>"
                                                    style="border: 1px solid #ced4da; border-radius: 8px; cursor: pointer; transition: all 0.2s ease; background-color: <?= $saved_val == $i ? '#e8f0fe' : '#ffffff'; ?>; color: <?= $saved_val == $i ? '#1a73e8' : '#495057'; ?>; font-weight: bold; border-color: <?= $saved_val == $i ? '#1a73e8' : '#ced4da'; ?>; min-width: 0;"
                                                    data-descriptor="<?= htmlspecialchars($descriptor_text); ?>">

                                                    <input type="radio"
                                                        name="scores[<?= $item['id']; ?>]"
                                                        value="<?= $i; ?>"
                                                        class="score-selector d-none"
                                                        data-weight="<?= $item['weight']; ?>"
                                                        <?= $saved_val == $i ? 'checked' : ''; ?>
                                                        required>
                                                    <?= $i; ?>
                                                </label>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="mt-2 text-xs text-info font-italic descriptor-preview-box" id="desc_preview_<?= $item['id']; ?>" style="display: none; background-color: #f8f9fa; padding: 8px; border-left: 3px solid #17a2b8; border-radius: 4px;">
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <!-- Reviewer's Comments Section -->
                            <div class="card card-outline card-secondary mt-4 shadow-sm">
                                <div class="card-header bg-light">
                                    <h3 class="card-title text-sm font-weight-bold text-secondary">
                                        <i class="fas fa-comments mr-1"></i> Reviewer's Comments Section
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold text-xs text-dark uppercase">Key Strengths of the Submission *</label>
                                        <textarea name="key_strengths" placeholder="Write key strengths..." class="form-control text-sm" rows="2" required><?= isset($submission->key_strengths) ? htmlspecialchars($submission->key_strengths) : '' ?></textarea>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold text-xs text-dark uppercase">Key Weaknesses of the Submission *</label>
                                        <textarea name="key_weaknesses" placeholder="Write key weaknesses..." class="form-control text-sm" rows="2" required><?= isset($submission->key_weaknesses) ? htmlspecialchars($submission->key_weaknesses) : '' ?></textarea>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold text-xs text-dark uppercase">Recommendations for Improvement *</label>
                                        <textarea name="recommendations" placeholder="Write recommendations..." class="form-control text-sm" rows="2" required><?= isset($submission->recommendations) ? htmlspecialchars($submission->recommendations) : '' ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Evaluation Recommendation Status Options -->
                            <div class="card card-outline card-secondary mt-3 shadow-sm">
                                <div class="card-header bg-light">
                                    <h3 class="card-title text-sm font-weight-bold text-secondary">
                                        <i class="fas fa-gavel mr-1"></i> Evaluation Recommendation
                                    </h3>
                                </div>
                                <div class="card-body p-3">
                                    <?php $saved_status = isset($submission->recommendation_status) ? $submission->recommendation_status : ''; ?>
                                    <div class="d-flex flex-column flex-md-row justify-content-start" style="gap: 20px;">

                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="status_final" name="recommendation_status" value="Qualified for the Final Round" <?= $saved_status == 'Qualified for the Final Round' ? 'checked' : '' ?> required>
                                            <label for="status_final" class="custom-control-label font-weight-bold text-sm text-success" style="cursor:pointer;">
                                                Qualified for the Final Round
                                            </label>
                                        </div>

                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="status_minor" name="recommendation_status" value="Qualified with Minor Revisions" <?= $saved_status == 'Qualified with Minor Revisions' ? 'checked' : '' ?>>
                                            <label for="status_minor" class="custom-control-label font-weight-bold text-sm text-warning" style="cursor:pointer;">
                                                Qualified with Minor Revisions
                                            </label>
                                        </div>

                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="status_not" name="recommendation_status" value="Not Qualified" <?= $saved_status == 'Not Qualified' ? 'checked' : '' ?>>
                                            <label for="status_not" class="custom-control-label font-weight-bold text-sm text-danger" style="cursor:pointer;">
                                                Not Qualified
                                            </label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-white d-flex justify-content-end align-items-center" style="flex-shrink: 0; gap: 15px; border-top: 1px solid #efefef;">
                            <div class="text-md">
                                <span class="font-weight-bold text-muted mr-2">Total Score Preview:</span>
                                <span id="live_total_score" class="badge badge-secondary p-2 text-md" style="min-width: 70px; border-radius: 15px;">0.00</span>
                            </div>
                            <button type="submit" class="btn btn-success btn-sm px-4 font-weight-bold shadow-sm">
                                <i class="fas fa-save mr-1"></i> Save Final Score
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {

        function calculateLiveScore() {
            let totalWeightedScore = 0;

            $('.score-selector:checked').each(function() {
                let score = parseInt($(this).val());
                let weight = parseInt($(this).data('weight'));
                // Proses Hitung Nilai
                if (!isNaN(score) && !isNaN(weight)) {
                    let componentValue = (score / 5) * weight;
                    totalWeightedScore += componentValue;
                }
            });

            $('#live_total_score').text(totalWeightedScore.toFixed(2));

            if (totalWeightedScore >= 70) {
                $('#live_total_score').removeClass('badge-secondary badge-warning badge-danger').addClass('badge-success');
            } else if (totalWeightedScore > 0 && totalWeightedScore < 70) {
                $('#live_total_score').removeClass('badge-secondary badge-success badge-danger').addClass('badge-warning');
            } else {
                $('#live_total_score').removeClass('badge-success badge-warning badge-danger').addClass('badge-secondary');
            }
        }

        // Tampilkan teks deskripsi panduan kriteria di awal jika data lama sudah tersimpan
        $('.score-selector:checked').each(function() {
            let labelElement = $(this).closest('.score-btn');
            let descText = labelElement.data('descriptor');
            let previewBox = labelElement.closest('.form-group').find('.descriptor-preview-box');

            if (descText && descText.trim() !== '') {
                previewBox.html('<strong>Indicator Guide:</strong> "' + descText + '"').show();
            }
        });

        calculateLiveScore();

        // Handler interaksi UI klik tombol kotak nilai 1-5
        $(document).on('change', '.score-selector', function() {
            let group = $(this).closest('.score-radio-group');
            let labelElement = $(this).closest('.score-btn');

            // Tampilkan deskripsi kualitatif bantuan penilaian di sisi kiri kriteria
            let descText = labelElement.data('descriptor');
            let previewBox = $(this).closest('.form-group').find('.descriptor-preview-box');

            if (descText && descText.trim() !== '') {
                previewBox.html('<strong>Indicator Guide:</strong> "' + descText + '"').fadeIn(150);
            } else {
                previewBox.hide().empty();
            }

            // Toggle visualisasi warna aktif tombol biru
            group.find('.score-btn').css({
                'background-color': '#ffffff',
                'color': '#495057',
                'border-color': '#ced4da'
            });

            if ($(this).is(':checked')) {
                labelElement.css({
                    'background-color': '#e8f0fe',
                    'color': '#1a73e8',
                    'border-color': '#1a73e8'
                });
            }
            calculateLiveScore();
        });
    });
</script>