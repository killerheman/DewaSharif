<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- OverlayScrollbars -->
<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
    crossorigin="anonymous"></script>

<!-- Popper -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    crossorigin="anonymous"></script>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>

<!-- AdminLTE -->
<script src="{{ asset('admin/assets/js/adminlte.js') }}"></script>

<!-- Summernote CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
    $(document).ready(function() {
        const selectors = '#editor, .ckeditor, textarea.editor, textarea[name="description"], textarea[name="banner_description"], textarea[name="answer"]';
        $(selectors).each(function() {
            if (!$(this).data('summernoteInitialized')) {
                $(this).data('summernoteInitialized', true);
                $(this).summernote({
                    placeholder: 'Write content here...',
                    tabsize: 2,
                    height: 180,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ]
                });
            }
        });
    });
</script>


@stack('scripts')