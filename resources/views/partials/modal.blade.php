<div class="modal fade" id="{{ $id ?? 'defaultModal' }}" tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $id }}Label">{{ $title ?? 'Default Title' }}</h5>
            </div>
            <div class="modal-body">
                {!! $body ?? 'Default Body Content' !!}
            </div>
            <div class="modal-footer">
                {!! $footer ?? '
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                ' !!}
            </div>
        </div>
    </div>
</div>
