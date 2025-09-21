<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Sistem Surat & Laporan<?= $this->endSection() ?>

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

<!-- Info Card -->
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-file-alt mr-2"></i>
                    Sistem Surat & Laporan Kepolisian
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <p class="mb-2">
                            <strong>Sistem Surat & Laporan Kepolisian:</strong> Sistem ini menyediakan template dan generator untuk berbagai jenis dokumen resmi kepolisian sesuai standar yang berlaku.
                        </p>
                        <ul class="list-unstyled ml-3">
                            <li><i class="fas fa-check text-success mr-2"></i> Laporan Polisi (LP) - Dokumen pencatatan kejadian</li>
                            <li><i class="fas fa-check text-success mr-2"></i> Berita Acara Pemeriksaan (BAP) - Pemeriksaan saksi/tersangka</li>
                            <li><i class="fas fa-check text-success mr-2"></i> Surat Panggilan - Pemanggilan pihak terkait</li>
                            <li><i class="fas fa-check text-success mr-2"></i> Resume Kasus - Ringkasan investigasi</li>
                            <li><i class="fas fa-check text-success mr-2"></i> Surat Keterangan - Dokumen keterangan resmi</li>
                            <li><i class="fas fa-check text-success mr-2"></i> Laporan Harian/Berkala - Statistik dan monitoring</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box bg-primary">
                            <span class="info-box-icon">
                                <i class="fas fa-file-contract"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Dokumen Standar</span>
                                <span class="info-box-number">POLRI</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Document Categories -->
<div class="row">
    <!-- Laporan Investigasi -->
    <div class="col-md-6">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-search mr-2"></i>
                    Laporan Investigasi
                </h3>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">Dokumen untuk proses investigasi dan pencatatan kasus</p>

                <div class="list-group">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Laporan Polisi (LP)</h6>
                            <small class="text-muted">Pencatatan awal kejadian pidana</small>
                        </div>
                        <button class="btn btn-primary btn-sm" onclick="selectKasus('lp')">
                            <i class="fas fa-file-alt mr-1"></i> Buat LP
                        </button>
                    </div>

                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Berita Acara Pemeriksaan (BAP)</h6>
                            <small class="text-muted">Pemeriksaan saksi, korban, tersangka</small>
                        </div>
                        <button class="btn btn-warning btn-sm" onclick="selectKasus('bap')" <?= $role !== 'reskrim' && $role !== 'kasium' ? 'disabled' : '' ?>>
                            <i class="fas fa-clipboard-check mr-1"></i> Buat BAP
                        </button>
                    </div>

                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Resume Kasus</h6>
                            <small class="text-muted">Ringkasan lengkap investigasi kasus</small>
                        </div>
                        <button class="btn btn-success btn-sm" onclick="selectKasus('resume')" <?= $role !== 'reskrim' && $role !== 'kasium' ? 'disabled' : '' ?>>
                            <i class="fas fa-file-medical mr-1"></i> Buat Resume
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Surat Resmi -->
    <div class="col-md-6">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-envelope mr-2"></i>
                    Surat Resmi
                </h3>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">Dokumen surat resmi dan korespondensi</p>

                <div class="list-group">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Surat Panggilan</h6>
                            <small class="text-muted">Pemanggilan saksi, korban, tersangka</small>
                        </div>
                        <button class="btn btn-warning btn-sm" onclick="selectKasus('panggilan')" <?= $role !== 'reskrim' && $role !== 'kasium' ? 'disabled' : '' ?>>
                            <i class="fas fa-bell mr-1"></i> Buat Panggilan
                        </button>
                    </div>

                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Surat Keterangan</h6>
                            <small class="text-muted">Keterangan resmi dari kepolisian</small>
                        </div>
                        <button class="btn btn-info btn-sm" onclick="selectKasus('keterangan')">
                            <i class="fas fa-certificate mr-1"></i> Buat Keterangan
                        </button>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Cases for Document Generation -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-folder-open mr-2"></i>
                    Pilih Kasus untuk Generate Dokumen
                </h3>
                <div class="card-tools">
                    <button class="btn btn-tool" onclick="refreshCases()">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="kasusTable" class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th width="15%">Nomor Kasus</th>
                                <th width="25%">Judul Kasus</th>
                                <th width="15%">Tanggal Kejadian</th>
                                <th width="10%">Status</th>
                                <th width="15%">Pelapor</th>
                                <th width="20%">Aksi Dokumen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data akan dimuat via DataTables -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Person Selection -->
