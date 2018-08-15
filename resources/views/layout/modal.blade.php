<!-- ./promo -->
<section class="rty-modal" id="new-modal-promo">
    <div class="invisible_btn"></div>

    <div class="container quote-wrapper">

    	<div class="header-modal-wrapper">
            <div class="title-holder">
                 <h3>New Promo</h3>
            </div>
            <a href="#" class="close2">|X|</a>
        </div>

        <div class="col-md-12 body-content">
            <!-- alert message -->
			<div class="alert alert-success fade hide">
				<strong><i class="fa fa-check-circle"></i> Success</strong>
				<p>Data successfully saved.</p>
			</div>
			<div class="alert alert-danger fade hide">
				<strong><i class="fa fa-exclamation-circle"></i> Error!</strong>
				<p>Error saving file</p>
			</div>

			<form class="form-valide" id="new-form-promo" action="{{ route('promo.store') }}" method="POST" novalidate="novalidate">
				@csrf

				<div class="form-group row promo-group">
					<label class="col-sm-12">
						Promo <span class="text-danger">*</span>
					</label>
					<div class="col-sm-12">
						<input type="text" name="promo" id="promo_name" class="form-control" aria-required="true" aria-describedby="promo_name_error" aria-invalid="true">
						<div id="promo_name_error" class="invalid-feedback animated fadeInDown">
							Please enter a promo name
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label for="promo_start_date" class="col-sm-12 control-label">Start Date</label>
					<div class="col-sm-12">
						<div class="input-group">
							<input type="text" name="start_date" id="promo_start_date" class="form-control datepicker">
	                        <span class="input-group-icon">
	                            <i class="fa fa-calendar" aria-hidden="true"></i>
	                        </span>
	                    </div>
					</div>
				</div>

				<div class="form-group row">
					<label for="promo_end_date" class="col-sm-12 control-label">End Date</label>
					<div class="col-sm-12">
						<div class="input-group">
							<input type="text" name="end_date" id="promo_end_date" class="form-control datepicker">
	                        <span class="input-group-icon">
	                            <i class="fa fa-calendar" aria-hidden="true"></i>
	                        </span>
	                    </div>
					</div>
				</div>

				<div class="form-group row raffle-date-group">
					<label for="promo_raffle_date" class="col-sm-12 control-label">
						Raffle Date <span class="text-danger">*</span>
					</label>
					<div class="col-sm-12">
						<div class="input-group">
							<input type="text" name="raffle_date" id="promo_raffle_date" class="form-control datepicker" aria-required="true" aria-describedby="promo_name_error" aria-invalid="true">
	                        <span class="input-group-icon">
	                            <i class="fa fa-calendar" aria-hidden="true"></i>
	                        </span>
							<div id="promo_name_error" class="invalid-feedback animated fadeInDown">
								Please enter raffle date
							</div>
	                    </div>
					</div>
				</div>

				<div class="form-group row">
					<label for="promo_mechanics" class="col-sm-12 control-label">Mechanics</label>
					<div class="col-sm-12">
						<textarea class="form-control" rows="5" name="mechanics" id="promo_mechanics"></textarea>
					</div>
				</div>

				<input type="hidden" name="method" id="promo-method" value="_save">

				<div class="col-md-12 text-center">
					<button type="submit" class="btn btn-info">Submit</button>
				</div>

			</form>
        </div>
        
    </div>
</section>

