function route(routeUrl) {
    window.location.href = routeUrl;
}

function toggleFilters() {
    const filterContainer = document.querySelector('.filter-container');
    filterContainer.style.display = filterContainer.style.display === 'block' ? 'none' : 'block';
}


document.getElementById('apply-filters-btn').addEventListener('click', applyFilters);
document.getElementById('reset-filters-btn').addEventListener('click', resetFilters);

function applyFilters() {
    let categories = document.querySelectorAll('input[name="category[]"]:checked');
    let brands = document.querySelectorAll('input[name="brand[]"]:checked');
    let sizes = document.querySelectorAll('input[name="size[]"]:checked');
    let priceRange = document.querySelectorAll('input[name="price_range[]"]:checked');
    let searchInput = document.getElementById('search');

    let queryString = '';

    if (categories.length > 0) {
        categories.forEach(category => {
            queryString += `category[]=${category.value}&`;
        });
    }

    if (brands.length > 0) {
        brands.forEach(brand => {
            queryString += `brand[]=${brand.value}&`;
        });
    }

    if (sizes.length > 0) {
        sizes.forEach(size => {
            queryString += `size[]=${size.value}&`;
        });
    }

    if (priceRange.length > 0) {
        priceRange.forEach(price => {
            queryString += `price_range[]=${price.value}&`;
        });
    }

    if (searchInput && searchInput.value.trim() !== '') {
        queryString += `search=${encodeURIComponent(searchInput.value)}&`;
    }

    queryString = queryString.endsWith('&') ? queryString.slice(0, -1) : queryString;

    window.location.href = '/shop?' + queryString;
}

function resetFilters() {
    let checkboxes = document.querySelectorAll('.form-check-input');
    checkboxes.forEach(checkbox => checkbox.checked = false);

    let searchInput = document.getElementById('search');
    if (searchInput) searchInput.value = '';

    window.location.href = '/shop';
}


// Listen for the apply filter button click
document.getElementById('apply-filters-btn').addEventListener('click', applyFilters);

// Function to pre-select filters based on the URL query parameters
function setSelectedFilters() {
    const urlParams = new URLSearchParams(window.location.search);

    // For search term
    const searchTerm = urlParams.get('search');
    if (searchTerm) {
        document.getElementById('search').value = searchTerm;
    }

    // Retain other filters (category, brand, size, price range)
    const selectedCategories = urlParams.getAll('category[]');
    selectedCategories.forEach(categoryId => {
        document.querySelectorAll(`input[name="category[]"][value="${categoryId}"]`).forEach(input => {
            input.checked = true;
        });
    });

    const selectedBrands = urlParams.getAll('brand[]');
    selectedBrands.forEach(brandId => {
        document.querySelectorAll(`input[name="brand[]"][value="${brandId}"]`).forEach(input => {
            input.checked = true;
        });
    });

    const selectedSizes = urlParams.getAll('size[]');
    selectedSizes.forEach(sizeId => {
        document.querySelectorAll(`input[name="size[]"][value="${sizeId}"]`).forEach(input => {
            input.checked = true;
        });
    });

    const selectedPriceRanges = urlParams.getAll('price_range[]');
    selectedPriceRanges.forEach(priceRange => {
        document.querySelectorAll(`input[name="price_range[]"][value="${priceRange}"]`).forEach(input => {
            input.checked = true;
        });
    });
}

window.onload = setSelectedFilters;



document.getElementById('search-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission

    let formAction = this.action; // Get form action URL
    let searchValue = document.getElementById('search').value.trim();
    let urlParams = new URLSearchParams(window.location.search);

    // Keep existing filters in the query string
    if (searchValue !== '') {
        urlParams.set('search', searchValue);
    } else {
        urlParams.delete('search');
    }

    window.location.href = formAction + '?' + urlParams.toString();
});


