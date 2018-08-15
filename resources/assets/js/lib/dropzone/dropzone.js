$(function() {
  
  $('#dropzone').on('dragover', function() {
    $(this).addClass('hover');
  });
  
  $('#dropzone').on('dragleave', function() {
    $(this).removeClass('hover');
  });
  
  $('#dropzone input').on('change', function(e) {
    var file = this.files[0];

    $('#dropzone').removeClass('hover');
    
    if (this.accept && $.inArray(file.type, this.accept.split(/, ?/)) == -1) {
      swal("Error!", "File not allowed. Please upload excel file only.", "error");
      $('#dropzone .img-holder').hide();
      $('#dropzone .text').html('Drop your file here.');
    }
    
    $('#dropzone').addClass('dropped');
    //$('#dropzone img').remove();
    
    if(file.type == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || file.type == 'application/vnd.ms-excel') {
      $('#dropzone .img-holder').show();
      $('#dropzone .text').html(file.name);
    }
    /*if ((/^image\/(gif|png|jpeg)$/i).test(file.type)) {
      var reader = new FileReader(file);

      reader.readAsDataURL(file);
      
      reader.onload = function(e) {
        var data = e.target.result,
            $img = $('<img />').attr('src', data).fadeIn();
        
        $('#dropzone div').html($img);
      };
    } else {
      var ext = file.name.split('.').pop();
      var filename = file.name;
      $('#dropzone div').html(filename);
    }*/

  });

});