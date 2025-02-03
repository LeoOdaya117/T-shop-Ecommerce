let user_id = null;
$('#addAddressBtn').on('click', function(){
    user_id = $(this).data('user-id');
    $('#createAddressModal').modal('show');

});

$("#UpdateProfileForm").submit(function(e) {
    
    e.preventDefault();
    
    var url = $(this).attr('action'); 
    // Collect the form data
    var formData = new FormData(this); // 'this' refers to the form element

    // Add userId to the form data
    formData.append('user_id', user_id);

    $.ajax({
        type: "POST",
        url: url,
        data: formData,
        processData: false, // Don't process the data
        contentType: false, // Don't set content type
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Dynamically fetch CSRF token
        },
        success: function(response) {
            if(response.success == true) {
                $('#alert-container1').html(`
                    <div class="alert alert-success">
                        ${response.message}
                    </div>
                `);
               
               
            } else {
                $('#alert-container1').html(`
                    <div class="alert alert-danger">
                        Something went wrong. Please try again.
                    </div>
                `);
               
            }
        },
        error: function(xhr, status, error) {
           
            const errors = xhr.responseJSON.errors;
            let errorHtml = '<ul>';
            for (let field in errors) {
                errorHtml += `<li>${errors[field][0]}</li>`;
            }
            errorHtml += '</ul>';
            $('#alert-container1').html(`
                <div class="alert alert-danger">
                    ${errorHtml}
                </div>
            `);
        }
    });
});
$("#createAddressForm").submit(function(e) {
    
    e.preventDefault();
    var url = window.routeUrls.createAddress;

    // Collect the form data
    var formData = new FormData(this); // 'this' refers to the form element

    // Add userId to the form data
    formData.append('user_id', user_id);

    $.ajax({
        type: "POST",
        url: url,
        data: formData,
        processData: false, // Don't process the data
        contentType: false, // Don't set content type
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Dynamically fetch CSRF token
        },
        success: function(response) {
            if(response.success == true) {
                $('#alert-container2').html(`
                    <div class="alert alert-success">
                        ${response.message}
                    </div>
                `);
                console.log(response.address);
                // Ensure response.address is available and contains the id
                if (response.address && response.address.id) {
                    const newAddressHtml = `
                        <div class="col-6 mb-2">
                            <div class="card position-relative">
                                <button class="btn rounded-circle fw-bold text-danger text-end m-2 p-0 delete-address-btn position-absolute top-0 end-0" style="z-index: 10;" data-address-id="${response.address.id}">
                                    <h5>x</h5>
                                </button>
                                <div class="card-body">
                                    <p class="m-0">${response.address.address_line_1},</p>
                                    ${response.address.address_line_2 ? `<p class="m-0">${response.address.address_line_2},</p>` : ''}
                                    <p class="m-0">${response.address.city},</p>
                                    <p class="m-0">${response.address.province} ${response.address.postal_code}</p>
                                    <p class="m-0">${response.address.country}</p>
                                </div>
                            </div>
                        </div>
                    `;
                    // Prepend the new address HTML before the "Add new Address" button
                    $(".row.mt-2").prepend(newAddressHtml); 
                } else {
                    console.log("Address data is missing or malformed.");
                }
               

                $('#createAddressModal').modal('hide');
            } else {
                $('#alert-container2').html(`
                    <div class="alert alert-danger">
                        Something went wrong. Please try again.
                    </div>
                `);
                $('#createAddressModal').modal('hide');
            }
        },
        error: function(xhr, status, error) {
            $('#createAddressModal').modal('hide');
            const errors = xhr.responseJSON.errors;
            let errorHtml = '<ul>';
            for (let field in errors) {
                errorHtml += `<li>${errors[field][0]}</li>`;
            }
            errorHtml += '</ul>';
            $('#alert-container1').html(`
                <div class="alert alert-danger">
                    ${errorHtml}
                </div>
            `);
        }
    });
});

// DELETE ADDRESS
$('.delete-address-btn').on('click', function(){
    const address_id = $(this).data('address-id');
    $.ajax({
        type: "DELETE",
        url: window.routeUrls.deleteAddress,
        data: {
            address_id: address_id,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Dynamically fetch CSRF token
        },
        success: function(response) {
            if (response.success) {
                // Find the card that contains the deleted address and remove it
                $(`button[data-address-id="${address_id}"]`).closest('.col-6').remove();

                // Optionally, show a success message
                $('#alert-container2').html('<div class="alert alert-success">Address deleted successfully.</div>');
            } else {
                // Optionally, show an error message
                $('#alert-container2').html('<div class="alert alert-danger">Failed to delete the address.</div>');
            }
        },
        error: function(xhr, status, error) {
            
            const errors = xhr.responseJSON.errors;
            let errorHtml = '<ul>';
            for (let field in errors) {
                errorHtml += `<li>${errors[field][0]}</li>`;
            }
            errorHtml += '</ul>';
            $('#alert-container1').html(`
                <div class="alert alert-danger">
                    ${errorHtml}
                </div>
            `);
        }
    });
});