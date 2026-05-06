import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

/* ================= FILE UPLOAD ================= */
window.fileUpload = function () {
    return {
        file: null,
        fileSize: null,

        handleFile(event) {
            const f = event.target.files[0];
            if (!f) return;

            if (f.type !== "application/pdf") {
                alert("Harus PDF");
                return;
            }

            if (f.size > 10 * 1024 * 1024) {
                alert("Max 10MB");
                return;
            }

            this.file = f;
            this.fileSize = this.formatSize(f.size);
        },

        removeFile() {
            this.file = null;
            this.fileSize = null;
        },

        formatSize(size) {
            return (size / 1024).toFixed(0) + " KB";
        },
    };
};

/* ================= MODAL HANDLER ================= */
window.modalHandler = function () {
    return {
        open: false,
        status: null,

        init() {
            this.status = document.body.dataset.status;

            if (!this.status) return;

            this.open = true;

            if (this.status === "verified") {
                setTimeout(() => {
                    window.location.href = "/login";
                }, 3000);
            }
        },

        get title() {
            return this.status === "verified"
                ? "Berhasil Diverifikasi"
                : "Menunggu Verifikasi";
        },

        get message() {
            return this.status === "verified"
                ? "Akun Anda sudah aktif"
                : "Data sedang diperiksa (max 3 hari)";
        },

        get icon() {
            return this.status === "verified"
                ? "/assets/icons/success-icon.png"
                : "/assets/icons/waiting-icon.png";
        },

        get badgeType() {
            return this.status === "verified" ? "success" : "warning";
        },

        get badgeText() {
            return this.status === "verified" ? "Verified" : "Pending";
        },
    };
};

Alpine.start();
