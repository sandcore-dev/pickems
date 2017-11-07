<div class="form-group{{ $errors->has($field) ? ' has-error' : '' }}">
    <label for="{{ $field }}" class="col-md-4 control-label">{{ $label }}</label>

    <div class="col-md-6">
        <select id="{{ $field }}" class="form-control" name="{{ $field }}"{{ isset($attributes) ? $attributes : '' }}>
        	@foreach( $options as $option )
			<option value="{{ $option->id }}"{{ old($field, (isset($value) ? $value : '')) == $option->id ? ' selected' : '' }}>{{ $option->name }}</option>
		@endforeach
        </select>

        @if ($errors->has($field))
            <span class="help-block">
                <strong>{{ $errors->first($field) }}</strong>
            </span>
        @endif
    </div>
</div>

