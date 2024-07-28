<div class="newly-added-question">
    <div class="d-flex justify-content-between">
        <div class="col-md-9">
            <div class="mb-3">
                <label class="form-label">Question</label>
                <input type="text" class="form-control questions" name="questions[]" placeholder="Question">
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <div class="mb-3">
                    <label class="form-label">Question Status</label>
                    <select name="question_statuses[]" class="form-select question_statuses">
                        <option value="">Select</option>
                        <option value="1">Active</option>
                        <option value="0">In-Active</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between">
        <div class="col-md-6">
            <div class="input-group mb-3">
                <div class="input-group-text">
                    <input class="form-check-input mt-0" type="radio" value="1"
                        name="answer[{{ $id }}]" checked>
                </div>
                <input type="text" class="form-control option1" name="option1[]">
            </div>
        </div>
        <div class="col-md-6">
            <div class="input-group">
                <div class="input-group-text">
                    <input class="form-check-input mt-0" type="radio" value="2"
                        name="answer[{{ $id }}]">
                </div>
                <input type="text" class="form-control option2" name="option2[]">
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between">
        <div class="col-md-6">
            <div class="input-group mb-3">
                <div class="input-group-text">
                    <input class="form-check-input mt-0" type="radio" value="3"
                        name="answer[{{ $id }}]">
                </div>
                <input type="text" class="form-control option3" name="option3[]">
            </div>
        </div>
        <div class="col-md-6">
            <div class="input-group">
                <div class="input-group-text">
                    <input class="form-check-input mt-0" type="radio" value="4"
                        name="answer[{{ $id }}]">
                </div>
                <input type="text" class="form-control option4" name="option4[]">
            </div>
        </div>
    </div>
    <button class="btn btn-sm btn-danger mb-4 question-remove" type="button">Remove</button>
</div>
