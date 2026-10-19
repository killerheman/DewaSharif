<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: '{{ session('success') }}',
        confirmButtonColor: '#198754'
    });
});
</script>
@endif

@if(session('error'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '{{ session('error') }}',
        confirmButtonColor: '#dc3545'
    });
});
</script>
@endif

@if(isset($errors) && $errors->any())
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: 'error',
        title: 'Validation Error',
        html: `{!! implode('<br>', $errors->all()) !!}`,
        confirmButtonColor: '#dc3545'
    });
});
</script>
@endif