<section class="rty-modal" id="view-modal-promo">
    <div class="invisible_btn"></div>

    <div class="container quote-wrapper">

    	<div class="header-modal-wrapper">
            <div class="title-holder">
                 <h3>Promo</h3>
            </div>
            <a href="#" class="close2">|X|</a>
        </div>

        <div class="col-md-12 body-content">
            <div class="form-horizontal p-t-20">
            	<div class="form-group row">
            		<label class="col-sm-3 control-label"><h4>Start Date:</h4></label>
            		<label class="col-sm-9 control-label"><h4 id="vp-start-date"><strong></strong></h4></label>
            	</div>
            	<div class="form-group row">
            		<label class="col-sm-3 control-label"><h4>End Date:</h4></label>
            		<label class="col-sm-9 control-label"><h4 id="vp-end-date"><strong></strong></h4></label>
            	</div>
            	<div class="form-group row">
            		<label class="col-sm-3 control-label"><h4>Raffle Date:</h4></label>
            		<label class="col-sm-9 control-label"><h4 id="vp-raffle-date"><strong></strong></h4></label>
            	</div>
            	<div class="form-group row">
            		<label class="col-sm-3 control-label"><h4>Mechanics:</h4></label>
            		<label class="col-sm-9 control-label"><h4 id="vp-mechanics"><strong></strong></h4></label>
            	</div>
            </div>
        </div>
        
    </div>
</section>


<!-- ./prize -->
<section class="rty-modal" id="modal-prize">
    <div class="invisible_btn"></div>

    <div class="container quote-wrapper">

    	<div class="header-modal-wrapper">
            <div class="title-holder">
                 <h3>New Prize</h3>
            </div>
            <a href="#" class="close2">|X|</a>
        </div>

        <div class="col-md-12 body-content">
            <!-- alert message -->
			<div class="alert alert-success fade hide">
				<strong><i class="fa fa-check-circle"></i> Success</strong>
				<p>Data successfully saved.</p>
			</div>
			<div class="alert alert-danger fade hide">
				<strong><i class="fa fa-exclamation-circle"></i> Error!</strong>
				<p>Error saving file</p>
			</div>

			<form class="form-valide" id="form-prize" action="{{ route('prize.store') }}" method="POST" enctype="multipart/form-data">
				@csrf

				<div class="form-group row prize-group">
					<label class="col-sm-12">
						Prize <span class="text-danger">*</span>
					</label>
					<div class="col-sm-12">
						<input type="text" name="prize" id="prize_name" class="form-control">
						<div class="invalid-feedback animated fadeInDown">
							Please enter a prize name
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label for="prize_image" class="col-sm-12 control-label">Image</label>
					<div class="col-sm-12">
						<input type="file" name="image" id="prize_image" class="form-control">
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group row quantity-group">
							<label for="prize_quantity" class="col-sm-12 control-label">Quantity</label>
							<div class="col-sm-12">
								<input type="number" name="quantity" min="1" id="prize_quantity" class="form-control">
								<div class="invalid-feedback animated fadeInDown">
									Please enter quantity
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group row">
							<label for="prize_order" class="col-sm-12 control-label">Order</label>
							<div class="col-sm-12">
								<input type="number" name="prize_order" min="1" id="prize_order" class="form-control">
							</div>
						</div>
					</div>
				</div>

				<div class="form-group row prize-promo-group">
					<label for="prize_promo" class="col-sm-12 control-label">
						Promo <span class="text-danger">*</span>
					</label>
					<div class="col-sm-12">
						<select class="form-control" name="promo_id" id="prize_promo">
							<option value=""></option>
							@if($promo->count() > 0)
								@foreach($promo as $row)
									<option value="{{ $row->id }}">{{ $row->promo }}</option>
								@endforeach
							@endif
						</select>
						<div class="invalid-feedback animated fadeInDown">
							Please select promo
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label for="prize_mechanics" class="col-sm-12 control-label">Description</label>
					<div class="col-sm-12">
						<textarea class="form-control" rows="5" name="description" id="prize_description"></textarea>
					</div>
				</div>

				<input type="hidden" name="method" id="prize-method" value="_save">

				<div class="col-md-12 text-center">
					<button type="submit" class="btn btn-info">Submit</button>
				</div>

			</form>
        </div>
        
    </div>
</section>

