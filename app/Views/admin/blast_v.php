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
                    <div class="mb-4">
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

                    <div class="alert alert-info border-0 rounded-4 mb-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-users fa-2x me-3 opacity-50"></i>
                            <div>
                                <p class="mb-0 small fw-bold">Target Penerima:</p>
                                <h5 class="mb-0 fw-800"><?= $total_penerima ?> Nomor WhatsApp Aktif</h5>
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
// 1. Logika Live Preview (Sudah Bagus)
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

// 2. LOGIKA KIRIM BLAST (Beneran Kirim ke Fonnte)
document.getElementById('btnBlast').addEventListener('click', function() {
    const pesan = document.getElementById('textPreview').innerText;
    const judul = document.getElementById('pilihKegiatan').value;

    if (judul === "") {
        Swal.fire('Pilih Kegiatan!', 'Pilih dulu kegiatan yang mau di-blast.', 'warning');
        return;
    }

    Swal.fire({
        title: 'Konfirmasi Blast?',
        text: "Pesan akan dikirim ke <?= $total_penerima ?> nomor warga via Fonnte.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#198754',
        confirmButtonText: 'Ya, Kirim Sekarang!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Munculkan Loading saat kirim
            Swal.fire({
                title: 'Sedang Mengirim...',
                html: 'Mohon jangan tutup halaman ini.',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading() }
            });

            // AJAX FETCH ke Controller Admin/proses_blast
            fetch('<?= base_url('admin/proses_blast') ?>', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest' 
                },
                body: `pesan=${encodeURIComponent(pesan)}&judul=${encodeURIComponent(judul)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: `Notifikasi terkirim ke ${data.total} warga.`,
                        confirmButtonColor: '#10b981'
                    }).then(() => {
                        location.reload(); // Refresh agar riwayat terupdate
                    });
                } else {
                    Swal.fire('Gagal!', 'Gagal mengirim pesan via API Fonnte.', 'error');
                }
            })
            .catch(err => {
                Swal.fire('Error!', 'Koneksi ke server gagal.', 'error');
            });
        }
    });
});
</script>
<?= $this->endSection() ?>