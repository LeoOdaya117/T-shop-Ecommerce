// Add CSRF token to all AJAX requests globally
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function() {

    // Handle sending OTP
    $("#sendOtpForm").submit(function(event) {
        event.preventDefault();
        console.log("Sending OTP...");
        let email = $("#email").val();
        let btn = $("#sendOtpBtn");
        btn.prop("disabled", true).text("Sending...");

        $.ajax({
            url: window.routeUrls.sendOtp,
            type: "POST",
            data: { email: email},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Dynamically fetch CSRF token
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: response.message,
                    toast: true,
                    position: 'center-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
                $("#otpEmail").val(email);
                $("#emailForm").addClass("d-none");
                $("#otpForm").removeClass("d-none");
            },
            error: function(xhr) {
                $("#alert-container1").fadeOut(100, function () {
                    $(this).html(`<div class="alert alert-danger">${xhr.responseJSON.message || "Invalid OTP."}</div>`).fadeIn(200);
                });
            },
            complete: function() {
                btn.prop("disabled", false).text("Send OTP");
            }
        });
    });

    // Handle OTP Verification
    $("#verifyOtpForm").submit(function(event) {
        event.preventDefault();
        let email = $("#otpEmail").val();
        let otp = $("#otp").val();
        let btn = $("#verifyOtpBtn");
        btn.prop("disabled", true).text("Verifying...");

        $.ajax({
            url: window.routeUrls.verifyOtp,
            type: "POST",
            data: { email: email, otp: otp},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Dynamically fetch CSRF token
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: response.message,
                    toast: true,
                    position: 'center-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
                $("#resetEmail").val(email);
                $("#resetOtp").val(otp);
                $("#otpForm").addClass("d-none");
                $("#resetPasswordForm").removeClass("d-none");
            },
            error: function(xhr) {
                $("#alert-container2").fadeOut(100, function () {
                    $(this).html(`<div class="alert alert-danger">${xhr.responseJSON.message || "Invalid OTP."}</div>`).fadeIn(200);
                });
            },
            complete: function() {
                btn.prop("disabled", false).text("Verify OTP");
            }
        });
    });

    // Handle Password Reset
    $("#resetPasswordForm").submit(function(event) {
        event.preventDefault();
        let formData = $(this).serialize();
        let btn = $("#resetPasswordBtn");
        btn.prop("disabled", true).text("Updating...");

        $.ajax({
            url: window.routeUrls.resetPassword,
            type: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Dynamically fetch CSRF token
            },
            success: function(response) {
                $("#alert-container3").html(`<div class="alert alert-success">${response.message}</div>`);
                setTimeout(() => {
                    window.location.href = window.routeUrls.login;
                }, 2000);
            },
            error: function(xhr) {
                $("#alert-container3").html(`<div class="alert alert-danger">${xhr.responseJSON.message || "Error updating password."}</div>`);
            },
            complete: function() {
                btn.prop("disabled", false).text("Update Password");
            }
        });
    });

});