

$(document).ready(function () {
    // Setup AJAX for CSRF Token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let itemIdToInactivate = null;
    // let productIdForStock = null;

    const inactivateModal = new bootstrap.Modal($('#deleteConfirmationModal')[0]);
    const adjustStockModal = new bootstrap.Modal($('#adjustStockModal')[0]);
    const updateProductModal = new bootstrap.Modal($('#updateProductModal')[0]);

    // Reset checkboxes on page load
    $('.rowCheckbox, #selectAll').prop('checked', false);

    // Toggle Bulk Update/Delete Buttons
    function toggleBulkButtons() {
        const selectedIds = $('.rowCheckbox:checked').map(function () {
            return $(this).data('id');
        }).get();

        if (selectedIds.length > 0) {
            $('#bulkUpdateButton, #bulkDeleteButton').show();
            $('#selectedProductIds').val(JSON.stringify(selectedIds));
        } else {
            $('#bulkUpdateButton, #bulkDeleteButton').hide();
            $('#selectedProductIds').val('');
        }
    }

    // Event listener for "Select All" checkbox
    $('#selectAll').on('click', function () {
        $('.rowCheckbox').prop('checked', $(this).prop('checked'));
        toggleBulkButtons();
    });

    // Event listener for individual row checkboxes
    $('.rowCheckbox').on('change', toggleBulkButtons);

    // Show Update Product Modal
    $('.update-btn').on('click', function () {
        $('#updateProductForm')[0].reset();
        updateProductModal.show();
    });

    // Hide Update Product Modal
    $('#cancelUpdateProduct').on('click', function () {
        updateProductModal.hide();
    });

    // Submit Update Product Form
    $('#updateProductForm').on('submit', function (e) {
        e.preventDefault();

        const url = $(this).attr('action');
        const formData = {
            ids: JSON.parse($('#selectedProductIds').val()),
            category: $(this).find('[name="category"]').val(),
            brand: $(this).find('[name="brand"]').val(),
            status: $(this).find('[name="status"]').val(),
        };

        $.ajax({
            type: 'PUT',
            url: url,
            data: formData,
            success: function (response) {
                if (response.success) {
                    $('#alert-container').html(`<div class="alert alert-success">${response.message}</div>`);
                    location.reload();
                } else {
                    $('#alert-container').html(`<div class="alert alert-danger">${response.message}</div>`);
                }
                updateProductModal.hide();
            },
            error: function (xhr) {
                const errors = xhr.responseJSON.errors;
                let errorHtml = '<ul>';
                $.each(errors, function (key, value) {
                    errorHtml += `<li>${value[0]}</li>`;
                });
                errorHtml += '</ul>';
                $('#alert-container').html(`<div class="alert alert-danger">${errorHtml}</div>`);
                updateProductModal.hide();
            }
        });
    });

    // // Show Adjust Stock Modal
    // $('.adjust-btn').on('click', function () {
    //     $('#adjustStockForm')[0].reset();
    //     productIdForStock = $(this).data('id');
    //     adjustStockModal.show();
    // });

    // // Hide Adjust Stock Modal
    // $('#cancelUpdateStockBtn').on('click', function () {
    //     adjustStockModal.hide();
    // });

    // // Submit Adjust Stock Form
    // $('#adjustStockForm').on('submit', function (e) {
    //     e.preventDefault();

    //     const url = $(this).data('action');
    //     const formData = $(this).serialize() + `&product_id=${productIdForStock}`;

    //     $.ajax({
    //         type: 'PUT',
    //         url: url,
    //         data: formData,
    //         success: function (response) {
    //             if (response.success) {
    //                 $('#alert-container').html(`<div class="alert alert-success">${response.message}</div>`);
    //                 location.reload();
    //             } else {
    //                 $('#alert-container').html(`<div class="alert alert-danger">Something went wrong. Please try again.</div>`);
    //             }
    //             adjustStockModal.hide();
    //         },
    //         error: function (xhr) {
    //             const errors = xhr.responseJSON.errors;
    //             let errorHtml = '<ul>';
    //             $.each(errors, function (key, value) {
    //                 errorHtml += `<li>${value[0]}</li>`;
    //             });
    //             errorHtml += '</ul>';
    //             $('#alert-container').html(`<div class="alert alert-danger">${errorHtml}</div>`);
    //             adjustStockModal.hide();
    //         }
    //     });
    // });

    // Show Inactivate Modal
    $('.delete-btn').on('click', function () {
        itemIdToInactivate = $(this).data('id');
        inactivateModal.show();
    });

    // Hide Inactivate Modal
    $('#cancelDelete').on('click', function () {
        if (itemIdToInactivate) {
            inactivateModal.hide();
        }
    });

    // Confirm Inactivation
    $('#confirmDeleteBtn').on('click', function () {
        if (itemIdToInactivate) {
            $.ajax({
                url: `/admin/product/inactivate/${itemIdToInactivate}`,
                type: 'PUT',
                data: {},
                success: function (result) {
                    $(`#${result.tr}`).slideUp('slow');
                    inactivateModal.hide();
                },
                error: function () {
                    alert('An error occurred while updating the product status.');
                }
            });
        }
    });

    // Filter Dropdown Toggle
    $('#filterBtn').on('click', function () {
        $('#filterDropdown').toggleClass('d-none');
    });

    $('#closeFilterDropdown').on('click', function () {
        $('#filterDropdown').addClass('d-none');
    });

    // Dropdown Toggle
    $('.dropdown-button').on('click', function () {
        $(this).closest('.dropdown').toggleClass('show');
    });

    // Close Dropdown on Outside Click
    $(window).on('click', function (event) {
        if (!$(event.target).hasClass('dropdown-button')) {
            $('.dropdown').removeClass('show');
        }
    });
});


