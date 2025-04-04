import './bootstrap';
setTimeout(() => {
    const toast = document.getElementById('toast-success');
    if (toast) {
        toast.classList.add('opacity-0');
        setTimeout(() => toast.remove(), 500);
    }
}, 3000);