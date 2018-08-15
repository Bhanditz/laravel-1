@extends('layout.main')

@section('content')

	<!-- Start Page Content -->
    <div class="row promo-wrapper">
        <div class="col-12">

        	@if($message = Session::get('success'))
	            <div class="alert alert-success">
	                <p>{{ $message }}</p>
	            </div>
		    @endif

            <div class="card">
                <div class="card-body">
                	<div class="header-holder">
	                    <h4 class="card-title pull-left">List of Promos</h4>
	                    <button type="button" class="btn btn-danger pull-right" id="del-btn-chk-promo">Delete</button>
	                    <button type="button" class="btn btn-info pull-right" id="new-btn-promo">Add New</button>
	                </div>
                    <div class="table-responsive">
                        <table id="table-promo" class="table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center remove-sort"><input type="checkbox" class="chkToDel"></th>
                                    <th>Promo</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Raffle Date</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Promo</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Raffle Date</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                            <tbody>
                            	@if($promo->count() > 0)
                                    @foreach($promo as $row)
                                    	<tr>
                                    		<td class="text-center"><input type="checkbox" name="toDelPromo" value="{{ $row->id }}"></td>
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
                                                <button type="button" class="btn btn-info btn-view-promo" value="{{ $row->id }}">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-info btn-edit-promo" value="{{ $row->id }}">
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-del-promo" value="{{ $row->id }}"">
                                                	<i class="fa fa-trash"></i>
                                                </button>
	                                        </td>
	                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End PAge Content -->
	

@endsection