<div class="modal fade" id="personModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Orang untuk Dokumen</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="personList">
                    <!-- Content will be loaded via AJAX -->
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    let selectedDocType = '';
    let selectedKasusId = '';

    $(document).ready(function() {
        // Initialize DataTable
        const table = $('#kasusTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= base_url('laporan/get-data') ?>',
                type: 'POST',
                data: function(d) {
                    d.<?= csrf_token() ?> = '<?= csrf_hash() ?>';
                },
                error: function(xhr, error, thrown) {
                    console.error('DataTables Error:', xhr.responseText);
                }
            },
            columns: [{
                    data: 'nomor_kasus',
                    name: 'nomor_kasus'
                },
                {
                    data: 'judul_kasus',
                    name: 'judul_kasus'
                },
                {
                    data: 'tanggal_kejadian',
                    name: 'tanggal_kejadian'
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return 'Lihat Detail';
                    },
                    orderable: false
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return generateActionButtons(row);
                    },
                    orderable: false,
                    searchable: false
                }
            ],
            order: [
                [2, 'desc']
            ],
            pageLength: 10,
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

        function generateActionButtons(row) {
            console.log('Row data:', row); // Debug log
            const kasusId = row.id || row.DT_RowData?.id || 1; // Multiple fallbacks for ID
            console.log('Kasus ID:', kasusId); // Debug log

            // Sanitize kasusId to prevent injection
            const safeKasusId = String(kasusId).replace(/['"]/g, '');

            let buttons = `
            <div class="btn-group" role="group">
                <button class="btn btn-primary btn-sm" onclick="generateLP(${safeKasusId})" title="Laporan Polisi">
                    <i class="fas fa-file-alt"></i>
                </button>
                <button class="btn btn-success btn-sm" onclick="generateResume(${safeKasusId})" title="Resume Kasus">
                    <i class="fas fa-file-medical"></i>
                </button>
                <button class="btn btn-info btn-sm" onclick="generateKeterangan(${safeKasusId})" title="Surat Keterangan">
                    <i class="fas fa-certificate"></i>
                </button>
        `;

            <?php if ($role === 'reskrim' || $role === 'kasium'): ?>
                buttons += `
                <button class="btn btn-warning btn-sm" onclick="selectPersonForDoc(${safeKasusId}, 'bap')" title="BAP">
                    <i class="fas fa-clipboard-check"></i>
                </button>
                <button class="btn btn-secondary btn-sm" onclick="selectPersonForDoc(${safeKasusId}, 'panggilan')" title="Surat Panggilan">
                    <i class="fas fa-bell"></i>
                </button>
        `;
            <?php endif; ?>

            buttons += `
            </div>
        `;

            return buttons;
        }

        // Expose function to global scope
        window.generateActionButtons = generateActionButtons;
    });

    function selectKasus(docType) {
        selectedDocType = docType;
        // The case selection will be done via the table actions
        Swal.fire({
            title: 'Pilih Kasus',
            text: 'Silakan pilih kasus dari tabel di bawah untuk generate dokumen ' + docType.toUpperCase(),
            icon: 'info'
        });
    }

    function generateLP(kasusId) {
        window.open(`<?= base_url('surat/laporan-polisi/') ?>${kasusId}`, '_blank');
    }

    function generateResume(kasusId) {
        window.open(`<?= base_url('surat/resume-kasus/') ?>${kasusId}`, '_blank');
    }

    function generateKeterangan(kasusId) {
        window.open(`<?= base_url('surat/surat-keterangan/') ?>${kasusId}`, '_blank');
    }

    function selectPersonForDoc(kasusId, docType) {
        selectedKasusId = kasusId;
        selectedDocType = docType;

        // Load persons for the case
        $.ajax({
            url: `<?= base_url('surat/get-persons/') ?>${kasusId}`,
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    let html = '<div class="row">';

                    // Korban
                    if (response.korban && response.korban.length > 0) {
                        html += '<div class="col-md-4"><h6>Korban:</h6>';
                        response.korban.forEach(function(person) {
                            html += `
                            <div class="card card-outline card-success mb-2">
                                <div class="card-body p-2">
                                    <h6 class="card-title">${person.nama}</h6>
                                    <p class="card-text"><small>${person.nik || 'NIK tidak ada'}</small></p>
                                    <button class="btn btn-sm btn-success" onclick="generatePersonDoc('${kasusId}', 'korban', '${person.id}')">
                                        Pilih Korban
                                    </button>
                                </div>
                            </div>
                        `;
                        });
                        html += '</div>';
                    }

                    // Tersangka
                    if (response.tersangka && response.tersangka.length > 0) {
                        html += '<div class="col-md-4"><h6>Tersangka:</h6>';
                        response.tersangka.forEach(function(person) {
                            html += `
                            <div class="card card-outline card-warning mb-2">
                                <div class="card-body p-2">
                                    <h6 class="card-title">${person.nama}</h6>
                                    <p class="card-text"><small>${person.nik || 'NIK tidak ada'}</small></p>
                                    <button class="btn btn-sm btn-warning" onclick="generatePersonDoc('${kasusId}', 'tersangka', '${person.id}')">
                                        Pilih Tersangka
                                    </button>
                                </div>
                            </div>
                        `;
                        });
                        html += '</div>';
                    }

                    // Saksi
                    if (response.saksi && response.saksi.length > 0) {
                        html += '<div class="col-md-4"><h6>Saksi:</h6>';
                        response.saksi.forEach(function(person) {
                            html += `
                            <div class="card card-outline card-info mb-2">
                                <div class="card-body p-2">
                                    <h6 class="card-title">${person.nama}</h6>
                                    <p class="card-text"><small>${person.nik || 'NIK tidak ada'}</small></p>
                                    <button class="btn btn-sm btn-info" onclick="generatePersonDoc('${kasusId}', 'saksi', '${person.id}')">
                                        Pilih Saksi
                                    </button>
                                </div>
                            </div>
                        `;
                        });
                        html += '</div>';
                    }

                    html += '</div>';

                    if (response.korban.length === 0 && response.tersangka.length === 0 && response.saksi.length === 0) {
                        html = '<div class="alert alert-warning">Belum ada data korban, tersangka, atau saksi untuk kasus ini.</div>';
                    }

                    $('#personList').html(html);
                    $('#personModal').modal('show');
                }
            },
            error: function() {
                Swal.fire('Error', 'Gagal memuat data orang', 'error');
            }
        });
    }

    function generatePersonDoc(kasusId, personType, personId) {
        $('#personModal').modal('hide');

        if (selectedDocType === 'bap') {
            window.open(`<?= base_url('surat/berita-acara-pemeriksaan/') ?>${kasusId}/${personType}/${personId}`, '_blank');
        } else if (selectedDocType === 'panggilan') {
            window.open(`<?= base_url('surat/surat-panggilan/') ?>${kasusId}/${personType}/${personId}`, '_blank');
        }
    }

    function refreshCases() {
        $('#kasusTable').DataTable().ajax.reload();
    }
</script>
<?= $this->endSection() ?>