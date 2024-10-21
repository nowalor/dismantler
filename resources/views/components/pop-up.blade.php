<!-- pop-up.blade.php -->
<div class="modal fade" id="infoPopup" tabindex="-1" aria-labelledby="infoPopupLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoPopupLabel">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ $message }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ $closeButton }}</button>
                <a href="/contact" class="btn btn-primary">{{ $contactButton }}</a>
            </div>
        </div>
    </div>
</div>

<!-- CSS for disabling scrolling -->
<style>
    .modal-content {
        max-height: 90vh;
        overflow: hidden;
    }

    body.modal-open {
        overflow: hidden !important;
        padding-right: 0 !important;
    }

    body {
        overflow-x: hidden;
    }
</style>
