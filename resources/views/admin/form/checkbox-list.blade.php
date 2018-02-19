<div class="form-group{{ $errors->has($field) ? ' has-error' : '' }}">
	<label class="col-md-4 control-label">@lang($label)</label>
	
	<?php $value = isset($value) ? $value : ''; ?>

	<div class="col-md-6">
		@foreach( $options as $option_value => $option_label )
			<div class="radio">
				<label>
					<input type="radio" name="{{ $field }}" value="{{ $option_value }}"{{ old($field, $value) == $option_value ? ' checked' : '' }}>
					{{ $option_label }}
				</label>
			</div>
		@endforeach

		@if ($errors->has($field))
			<span class="help-block">
				<strong>{{ $errors->first($field) }}</strong>
			</span>
		@endif
	</div>
</div>
