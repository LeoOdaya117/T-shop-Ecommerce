<form method="POST" id="updateProductForm" action="{{ route('admin.update.selected.products') }}">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="inputText3" class="col-form-label">Status</label>
        <select name="status" class="form-control rounded-pill mb-2">
            <option  disabled selected>Select Status</option>
            <option value="active" >Active</option>
            <option value="inactive" >Inactive</option>
        </select>
    </div>
    
     <div class="form-group">
        <label for="inputText3" class="col-form-label">Category</label>
        <select name="category" class="form-control rounded-pill mb-2">
            <option selected disabled>Select Category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}"> {{ $category->name }}</option>
                    
               
            @endforeach
            
        </select>
    </div>
    <div class="form-group">
        <label for="inputText3" class="col-form-label">Brand</label>
        <select name="brand" class="form-control rounded-pill mb-2">
            <option selected disabled>Select Category</option>
            @foreach ($brands as $brand)
                <option value="{{ $brand->id }}"> {{ $brand->name }}</option>
                    
               
            @endforeach
            
        </select>
    </div>
    <input type="hidden" id="selectedProductIds" name="ids" value="">

    <div class="d-flex justify-content-end align-items-end">
        <button type="button" class="btn btn-secondary mx-1" id="cancelUpdateProduct">Cancel</button>
        <button type="submit" class="btn btn-danger" id="updateStockBtn">Update</button>
    </div>
    
   
</form>