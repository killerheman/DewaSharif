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

<!-- Universal Password Visibility Toggle Script -->
<script>
    $(document).on('click', '.toggle-password-btn', function (e) {
        e.preventDefault();
        var targetId = $(this).attr('data-target');
        var $input = targetId ? $('#' + targetId) : $(this).closest('.input-group, .input-box-inner, .form-group, .input-field').find('input[type="password"], input[type="text"]');
        if ($input.length) {
            var isPass = $input.attr('type') === 'password';
            $input.attr('type', isPass ? 'text' : 'password');

            var $icon = $(this).find('i');
            if ($icon.length) {
                if ($icon.hasClass('bi-eye')) {
                    $icon.removeClass('bi-eye').addClass('bi-eye-slash');
                } else if ($icon.hasClass('bi-eye-slash')) {
                    $icon.removeClass('bi-eye-slash').addClass('bi-eye');
                } else if ($icon.hasClass('fa-eye')) {
                    $icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else if ($icon.hasClass('fa-eye-slash')) {
                    $icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            }
        }
    });
</script>

@stack('scripts')