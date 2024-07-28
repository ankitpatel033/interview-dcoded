@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row pt-3">
            <div class="col-md-10">
                <h3>Courses</h3>
            </div>
            <div class="col-md-2 text-end">
                <a href="{{ route('courses.create') }}" class="btn btn-sm btn-primary">Create</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @include('messages')
                <table id="course-list" class="table table-hoverable">
                    <thead class="bg-secondary">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Status</th>
                            <th scope="col">Created By</th>
                            <th scope="col">Created At</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {

            var table = $('#course-list').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('courses.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'created_by',
                        name: 'created_by'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
            });
        });

        function editCourse(id) {
            // console.log("{{ route('courses.edit') }}" + id);
            // return false; // to prevent form submission
            window.location.href = "{{ route('courses.edit') }}" + '/' + id;
        }

        function deleteCourse(id) {
            if (confirm('Are you sure you want to delete this course?')) {
                $.ajax({
                    url: '{{ route('courses.destroy') }}' + '/' + id,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        window.location.href = '{{ route('courses.index') }}';
                    }
                });
            } else {
                return false;
            }
        }
    </script>
@endpush
