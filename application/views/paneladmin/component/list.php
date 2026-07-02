<section class="content pt-3">
    <div class="container-fluid">

        <div class="row mb-3">
            <div class="col-12">
                <div class="card mb-0 shadow-sm">
                    <div class="card-body p-2 bg-light">
                        <ul class="nav nav-pills font-weight-bold small">
                            <li class="nav-item">
                                <a class="nav-link <?= $current_category == 'GENERAL' ? 'active bg-primary' : 'text-muted'; ?>" href="<?= base_url('admin/component?category=GENERAL'); ?>">
                                    <i class="fas fa-bars mr-1"></i> General Form
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= $current_category == 'IRPC' ? 'active bg-primary' : 'text-muted'; ?>" href="<?= base_url('admin/component?category=IRPC'); ?>">
                                    <i class="fas fa-chart-line mr-1"></i> International Research Pitch (IRPC)
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= $current_category == 'AHIC' ? 'active bg-primary' : 'text-muted'; ?>" href="<?= base_url('admin/component?category=AHIC'); ?>">
                                    <i class="fas fa-lightbulb mr-1"></i> Health Innovation Challenge (AHIC)
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= $current_category == 'E2IPBC' ? 'active bg-primary' : 'text-muted'; ?>" href="<?= base_url('admin/component?category=E2IPBC'); ?>">
                                    <i class="fas fa-file-medical-alt mr-1"></i> Evidence to Impact Policy Brief (E2I-PBC)
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-primary card-outline shadow-sm">
            <div class="card-header">
                <h3 class="card-title font-weight-bold text-sm text-dark">
                    <i class="fas fa-sliders-h mr-2"></i>
                    Manage Components: <span class="text-uppercase text-primary"><?= $current_category; ?></span>
                </h3>
            </div>

            <form id="form_components" method="POST" action="<?= base_url('admin/component/save_batch'); ?>">
                <input type="hidden" name="csrf_token_jkt3" id="csrf_token" value="<?= $this->security->get_csrf_hash(); ?>">
                <input type="hidden" name="category_code" value="<?= $current_category; ?>">

                <div class="card-body">
                    <div class="alert alert-info small shadow-sm">
                        <i class="fas fa-info-circle mr-1"></i>
                        Pastikan **Total Bobot Seluruh Kriteria** untuk kategori **<?= strtoupper($current_category); ?>** berjumlah tepat **100%** sebelum menyimpan perubahan.
                    </div>

                    <div class="row text-sm font-weight-bold border-bottom pb-2 mb-3 d-none d-md-flex text-muted">
                        <div class="col-md-5">Name Component & Score Guidelines (1 - 5)</div>
                        <div class="col-md-4">General Description</div>
                        <div class="col-md-2 text-center">Weight</div>
                        <div class="col-md-1 text-center">Action</div>
                    </div>

                    <div id="component_rows_container">
                        <?php if (!empty($existing_components)): ?>
                            <?php foreach ($existing_components as $comp): ?>
                                <div class="component-block border rounded p-3 mb-3 bg-white shadow-sm">
                                    <div class="row component-row align-items-center">
                                        <input type="hidden" name="components[<?= $comp['id'] ?>][id]" value="<?= $comp['id'] ?>">
                                        <div class="col-md-5 col-12 mb-2 mb-md-0">
                                            <input type="text" name="components[<?= $comp['id'] ?>][component_name]" class="form-control form-control-sm font-weight-bold" placeholder="Contoh: Novelty and Scientific Merit" value="<?= htmlspecialchars($comp['component_name']) ?>" required>
                                        </div>
                                        <div class="col-md-4 col-12 mb-2 mb-md-0">
                                            <input type="text" name="components[<?= $comp['id'] ?>][description]" class="form-control form-control-sm" placeholder="Deskripsi bantuan kriteria..." value="<?= htmlspecialchars($comp['description']) ?>">
                                        </div>
                                        <div class="col-md-2 col-9">
                                            <div class="input-group input-group-sm">
                                                <input type="number" name="components[<?= $comp['id'] ?>][weight]" class="form-control text-right component-weight font-weight-bold" placeholder="0" min="1" max="100" value="<?= $comp['weight'] ?>" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text font-weight-bold">%</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-3 text-center">
                                            <button type="button" class="btn btn-danger btn-sm btn-remove-block shadow-sm" title="Hapus Blok Kriteria">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mt-3 pt-3 border-top bg-light p-3 rounded">
                                        <div class="text-xs text-muted font-weight-bold uppercase mb-2">
                                            <i class="fas fa-info-circle text-info"></i> Live Indicator Guides for Reviewer (Score 1 - 5):
                                        </div>

                                        <div class="d-flex flex-column" style="gap: 8px;">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend" style="width: 100px;">
                                                    <span class="input-group-text bg-danger text-white w-100 justify-content-center font-weight-bold text-xs">Score 1 (Poor)</span>
                                                </div>
                                                <input type="text" name="components[<?= $comp['id'] ?>][score_1_desc]" class="form-control text-xs" placeholder="Describe criteria behavior for score 1..." value="<?= htmlspecialchars($comp['score_1_desc'] ?? '') ?>">
                                            </div>

                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend" style="width: 100px;">
                                                    <span class="input-group-text bg-warning text-dark w-100 justify-content-center font-weight-bold text-xs">Score 2 (Fair)</span>
                                                </div>
                                                <input type="text" name="components[<?= $comp['id'] ?>][score_2_desc]" class="form-control text-xs" placeholder="Describe criteria behavior for score 2..." value="<?= htmlspecialchars($comp['score_2_desc'] ?? '') ?>">
                                            </div>

                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend" style="width: 100px;">
                                                    <span class="input-group-text bg-secondary text-white w-100 justify-content-center font-weight-bold text-xs">Score 3 (Good)</span>
                                                </div>
                                                <input type="text" name="components[<?= $comp['id'] ?>][score_3_desc]" class="form-control text-xs" placeholder="Describe criteria behavior for score 3..." value="<?= htmlspecialchars($comp['score_3_desc'] ?? '') ?>">
                                            </div>

                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend" style="width: 100px;">
                                                    <span class="input-group-text bg-info text-white w-100 justify-content-center font-weight-bold text-xs">Score 4 (V. Good)</span>
                                                </div>
                                                <input type="text" name="components[<?= $comp['id'] ?>][score_4_desc]" class="form-control text-xs" placeholder="Describe criteria behavior for score 4..." value="<?= htmlspecialchars($comp['score_4_desc'] ?? '') ?>">
                                            </div>

                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend" style="width: 100px;">
                                                    <span class="input-group-text bg-success text-white w-100 justify-content-center font-weight-bold text-xs">Score 5 (Excel.)</span>
                                                </div>
                                                <input type="text" name="components[<?= $comp['id'] ?>][score_5_desc]" class="form-control text-xs" placeholder="Describe criteria behavior for score 5..." value="<?= htmlspecialchars($comp['score_5_desc'] ?? '') ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="component-block border rounded p-3 mb-3 bg-white shadow-sm">
                                <div class="row component-row align-items-center">
                                    <input type="hidden" name="components[init_0][id]" value="">
                                    <div class="col-md-5 col-12 mb-2 mb-md-0">
                                        <input type="text" name="components[init_0][component_name]" class="form-control form-control-sm font-weight-bold" placeholder="Contoh: Novelty and Scientific Merit" required>
                                    </div>
                                    <div class="col-md-4 col-12 mb-2 mb-md-0">
                                        <input type="text" name="components[init_0][description]" class="form-control form-control-sm" placeholder="Deskripsi bantuan kriteria...">
                                    </div>
                                    <div class="col-md-2 col-9">
                                        <div class="input-group input-group-sm">
                                            <input type="number" name="components[init_0][weight]" class="form-control text-right component-weight font-weight-bold" placeholder="0" min="1" max="100" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text font-weight-bold">%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-3 text-center">
                                        <button type="button" class="btn btn-danger btn-sm btn-remove-block shadow-sm" title="Hapus Blok Kriteria">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mt-3 pt-3 border-top bg-light p-3 rounded">
                                    <div class="text-xs text-muted font-weight-bold uppercase mb-2">
                                        <i class="fas fa-info-circle text-info"></i> Live Indicator Guides for Reviewer (Score 1 - 5):
                                    </div>

                                    <div class="d-flex flex-column" style="gap: 8px;">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend" style="width: 100px;">
                                                <span class="input-group-text bg-danger text-white w-100 justify-content-center font-weight-bold text-xs">Score 1 (Poor)</span>
                                            </div>
                                            <input type="text" name="components[init_0][score_1_desc]" class="form-control text-xs" placeholder="Describe criteria behavior for score 1...">
                                        </div>

                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend" style="width: 100px;">
                                                <span class="input-group-text bg-warning text-dark w-100 justify-content-center font-weight-bold text-xs">Score 2 (Fair)</span>
                                            </div>
                                            <input type="text" name="components[init_0][score_2_desc]" class="form-control text-xs" placeholder="Describe criteria behavior for score 2...">
                                        </div>

                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend" style="width: 100px;">
                                                <span class="input-group-text bg-secondary text-white w-100 justify-content-center font-weight-bold text-xs">Score 3 (Good)</span>
                                            </div>
                                            <input type="text" name="components[init_0][score_3_desc]" class="form-control text-xs" placeholder="Describe criteria behavior for score 3...">
                                        </div>

                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend" style="width: 100px;">
                                                <span class="input-group-text bg-info text-white w-100 justify-content-center font-weight-bold text-xs">Score 4 (V. Good)</span>
                                            </div>
                                            <input type="text" name="components[init_0][score_4_desc]" class="form-control text-xs" placeholder="Describe criteria behavior for score 4...">
                                        </div>

                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend" style="width: 100px;">
                                                <span class="input-group-text bg-success text-white w-100 justify-content-center font-weight-bold text-xs">Score 5 (Excel.)</span>
                                            </div>
                                            <input type="text" name="components[init_0][score_5_desc]" class="form-control text-xs" placeholder="Describe criteria behavior for score 5...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="row border-top pt-3 mt-4 justify-content-end">
                        <div class="col-md-6 text-right d-flex align-items-center justify-content-end">
                            <span class="text-md font-weight-bold text-muted mr-3">Total Accumulative Weight:</span>
                            <span id="total_weight_badge" class="badge badge-secondary p-2 text-md" style="border-radius: 15px; min-width: 80px;">0%</span>
                        </div>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-between bg-white">
                    <button type="button" id="btn_add_component" class="btn btn-success btn-sm px-3 font-weight-bold shadow-sm">
                        <i class="fas fa-plus mr-1"></i> Add New Row
                    </button>
                    <button type="submit" id="btn_save_components" class="btn btn-info btn-sm px-4 font-weight-bold shadow-sm">
                        <i class="fas fa-save mr-1"></i> Save Changes Components
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {

        function calculateTotalWeight() {
            let total = 0;
            $('.component-weight').each(function() {
                let val = parseInt($(this).val());
                if (!isNaN(val)) total += val;
            });

            $('#total_weight_badge').text(total + '%');

            if (total === 100) {
                $('#total_weight_badge').removeClass('badge-secondary badge-danger').addClass('badge-success');
                $('#btn_save_components').prop('disabled', false);
            } else {
                $('#total_weight_badge').removeClass('badge-success badge-secondary').addClass('badge-danger');
            }
        }

        calculateTotalWeight();

        $(document).on('input change', '.component-weight', function() {
            calculateTotalWeight();
        });

        // Tambah baris baru beserta 5 field panduan skor sekaligus
        // Tambah baris baru beserta 5 field panduan skor susun ke bawah vertikal
        $('#btn_add_component').click(function() {
            let uniqueId = Date.now();

            let newRow = `
            <div class="component-block border rounded p-3 mb-3 bg-white shadow-sm" style="display:none;">
                <div class="row component-row align-items-center">
                    <input type="hidden" name="components[${uniqueId}][id]" value="">
                    <div class="col-md-5 col-12 mb-2 mb-md-0">
                        <input type="text" name="components[${uniqueId}][component_name]" class="form-control form-control-sm font-weight-bold" placeholder="Contoh: Methodological Rigor" required>
                    </div>
                    <div class="col-md-4 col-12 mb-2 mb-md-0">
                        <input type="text" name="components[${uniqueId}][description]" class="form-control form-control-sm" placeholder="Deskripsi bantuan kriteria...">
                    </div>
                    <div class="col-md-2 col-9">
                        <div class="input-group input-group-sm">
                            <input type="number" name="components[${uniqueId}][weight]" class="form-control text-right component-weight font-weight-bold" placeholder="0" min="1" max="100" required>
                            <div class="input-group-append">
                                <span class="input-group-text font-weight-bold">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1 col-3 text-center">
                        <button type="button" class="btn btn-danger btn-sm btn-remove-block shadow-sm" title="Hapus Blok Kriteria">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                
                <div class="mt-3 pt-3 border-top bg-light p-3 rounded">
                    <div class="text-xs text-muted font-weight-bold uppercase mb-2">
                        <i class="fas fa-info-circle text-info"></i> Live Indicator Guides for Reviewer (Score 1 - 5):
                    </div>
                    
                    <div class="d-flex flex-column" style="gap: 8px;">
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend" style="width: 100px;">
                                <span class="input-group-text bg-danger text-white w-100 justify-content-center font-weight-bold text-xs">Score 1 (Poor)</span>
                            </div>
                            <input type="text" name="components[${uniqueId}][score_1_desc]" class="form-control text-xs" placeholder="Describe criteria behavior for score 1...">
                        </div>
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend" style="width: 100px;">
                                <span class="input-group-text bg-warning text-dark w-100 justify-content-center font-weight-bold text-xs">Score 2 (Fair)</span>
                            </div>
                            <input type="text" name="components[${uniqueId}][score_2_desc]" class="form-control text-xs" placeholder="Describe criteria behavior for score 2...">
                        </div>
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend" style="width: 100px;">
                                <span class="input-group-text bg-secondary text-white w-100 justify-content-center font-weight-bold text-xs">Score 3 (Good)</span>
                            </div>
                            <input type="text" name="components[${uniqueId}][score_3_desc]" class="form-control text-xs" placeholder="Describe criteria behavior for score 3...">
                        </div>
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend" style="width: 100px;">
                                <span class="input-group-text bg-info text-white w-100 justify-content-center font-weight-bold text-xs">Score 4 (V. Good)</span>
                            </div>
                            <input type="text" name="components[${uniqueId}][score_4_desc]" class="form-control text-xs" placeholder="Describe criteria behavior for score 4...">
                        </div>
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend" style="width: 100px;">
                                <span class="input-group-text bg-success text-white w-100 justify-content-center font-weight-bold text-xs">Score 5 (Excel.)</span>
                            </div>
                            <input type="text" name="components[${uniqueId}][score_5_desc]" class="form-control text-xs" placeholder="Describe criteria behavior for score 5...">
                        </div>
                    </div>
                </div>
            </div>`;

            $('#component_rows_container').append(newRow);
            $('.component-block').last().fadeIn(200);
            calculateTotalWeight();
        });

        $(document).on('click', '.btn-remove-block', function() {
            let totalBlocks = $('#component_rows_container .component-block').length;
            let blockElement = $(this).closest('.component-block');

            if (totalBlocks > 1) {
                blockElement.fadeOut(200, function() {
                    $(this).remove();
                    calculateTotalWeight();
                });
            } else {
                Swal.fire('Perhatian', 'Minimal harus menyisakan 1 baris kriteria komponen.', 'warning');
            }
        });

        // Ajax Submit handler (Inject Header + Cookie Sync murni yang sudah kita buat)
        $('#form_components').submit(function(e) {
            e.preventDefault();

            let total = 0;
            $('.component-weight').each(function() {
                let val = parseInt($(this).val());
                if (!isNaN(val)) total += val;
            });

            if (total !== 100) {
                Swal.fire({
                    icon: 'error',
                    title: 'Bobot Belum Pas 100%',
                    text: 'Akumulasi total bobot saat ini bernilai ' + total + '%. Wajib berjumlah tepat 100%!',
                    confirmButtonColor: '#3085d6'
                });
                return false;
            }

            $('#btn_save_components').prop('disabled', true).text('Menyimpan...');

            let cookieToken = document.cookie.split('; ').find(row => row.startsWith('csrf_cookie_jkt3='))?.split('=')[1] || '';
            if (cookieToken !== '') {
                $('#csrf_token').val(decodeURIComponent(cookieToken));
            }

            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                headers: {
                    'X-CSRF-Token': $('#csrf_token').val()
                },
                data: $('#form_components').serialize(),
                dataType: "JSON",
                success: function(res) {
                    if (res.status === 'Error') {
                        Swal.fire('CSRF Security Error', res.message, 'error');
                        if (res.csrf_token) $('#csrf_token').val(res.csrf_token);
                        $('#btn_save_components').prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Save Changes Components');
                        return false;
                    }

                    if (res.status) {
                        Swal.fire('Berhasil!', 'Komponen kriteria penilaian berhasil diperbarui.', 'success').then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire('Gagal!', res.message || 'Terjadi kesalahan sistem.', 'error');
                        $('#btn_save_components').prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Save Changes Components');
                    }
                }
            });
        });
    });
</script>