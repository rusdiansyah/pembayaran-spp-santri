// File: public/js/livewire-adminlte.js
document.addEventListener("livewire:load", () => {
    window.livewire.hook("message.processed", () => {
        $('[data-widget="pushmenu"]').PushMenu(); // Re-inisialisasi
    });
});
