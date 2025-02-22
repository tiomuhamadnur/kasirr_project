<script>
    $(document).ready(function() {
        $('#deleteModal').on('show.bs.modal', function(e) {
            var url = $(e.relatedTarget).data('url');

            document.getElementById("deleteForm").action = url;
        });

        $('#exportModal').on('show.bs.modal', function(e) {
            var url = $(e.relatedTarget).data('url');

            document.getElementById("exportForm").action = url;
        });

        function exportExcel() {
            $('#datatable-excel').click();
            console.log('klik');
        }
    })
</script>

<script>
    @if (session('notify'))
        swal("Yeheeey!", "{{ session('notify') ?? '-' }}", "success");
    @elseif (session('notifyerror'))
        swal("Ooopss!", "{{ session('notifyerror') ?? '-' }}", "error");
    @elseif ($errors->any())
        @php
            $messageError = implode('<br>', $errors->all());
        @endphp
        swal("Ooopss!", "{{ $messageError }}", "error");
    @endif
</script>
