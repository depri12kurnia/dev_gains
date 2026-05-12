<section class="content">
    <div class="container-fluid">
        <!-- PAYMENT STATISTICS -->
        <div class="row mb-4">
            <div class="col-md-12">
                <h3 class="mb-3"><i class="fas fa-credit-card mr-2"></i> Payment Statistics</h3>
                <button class="btn btn-primary btn-sm float-right" onclick="printDashboard()"><i class="fas fa-print"></i> Print Dashboard</button>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3><?= $payment_total; ?></h3>
                        <p>Total Payments</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-document"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?= $payment_pending; ?></h3>
                        <p>Pending</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-clock"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?= $payment_approved; ?></h3>
                        <p>Approved</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-checkmark-circled"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?= $payment_rejected; ?></h3>
                        <p>Rejected</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-close-circled"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- SUBMISSION STATISTICS -->
        <div class="row mb-4">
            <div class="col-md-12">
                <h3 class="mb-3"><i class="fas fa-file-upload mr-2"></i> Submission Statistics</h3>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?= $submission_total; ?></h3>
                        <p>Total Submissions</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-document"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3><?= $submission_submitted; ?></h3>
                        <p>Submitted</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-arrow-up-a"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?= $submission_finalist; ?></h3>
                        <p>Finalist</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-star"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3><?= $submission_not_selected; ?></h3>
                        <p>Not Selected</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-close"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- CHARTS ROW -->
        <div class="row">
            <!-- Payment Status Chart -->
            <div class="col-md-6">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Payment Status Distribution</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="paymentStatusChart" style="height: 300px;"></canvas>
                    </div>
                </div>
            </div>

            <!-- Submission Status Chart -->
            <div class="col-md-6">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Submission Status Distribution</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="submissionStatusChart" style="height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- CHARTS ROW 2 -->
        <div class="row mt-4">
            <!-- Category Chart -->
            <div class="col-md-6">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Submissions by Category</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="categoryChart" style="height: 300px;"></canvas>
                    </div>
                </div>
            </div>

            <!-- Top Countries Chart -->
            <div class="col-md-6">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Top 10 Countries</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="countryChart" style="height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- TRENDS ROW -->
        <div class="row mt-4">
            <!-- Payment Trend -->
            <div class="col-md-6">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Payment Trend (Last 6 Months)</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="paymentTrendChart" style="height: 300px;"></canvas>
                    </div>
                </div>
            </div>

            <!-- Submission Trend -->
            <div class="col-md-6">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Submission Trend (Last 6 Months)</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="submissionTrendChart" style="height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- RECENT DATA ROW -->
        <div class="row mt-4">
            <!-- Recent Payments -->
            <div class="col-md-6">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Recent Payments</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-striped table-valign-middle">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Bank</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($recent_payments): ?>
                                    <?php foreach ($recent_payments as $p): ?>
                                        <tr>
                                            <td><?= $p->user_id; ?></td>
                                            <td><?= $p->bank_name; ?></td>
                                            <td>
                                                <?php
                                                $badge_class = 'badge-secondary';
                                                if ($p->status == 'approved') $badge_class = 'badge-success';
                                                elseif ($p->status == 'pending') $badge_class = 'badge-warning';
                                                elseif ($p->status == 'rejected') $badge_class = 'badge-danger';
                                                ?>
                                                <span class="badge <?= $badge_class; ?>"><?= ucfirst($p->status); ?></span>
                                            </td>
                                            <td><?= date('M d, Y', strtotime($p->created_at)); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-gray-500">No data</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Recent Submissions -->
            <div class="col-md-6">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Recent Submissions</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-striped table-valign-middle">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($recent_submissions): ?>
                                    <?php foreach ($recent_submissions as $s): ?>
                                        <tr>
                                            <td><?= $s->user_id; ?></td>
                                            <td><?= $s->category; ?></td>
                                            <td>
                                                <?php
                                                $badge_class = 'badge-secondary';
                                                if ($s->status == 'finalist') $badge_class = 'badge-success';
                                                elseif ($s->status == 'submitted') $badge_class = 'badge-info';
                                                elseif ($s->status == 'not selected') $badge_class = 'badge-danger';
                                                ?>
                                                <span class="badge <?= $badge_class; ?>"><?= ucfirst($s->status); ?></span>
                                            </td>
                                            <td><?= date('M d, Y', strtotime($s->created_at)); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-gray-500">No data</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    // Payment Status Chart
    const paymentCtx = document.getElementById('paymentStatusChart').getContext('2d');
    new Chart(paymentCtx, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Approved', 'Rejected'],
            datasets: [{
                data: [<?= $payment_pending; ?>, <?= $payment_approved; ?>, <?= $payment_rejected; ?>],
                backgroundColor: ['#ffc107', '#28a745', '#dc3545']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Submission Status Chart
    const submissionCtx = document.getElementById('submissionStatusChart').getContext('2d');
    new Chart(submissionCtx, {
        type: 'doughnut',
        data: {
            labels: ['Submitted', 'Finalist', 'Not Selected'],
            datasets: [{
                data: [<?= $submission_submitted; ?>, <?= $submission_finalist; ?>, <?= $submission_not_selected; ?>],
                backgroundColor: ['#17a2b8', '#28a745', '#6c757d']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Category Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(categoryCtx, {
        type: 'bar',
        data: {
            labels: [<?php echo implode(',', array_map(function ($c) {
                            return '"' . $c->category . '"';
                        }, $submissions_by_category)); ?>],
            datasets: [{
                label: 'Submissions',
                data: [<?php echo implode(',', array_map(function ($c) {
                            return $c->count;
                        }, $submissions_by_category)); ?>],
                backgroundColor: '#007bff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'x'
        }
    });

    // Country Chart
    const countryCtx = document.getElementById('countryChart').getContext('2d');
    new Chart(countryCtx, {
        type: 'bar',
        data: {
            labels: [<?php echo implode(',', array_map(function ($c) {
                            return '"' . $c->country . '"';
                        }, $submissions_by_country)); ?>],
            datasets: [{
                label: 'Submissions',
                data: [<?php echo implode(',', array_map(function ($c) {
                            return $c->count;
                        }, $submissions_by_country)); ?>],
                backgroundColor: '#17a2b8'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y'
        }
    });

    // Payment Trend Chart
    const paymentTrendCtx = document.getElementById('paymentTrendChart').getContext('2d');
    new Chart(paymentTrendCtx, {
        type: 'line',
        data: {
            labels: [<?php echo implode(',', array_map(function ($p) {
                            return '"' . $p->month . '"';
                        }, $payment_trend)); ?>],
            datasets: [{
                    label: 'Approved',
                    data: [<?php echo implode(',', array_map(function ($p) {
                                return $p->approved;
                            }, $payment_trend)); ?>],
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)'
                },
                {
                    label: 'Pending',
                    data: [<?php echo implode(',', array_map(function ($p) {
                                return $p->pending;
                            }, $payment_trend)); ?>],
                    borderColor: '#ffc107',
                    backgroundColor: 'rgba(255, 193, 7, 0.1)'
                },
                {
                    label: 'Rejected',
                    data: [<?php echo implode(',', array_map(function ($p) {
                                return $p->rejected;
                            }, $payment_trend)); ?>],
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220, 53, 69, 0.1)'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Submission Trend Chart
    const submissionTrendCtx = document.getElementById('submissionTrendChart').getContext('2d');
    new Chart(submissionTrendCtx, {
        type: 'line',
        data: {
            labels: [<?php echo implode(',', array_map(function ($s) {
                            return '"' . $s->month . '"';
                        }, $submission_trend)); ?>],
            datasets: [{
                    label: 'Finalist',
                    data: [<?php echo implode(',', array_map(function ($s) {
                                return $s->finalist;
                            }, $submission_trend)); ?>],
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)'
                },
                {
                    label: 'Submitted',
                    data: [<?php echo implode(',', array_map(function ($s) {
                                return $s->submitted;
                            }, $submission_trend)); ?>],
                    borderColor: '#17a2b8',
                    backgroundColor: 'rgba(23, 162, 184, 0.1)'
                },
                {
                    label: 'Not Selected',
                    data: [<?php echo implode(',', array_map(function ($s) {
                                return $s->not_selected;
                            }, $submission_trend)); ?>],
                    borderColor: '#6c757d',
                    backgroundColor: 'rgba(108, 117, 125, 0.1)'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<style media="print">
    @page {
        size: A4;
        margin: 1cm;
    }

    body {
        font-size: 12px;
    }

    .btn,
    .card-header .btn,
    .float-right {
        display: none !important;
    }

    .card {
        page-break-inside: avoid;
        margin-bottom: 20px;
    }

    .row {
        page-break-inside: avoid;
    }

    canvas {
        max-width: 100% !important;
        height: auto !important;
    }
</style>

<script>
    function printDashboard() {
        window.print();
    }
</script>