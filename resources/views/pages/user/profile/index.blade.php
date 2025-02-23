@extends('layout.base')

@section('title-head')
    <title>Profile</title>
@endsection

@section('page-header')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Data Profile
                    </h2>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="row g-0">
            <div class="col-12 col-md-3 border-end">
                <div class="card-body">
                    <h4 class="subheader">Business settings</h4>
                    <div class="list-group list-group-transparent">
                        <a href="{{ route('profile.index') }}"
                            class="list-group-item list-group-item-action d-flex align-items-center active">My Account</a>
                        <a href="#"
                            class="list-group-item list-group-item-action d-flex align-items-center">Plans</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-9 d-flex flex-column">
                <div class="card-body">
                    <h2 class="mb-4">My Account</h2>
                    <h3 class="card-title">Profile Details</h3>
                    <div class="row align-items-center">
                        <div class="col-auto"><span class="avatar avatar-xl"
                                style="background-image: url(./static/avatars/000m.jpg)"></span>
                        </div>
                        <div class="col-auto"><a href="#" class="btn">
                                Change avatar
                            </a></div>
                        <div class="col-auto"><a href="#" class="btn btn-ghost-danger">
                                Delete avatar
                            </a></div>
                    </div>
                    <h3 class="card-title mt-4">Business Profile</h3>
                    <div class="row g-3">
                        <div class="col-md">
                            <div class="form-label">Business Name</div>
                            <input type="text" class="form-control" value="{{ auth()->user()->name }}">
                        </div>
                        <div class="col-md">
                            <div class="form-label">Gender</div>
                            <input type="text" class="form-control" value="{{ auth()->user()->gender->name ?? '' }}">
                        </div>
                        <div class="col-md">
                            <div class="form-label">Group</div>
                            <input type="text" class="form-control" value="{{ auth()->user()->group->name ?? '' }}">
                        </div>
                    </div>
                    <h3 class="card-title mt-4">Email</h3>
                    <p class="card-subtitle">This contact will be shown to others publicly, so choose it carefully.</p>
                    <div>
                        <div class="row g-2">
                            <div class="col-auto">
                                <input type="text" class="form-control w-auto" value="{{ auth()->user()->email ?? '' }}">
                            </div>
                            <div class="col-auto"><a href="#" class="btn">
                                    Change
                                </a></div>
                        </div>
                    </div>
                    <h3 class="card-title mt-4">Password</h3>
                    <p class="card-subtitle">You can set a permanent password if you don't want to use temporary login
                        codes.</p>
                    <div>
                        <a href="#" class="btn">
                            Set new password
                        </a>
                    </div>
                    <h3 class="card-title mt-4">Public profile</h3>
                    <p class="card-subtitle">Making your profile public means that anyone on the Dashkit network will be
                        able to find
                        you.</p>
                    <div>
                        <label class="form-check form-switch form-switch-lg">
                            <input class="form-check-input" type="checkbox">
                            <span class="form-check-label form-check-label-on">You're currently visible</span>
                            <span class="form-check-label form-check-label-off">You're
                                currently invisible</span>
                        </label>
                    </div>
                </div>
                <div class="card-footer bg-transparent mt-auto">
                    <div class="btn-list justify-content-end">
                        <a href="#" class="btn">
                            Cancel
                        </a>
                        <a href="#" class="btn btn-primary">
                            Submit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <!-- Add Modal -->
    <div class="modal modal-blur fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('group.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="modal-header">
                        <h5 class="modal-title">Add New</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label required">Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Input name"
                                autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Code</label>
                            <input type="text" class="form-control" name="code" placeholder="Input code"
                                autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Description</label>
                            <textarea class="form-control" name="description" id="description" rows="4" placeholder="input description"
                                required></textarea>
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
                            <label class="form-label required">Name</label>
                            <input type="text" class="form-control" id="name_edit" name="name"
                                placeholder="Input name" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Code</label>
                            <input type="text" class="form-control" id="code_edit" name="code"
                                placeholder="Input code" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Description</label>
                            <textarea class="form-control" name="description" id="description_edit" rows="4"
                                placeholder="input description" required></textarea>
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
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            $('#editModal').on('show.bs.modal', function(e) {
                var url = $(e.relatedTarget).data('url');
                var name = $(e.relatedTarget).data('name');
                var code = $(e.relatedTarget).data('code');
                var description = $(e.relatedTarget).data('description');

                document.getElementById("editForm").action = url;
                $('#name_edit').val(name);
                $('#code_edit').val(code);
                $('#description_edit').val(description);
            });
        });
    </script>
@endsection
