@extends('promo.layout')

@section('content')
	
	<div class="row">
		<div class="col-lg-12 margin-tb">
			<div class="pull-left">
				<h2>Add New Promo</h2>
			</div>
			<div class="pull-right">
				<a href="{{ route('promo.index') }}" class="btn btn-primary">Back</a>
			</div>
		</div>
	</div>

	@if($errors->any())
		<div class="alert alert-danger">
			<strong>Whoops!</strong> There were some problems with your input.<br><br>
			<ul>
				@foreach($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	<div class="row">
		<form action="{{ route('promo.store') }}" method="POST">
			@csrf

			<div class="col-md-12">
				<div class="form-group">
					<label class="form-label">Promo</label>
					<input type="text" name="promo" class="form-control" placeholder="Promo Name">
				</div>
			</div>

			<div class="col-md-4">
				<div class="form-group">
					<label>Start Date</label>
					<div class="input-group">
                        <input class="form-control datepicker" name="start_date" type="text"  />
                        <span class="input-group-btn">
                            <button class="btn" type="button">
                            	<i class="fa fa-calendar" aria-hidden="true"></i>
                            </button>
                        </span>
                    </div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="form-group">
					<label>End Date</label>
					<div class="input-group">
                        <input class="form-control datepicker" name="end_date" type="text"  />
                        <span class="input-group-btn">
                            <button class="btn" type="button">
                            	<i class="fa fa-calendar" aria-hidden="true"></i>
                            </button>
                        </span>
                    </div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="form-group">
					<label>Raffle Date</label>
					<div class="input-group">
                        <input class="form-control datepicker" name="raffle_date" type="text"  />
                        <span class="input-group-btn">
                            <button class="btn" type="button">
                            	<i class="fa fa-calendar" aria-hidden="true"></i>
                            </button>
                        </span>
                    </div>
				</div>
			</div>

			<div class="col-md-12">
				<div class="form-group">
					<label>Mechanics</label>
					<textarea class="form-control" rows="5" name="mechanics"></textarea>
				</div>
			</div>

			<div class="col-md-12">
				<button type="submit" class="btn btn-primary text-center">Submit</button>
			</div>

		</form>
	</div>

@endsection