@extends('layout.main')

@section('content')

	<!-- Start Page Content -->
    <div class="row layout-wrapper">
        <div class="col-12">
            <form action="{{ route('layout.store') }}" method="POST" id="form-layout" enctype="multipart/form-data">

                <div class="card">
                    <div class="card-body">


                        <!-- <div class="slot-machine-holder test">
                            <div class="slot-text">
                                <h1></h1>
                            </div>
                        </div> -->
                        <!-- <div class="slot-machine-holder test">
                            <canvas class="slot-text"></canvas>
                        </div> -->
                        <!-- <div class="slot-machine-holder test">
                            <div class="roulette">
                                <div id="indev0">Loading...</div>
                                @for($x = 1; $x < 101; $x++)
                                    <div id="indev{{ $x }}">Fullname {{ $x }}</div>
                                @endfor
                            </div>
                        </div> -->
                        

                    	<div class="header-holder row">
                            <div class="col-md-12">
                                <h4 class="card-title pull-left">Raffle Layout</h4>
                                <!-- <button type="button" class="btn btn-danger pull-right" id="reset-btn-layout">Reset</button> -->
                                <button type="submit" class="btn btn-info pull-right" id="save-btn-layout">Save</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="top-holder">

                                    <div class="row">
                                        <div class="form-group row col-md-5 promo-group">
                                            <label for="layout_promo" class="col-md-3 control-label records-label">Promo:</label>
                                            <div class="col-md-7">
                                                <select class="form-control" name="promo_id" id="layout_promo">
                                                    <option value=""></option>
                                                    @if($promo->count() > 0)
                                                        @foreach($promo as $row)
                                                            <option value="{{ base64_encode($timestamp.$row->id.$randomKey) }}">{{ $row->promo }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <div class="invalid-feedback animated fadeInDown">
                                                    Please select promo
                                                </div>
                                            </div>
                                            <div class="spinner-holder">
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="components-holder hide">

                                                <ul class="nav nav-tabs">
                                                    <li class="active">
                                                        <a href="#general-pane" data-toggle="tab">General</a>
                                                    </li>
                                                    <li>
                                                        <a href="#label-pane" data-toggle="tab">Label</a>
                                                    </li>
                                                    <li>
                                                        <a href="#image-pane" data-toggle="tab">Image</a>
                                                    </li>
                                                    <li>
                                                        <a href="#button-pane" data-toggle="tab">Button</a>
                                                    </li>
                                                    <li>
                                                        <a href="#slot-machine-pane" data-toggle="tab">Slot Machine</a>
                                                    </li>
                                                </ul>

                                                <div class="tab-content">

                                                    <div id="general-pane" class="tab-pane fade in active">
                                                        <label class="control-label">
                                                            <h4>Background:</h4>
                                                        </label>
                                                        <input type="file" name="bg-image" id="bg-image"  accept="image/*">
                                                    </div>

                                                    <div id="label-pane" class="tab-pane fade">
                                                        <div class="form-group row label-group">
                                                            <label class="col-sm-1">Text:</label>
                                                            <div class="col-sm-3">
                                                                <input type="text" name="text-label" id="text-label" class="form-control">
                                                                <div class="invalid-feedback animated fadeInDown">
                                                                    Please input your text label.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-1">Size:</label>
                                                            <div class="col-sm-3">
                                                                <input type="number" min="12" name="text-size" id="text-size" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-1">Color:</label>
                                                            <div class="col-sm-3 input-group colorpicker">
                                                                <input type="text" name="text-color" id="text-color" class="form-control" value="#000">
                                                                <span class="input-group-addon"><i></i></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <button type="button" class="btn btn-info btn-add-label">Add</button>
                                                        </div>
                                                    </div>

                                                    <div id="image-pane" class="tab-pane fade">
                                                        <div class="form-group row">
                                                            <label class="col-sm-1">Upload:</label>
                                                            <div class="col-sm-3 input-group">
                                                                <input type="file" name="layout-image" id="layout-image"  accept="image/*">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <button type="button" class="btn btn-info btn-add-image">Add</button>
                                                        </div>
                                                    </div>

                                                    <div id="button-pane" class="tab-pane fade">
                                                        <div class="form-group row btn-text-group">
                                                            <label class="col-sm-2">Text:</label>
                                                            <div class="col-sm-3 input-group">
                                                                <input type="text" name="btn-text" id="btn-text" class="form-control">
                                                                <div class="invalid-feedback animated fadeInDown">
                                                                    Please input your button text.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row btn-target-group">
                                                            <label class="col-sm-2">Target:</label>
                                                            <div class="col-sm-3 input-group">
                                                                <select class="form-control" name="btn-link" id="btn-link">
                                                                    
                                                                </select>
                                                                <div class="invalid-feedback animated fadeInDown">
                                                                    Please input your button text.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2">Border Radius:</label>
                                                            <div class="col-sm-3 input-group">
                                                                <input type="number" name="btn-bradius" id="btn-bradius" min="1" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2">Text Color:</label>
                                                            <div class="col-sm-3 input-group colorpicker">
                                                                <input type="text" name="btn-txt-color" id="btn-txt-color" class="form-control" value="#000">
                                                                <span class="input-group-addon"><i></i></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2">Background Color:</label>
                                                            <div class="col-sm-3 input-group colorpicker">
                                                                <input type="text" name="btn-bg-color" id="btn-bg-color" class="form-control" value="#000">
                                                                <span class="input-group-addon"><i></i></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <button type="button" class="btn btn-info btn-add-btn">Add</button>
                                                        </div>
                                                    </div>

                                                    <div id="slot-machine-pane" class="tab-pane fade">
                                                        <div class="form-group row">
                                                            <label class="col-sm-2">Type:</label>
                                                            <div class="col-sm-3 input-group">
                                                                <select class="form-control" id="slot-machine-selector">
                                                                    <option value="0">Random Letter</option>
                                                                    <option value="1">Letter Roulette</option>
                                                                    <option value="2">Word Roulette</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2">Display Time:</label>
                                                            <div class="col-sm-3 input-group">
                                                                <select class="form-control" id="display-time">
                                                                    <option value="100"></option>
                                                                    <option value="100">5 seconds</option>
                                                                    <option value="200">10 seconds</option>
                                                                    <option value="300">15 seconds</option>
                                                                    <option value="400">20 seconds</option>
                                                                    <option value="500">25 seconds</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <button type="button" class="btn btn-info btn-add-slot-machine">Add</button>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                    <!-- <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-info">Upload</button>
                                        </div>
                                    </div> -->
                            </div>
                        </div>

                    </div>
                </div>


                <!-- layout view wrapper -->
                <div class="card main-layout-holder hide">
                    <div class="card-body">
                        <div class="inner-holder">
                            
                            

                        </div>
                    </div>
                </div>

                <input type="hidden" name="promo_id" id="promo_id">

            </form>
        </div>
    </div>
    <!-- End PAge Content -->
	

@endsection