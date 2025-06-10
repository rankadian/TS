@props([
    'label' => '',
    'name',
    'type' => 'text',
    'required' => false,
    'value' => old($name),
])

<div class="mb-3">
    @if ($label)
        <label for="{{ $name }}" class="form-label">{{ $label }} @if($required)<span class="text-danger">*</span>@endif</label>
    @endif

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ $value }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : '')]) }}
    >

    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