<section class="rty-modal" id="view-modal-prize">
    <div class="invisible_btn"></div>

    <div class="container quote-wrapper">

    	<div class="header-modal-wrapper">
            <div class="title-holder">
                 <h3>Prize</h3>
            </div>
            <a href="#" class="close2">|X|</a>
        </div>

        <div class="col-md-12 body-content">
            <div class="form-horizontal p-t-20">
            	<div class="form-group row">
            		<label class="col-sm-2 control-label"><h4>Description:</h4></label>
            		<label class="col-sm-10 control-label"><h4 id="vp-description"><strong></strong></h4></label>
            	</div>
            	<div class="form-group row">
            		<label class="col-sm-2 control-label"><h4>Image:</h4></label>
            		<label class="col-sm-10 control-label"><img src="{{ asset('resources/assets/img/no-image.jpg') }}" id="vp-image"></label>
            	</div>


            	<div class="row">
            		<div class="col-md-6">
            			<div class="form-group row">
		            		<label class="col-sm-4 control-label"><h4>Quantity:</h4></label>
		            		<label class="col-sm-8 control-label"><h4 id="vp-quantity"><strong></strong></h4></label>
		            	</div>
            		</div>
            		<div class="col-md-6">
            			<div class="form-group row">
		            		<label class="col-sm-4 control-label"><h4>Order:</h4></label>
		            		<label class="col-sm-8 control-label"><h4 id="vp-order"><strong></strong></h4></label>
		            	</div>
            		</div>
            	</div>
            	
            	
            	<div class="row">
            		<div class="col-md-6">
		            	<div class="form-group row">
		            		<label class="col-sm-4 control-label"><h4>Promo:</h4></label>
		            		<label class="col-sm-8 control-label"><h4 id="vp-promo"><strong></strong></h4></label>
		            	</div>
            		</div>
            		<div class="col-md-6">
		            	<div class="form-group row">
		            		<label class="col-sm-4 control-label"><h4>Draw Up:</h4></label>
		            		<label class="col-sm-8 control-label"><h4 id="vp-draw-up"><strong></strong></h4></label>
		            	</div>
            		</div>
            	</div>


            </div>
        </div>
        
    </div>
</section>


<!-- ./generate tickets -->
<section class="rty-modal" id="view-modal-records">
    <div class="invisible_btn"></div>

    <div class="container quote-wrapper">

    	<div class="header-modal-wrapper">
            <div class="title-holder">
                 <h3>Records Columns</h3>
            </div>
            <a href="#" class="close2">|X|</a>
        </div>

        <div class="col-md-12 body-content">
        	<div class="row">
        		<div class="col-md-12">
        			<h4 class="text-center">Drag column name to specified label</h4>
        		</div>
        	</div>
            <div class="row">
            	<div class="col-md-6 left-col">
            		<label class="col-md-12 text-center">Excel Columns</label>
            		<div id="column-holder" data-drop-target="true">
            			
            		</div>
            	</div>
            	<div class="col-md-6 right-col">
            		<label class="col-md-12 text-center">Tickets Data</label>
            		<div class="col-record uname-group">
            			<label>Username/Code:</label>
            			<div id="col-record-uname" class="dropzone" data-drop-target="true"></div>
            		</div>
            		<div class="col-record name-group">
            			<label>Name:</label>
            			<div id="col-record-name" class="dropzone" data-drop-target="true"></div>
            		</div>
            		<div class="col-record entries-group">
            			<label>Entries:</label>
            			<div id="col-record-entries" class="dropzone" data-drop-target="true"></div>
            		</div>
            		<div class="col-record entries-group">
            			<label>Other Info:</label>
            			<div id="col-record-others" class="dropzone" data-drop-target="true"></div>
            		</div>
            	</div>
            </div>
            <div class="row p-t-30">
            	<div class="col-md-12 text-center">
            		<button type="button" class="btn btn-info btn-generate-tickets">Generate Tickets</button>
            	</div>
            </div>
        </div>
        
    </div>
</section>


<!-- ./view record meta data -->
<section class="rty-modal" id="view-modal-record-meta">
    <div class="invisible_btn"></div>

    <div class="container quote-wrapper">

    	<div class="header-modal-wrapper">
            <div class="title-holder">
                 <h3>Record Data</h3>
            </div>
            <a href="#" class="close2">|X|</a>
        </div>

        <div class="col-md-12 body-content">
            
        </div>
        
    </div>
</section>