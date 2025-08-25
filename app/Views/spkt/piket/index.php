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
            Daftar Jadwal Piket Polsek Lunang Silaut
        </h3>
        <div class="card-tools">
            <span class="badge badge-info">
                <i class="fas fa-eye mr-1"></i> View Only
            </span>
        </div>
    </div>

    <div class="card-body">
        <!-- Info Box -->
        <div class="alert alert-info">
            <i class="fas fa-info-circle mr-2"></i>
            <strong>Informasi:</strong> Anda memiliki akses <strong>read-only</strong> untuk melihat data piket.
            Untuk mengelola data piket, hubungi bagian Kasium.
        </div>

        <div class="table-responsive">
            <table id="tablePiket" class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th width="12%">Tanggal</th>
                        <th width="25%">Anggota</th>
                        <th width="10%">Shift</th>
                        <th width="15%">Jam</th>
                        <th width="15%">Lokasi</th>
                        <th width="13%">Status</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data akan diload via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Initialize DataTable
        const table = $('#tablePiket').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= base_url('spkt/piket/data') ?>',
                type: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            },
            columns: [{
                    data: 'tanggal_piket',
                    render: function(data, type, row) {
                        if (data) {
                            const date = new Date(data);
                            const options = {
                                weekday: 'short',
                                year: 'numeric',
                                month: 'short',
                                day: 'numeric'
                            };
                            return date.toLocaleDateString('id-ID', options);
                        }
                        return '-';
                    }
                },
                {
                    data: 'anggota_count',
                    render: function(data, type, row) {
                        if (data && data > 0) {
                            return `<span class="badge badge-primary">${data} Anggota</span>`;
                        }
                        return '<span class="badge badge-secondary">Belum ada</span>';
                    }
                },
                {
                    data: 'shift',
                    render: function(data, type, row) {
                        if (!data) return '<span class="badge badge-secondary">-</span>';

                        const shiftClass = {
                            'pagi': 'badge-success',
                            'siang': 'badge-warning',
                            'malam': 'badge-dark'
                        };

                        const shiftText = typeof data === 'string' ? data.toUpperCase() : String(data).toUpperCase();
                        return `<span class="badge ${shiftClass[data] || 'badge-secondary'}">${shiftText}</span>`;
                    }
                },
                {
                    data: 'jam_mulai',
                    render: function(data, type, row) {
                        if (data && row.jam_selesai) {
                            return `${data} - ${row.jam_selesai}`;
                        }
                        return '-';
                    }
                },
                {
                    data: 'lokasi_piket'
                },
                {
                    data: 'status',
                    render: function(data, type, row) {
                        if (!data) return '<span class="badge badge-secondary">DRAFT</span>';

                        const statusClass = {
                            'aktif': 'badge-success',
                            'selesai': 'badge-info',
                            'batal': 'badge-danger'
                        };

                        const statusText = typeof data === 'string' ? data.toUpperCase() : String(data).toUpperCase();
                        return `<span class="badge ${statusClass[data] || 'badge-secondary'}">${statusText}</span>`;
                    }
                },
                {
                    data: 'id',
                    render: function(data, type, row) {
                        return `
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-info btn-sm" onclick="showDetail(${data})" title="Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    `;
                    },
                    orderable: false,
                    searchable: false
                }
            ],
            order: [
                [0, 'desc']
            ],
            pageLength: 10,
            responsive: true,
            language: {
                "sProcessing": "Memproses...",
                "sLengthMenu": "Tampilkan _MENU_ entri",
                "sZeroRecords": "Tidak ditemukan data yang sesuai",
                "sInfo": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                "sInfoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
                "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
                "sInfoPostFix": "",
                "sSearch": "Cari:",
                "sUrl": "",
                "oPaginate": {
                    "sFirst": "Pertama",
                    "sPrevious": "Sebelumnya",
                    "sNext": "Selanjutnya",
                    "sLast": "Terakhir"
                }
            },
            dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            drawCallback: function() {
                // Re-initialize tooltips
                $('[data-toggle="tooltip"]').tooltip();
            }
        });

        // Refresh table
        window.refreshTable = function() {
            table.ajax.reload(null, false);
        };
    });

    // Show detail function
    function showDetail(id) {
        window.location.href = '<?= base_url('spkt/piket/show') ?>/' + id;
    }
</script>
<?= $this->endSection() ?>