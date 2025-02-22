    <!-- Modal Delete -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Are you sure to delete this data?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <i class="bx bx-trash me-1 text-danger" style="font-size: 100px"></i>
                    </div>
                    <form id="deleteForm" action="#" method="POST">
                        @csrf
                        @method('delete')
                        <input type="text" name="id" id="id_modal" required hidden>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" form="deleteForm" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
