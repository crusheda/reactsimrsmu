// resources/js/helpers/formValidation.js

export const validateForm = (formElement) => {
    let isValid = true;

    // Ambil semua input, select, textarea di dalam form
    const inputs = formElement.querySelectorAll("input, select, textarea");

    inputs.forEach((input) => {
        // Hapus pesan sebelumnya agar tidak menumpuk
        const feedbacks = input.parentElement.querySelectorAll(
            ".valid-feedback, .invalid-feedback"
        );
        feedbacks.forEach((el) => el.remove());

        // Cek validitas bawaan browser
        if (input.checkValidity()) {
            input.classList.remove("is-invalid");
            input.classList.add("is-valid");

            const validFeedback = document.createElement("div");
            validFeedback.className = "valid-feedback";
            validFeedback.innerText = "Data Sesuai!";
            input.parentElement.appendChild(validFeedback);
        } else {
            input.classList.remove("is-valid");
            input.classList.add("is-invalid");

            const invalidFeedback = document.createElement("div");
            invalidFeedback.className = "invalid-feedback";
            invalidFeedback.innerText = "Data Belum Sesuai!";
            input.parentElement.appendChild(invalidFeedback);

            isValid = false;
        }
    });

    return isValid;
};
