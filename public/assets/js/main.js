// assets/js/main.js
// Kode room selalu huruf besar supaya konsisten dengan yang dibagikan host.
document.addEventListener('DOMContentLoaded', function () {
    var code = document.getElementById('roomCode');
    if (code) {
        code.addEventListener('input', function () {
            code.value = code.value.toUpperCase().replace(/\s/g, '');
        });
    }
});
