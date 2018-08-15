@extends('layout.header')

	
	<!-- Page wrapper  -->
    <div class="page-wrapper">
        <!-- Bread crumb -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-primary">Dashboard</h3> </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
        <!-- End Bread crumb -->
        <!-- Container fluid  -->
        <div class="container-fluid">
			@yield('content')
        </div>
        <!-- End Container fluid  -->

@extends('layout.footer')


<!-- <div class="modal fade" id="modal-edit-promo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="z-index: 9999">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Task Editor</h4>
            </div>
            <div class="modal-body">
                <form id="frmTasks" name="frmTasks" class="form-horizontal" novalidate="">

                    <div class="form-group error">
                        <label for="inputTask" class="col-sm-3 control-label">Task</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control has-error" id="task" name="task" placeholder="Task" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Description</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="description" name="description" placeholder="Description" value="">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-save" value="add">Save changes</button>
            </div>
        </div>
    </div>
</div> -->

@if($promo->count() > 0)
                                    @foreach($promo as $row)
                                        <td>{{ $row->promo }}</td>
                                        <td>
                                            {{ (empty($row->start_date)) ? '---' : \Carbon\Carbon::parse($row->start_date)->format('F d, y') }}
                                        </td>
                                        <td>
                                            {{ (empty($row->end_date)) ? '---' : \Carbon\Carbon::parse($row->end_date)->format('F d, Y') }}
                                        </td>
                                        <td>
                                            {{ (empty($row->raffle_date)) ? '---' : \Carbon\Carbon::parse($row->raffle_date)->format('F d, Y') }}
                                        </td>
                                        <td class="text-center">
                                            @if($row->status === 0)
                                                <span class="label label-danger">Inactive</span>
                                            @else
                                                <span class="label label-success">Active</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('promo.destroy', $row->id) }}" method="POST">
                                                <button type="button" class="btn btn-primary btn-edit-promo" value="{{ $row->id }}">Edit</button>

                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    @endforeach
                                @endif


<div class="modal fade" id="new-modal-promo2" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">New Promo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
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

                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                </form>
            </div>
            <!-- <div class="modal-footer">
                
            </div> -->
        </div>
    </div>
</div>