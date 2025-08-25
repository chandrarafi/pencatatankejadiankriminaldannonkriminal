<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Data Piket<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Alert Messages -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle mr-2"></i>
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle mr-2"></i>
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<!-- Data Table Card -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-calendar-alt mr-2"></i>
            Data Piket
        </h3>
        <div class="card-tools">
            <span class="badge badge-info">Read Only - RESKRIM</span>
        </div>
    </div>

    <div class="card-body">
        <!-- Filter Section -->
        <div class="row mb-3">
            <div class="col-md-2">
                <select id="filterShift" class="form-control form-control-sm">
                    <option value="">Semua Shift</option>
                    <option value="pagi">Pagi</option>
                    <option value="siang">Siang</option>
                    <option value="malam">Malam</option>
                </select>
            </div>
            <div class="col-md-2">
                <select id="filterStatus" class="form-control form-control-sm">
                    <option value="">Semua Status</option>
                    <option value="draft">Draft</option>
                    <option value="aktif">Aktif</option>
                    <option value="selesai">Selesai</option>
                    <option value="dibatalkan">Dibatalkan</option>
                </select>
            </div>
            <div class="col-md-8">
                <div class="info-box bg-light">
                    <span class="info-box-icon bg-info">
                        <i class="fas fa-info-circle"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Akses Read-Only</span>
                        <span class="info-box-number">Hanya dapat melihat data piket dari Kasium</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table id="piketTable" class="table table-bordered table-striped" width="100%">
                <thead>
                    <tr>
                        <th>Tanggal Piket</th>
                        <th>Shift</th>
                        <th>Lokasi</th>
                        <th>Anggota</th>
                        <th>Status</th>
                        <th>Dibuat</th>
                        <th width="60">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data akan dimuat via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Inisialisasi DataTable
        var table = $('#piketTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= base_url('reskrim/piket/get-data') ?>',
                type: 'POST',
                data: function(d) {
                    d.<?= csrf_token() ?> = '<?= csrf_hash() ?>';
                    d.filterShift = $('#filterShift').val();
                    d.filterStatus = $('#filterStatus').val();
                },
                error: function(xhr, error, thrown) {
                    console.error('DataTables Error:', xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Gagal memuat data piket'
                    });
                }
            },
            columns: [{
                    data: 'tanggal_piket',
                    name: 'tanggal_piket'
                },
                {
                    data: 'shift',
                    name: 'shift',
                    orderable: false
                },
                {
                    data: 'lokasi_piket',
                    name: 'lokasi_piket'
                },
                {
                    data: 'anggota_list',
                    name: 'anggota_list',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ],
            order: [
                [0, 'desc']
            ],
            pageLength: 25,
            responsive: true,
            language: {
                processing: "Memuat data...",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                zeroRecords: "Data tidak ditemukan",
                info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                infoEmpty: "Tidak ada data yang tersedia",
                infoFiltered: "(difilter dari _MAX_ total data)",
                search: "Cari:",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            }
        });

        // Filter handlers
        $('#filterShift, #filterStatus').on('change', function() {
            table.ajax.reload();
        });

        // Row click handler untuk detail
        $('#piketTable tbody').on('click', 'tr', function() {
            var data = table.row(this).data();
            if (data) {
                // Bisa ditambahkan handler untuk detail view
                // window.location.href = '<?= base_url('reskrim/piket/show/') ?>' + data.id;
            }
        });

        // Tooltip initialization
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<?= $this->endSection() ?>