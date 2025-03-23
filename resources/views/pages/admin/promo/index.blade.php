@extends('layout.base')

@section('title-head')
    <title>Promo</title>
@endsection

@section('page-header')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Data Promo
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <span class="d-sm-inline">
                            <div class='dropdown'>
                                <button class='btn btn-outline-secondary dropdown-toggle align-text-top'
                                    data-bs-toggle='dropdown'>
                                    Actions
                                </button>
                                <div class='dropdown-menu dropdown-menu-end'>
                                    <a class='dropdown-item' href='#'>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-filter">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M4 4h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414v7l-6 2v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227z" />
                                        </svg>
                                        Filter
                                    </a>
                                    <a class='dropdown-item' href='#'>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-file-arrow-right">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                            <path
                                                d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                            <path d="M9 15h6" />
                                            <path d="M12.5 17.5l2.5 -2.5l-2.5 -2.5" />
                                        </svg>
                                        Export
                                    </a>
                                    <a class='dropdown-item' href='#'>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-file-arrow-left">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                            <path
                                                d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                            <path d="M15 15h-6" />
                                            <path d="M11.5 17.5l-2.5 -2.5l2.5 -2.5" />
                                        </svg>
                                        Import
                                    </a>
                                </div>
                            </div>
                        </span>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#addModal"
                            class="btn btn-primary d-sm-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Add new
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                {{ $dataTable->table(['class' => 'table table-vcenter card-table'], true) }}
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <!-- Add Modal -->
    <div class="modal modal-blur fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('promo.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="modal-header">
                        <h5 class="modal-title">Add New</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label required">Title</label>
                            <input type="text" class="form-control" name="title" placeholder="input title"
                                autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Description</label>
                            <textarea class="form-control" name="description" id="description" rows="4" placeholder="input description"
                                required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Type</label>
                            <select class="form-select" name="type" id="type" required>
                                <option value="" selected disabled>- select option -</option>
                                <option value="image">Image</option>
                                <option value="video">Video</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">File</label>
                            <input type="file" class="form-control" name="file" id="file" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Target</label>
                            <select class="form-select" name="target" id="target" required>
                                <option value="" selected disabled>- select option -</option>
                                <option value="all">All</option>
                                <option value="subscribed">Subscribed</option>
                                <option value="unsubscribed">Unsubscribed</option>
                            </select>
                        </div>
                        <div class="mb-3 row">
                            <div class="mb-3 col-sm-6">
                                <label class="form-label required">Start Date</label>
                                <input type="datetime-local" class="form-control" name="start_date"
                                    placeholder="input start date" required>
                            </div>
                            <div class="mb-3 col-sm-6">
                                <label class="form-label required">End Date</label>
                                <input type="datetime-local" class="form-control" name="end_date"
                                    placeholder="input end date" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Status</label>
                            <select class="form-select" name="status" id="status" required>
                                <option value="" selected disabled>- select option -</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary ms-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Create new
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal modal-blur fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="editForm" action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label required">Title</label>
                            <input type="text" class="form-control" name="title" id="title_edit"
                                placeholder="Input title" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Description</label>
                            <textarea class="form-control" name="description" id="description_edit" rows="4"
                                placeholder="input description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Type</label>
                            <select class="form-select" name="type" id="type_edit" required>
                                <option value="" selected disabled>- select option -</option>
                                <option value="image">Image</option>
                                <option value="video">Video</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">File</label>
                            <a id="file_url" href="#" title="Show file" target="_blank"
                                class="btn btn-warning btn-icon mb-1" aria-label="Tabler">
                                <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24'
                                    viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2'
                                    stroke-linecap='round' stroke-linejoin='round'
                                    class='icon icon-tabler icons-tabler-outline icon-tabler-file'>
                                    <path stroke='none' d='M0 0h24v24H0z' fill='none' />
                                    <path d='M14 3v4a1 1 0 0 0 1 1h4' />
                                    <path d='M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z' />
                                </svg>
                            </a>
                            <input type="file" class="form-control" name="file">
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Target</label>
                            <select class="form-select" name="target" id="target_edit" required>
                                <option value="" selected disabled>- select option -</option>
                                <option value="all">All</option>
                                <option value="subscribed">Subscribed</option>
                                <option value="unsubscribed">Unsubscribed</option>
                            </select>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-sm-6">
                                <label class="form-label required">Start Date</label>
                                <input type="datetime-local" class="form-control" name="start_date"
                                    id="start_date_edit" required>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label required">End Date</label>
                                <input type="datetime-local" class="form-control" name="end_date"
                                    id="end_date_edit" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Status</label>
                            <select class="form-select" name="status" id="status_edit" required>
                                <option value="" selected disabled>- select option -</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary ms-auto">
                            <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'
                                fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round'
                                stroke-linejoin='round' class='icon icon-tabler icons-tabler-outline icon-tabler-pencil'>
                                <path stroke='none' d='M0 0h24v24H0z' fill='none' />
                                <path d='M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4' />
                                <path d='M13.5 6.5l4 4' />
                            </svg>
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- File Modal -->
    <div class="modal modal-blur fade" id="fileModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-status bg-warning"></div>
                <div class="modal-body text-center py-4">
                    <svg xmlns='http://www.w3.org/2000/svg' class="icon mb-2 text-warning icon-lg" width='24'
                        height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2'
                        stroke-linecap='round' stroke-linejoin='round'
                        class='icon icon-tabler icons-tabler-outline icon-tabler-file'>
                        <path stroke='none' d='M0 0h24v24H0z' fill='none' />
                        <path d='M14 3v4a1 1 0 0 0 1 1h4' />
                        <path d='M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z' />
                    </svg>
                    <h3>Are you sure?</h3>
                    <div class="text-secondary">Do you really want to download this File?</div>
                </div>
                <div class="modal-footer">
                    <div class="w-100">
                        <div class="row">
                            <div class="col">
                                <a href="#" class="btn w-100" data-bs-dismiss="modal">
                                    Cancel
                                </a>
                            </div>
                            <div class="col">
                                <a href="#" target="_blank" id="exportURL" class="btn btn-warning w-100">
                                    Download
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End File Modal -->
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush

@section('javascript')
    <script>
        $(document).ready(function() {
            $('#editModal').on('show.bs.modal', function(e) {
                var url = $(e.relatedTarget).data('url');
                var title = $(e.relatedTarget).data('title');
                var description = $(e.relatedTarget).data('description');
                var type = $(e.relatedTarget).data('type');
                var status = $(e.relatedTarget).data('status');
                var target = $(e.relatedTarget).data('target');
                var start_date = $(e.relatedTarget).data('start_date');
                var end_date = $(e.relatedTarget).data('end_date');
                var file_url = $(e.relatedTarget).data('file_url');


                document.getElementById("editForm").action = url;
                $('#title_edit').val(title);
                $('#description_edit').val(description);
                $('#type_edit').val(type);
                $('#status_edit').val(status);
                $('#target_edit').val(target);
                $('#start_date_edit').val(start_date);
                $('#end_date_edit').val(end_date);
                document.getElementById("file_url").href = file_url;
            });

            $('#fileModal').on('show.bs.modal', function(e) {
                var url = $(e.relatedTarget).data('url');

                document.getElementById("exportURL").href = url;
            });
        });
    </script>
@endsection
