
<div class="form-group">
	{!! Form::label('Name', 'Nome:') !!}
	{!! Form::text('user[name]', null, ['class'=>'form-control']) !!}
</div>

<div class="form-group">
	{!! Form::label('Email', 'E-mail:') !!}
	{!! Form::text('user[email]', null, ['class'=>'form-control']) !!}
</div>

<div class="form-group">
	{!! Form::label('Phone', 'Fone:') !!}
	{!! Form::text('phone', null, ['class'=>'form-control']) !!}
</div>

<div class="form-group">
	{!! Form::label('Address', 'Endereço:') !!}
	{!! Form::textArea('address', null, ['class'=>'form-control']) !!}
</div>

<div class="form-group">
	{!! Form::label('State', 'Estado:') !!}
	{!! Form::text('state', null, ['class'=>'form-control']) !!}
</div>

<div class="form-group">
	{!! Form::label('City', 'Cidade:') !!}
	{!! Form::text('city', null, ['class'=>'form-control']) !!}
</div>

<div class="form-group">
	{!! Form::label('Zipcode', 'CEP:') !!}
	{!! Form::text('zipcode', null, ['class'=>'form-control']) !!}
</div> 