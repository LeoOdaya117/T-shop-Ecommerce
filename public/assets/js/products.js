function createSlug(title){

    return title.replace(/ /g,"-").toLowerCase();
}
function generateSKU(category, color, size, brand, productId) {
    const sku = `${category.toUpperCase()}-${color.toUpperCase()}-${size.toUpperCase()}-${brand.toUpperCase()}-${productId}`;
    return sku;
}