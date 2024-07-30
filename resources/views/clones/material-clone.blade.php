<div class="newly-added d-flex justify-content-between">
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">Type</label>
            <input type="text" class="form-control material_types"
                name="module[{{ $id }}][material_types][]" placeholder="External Link">
        </div>
    </div>
    <div class="col-md-8">
        <div class="mb-3">
            <label class="form-label">Link</label>
            <input type="text" class="form-control material_links"
                name="module[{{ $id }}][material_links][]" placeholder="https://youtube.com">
        </div>
    </div>
</div>
<div>
    <button class="btn btn-sm btn-danger mb-4 material-remove">Remove</button>
</div>
