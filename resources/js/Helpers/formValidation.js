// resources/js/Helpers/formValidation.js

export const validateForm = (formElement) => {
    let isValid = true;

    // Ambil semua input, select, dan textarea di dalam form
    const inputs = formElement.querySelectorAll("input, select, textarea");

    inputs.forEach((input) => {
        // Hapus feedback lama
        const feedbacks = input.parentElement.querySelectorAll(
            ".valid-feedback, .invalid-feedback"
        );
        feedbacks.forEach((el) => el.remove());

        // Ambil nilai input
        const value = input.value?.trim();

        // --- Validasi Manual untuk Required ---
        if (input.hasAttribute("required") && !value) {
            input.classList.remove("is-valid");
            input.classList.add("is-invalid");

            const invalidFeedback = document.createElement("div");
            invalidFeedback.className = "invalid-feedback";
            invalidFeedback.innerText = "Kolom ini wajib diisi!";
            input.parentElement.appendChild(invalidFeedback);

            isValid = false;
            return; // langsung skip ke input berikutnya
        }

        // --- Validasi Bawaan Browser (untuk pola, email, dsb) ---
        if (input.checkValidity()) {
            input.classList.remove("is-invalid");
            input.classList.add("is-valid");

            const validFeedback = document.createElement("div");
            validFeedback.className = "valid-feedback";
            validFeedback.innerText = "Data sesuai!";
            input.parentElement.appendChild(validFeedback);
        } else {
            input.classList.remove("is-valid");
            input.classList.add("is-invalid");

            const invalidFeedback = document.createElement("div");
            invalidFeedback.className = "invalid-feedback";
            invalidFeedback.innerText = "Data belum sesuai!";
            input.parentElement.appendChild(invalidFeedback);

            isValid = false;
        }
    });

    return isValid;
};
