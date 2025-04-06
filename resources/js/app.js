import './bootstrap';
import { initLandingPageBuilder } from './landingPreview';

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



document.addEventListener('DOMContentLoaded', () => {
    const previewRoute = document.querySelector('[data-preview-route]')?.dataset.previewRoute;
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    if (previewRoute && csrfToken) {
        initLandingPageBuilder(previewRoute, csrfToken);
    }
});

   // Toast fade-out
   setTimeout(() => {
    document.querySelectorAll('[id^="toast-"]').forEach(toast => {
        toast.classList.add('opacity-0');
        setTimeout(() => toast.remove(), 500);
    });
}, 3000);

// Delete modal toggle
document.querySelectorAll('[data-modal-toggle]').forEach(btn => {
    const targetId = btn.getAttribute('data-modal-toggle');
    const modal = document.getElementById(targetId);

    btn.addEventListener('click', () => {
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    });

    modal?.querySelectorAll('[data-modal-hide]').forEach(closeBtn => {
        closeBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        });
    });
});