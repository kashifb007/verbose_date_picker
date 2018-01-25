$(function() {
      $( "#datepicker" ).datepicker({
        showOn: "button",
        constrainInput: false,
        dateFormat: 'dd-mm-yy'
      });

      $('button.ui-datepicker-trigger').remove();

      $("#calendar").click(function() 
      {
      	$("#datepicker").datepicker("show");
    	});
  	});