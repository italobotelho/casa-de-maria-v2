@props(['title', 'subtitle', 'actionText' => '', 'actionUrl' => ''])

<div class="d-flex justify-content-between align-items-center mb-4 fade-in-up">
    <div>
        <h1 class="display-5 fw-bold" style="color: #a47d53;">{{ $title }}</h1>
        @if($subtitle)
            <p class="text-muted fs-5">{{ $subtitle }}</p>
        @endif
    </div>
    
    @if($actionText && $actionUrl)
        <div>
            <a href="{{ $actionUrl }}" class="btn btn-primary-custom px-4 py-2 d-flex align-items-center gap-2 rounded-pill">
                <i class="bi bi-plus-circle"></i> {{ $actionText }}
            </a>
        </div>
    @endif
</div>
