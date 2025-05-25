// ===== REGISTRATION JAVASCRIPT =====

document.addEventListener("DOMContentLoaded", () => {
  // ===== FORM VALIDATION =====
  const forms = document.querySelectorAll(".register-form");

  forms.forEach((form) => {
    const inputs = form.querySelectorAll("input, select, textarea");

    inputs.forEach((input) => {
      input.addEventListener("blur", () => validateField(input));
      input.addEventListener("input", () => {
        // Validate on input only if it's already marked as invalid
        if (input.classList.contains("is-invalid")) {
          validateField(input);
        }

        // Real-time password strength check
        if (input.type === "password" && input.id === "password") {
          checkPasswordStrength(input);
        }

        // Real-time password confirmation check
        if (input.id === "konf_password") {
          checkPasswordMatch(input);
        }
      });
    });

    // Form submission
    form.addEventListener("submit", (e) => {
      e.preventDefault(); // Prevent default form submission initially

      let isValid = true;
      // Validate all fields before submission
      inputs.forEach((input) => {
        if (!validateField(input)) {
          isValid = false;
        }
      });

      const termsCheckbox = document.getElementById("terms");
      if (!termsCheckbox || !termsCheckbox.checked) {
        isValid = false;
        showNotification("Anda harus menyetujui Syarat & Ketentuan.", "error");
      }

      if (isValid) {
        submitForm(form);
      } else {
        showNotification(
          "Mohon periksa kembali data yang Anda masukkan.",
          "error"
        );
      }
    });
  });

  // ===== FIELD VALIDATION =====
  function validateField(field) {
    const value = field.value.trim();
    let isValid = true;
    let errorMessage = "";

    // Required field validation
    if (field.hasAttribute("required") && !value) {
      isValid = false;
      errorMessage = "Kolom ini wajib diisi.";
    } else {
      // Only proceed with specific validations if the field is not empty (if required)
      // Email validation
      if (field.type === "email" && value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
          isValid = false;
          errorMessage = "Format email tidak valid.";
        }
      }

      // Phone validation (basic)
      if (field.type === "tel" && value) {
        const phoneRegex = /^[0-9+() -]{10,}$/; // Allows numbers, +, -, space, ()
        if (!phoneRegex.test(value)) {
          isValid = false;
          errorMessage = "Format nomor telepon tidak valid. Minimal 10 digit.";
        }
      }

      // Password validation
      if (field.type === "password" && field.id === "password" && value) {
        if (value.length < 6) {
          isValid = false;
          errorMessage = "Password minimal 6 karakter.";
        }
      }

      // Password confirmation validation
      if (field.id === "konf_password" && value) {
        const passwordField = document.getElementById("password");
        if (passwordField && value !== passwordField.value) {
          isValid = false;
          errorMessage = "Konfirmasi password tidak cocok.";
        }
      }

      // Number input validation (tahun_pengalaman)
      if (field.type === "number" && value) {
        const min = parseInt(field.min);
        const max = parseInt(field.max);
        const numValue = parseInt(value);

        if (isNaN(numValue)) {
          isValid = false;
          errorMessage = "Harus berupa angka.";
        } else if (!isNaN(min) && numValue < min) {
          isValid = false;
          errorMessage = `Minimal ${min}.`;
        } else if (!isNaN(max) && numValue > max) {
          isValid = false;
          errorMessage = `Maksimal ${max}.`;
        }
      }

      // Select (dropdown) validation
      if (
        field.tagName === "SELECT" &&
        field.hasAttribute("required") &&
        value === ""
      ) {
        isValid = false;
        errorMessage = "Mohon pilih salah satu opsi.";
      }

      // File validation
      if (field.type === "file" && field.files.length > 0) {
        const file = field.files[0];
        const maxSize = 5 * 1024 * 1024; // 5MB
        const allowedTypes = ["image/jpeg", "image/png", "application/pdf"];

        if (file.size > maxSize) {
          isValid = false;
          errorMessage = "Ukuran file maksimal 5MB.";
        } else if (!allowedTypes.includes(file.type)) {
          isValid = false;
          errorMessage = "Format file harus JPG, PNG, atau PDF.";
        }
      } else if (
        field.type === "file" &&
        field.hasAttribute("required") &&
        field.files.length === 0
      ) {
        isValid = false;
        errorMessage = "File ini wajib diunggah.";
      }
    }

    // Update field appearance based on validation result
    updateFieldValidation(field, isValid, errorMessage);
    return isValid;
  }

  function updateFieldValidation(field, isValid, errorMessage) {
    const feedback = field.parentNode.querySelector(".form-feedback");

    if (isValid) {
      field.classList.remove("is-invalid");
      field.classList.add("is-valid");
      if (feedback) {
        feedback.textContent = "";
        feedback.className = "form-feedback valid-feedback";
      }
    } else {
      field.classList.remove("is-valid");
      field.classList.add("is-invalid");
      if (feedback) {
        feedback.textContent = errorMessage;
        feedback.className = "form-feedback invalid-feedback";
      }
    }
  }

  // ===== PASSWORD STRENGTH CHECKER =====
  function checkPasswordStrength(passwordField) {
    const password = passwordField.value;
    const strengthBar =
      passwordField.parentNode.parentNode.querySelector(".strength-bar");
    const strengthText =
      passwordField.parentNode.parentNode.querySelector(".strength-text");

    if (!strengthBar || !strengthText) return;

    let strength = 0;
    let strengthLabel = "Sangat Lemah";
    let barColor = "#dc3545"; // Red

    // Check password criteria
    if (password.length >= 6) strength++; // Basic length
    if (password.match(/[a-z]/)) strength++; // Lowercase letters
    if (password.match(/[A-Z]/)) strength++; // Uppercase letters
    if (password.match(/[0-9]/)) strength++; // Numbers
    if (password.match(/[^a-zA-Z0-9]/)) strength++; // Special characters

    // Update strength bar width and color
    let barWidth = (strength / 5) * 100; // Max strength is 5
    if (strength === 0) {
      strengthLabel = "Sangat Lemah";
      barColor = "#dc3545";
      barWidth = 0;
    } else if (strength <= 2) {
      strengthLabel = "Lemah";
      barColor = "#ffc107"; // Yellow
    } else if (strength === 3) {
      strengthLabel = "Sedang";
      barColor = "#17a2b8"; // Info blue
    } else if (strength === 4) {
      strengthLabel = "Kuat";
      barColor = "#28a745"; // Green
    } else if (strength === 5) {
      strengthLabel = "Sangat Kuat";
      barColor = "#10b981"; // Darker green for very strong
    }

    strengthBar.style.width = `${barWidth}%`;
    strengthBar.style.backgroundColor = barColor;

    strengthText.textContent = `Kekuatan password: ${strengthLabel}`;
  }

  function checkPasswordMatch(confirmField) {
    const passwordField = document.getElementById("password");
    if (!passwordField) return;

    const isMatch = confirmField.value === passwordField.value;
    updateFieldValidation(
      confirmField,
      isMatch || confirmField.value === "", // Valid if matches or empty (user hasn't typed yet)
      isMatch ? "" : "Konfirmasi password tidak cocok."
    );
  }

  // ===== FORM SUBMISSION =====
  function submitForm(form) {
    const submitBtn = form.querySelector(".register-btn");
    const btnText = submitBtn.querySelector(".btn-text");
    const btnLoading = submitBtn.querySelector(".btn-loading");

    // Show loading state
    submitBtn.classList.add("loading");
    btnText.classList.add("d-none");
    btnLoading.classList.remove("d-none");
    submitBtn.disabled = true;

    // Use native form submission to allow PHP to handle redirects and server-side alerts
    form.submit();
  }

  // ===== FILE UPLOAD HANDLING =====
  const fileInputs = document.querySelectorAll('input[type="file"]');

  fileInputs.forEach((input) => {
    const uploadArea = input.closest(".file-upload-area");

    if (uploadArea) {
      // Drag and drop functionality
      uploadArea.addEventListener("dragover", (e) => {
        e.preventDefault();
        uploadArea.classList.add("dragover");
      });

      uploadArea.addEventListener("dragleave", () => {
        uploadArea.classList.remove("dragover");
      });

      uploadArea.addEventListener("drop", (e) => {
        e.preventDefault();
        uploadArea.classList.remove("dragover");

        const files = e.dataTransfer.files;
        if (files.length > 0) {
          input.files = files; // Assign files to the input
          updateFileDisplay(input, files[0]);
          validateField(input); // Validate dropped file
        }
      });

      // File selection
      input.addEventListener("change", (e) => {
        if (e.target.files.length > 0) {
          updateFileDisplay(input, e.target.files[0]);
          validateField(input); // Validate selected file
        } else {
          // Reset display if no file is selected (e.g., user cancels file dialog)
          resetFileDisplay(input);
          validateField(input); // Re-validate to show "required" error if applicable
        }
      });
    }
  });

  function updateFileDisplay(input, file) {
    const uploadArea = input.closest(".file-upload-area");
    const uploadText = uploadArea.querySelector(".file-upload-text");

    if (file) {
      uploadText.innerHTML = `
                <i class="fas fa-file-check"></i>
                <span>File terpilih: ${file.name}</span>
                <small>Ukuran: ${formatFileSize(file.size)}</small>
            `;
      uploadArea.style.borderColor = "var(--success-color, #10b981)"; // Fallback color
      uploadArea.style.background = "rgba(16, 185, 129, 0.05)";
    }
  }

  function resetFileDisplay(input) {
    const uploadArea = input.closest(".file-upload-area");
    const uploadText = uploadArea.querySelector(".file-upload-text");
    uploadText.innerHTML = `
            <i class="fas fa-cloud-upload-alt"></i>
            <span>Klik untuk upload atau drag & drop</span>
            <small>Format: JPG, PNG, PDF (Max: 5MB)</small>
        `;
    uploadArea.style.borderColor = ""; // Reset to default
    uploadArea.style.background = ""; // Reset to default
  }

  function formatFileSize(bytes) {
    if (bytes === 0) return "0 Bytes";
    const k = 1024;
    const sizes = ["Bytes", "KB", "MB", "GB"];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return (
      Number.parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + " " + sizes[i]
    );
  }

  // ===== NOTIFICATION SYSTEM =====
  function showNotification(message, type = "info") {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll(".notification");
    existingNotifications.forEach((notif) => notif.remove());

    // Create notification element
    const notification = document.createElement("div");
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
            <div class="notification-content">
                <i class="fas fa-${getNotificationIcon(type)} me-2"></i>
                <span>${message}</span>
                <button class="notification-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;

    // Add styles
    notification.style.cssText = `
            position: fixed;
            top: 100px;
            right: 20px;
            background: ${getNotificationColor(type)};
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            z-index: 9999;
            transform: translateX(100%);
            transition: transform 0.3s ease;
            max-width: 350px;
            font-family: 'Inter', sans-serif; /* Use Inter font */
        `;

    document.body.appendChild(notification);

    // Animate in
    setTimeout(() => {
      notification.style.transform = "translateX(0)";
    }, 100);

    // Handle close button
    const closeBtn = notification.querySelector(".notification-close");
    closeBtn.style.cssText = `
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            padding: 0;
            margin-left: 1rem;
            opacity: 0.8;
            font-size: 1rem; /* Ensure icon is visible */
        `;

    closeBtn.addEventListener("click", () => {
      notification.style.transform = "translateX(100%)";
      setTimeout(() => notification.remove(), 300);
    });

    // Auto remove after 5 seconds
    setTimeout(() => {
      if (notification.parentNode) {
        notification.style.transform = "translateX(100%)";
        setTimeout(() => notification.remove(), 300);
      }
    }, 5000);
  }

  function getNotificationIcon(type) {
    const icons = {
      success: "check-circle",
      error: "exclamation-circle",
      warning: "exclamation-triangle",
      info: "info-circle",
    };
    return icons[type] || icons.info;
  }

  function getNotificationColor(type) {
    const colors = {
      success: "#10b981", // Tailwind Green-500
      error: "#ef4444", // Tailwind Red-500
      warning: "#f59e0b", // Tailwind Yellow-500
      info: "#3b82f6", // Tailwind Blue-500
    };
    return colors[type] || colors.info;
  }

  // ===== CHOICE CARD ANIMATIONS (if present on the page) =====
  const choiceCards = document.querySelectorAll(".choice-card");
  if (choiceCards) {
    choiceCards.forEach((card) => {
      card.addEventListener("mouseenter", () => {
        card.style.transform = "translateY(-10px) scale(1.02)";
      });

      card.addEventListener("mouseleave", () => {
        card.style.transform = "translateY(0) scale(1)";
      });
    });
  }

  // ===== SMOOTH SCROLLING (if present on the page) =====
  const links = document.querySelectorAll('a[href^="#"]');
  if (links) {
    links.forEach((link) => {
      link.addEventListener("click", (e) => {
        e.preventDefault();
        const targetId = link.getAttribute("href");
        const targetElement = document.querySelector(targetId);

        if (targetElement) {
          targetElement.scrollIntoView({
            behavior: "smooth",
            block: "start",
          });
        }
      });
    });
  }

  // ===== LOADING OVERLAY (not used directly in current submitForm, but kept for utility) =====
  // This part of the JS was previously attempting to handle form submission via Fetch API
  // and then parsing the response to show notifications.
  // The PHP code directly uses `echo "<script>alert(...)</script>";` and `window.location.href`
  // which means the Fetch API approach in JS is largely bypassed for success/error handling.
  // The `submitForm` function has been simplified to just `form.submit();` to align with PHP's direct redirect/alert.
  // The `showLoadingOverlay` and `hideLoadingOverlay` functions are thus less critical for this specific flow,
  // but can be useful for other AJAX interactions.

  function showLoadingOverlay() {
    const overlay = document.createElement("div");
    overlay.className = "loading-overlay";
    overlay.innerHTML = `
            <div class="loading-spinner"></div>
        `;
    document.body.appendChild(overlay);

    setTimeout(() => {
      overlay.classList.add("show");
    }, 10);

    return overlay;
  }

  function hideLoadingOverlay(overlay) {
    overlay.classList.remove("show");
    setTimeout(() => {
      overlay.remove();
    }, 300);
  }

  // ===== ANALYTICS TRACKING =====
  function trackEvent(category, action, label = "") {
    if (typeof gtag !== "undefined") {
      gtag("event", action, {
        event_category: category,
        event_label: label,
      });
    }
    console.log("Event tracked:", { category, action, label });
  }

  // Track form interactions
  document.addEventListener("click", (e) => {
    if (e.target.matches(".choice-btn")) {
      trackEvent(
        "Registration",
        "Choice Selected",
        e.target.textContent.trim()
      );
    }

    if (e.target.matches(".register-btn")) {
      // This event will fire when the button is clicked, BEFORE the form is submitted
      // and the page potentially redirects.
      trackEvent(
        "Registration",
        "Form Submission Initiated",
        window.location.pathname
      );
    }
  });

  // ===== INITIALIZATION COMPLETE =====
  console.log("Registration system initialized successfully!");
});

// ===== PASSWORD TOGGLE FUNCTION (global, as used by onclick attribute) =====
function togglePassword(fieldId) {
  const field = document.getElementById(fieldId);
  const toggle = field.parentNode.querySelector(".password-toggle i");

  if (field.type === "password") {
    field.type = "text";
    toggle.classList.remove("fa-eye");
    toggle.classList.add("fa-eye-slash");
  } else {
    field.type = "password";
    toggle.classList.remove("fa-eye-slash");
    toggle.classList.add("fa-eye");
  }
}

// ===== UTILITY FUNCTIONS (global, as exported to window) =====
function formatCurrency(amount) {
  return new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    minimumFractionDigits: 0,
  }).format(amount);
}

function formatDate(date) {
  return new Intl.DateTimeFormat("id-ID", {
    year: "numeric",
    month: "long",
    day: "numeric",
  }).format(date);
}

// ===== EXPORT FOR MODULE USAGE =====
window.TemuMobilRegister = {
  showNotification,
  trackEvent,
  togglePassword,
  formatCurrency,
  formatDate,
};
