<style>
    .container {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
        margin: 20px 0;
        max-width: 500px
    }

    .exists {
        width: 10px;
        height: 10px;
        background-color: #48bb78;
        border-radius: 50%;
    }

    .not-exists {
        width: 10px;
        height: 10px;
        background-color: #f56565;
        border-radius: 50%;
    }
</style>

@php
    /** @var \Spatie\Permission\Models\Role $role */
    $role = $getState();
@endphp

<div class="container">
    @foreach ($permissions as $permission)
        @if ($permission->guard_name !== $role?->guard_name)
            @php
                continue;
            @endphp
        @endif

        <span class="{{ $role?->permissions->contains($permission->id) ? 'exists' : 'not-exists' }}"
            title="{{ $permission->name }}"></span>
    @endforeach
</div>
