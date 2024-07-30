<div class="modules">
    <div class="card mt-3 border-2px">
        <div class="card-body">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne{{ $id }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne{{ $id }}" aria-expanded="true"
                            aria-controls="collapseOne{{ $id }}">
                            New Module
                        </button>
                    </h2>
                    <button class="btn btn-sm btn-danger module-remove-btn" type="button">
                        <i class="fa fa-trash"></i>
                    </button>
                    <div id="collapseOne{{ $id }}" class="accordion-collapse collapse show"
                        aria-labelledby="headingOne{{ $id }}">
                        <div class="row mt-3 mx-2">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Module Title</label>
                                    <input type="text" class="form-control module_title"
                                        name="module[{{ $id }}][module_title]" placeholder="Module Title">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Module Status</label>
                                    <select class="form-select module_status" name="module[{{ $id }}][module_status]">
                                        <option value="">Select Status</option>
                                        <option value="1">Active</option>
                                        <option value="0">In-Active</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Is Testable</label>
                                    <select name="module[{{ $id }}][is_testable]" class="form-select is_testable">
                                        <option value="">Select</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mx-2">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control module_description" rows="3" placeholder="Description"
                                        name="module[{{ $id }}][module_description]"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mx-2 module_materials">
                            <div class="d-flex justify-content-between">
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
                        </div>
                        <button class="btn btn-sm btn-primary mx-4 mb-4 add-material" type="button" data-index="{{ $id }}">Add
                            Material</button>
                        <div class="custom-div">
                            <div class="row mx-2">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label class="form-label">Course Test Title</label>
                                        <input type="text" class="form-control course_test_title"
                                            name="module[{{ $id }}][course_test_title]" placeholder="Course Test Title">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Duration</label>
                                        <input type="text" class="form-control duration" name="module[{{ $id }}][duration]"
                                            placeholder="Duration">
                                    </div>
                                </div>
                            </div>
                            <div class="row mx-2">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Instructions</label>
                                        <textarea class="form-control instruction" rows="3" placeholder="Competitive Exam" name="module[{{ $id }}][instruction]"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mx-2 module_questions">
                                <div>
                                    <div class="d-flex justify-content-between">
                                        <div class="col-md-9">
                                            <div class="mb-3">
                                                <label class="form-label">Question</label>
                                                <input type="text" class="form-control questions"
                                                    name="module[{{ $id }}][questions][]" placeholder="Question">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <div class="mb-3">
                                                    <label class="form-label">Question Status</label>
                                                    <select name="module[{{ $id }}][question_statuses][]"
                                                        class="form-select question_statuses">
                                                        <option value="">Select</option>
                                                        <option value="1">Active</option>
                                                        <option value="0">In-Active</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-group mb-3">
                                                <div class="input-group-text">
                                                    <input class="form-check-input mt-0" type="radio"
                                                        value="1" name="module[{{ $id }}][answer][0]" checked>
                                                </div>
                                                <input type="text" class="form-control option1"
                                                    name="module[{{ $id }}][option1][]">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-text">
                                                    <input class="form-check-input mt-0" type="radio"
                                                        value="2" name="module[{{ $id }}][answer][0]">
                                                </div>
                                                <input type="text" class="form-control option2"
                                                    name="module[{{ $id }}][option2][]">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group mb-3">
                                                <div class="input-group-text">
                                                    <input class="form-check-input mt-0" type="radio"
                                                        value="3" name="module[{{ $id }}][answer][0]">
                                                </div>
                                                <input type="text" class="form-control option3"
                                                    name="module[{{ $id }}][option3][]">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-text">
                                                    <input class="form-check-input mt-0" type="radio"
                                                        value="4" name="module[{{ $id }}][answer][0]">
                                                </div>
                                                <input type="text" class="form-control option4"
                                                    name="module[{{ $id }}][option4][]">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-sm btn-primary mx-4 mb-4 add-question" type="button" data-index="{{ $id }}">Add
                                Question</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
