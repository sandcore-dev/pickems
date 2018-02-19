<div class="form-group{{ $errors->has($field) ? ' has-error' : '' }}">
    <div class="col-md-6 col-md-offset-4 checkbox">
    	<label>
	        <input type="hidden" name="{{ $field }}" value="0">
	        <input type="checkbox" name="{{ $field }}" value="1"{{ old($field, (isset($value) ? $value : '')) == 1 ? ' checked' : '' }}>
        	@lang($label)
        </label>

        @if ($errors->has($field))
            <span class="help-block">
                <strong>{{ $errors->first($field) }}</strong>
            </span>
        @endif
    </div>
</div>

