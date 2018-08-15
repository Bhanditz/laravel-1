$(document).ready(function() {

	var promo_id = 0;
	var prize_id = 0;
	var record_id = 0;
	var record_data_id = 0;
	
	$.ajaxSetup({
		'headers': {
			'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
		}
	});

	$('.datepicker').datepicker({
		format: 'yyyy-mm-dd',
		autoclose: true,
	});

	$('#table-promo, #table-prize, #table-records, #table-file-records').DataTable({
		iDisplayLength: 25,
		dom: 'Bfrtip',
		buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
		columnDefs: [{
			targets: [0, -1, -2],
			orderable: false,
		}],
		fnDrawCallback: function(oSettings) {
			if($(this).find('tr').length < 25) {
				//$('.dataTables_info').hide();
				$('.dataTables_paginate').hide();
			}
		}
	});



	/* modal */
	$('.rty-modal').on('click', '.invisible_btn, .header-modal-wrapper .close2', function() {
		$('.rty-modal form').trigger('reset');
		$('.rty-modal form button[type="submit"]').html('Submit');
		$('.rty-modal form .form-group').each(function() {
			if($(this).hasClass('is-invalid')) {
				$(this).removeClass('is-invalid');
			}
		});
		$('.rty-modal').slideUp(500);
	});

	$('#new-btn-promo').on('click', function() {
		$('#new-modal-promo').slideDown(500);
		$('#new-form-promo #promo-method').val('_save');
	});

	$('#new-btn-prize').on('click', function() {
		$('#modal-prize').slideDown(500);
		$('#form-prize #prize-method').val('_save');
	});



	/* global events */
	$('table thead tr').change('th .chkToDel', function() {
		$('table tbody tr td input[type="checkbox"]').each(function() {
			if($(this).prop('checked') == false && $('table thead tr th .chkToDel').prop('checked') == true) {
				$(this).prop('checked', true);
			} else if($(this).prop('checked') == true && $('table thead tr th .chkToDel').prop('checked') == true) {

			} else {
				$(this).prop('checked', false);
			}
		});
	});



	/* global functions */
	function formatDate(date) {
		if(date != null) {
			var x = new Date(date);
			var d = x.getDate('M');
			var m = x.getMonth();
			var y = x.getFullYear();

			var month = new Array();
			month[0] = "January";
			month[1] = "February";
			month[2] = "March";
			month[3] = "April";
			month[4] = "May";
			month[5] = "June";
			month[6] = "July";
			month[7] = "August";
			month[8] = "September";
			month[9] = "October";
			month[10] = "November";
			month[11] = "December";

			return month[m] + ' ' + d + ', ' + y;
		} else {
			return '---';
		}
	}

	function saveData(url, data, target, modal, form) {
		$.ajax({
			dataType: 'json',
			type: 'POST',
			url: url,              
	        data: data,
		}).done(function(data) {
			if(data.status) {
				target.DataTable().destroy();
				target.find('tbody').html(data.data);
				target.DataTable({
					dom: 'Bfrtip',
					buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
					columnDefs: [{
						targets: [0, -1, -2],
						orderable: false,
					}],
				}).draw();
				modal.find('.body-content .alert.alert-success').removeClass('hide');
				modal.find('.body-content .alert.alert-success').addClass('show');
			} else {
				modal.find('.body-content .alert.alert-danger').removeClass('hide');
				modal.find('.body-content .alert.alert-danger').addClass('show');
			}
			setTimeout(function() {
				modal.find('.body-content .alert.alert-success').removeClass('show');
				modal.find('.body-content .alert.alert-success').addClass('hide');
				modal.find('.body-content .alert.alert-danger').removeClass('show');
				modal.find('.body-content .alert.alert-danger').addClass('hide');
				form.find('button[type="submit"]').html('Submit');
				form.trigger('reset');
				modal.slideUp(500);
			}, 1500);
		});
	}

	function delData(title, url, data, table) {
		swal({
		  	title: "Are you sure?",
			text: "You will not be able to recover " + title,
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Delete",
			cancelButtonText: "Cancel",
			closeOnConfirm: false,
			closeOnCancel: false
		},
		function(isConfirm) {
			if (isConfirm) {
				$('.sweet-alert .sa-button-container .confirm').prepend('<i class="fa fa-spinner fa-spin"></i> ');
				$.ajax({
					dataType: 'json',
					type: 'GET',
					url: url,
					data: data
				}).done(function(data) {
					if(data.status) {
						swal("Deleted!", "File has been deleted.", "success");
						table.DataTable().destroy();
						table.find('tbody').html(data.data);
						table.DataTable({
							dom: 'Bfrtip',
							buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
							columnDefs: [{
								targets: [0, -1, -2],
								orderable: false,
							}],
						}).draw();
					} else {
						swal("Error!", "Something went wrong.", "error");
					}
				});
			} else {
			    swal("Cancelled", "Your file is safe :)", "error");
			}
		});
	}

	function bulkDelData(url, data, table, checkMain, checkboxes) {
		swal({
		  	title: "Are you sure?",
			text: "You will not be able to recover this files",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Delete",
			cancelButtonText: "Cancel",
			closeOnConfirm: false,
			closeOnCancel: false
		},
		function(isConfirm) {
			if (isConfirm) {
				$('.sweet-alert .sa-button-container .confirm').prepend('<i class="fa fa-spinner fa-spin"></i> ');
				$.ajax({
					dataType: 'json',
					type: 'GET',
					url: url,
					data: data
				}).done(function(data) {
					swal("Deleted!", "Files has been deleted.", "success");
					checkMain.prop('checked', false);
					table.DataTable().destroy();
					table.find('tbody').html(data.data);
					table.DataTable({
						dom: 'Bfrtip',
						buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
						columnDefs: [{
							targets: [0, -1, -2],
							orderable: false,
						}],
					}).draw();
				});
			} else {
				swal("Cancelled", "Your file is safe :)", "error");
				checkMain.prop('checked', false);
				checkboxes.each(function() {
					$(this).prop('checked', false);
				});
			}
		});
	}



	/* Promo functionalities */
	$('#new-form-promo').on('submit', function(e) {
		e.preventDefault();
		if( $('#new-form-promo #promo_name').val() == '' ) {
			$('.promo-group').addClass('is-invalid');
			$('#new-form-promo #promo_name').focus();
		} else if( $('#new-form-promo #promo_raffle_date').val() == '' ) {
			$('.raffle-date-group').addClass('is-invalid');
			$('#new-form-promo #promo_raffle_date').focus();
		} else {
			var method = $('#new-form-promo #promo-method').val();
			var url_promo_form = $('#new-form-promo').attr('action');
			var data = $('#new-form-promo').serializeArray();
			$(this).find('button[type="submit"]').prepend('<i class="fa fa-spinner fa-spin"></i> ');

			if(method == '_update') {
				data[data.length] = {name: 'id', value: promo_id};
			}

			saveData(url_promo_form, data, $('.promo-wrapper #table-promo'), $('#new-modal-promo'), $('#new-form-promo'));
		}
	});

	$('.promo-wrapper #table-promo').on('click', '.btn-view-promo', function() {
		var id = $(this).val();
		var target = $('#view-modal-promo .body-content');
		$(this).html('<i class="fa fa-spinner fa-spin"></i>');
		$.ajax({
			dataType: 'json',
			type: 'GET',
			url: 'getpromodata',
			data: {promo_id: id}
		}).done(function(data) {
			if(data.status) {
				$.each(data.data, function(index, value) {
					target.closest('.quote-wrapper').find('.header-modal-wrapper .title-holder h3').html(value.promo);
					target.find('#vp-start-date strong').html(formatDate(value.start_date));
					target.find('#vp-end-date strong').html(formatDate(value.end_date));
					target.find('#vp-raffle-date strong').html(formatDate(value.raffle_date));
					target.find('#vp-mechanics strong').html(value.mechanics);
				});
				$('#view-modal-promo').slideDown(500);
			}
			$('.promo-wrapper #table-promo .btn-view-promo').html('<i class="fa fa-eye"></i>');
		});;
	});

	$('.promo-wrapper #table-promo').on('click', '.btn-edit-promo', function() {
		var id = $(this).val();
		var form = $('#new-modal-promo #new-form-promo');
		$(this).html('<i class="fa fa-spinner fa-spin"></i>');
		$.ajax({
			dataType: 'json',
			type: 'GET',
			url: 'getpromodata',
			data: {promo_id: id}
		}).done(function(data) {
			if(data.status) {
				form.find('#promo-method').val('_update');
				$.each(data.data, function(index, value) {
					promo_id = value.id;
					form.find('#promo_name').val(value.promo);
					form.find('#promo_start_date').val(value.start_date);
					form.find('#promo_end_date').val(value.end_date);
					form.find('#promo_raffle_date').val(value.raffle_date);
					form.find('#promo_mechanics').val(value.mechanics);
				});
				$('#new-modal-promo').slideDown(500);
			}
			$('.promo-wrapper #table-promo .btn-edit-promo').html('<i class="fa fa-pencil"></i>');
		});
	});
	
	$('.promo-wrapper #table-promo').on('click', '.btn-del-promo', function() {
		var id = $(this).val();
		var title = $(this).closest('tr').find('td').eq(1).html();
		var data = {promo_id: id, multiple: 'false'};

		delData(title, 'delpromodata', data, $('.promo-wrapper #table-promo'));
	});

	$('#del-btn-chk-promo').on('click', function() {
		var checked = 0;
		var toDel = [];
		var data = {promo_id: toDel, multiple: 'true'};
		$('#table-promo tbody tr td input[name="toDelPromo"]').each(function() {
			if($(this).prop('checked') == true) {
				checked++;
				toDel.push($(this).val());
			}
		});

		if(checked > 0) {
			bulkDelData('delpromodata', data, $('.promo-wrapper #table-promo'), $('#table-promo thead tr th .chkToDel'), $('#table-promo tbody tr td input[name="toDelPromo"]'));
		} else {
			swal("Error!", "No file has been selected.", "error");
		}
	});



	/* Prize Functionalities */
	$('#form-prize').on('change', '#prize_image', function() {
		var file = this.files[0]
		var imgFile = file.type;
		var match = ["image/jpeg", "image/png", "image/jpg", "image/gif"];
		if( !( (imgFile == match[0]) || (imgFile == match[1]) || (imgFile == match[2]) ) ) {
			swal("Invalid!", "Please select a valid image file", "error");
			$('#form-prize #prize_image').val('');
			return false;
		}
	});

	$('#form-prize').on('submit', function(e) {
		e.preventDefault();
		var form = $('#modal-prize #form-prize');
		var target = $('.prize-wrapper #table-prize');
		var modal = $('#modal-prize');

		if( form.find('#prize_name').val() == '' ) {
			form.find('.prize-group').addClass('is-invalid');
			form.find('#prize_name').focus();
		} else if( form.find('#prize_quantity').val() == '' ) {
			form.find('.quantity-group').addClass('is-invalid');
			form.find('#prize_quantity').focus();
		} else if( form.find('#prize_promo').val() == '' ) {
			form.find('.prize-promo-group').addClass('is-invalid');
			form.find('#prize_promo').focus();
		} else {
			var method = form.find('#prize-method').val();
			var url_prize_form = form.attr('action');
			var img = form.find('#prize_image').val();
			var data = new FormData(this);
			$(this).find('button[type="submit"]').prepend('<i class="fa fa-spinner fa-spin"></i> ');
			
			if(method == '_update') {
				data.append('id', prize_id);
			}

			$.ajax({
				type: 'POST',
				url: url_prize_form,
				data: data,
				contentType: false,
				cache: false,
				processData: false,
				success: function(data) {
					if(data.status) {
						target.DataTable().destroy();
						target.find('tbody').html(data.data);
						target.DataTable({
							dom: 'Bfrtip',
							buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
							columnDefs: [{
								targets: [0, -1, -2],
								orderable: false,
							}],
						}).draw();
						modal.find('.body-content .alert.alert-success').removeClass('hide');
						modal.find('.body-content .alert.alert-success').addClass('show');
					} else {
						modal.find('.body-content .alert.alert-danger').removeClass('hide');
						modal.find('.body-content .alert.alert-danger').addClass('show');
					}
					setTimeout(function() {
						modal.find('.body-content .alert.alert-success').removeClass('show');
						modal.find('.body-content .alert.alert-success').addClass('hide');
						modal.find('.body-content .alert.alert-danger').removeClass('show');
						modal.find('.body-content .alert.alert-danger').addClass('hide');
						form.find('button[type="submit"]').html('Submit');
						form.trigger('reset');
						modal.slideUp(500);
					}, 1500);
				}
			});
		}
	});

	$('.prize-wrapper #table-prize').on('click', '.btn-view-prize', function() {
		var id = $(this).val();
		var target = $('#view-modal-prize .body-content');
		$(this).html('<i class="fa fa-spinner fa-spin"></i>');
		$.ajax({
			dataType: 'json',
			type: 'GET',
			url: 'getprizedata',
			data: {prize_id: id}
		}).done(function(data) {
			if(data.status) {
				var imgsrc = target.find('#vp-image').attr('src');
				$.each(data.data, function(index, value) {
					target.closest('.quote-wrapper').find('.header-modal-wrapper .title-holder h3').html(value.prize);
					target.find('#vp-description strong').html(value.description);
					target.find('#vp-quantity strong').html(value.quantity);
					target.find('#vp-order strong').html(value.prize_order);
					target.find('#vp-promo strong').html(value.promo);
					target.find('#vp-draw-up strong').html((value.draw_up == 0) ? 'No' : 'Yes');

					if( value.image != null ) {
						target.find('#vp-image').attr('src', url_assets + '/uploads/img/' + value.image);
					} else {
						target.find('#vp-image').attr('src', url_assets + '/img/no-image.jpg');
					}
				});
				$('#view-modal-prize').slideDown(500);
			}
			$('.prize-wrapper #table-prize .btn-view-prize').html('<i class="fa fa-eye"></i>');
		});;
	});

	$('.prize-wrapper #table-prize').on('click', '.btn-edit-prize', function() {
		var id = $(this).val();
		var form = $('#modal-prize #form-prize');
		$(this).html('<i class="fa fa-spinner fa-spin"></i>');
		$.ajax({
			dataType: 'json',
			type: 'GET',
			url: 'getprizedata',
			data: {prize_id: id}
		}).done(function(data) {
			if(data.status) {
				form.find('#prize-method').val('_update');
				$.each(data.data, function(index, value) {
					prize_id = value.id;
					form.find('#prize_name').val(value.prize);
					//form.find('#prize_image').val(value.image);
					form.find('#prize_quantity').val(value.quantity);
					form.find('#prize_order').val(value.prize_order);
					form.find('#prize_promo').val(value.promo_id);
					form.find('#prize_description').val(value.description);
				});
				$('#modal-prize').slideDown(500);
			}
			$('.prize-wrapper #table-prize .btn-edit-prize').html('<i class="fa fa-pencil"></i>');
		});
	});
	
	$('.prize-wrapper #table-prize').on('click', '.btn-del-prize', function() {
		var id = $(this).val();
		var title = $(this).closest('tr').find('td').eq(1).html();
		var data = {prize_id: id, multiple: 'false'};

		delData(title, 'delprizedata', data, $('.prize-wrapper #table-prize'));
	});

	$('#del-btn-chk-prize').on('click', function() {
		var checked = 0;
		var toDel = [];
		var data = {prize_id: toDel, multiple: 'true'};
		$('#table-prize tbody tr td input[name="toDelPrize"]').each(function() {
			if($(this).prop('checked') == true) {
				checked++;
				toDel.push($(this).val());
			}
		});

		if(checked > 0) {
			bulkDelData('delprizedata', data, $('.prize-wrapper #table-prize'), $('#table-prize thead tr th .chkToDel'), $('#table-prize tbody tr td input[name="toDelPrize"]'));
		} else {
			swal("Error!", "No file has been selected.", "error");
		}
	});




	/* Records Functionalities */
	$('#view-modal-records').on('click', '.invisible_btn, .header-modal-wrapper .close2', function() {
		var modal = $('#view-modal-records');
		modal.find('.left-col #column-header').html('');
		modal.find('.right-col #col-record-uname').html('');
		modal.find('.right-col #col-record-name').html('');
		modal.find('.right-col #col-record-entries').html('');
		modal.find('.right-col #col-record-others').html('');
	});

	$('.records-wrapper .card').on('click', '#new-btn-records', function() {
		if($('.records-wrapper .upload-holder').hasClass('open')) {
			$(this).html('Add New');
			$(this).addClass('btn-info');
			$(this).removeClass('btn-danger');
			$('.records-wrapper .upload-holder').removeClass('open');
			$('.records-wrapper .upload-holder').slideUp(500);
		} else {
			$(this).html('Close');
			$(this).removeClass('btn-info');
			$(this).addClass('btn-danger');
			$('.records-wrapper .upload-holder').addClass('open');
			$('.records-wrapper .upload-holder').slideDown(500);
		}
	});

	$('#form-records').on('submit', function(e) {
		e.preventDefault();
		var form = $('#form-records');
		if( form.find('#records_promo').val() == '' ) {
			form.find('.promo-group').addClass('is-invalid');
			form.find('#records_promo').focus();
		} else if( form.find('#records_file').val() == '' ) {
			form.find('.input-group').addClass('is-invalid');
		} else {
			var data = new FormData(this);
			var url_records_form = form.attr('action');
			var table = $('.records-wrapper #table-records');
			$(this).find('button[type="submit"]').prepend('<i class="fa fa-spinner fa-spin"></i> ');

			$.ajax({
				type: 'POST',
				url: url_records_form,
				data: data,
				contentType: false,
				cache: false,
				processData: false,
				success: function(data) {
					if(data.status) {
						table.DataTable().destroy();
						table.find('tbody').html(data.data);
						table.DataTable({
							dom: 'Bfrtip',
							buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
							columnDefs: [{
								targets: [0, -1, -2],
								orderable: false,
							}]
						});
						$('.records-wrapper .card #new-btn-records').addClass('btn-info');
						$('.records-wrapper .card #new-btn-records').removeClass('btn-danger');
						$('.records-wrapper .card #new-btn-records').html('Add New');
						$('.records-wrapper .upload-holder').removeClass('open');
						$('.records-wrapper .upload-holder').slideUp(500);
						form.find('#dropzone .img-holder').hide();
						form.find('#dropzone .text').html('Drop your file here.');
						form.trigger('reset');
						swal("Success", "File has been uploaded.", "success");
					} else {
						swal("Error!", "File already exist on the same promo.", "error");
					}
					form.find('button[type="submit"]').html('Upload');
				}
			});
		}
	});
	
	$('.records-wrapper #table-records').on('click', '.btn-del-record', function() {
		var id = $(this).val();
		var title = $(this).closest('tr').find('td').eq(0).html();
		var data = {record_id: id};

		delData(title, 'delrecordsdata', data, $('.records-wrapper #table-records'));
	});

	$('.records-wrapper #table-records').on('click', '.btn-generate-record', function() {
		var id = $(this).val();
		$(this).prepend('<i class="fa fa-spinner fa-spin"></i> ');
		record_id = id;
		$.ajax({
			dataType: 'json',
			type: 'GET',
			url: 'getrecordsdata',
			data: {record_id: id}
		}).done(function(data) {
			if(data.status) {
				var cols = data.data;
				$('#view-modal-records .body-content .left-col #column-holder').html('');
				$.each(data.data, function(index, value) {
					$('#view-modal-records .body-content .left-col #column-holder').append('<div class="col-drag" id="' + index + '" draggable="true"><< <span>' + value + '</span> >></div>');
				});
				$('#view-modal-records').slideDown(500);
			}

			$('.records-wrapper #table-records .btn-generate-record').html('Generate Tickets');
		});
	});

	$('#view-modal-records').on('click', '.btn-generate-tickets', function() {
		var others = [];
		var modal = $('#view-modal-records');
		var table = $('.records-wrapper #table-records');
		if(modal.find('.right-col #col-record-name').is(':empty')) {
			swal('Error!', 'No column has been drop to name box.', 'error');
		} else if(modal.find('.right-col #col-record-entries').is(':empty')) {
			swal('Error!', 'No column has been drop to entries box.', 'error');
		} else {
			var uname = modal.find('.right-col #col-record-uname div span').html();
			var name = modal.find('.right-col #col-record-name div span').html();
			var entries = modal.find('.right-col #col-record-entries div span').html();
			$.each(modal.find('.right-col #col-record-others div'), function() {
				others.push($(this).find('span').html());
			});
			$(this).prepend('<i class="fa fa-spinner fa-spin"></i> ');
			
			$.ajax({
				dataType: 'json',
				type: 'POST',
				url: 'generatetickets',
				data: {record_id: record_id, uname: uname, name: name, entries: entries, others: others}
			}).done(function(data) {
				if(data.status) {
					table.DataTable().destroy();
					table.find('tbody').html(data.data);
					table.DataTable({
						dom: 'Bfrtip',
						buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
						columnDefs: [{
							targets: [0, -1, -2],
							orderable: false,
						}]
					});
					swal('Success', 'Record file has been generated successfully.', 'success');
					modal.slideUp(500);
				} else {
					swal('Error!', 'Something went wrong.', 'error');
				}
				modal.find('.btn-generate-tickets').html('Generate Tickets');
			});
		}
	});

	$('.records-wrapper #table-records').on('click', '.btn-view-record', function() {
		var id = $(this).val();
		record_data_id = id;
		var table = $('.records-wrapper #table-file-records');
		$(this).html('<i class="fa fa-spinner fa-spin"></i>');

		$.ajax({
			dataType: 'json',
			type: 'GET',
			url: 'viewrecordsdata',
			data: {record_id: id}
		}).done(function(data) {
			if(data.status) {
				table.DataTable().destroy();
				table.find('tbody').html(data.data);
				table.DataTable({
					iDisplayLength: 50,
					dom: 'Bfrtip',
					buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
					columnDefs: [{
						targets: [0, -1],
						orderable: false,
					}],
					fnDrawCallback: function(oSettings) {
						if($(this).find('tr').length < 50) {
							//$('.dataTables_info').hide();
							$('.dataTables_paginate').hide();
						}
					}
				});
				$('.records-wrapper .record-table-holder').slideUp(500);
				$('.records-wrapper .record-data-table-holder').slideDown(500);
			}

			$('.records-wrapper #table-records .btn-view-record').html('<i class="fa fa-eye"></i>');
		});
	});

	/* file data records */
	$('.records-wrapper #table-file-records').on('click', '.btn-view-record-meta', function() {
		var id = $(this).val();
		var table = $('.records-wrapper #table-file-records');
		var modal = $('#view-modal-record-meta');
		var title = $(this).closest('tr').find('td').eq(1).html();
		$(this).html('<i class="fa fa-spinner fa-spin"></i>');

		$.ajax({
			dataType: 'json',
			type: 'POST',
			url: 'viewrecordsmetadata',
			data: {fr_id: id}
		}).done(function(data) {
			if(data.status) {
				modal.find('.header-modal-wrapper .title-holder h3').html(title);
				modal.find('.quote-wrapper .body-content').html(data.data);
				modal.slideDown(500);
			}

			table.find('.btn-view-record-meta').html('<i class="fa fa-eye"></i>');
		});
	});

	$('.records-wrapper #table-file-records').on('click', '.btn-del-record-meta', function() {
		var id = $(this).val();
		var title = $(this).closest('tr').find('td').eq(1).html();
		var data = {fr_id: id, record_id: record_data_id, multiple: 'false'};

		delData(title, 'delrecordsmetadata', data, $('.records-wrapper #table-file-records'));
	});

	$('#del-btn-record-file').on('click', function() {
		var checked = 0;
		var toDel = [];
		var data = {fr_id: toDel, record_id: record_data_id, multiple: 'true'};
		$('#table-file-records tbody tr td input[name="toDelRecFile"]').each(function() {
			if($(this).prop('checked') == true) {
				checked++;
				toDel.push($(this).val());
			}
		});

		if(checked > 0) {
			bulkDelData('delrecordsmetadata', data, $('.records-wrapper #table-file-records'), $('#table-file-records thead tr th .chkToDel'), $('#table-file-records tbody tr td input[name="toDelRecFile"]'));
		} else {
			swal("Error!", "No file has been selected.", "error");
		}
	});


});