import './bootstrap';

document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('contract_file');
    const fileNameDisplay = document.getElementById('file-name');
    fileInput.addEventListener('change', function () {
        const file = fileInput.files[0];
        if (file) {
            fileNameDisplay.textContent = file.name;
            fileNameDisplay.classList.remove('hidden');
        } else {
            fileNameDisplay.classList.add('hidden');
            fileNameDisplay.textContent = '';
        }
    });
});

setTimeout(() => {
    const toast = document.getElementById('toast-success');
    if (toast) {
        toast.classList.add('opacity-0');
        setTimeout(() => toast.remove(), 500);
    }
}, 3000);
