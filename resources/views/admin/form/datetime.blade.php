<div class="form-group{{ $errors->has($field . '*') ? ' has-error' : '' }}">
    <label for="{{ $field }}_day" class="col-md-4 control-label">{{ $label }}</label>

    <div class="col-md-6">
    	<div class="row">
    		<div class="col-md-2">
			<input id="{{ $field }}_day" type="number" min="1" max="31" class="form-control" name="{{ $field }}_day" value="{{ old($field . '_day', (isset($value) ? $value->day : '')) }}" required>
		</div>
		<div class="col-md-2">
			<input id="{{ $field }}_month" type="number" min="1" max="12" class="form-control" name="{{ $field }}_month" value="{{ old($field . '_month', (isset($value) ? $value->month : '')) }}" required>
		</div>
		<div class="col-md-3">
			<input id="{{ $field }}_year" type="number" class="form-control" name="{{ $field }}_year" value="{{ old($field . '_year', (isset($value) ? $value->year : '')) }}"{{ isset($year_attributes) ? $year_attributes : '' }}>
		</div>
		<div class="col-md-2">
			<input id="{{ $field }}_hour" type="number" min="0" max="23" class="form-control" name="{{ $field }}_hour" value="{{ old($field . '_hour', (isset($value) ? $value->hour : '')) }}" required>
		</div>
		<div class="col-md-2">
			<input id="{{ $field }}_minute" type="number" min="0" max="59" class="form-control" name="{{ $field }}_minute" value="{{ old($field . '_minute', (isset($value) ? $value->minute : '')) }}" required>
		</div>
	</div>
	
        @if ($errors->has($field . '*'))
            <span class="help-block">
                <strong>{{ $errors->first($field. '*') }}</strong>
            </span>
        @endif
    </div>
</div>