// CREATE PRODUCT BLADE
$('#createProductOpenModal').on('click', function () {
    // console.log('Modal open button clicked');
    $('#createProductConfirmation').modal('show');
});

$('#image-url').on('change', function () {
    const newImageUrl = $(this).val();
    $('#image-container').attr('src', newImageUrl || "{{ asset('assets/image/no-product-image.png') }}");
});

$('#title').on('change', function () {
    const newTitle = $(this).val();
    $('#slug').val(newTitle ? createSlug(newTitle) : '');
});

function createSlug(title) {
    return title
        .trim()
        .toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
        .replace(/\s+/g, '-') // Replace spaces with dashes
        .replace(/-+/g, '-'); // Collapse multiple dashes
}

$('#confirmCreateProduct').on('click', function () {
    const form = $('#createProductForm');
    const formData = new FormData(form[0]);

    $.ajax({
        url: form.attr('action'),
        method: form.attr('method'),
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#alert-container').html(`
                <div class="spinner-border text-primary"></div> Saving...
            `);
        },
        success: function (response) {
            $('#alert-container').html(`
                <div class="alert alert-success">
                    Product updated successfully!
                </div>
            `);
            $('#createProductConfirmation').modal('hide');
            form.trigger('reset');
        },
        error: function (xhr) {
            $('#createProductConfirmation').modal('hide');
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                let errorHtml = '<ul>';
                for (let field in errors) {
                    errorHtml += `<li>${errors[field][0]}</li>`;
                }
                errorHtml += '</ul>';
                $('#alert-container').html(`
                    <div class="alert alert-danger">
                        ${errorHtml}
                    </div>
                `);
            } else {
                $('#alert-container').html(`
                    <div class="alert alert-danger">
                        Something went wrong. Please try again.
                    </div>
                `);
            }
        },
    });
});

//  // EDIT PRODUCT BLADE
// $('document').ready(function () {

//     $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
//     });
//     $('#updateProductOpenModal').on('click', function () {
//         $('#updateConfirmation').modal('show');
//     });
    
//     $('#confirmUpdate').on('click', function () {
//         const form = document.getElementById('productUpdateForm');
//         const formData = new FormData(form);
    
//         $.ajax({
//             url: "{{ route('admin.update.product', ['id' => $productInfo->id]) }}",

//             type: "POST",
//             data: formData,
//             processData: false,
//             contentType: false,
//             success: function (response) {
//                 $('#updateConfirmation').modal('hide');
//                 $('#alert-container').html(`<div class="alert alert-success">Product updated successfully!</div>`);
//             },
//             error: function (xhr) {
//                 $('#updateConfirmation').modal('hide');
//                 if (xhr.status === 422) {
//                     const errors = xhr.responseJSON.errors;
//                     let errorHtml = '<ul>';
//                     for (let field in errors) {
//                         errorHtml += `<li>${errors[field][0]}</li>`;
//                     }
//                     errorHtml += '</ul>';
//                     $('#alert-container').html(`
//                         <div class="alert alert-danger">
//                             ${errorHtml}
//                         </div>
//                     `);
//                 } else {
//                     $('#alert-container').html(`
//                         <div class="alert alert-danger">
//                             Something went wrong. Please try again.
//                         </div>
//                     `);
//                 }
//             }
//         });
//     });
    
//     let productId = null;
//     let variant_id = null;
    
    
//     // Assuming you have a button or link to open the modal
//     $(document).ready(function () {
//         $('.adjust-btn').on('click', function() {
        
//             $('#adjustStockForm')[0].reset(); // Reset form data
//             variantId = this.getAttribute('data-id');
//             productId = this.getAttribute('data-product-id');
//             $('#adjustStockModal').modal('show');
        
//         });
        
//     });
    
    
//     $('#cancelUpdateStockBtn').on('click', function () {
//             $('#adjustStockModal').hide();
        
//     });
    
//     $("#adjustStockForm").submit(function(e) {
//             const url = `{{ route('admin.inventory.stock.update') }}`;
        
//             var form = $(this);
//             var formData = form.serialize(); // Serialize the form data
    
//             // Append product_id to the serialized form data
//             formData += `&product_id=${productId}`;
//             formData += `&variant_id=${variantId}`;
//             e.preventDefault();
//             $.ajax({
//                 type: "PUT",
//                 url: url,
//                 data: formData,
//                 headers: {
//                     'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for security
//                 },
//                 success: function(response) {
//                     if(response.success == true) {
                        
//                         adjustStockModal.hide();
//                         Swal.fire({
//                             title: 'Adjust Stock',
//                             text: 'Are you sure you want to adjust the stock for this variant?',
//                             icon: 'warning',
//                             showCancelButton: true,
//                             confirmButtonText: 'Yes, Adjust it!',
//                             cancelButtonText: 'Cancel',
//                         }).then((result) => {
//                             if (result.isConfirmed) {
//                                 $(`tr[data-variant-id="${variantId}"] .stock-cell`).text(newStock);

//                             }
//                         });
                        
    
//                         // location.reload();
                        
//                     } else {
//                         $('#alert-container').html(`
//                             <div class="alert alert-danger">
//                                 Something went wrong. Please try again.
//                             </div>
//                         `);
//                         adjustStockModal.hide();
//                     }
//                 },
//                 error: function(xhr, status, error) {
//                     adjustStockModal.hide(); // Close the modal on failure
//                     const errors = xhr.responseJSON.errors;
//                     let errorHtml = '<ul>';
//                     for (let field in errors) {
//                         errorHtml += `<li>${errors[field][0]}</li>`;
//                     }
//                     errorHtml += '</ul>';
//                     $('#alert-container').html(`
//                         <div class="alert alert-danger">
//                             ${errorHtml}
//                         </div>
//                     `);
                    
//                 }
                
        
                
//             });
//     });
// });




