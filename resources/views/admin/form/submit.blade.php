<div class="form-group">
	<div class="col-md-8 col-md-offset-4">
		<button type="submit" class="btn btn-{{ isset($context) ? $context: 'primary' }}">
			@lang(trim($slot))
		</button>

		@if( isset($cancel) )
		<a class="btn btn-default" href="{{ $cancel }}">@lang('Cancel')</a>
		@endif
	</div>
</div>

