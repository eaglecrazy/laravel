<div class="alert alert-{{ session('alert')['type'] ?? $alert['type'] }} alert-dismissible fade show" role="alert">
    <strong>{{ session('alert')['text'] ?? $alert['text'] }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
