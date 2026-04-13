<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px;">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0 text-success"><i class="fab fa-whatsapp me-2"></i> Kirim Notifikasi Kegiatan</h5>
            </div>
            <div class="card-body">
                <form id="formBlast">
                    <div class="mb-3">
                        <label class="small fw-bold text-muted mb-2">PILIH KEGIATAN</label>
                        <select class="form-select border-success-subtle py-2 shadow-none" id="pilihKegiatan" required>
                            <option value="" data-lokasi="" data-anggaran="" data-tgl="">-- Pilih Kegiatan --</option>
                            <?php foreach($kegiatan as $k): ?>
                                <option value="<?= $k['judul_kegiatan'] ?>" 
                                        data-lokasi="<?= $k['lokasi'] ?>" 
                                        data-anggaran="<?= number_format((float)$k['anggaran'], 0, ',', '.') ?>"
                                        data-tgl="<?= date('d M Y', strtotime($k['updated_at'] ?? $k['created_at'] ?? date('Y-m-d'))) ?>">
                                    <?= $k['judul_kegiatan'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="small fw-bold text-muted mb-2">TARGET DUSUN</label>
                        <select class="form-select border-success-subtle py-2 shadow-none" id="filterDusun">
                            <option value="Semua">-- Semua Dusun --</option>
                            <?php foreach($list_dusun as $d): ?>
                                <?php if(!empty($d['dusun'])): ?>
                                    <option value="<?= $d['dusun'] ?>"><?= $d['dusun'] ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="small fw-bold text-muted mb-2">JEDA ANTAR PESAN (DETIK)</label>
                        <div class="input-group">
                            <input type="number" id="inputDelay" class="form-control border-success-subtle shadow-none" value="10" min="1">
                            <span class="input-group-text bg-success-subtle text-success border-success-subtle">Detik</span>
                        </div>
                        <small class="text-muted text-xs">*Berikan delay per pesan, agar tidak terdeteksi bot.</small>
                    </div>

                    <div class="alert alert-info border-0 rounded-4 mb-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-users fa-2x me-3 opacity-50"></i>
                            <div>
                                <p class="mb-0 small fw-bold">Target Penerima:</p>
                                <h5 class="mb-0 fw-800"><span id="jumlahTarget"><?= $total_penerima ?></span> Nomor WhatsApp Aktif</h5>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="btnBlast" class="btn btn-success w-100 py-3 rounded-pill fw-bold shadow">
                        <i class="fas fa-paper-plane me-2"></i> MULAI BLAST SEKARANG
                    </button>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm" style="border-radius: 20px;">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0 text-dark"><i class="fas fa-history me-2"></i> Riwayat Blast Terbaru</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light small">
                            <tr>
                                <th class="ps-4">Tanggal</th>
                                <th>Kegiatan</th>
                                <th>Total</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($riwayat)): foreach($riwayat as $r): ?>
                            <tr>
                                <td class="ps-4 small"><?= date('d/m/y H:i', strtotime($r['created_at'])) ?></td>
                                <td class="fw-bold small"><?= $r['judul_kegiatan'] ?></td>
                                <td><span class="badge bg-success-subtle text-success"><?= $r['total_penerima'] ?></span></td>
                                <td class="text-center">
                                    <button class="btn btn-light btn-sm rounded-circle" onclick="Swal.fire('Isi Pesan', '<?= addslashes($r['isi_pesan']) ?>', 'info')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; else: ?>
                                <tr><td colspan="4" class="text-center py-3 text-muted">Belum ada riwayat.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card border-0 shadow-sm" style="border-radius: 20px; background: #e5ddd5; position: sticky; top: 90px;">
            <div class="card-header bg-success text-white py-3" style="border-radius: 20px 20px 0 0;">
                <div class="d-flex align-items-center">
                    <i class="fas fa-user-circle fa-2x me-2"></i>
                    <div>
                        <h6 class="mb-0 fw-bold">Preview Notifikasi</h6>
                        <small class="opacity-75">Live Preview</small>
                    </div>
                </div>
            </div>
            <div class="card-body p-4" style="min-height: 300px;">
                <div class="bg-white p-3 shadow-sm rounded-3 position-relative" style="max-width: 90%;">
                    <p class="mb-0 small" id="textPreview" style="white-space: pre-wrap;">
                        Silakan pilih kegiatan untuk melihat pratinjau pesan...
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('filterDusun').addEventListener('change', function() {
    const dusun = this.value;
    const targetSpan = document.getElementById('jumlahTarget');

    // Beri efek loading sementara
    targetSpan.innerText = '...';

    fetch('<?= base_url('admin/hitung_target_dusun') ?>', {
        method: 'POST',
        headers: { 
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest' 
        },
        body: `dusun=${encodeURIComponent(dusun)}`
    })
    .then(response => response.json())
    .then(data => {
        targetSpan.innerText = data.jumlah;
    })
    .catch(err => {
        targetSpan.innerText = '0';
        console.error('Gagal mengambil data target:', err);
    });
});
// 1. Live Preview Logic
document.getElementById('pilihKegiatan').addEventListener('change', function() {
    const judul = this.value;
    const lokasi = this.options[this.selectedIndex].getAttribute('data-lokasi');
    const anggaran = this.options[this.selectedIndex].getAttribute('data-anggaran');
    const tgl = this.options[this.selectedIndex].getAttribute('data-tgl');

    if (judul) {
        const pesan = `*PEMBERITAHUAN KEGIATAN DESA*\n\n` +
                      `Halo Bapak/Ibu Warga Desa Segarau Parit,\n` +
                      `Berikut adalah rincian kegiatan terbaru:\n\n` +
                      `📌 *Kegiatan:* ${judul}\n` +
                      `📍 *Lokasi:* ${lokasi}\n` +
                      `💰 *Anggaran:* Rp ${anggaran}\n` +
                      `📅 *Tanggal ACC:* ${tgl}\n\n` +
                      `_Pesan ini dikirim otomatis oleh Sistem Digital Desa Segarau Parit._`;
        
        document.getElementById('textPreview').innerText = pesan;
    } else {
        document.getElementById('textPreview').innerText = "Silakan pilih kegiatan...";
    }
});

// Di dalam event listener btnBlast
document.getElementById('btnBlast').addEventListener('click', function() {
    const pesan = document.getElementById('textPreview').innerText;
    const judul = document.getElementById('pilihKegiatan').value;
    const dusun = document.getElementById('filterDusun').value;
    const delay = document.getElementById('inputDelay').value; // Ambil nilai delay

    if (judul === "") {
        Swal.fire('Pilih Kegiatan!', 'Pilih dulu kegiatan.', 'warning');
        return;
    }

    Swal.fire({
        title: 'Konfirmasi Blast?',
        text: `Kirim ke Dusun ${dusun} dengan jeda ${delay} detik per pesan.`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Kirim!'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({ title: 'Memproses...', allowOutsideClick: false, didOpen: () => { Swal.showLoading() } });

            fetch('<?= base_url('admin/proses_blast') ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                // Tambahkan delay ke body
                body: `pesan=${encodeURIComponent(pesan)}&judul=${encodeURIComponent(judul)}&dusun=${encodeURIComponent(dusun)}&delay=${delay}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire('Berhasil!', `Proses antrean ${data.total} pesan dimulai.`, 'success').then(() => { location.reload(); });
                } else {
                    Swal.fire('Gagal!', data.msg, 'error');
                }
            });
        }
    });
});
</script>
<?= $this->endSection() ?>