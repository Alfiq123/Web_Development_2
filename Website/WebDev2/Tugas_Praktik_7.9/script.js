const input    = document.getElementById('input-file');
const dropzone = document.getElementById('dropzone');
const teks     = document.getElementById('dz-text');
const form     = document.getElementById('form-upload');

// Tampilkan nama file yang dipilih
input.addEventListener('change', () => {
    teks.textContent = input.files.length ? input.files[0].name : 'Klik atau seret file ke sini';
});

// Drag & drop
dropzone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropzone.classList.add('aktif');
});
dropzone.addEventListener('dragleave', () => dropzone.classList.remove('aktif'));
dropzone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropzone.classList.remove('aktif');
    input.files = e.dataTransfer.files;
    input.dispatchEvent(new Event('change'));
});

// Cek ukuran sebelum dikirim (pengecekan utama tetap di server)
form.addEventListener('submit', (e) => {
    const maks = Number(input.dataset.max);
    if (input.files.length && input.files[0].size > maks) {
        e.preventDefault();
        alert('Ukuran file melebihi batas ' + (maks / 1024 / 1024) + ' MB.');
    }
});

// Hilangkan notifikasi otomatis setelah 4 detik + bersihkan ?status= dari URL
const alertBox = document.querySelector('.alert');
if (alertBox) {
    setTimeout(() => alertBox.remove(), 4000);
    history.replaceState(null, '', 'index.php');
}
