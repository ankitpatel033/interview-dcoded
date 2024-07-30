@extends('layouts.app')

@section('content')
    <div class="container">
        <form id="course-create-form">
            <div class="justify-content-center">
                <div class="card">
                    <div class="card-header">{{ __('Create Course') }}</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control" name="course_title"
                                        placeholder="Course Title">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="course_status" class="form-select">
                                        <option value="">Select Status</option>
                                        <option value="1">Active</option>
                                        <option value="0">In-Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="3" placeholder="Couse Description" name="course_description"></textarea>
                        </div>
                    </div>
                </div>
                <div class="module-root">
                    <div class="modules">
                        <div class="card mt-3 border-2px">
                            <div class="card-body">
                                <div class="accordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                                                aria-controls="collapseOne">
                                                New Module
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse show"
                                            aria-labelledby="headingOne">
                                            <div class="row mt-3 mx-2">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Module Title</label>
                                                        <input type="text" class="form-control module_title"
                                                            name="module[0][module_title]" placeholder="Module Title">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label class="form-label">Module Status</label>
                                                        <select class="form-select module_status"
                                                            name="module[0][module_status]">
                                                            <option value="">Select Status</option>
                                                            <option value="1">Active</option>
                                                            <option value="0">In-Active</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label class="form-label">Is Testable</label>
                                                        <select name="module[0][is_testable]"
                                                            class="form-select is_testable">
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
                                                            name="module[0][module_description]"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mx-2 module_materials">
                                                <div class="d-flex justify-content-between">
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Type</label>
                                                            <input type="text" class="form-control material_types"
                                                                name="module[0][material_types][]"
                                                                placeholder="External Link">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="mb-3">
                                                            <label class="form-label">Link</label>
                                                            <input type="text" class="form-control material_links"
                                                                name="module[0][material_links][]"
                                                                placeholder="https://youtube.com">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-sm btn-primary mx-4 mb-4 add-material" type="button"
                                                data-index="0">Add
                                                Material</button>
                                            <div class="custom-div">
                                                <div class="row mx-2">
                                                    <div class="col-md-8">
                                                        <div class="mb-3">
                                                            <label class="form-label">Course Test Title</label>
                                                            <input type="text" class="form-control course_test_title"
                                                                name="module[0][course_test_title]"
                                                                placeholder="Course Test Title">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Duration</label>
                                                            <input type="text" class="form-control duration"
                                                                name="module[0][duration]" placeholder="Duration">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mx-2">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Instructions</label>
                                                            <textarea class="form-control instruction" rows="3" placeholder="Competitive Exam"
                                                                name="module[0][instruction]"></textarea>
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
                                                                        name="module[0][questions][]"
                                                                        placeholder="Question">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="mb-3">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Question Status</label>
                                                                        <select name="module[0][question_statuses][]"
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
                                                                        <input class="form-check-input mt-0"
                                                                            type="radio" value="1"
                                                                            name="module[0][answer][0]" checked>
                                                                    </div>
                                                                    <input type="text" class="form-control option1"
                                                                        name="module[0][option1][0]">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="input-group">
                                                                    <div class="input-group-text">
                                                                        <input class="form-check-input mt-0"
                                                                            type="radio" value="2"
                                                                            name="module[0][answer][0]">
                                                                    </div>
                                                                    <input type="text" class="form-control option2"
                                                                        name="module[0][option2][0]">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-text">
                                                                        <input class="form-check-input mt-0"
                                                                            type="radio" value="3"
                                                                            name="module[0][answer][0]">
                                                                    </div>
                                                                    <input type="text" class="form-control option3"
                                                                        name="module[0][option3][0]">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="input-group">
                                                                    <div class="input-group-text">
                                                                        <input class="form-check-input mt-0"
                                                                            type="radio" value="4"
                                                                            name="module[0][answer][0]">
                                                                    </div>
                                                                    <input type="text" class="form-control option4"
                                                                        name="module[0][option4][0]">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button class="btn btn-sm btn-primary mx-4 mb-4 add-question"
                                                    type="button" data-index="0">Add
                                                    Question</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-primary add-module mt-2">Add Module</button>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <button class="mt-4 btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('js')
    <script>
        $('.is_testable').change(function() {
            let elm = $(this).parents('.collapse').find('.custom-div');
            if ($(this).val() == 0) {
                elm.addClass('d-none');
            } else {
                elm.removeClass('d-none');
            }
        });
        $(document).ready(function() {
            $(document).on('click', '.add-module', function() {
                let moduleIndex = $('.module-root').children().length;
                $.ajax({
                    url: '{{ route('clone.module') }}' + '/' + (moduleIndex),
                    type: 'GET',
                    success: function(response) {
                        $('.module-root').append(response.html);
                    }
                });
            });

            $(document).on('click', '.add-material', function() {
                let elm = $(this).parents('.collapse').find('.module_materials');
                $.ajax({
                    url: '{{ route('clone.material') }}' + '/' + $(this).data('index'),
                    type: 'GET',
                    success: function(response) {
                        elm.append(response.html);
                    }
                });
            });

            $(document).on('click', '.add-question', function() {
                let elm = $(this).parents('.collapse').find('.module_questions');
                let answerIndex = $(this).parent('').find('.module_questions').children().length;
                $.ajax({
                    url: '{{ route('clone.question') }}' + '/' + $(this).data('index') + '/' +
                        answerIndex,
                    type: 'GET',
                    success: function(response) {
                        elm.append(response.html);
                    }
                });
            });

            $(document).on('click', '.module-remove-btn', function() {
                let elm = $(this).closest('.modules');
                elm.remove();
            });

            $(document).on('click', '.material-remove', function() {
                $(this).parent().prev().remove();
                $(this).remove();
            });

            $(document).on('click', '.question-remove', function() {
                $(this).closest('.newly-added-question').remove();
            });

            $.validator.addClassRules("module_description", {
                required: true
            });
            $.validator.addClassRules("module_status", {
                required: true
            });
            $.validator.addClassRules("module_title", {
                required: true
            });
            $.validator.addClassRules("material_types", {
                required: true
            });
            $.validator.addClassRules("material_links", {
                required: true
            });

            $('#course-create-form').validate({
                errorClass: 'error-class',
                rules: {
                    course_title: {
                        required: true
                    },
                    course_status: {
                        required: true
                    },
                    course_description: {
                        required: true
                    }
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: '{{ route('courses.store') }}',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: new FormData(form),
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response.success == false) {
                                alert(response.errors);
                                return false;
                            } else {
                                window.location.href = "{{ route('courses.index') }}";
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush
