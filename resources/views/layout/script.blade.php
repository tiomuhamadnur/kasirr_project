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
        Swal.fire({
            title: "Yeheeey!",
            icon: "success",
            text: "{{ session('notify') ?? '-' }}",
            draggable: true
        });
    @elseif (session('notifyerror'))
        Swal.fire({
            icon: "error",
            title: "Ooopss!",
            text: "{{ session('notifyerror') ?? '-' }}",
        });
    @elseif ($errors->any())
        @php
            $messageError = implode('<br>', $errors->all());
        @endphp
        Swal.fire({
            icon: "error",
            title: "Ooopss!",
            text: "{{ $messageError }}",
        });
    @endif
</script>
