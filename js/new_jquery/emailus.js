jQuery(document).ready(function($){
    // Variable to store your files
	var files;

	// Add events
	jQuery('input[type=file]').live('change', prepareUpload);
	
        jQuery("#submitfile").live("click",uploadFiles);
	//$('form#fileupload').on('submit', uploadFiles);

	// Grab the files and set them to our variable
	function prepareUpload(event)
	{
		files = event.target.files;
	}

	// Catch the form submit and upload the files
	function uploadFiles(event)
	{
                event.stopPropagation(); // Stop stuff happening
                event.preventDefault(); // Totally stop stuff happening
                jQuery('#resultdiv').empty();
                // START A LOADING SPINNER HERE

                // Create a formdata object and add the files
                var name = jQuery.trim(jQuery('#name').val());
                var topic = jQuery.trim(jQuery('#topic').val());
                var message = jQuery.trim(jQuery('#message').val());
                var email = jQuery.trim(jQuery('#email').val());
                if (name == '' || topic == '' || email == '' || message =='')
                {
                    jQuery('#resultdiv').empty().append('All the fields are mandatory.').show().delay('10000').hide(0);
                    return false;
                }
                emailReg = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
                var valid = emailReg.test(email);
                if (!valid) {
                    jQuery('#resultdiv').empty().append('Please enter valid email address.').show().delay('10000').hide(0);
                    return false;
                }
                var data = new FormData();
                if(files){
                    jQuery.each(files, function(key, value)
                    {
                            data.append(key, value);
                    });
                }
            //    alert(JSON.stringify(data));
                data.append('topic', topic);
                data.append('name', name);
                data.append('message', message);
                data.append('email', email);
                jQuery('#loader').show();
                jQuery('#submitfile').hide();
                jQuery.ajax({
                    url: 'mynewtheme/emailus/sendmail',
                    type: 'POST',
                    data: data,
                    cache: false,
                    dataType: 'json',
                    processData: false, // Don't process the files
                    contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                    success: function(data, textStatus, jqXHR)
                    {
                        if(typeof data.error === 'undefined')
                        {
                                // Success so call function to process the form
                                //submitForm(event, data);
                                jQuery('input,textarea').val('');
                                jQuery('#resultdiv').empty().append('Thanks for submitting your query.').show().delay('10000').hide(0);
                        }
                        else
                        {
                                // Handle errors here
                                jQuery('#resultdiv').empty().append('ERRORS: ' + data.error).show().delay('10000').hide(0);
                              //  console.log('ERRORS: ' + data.error);
                        }
                        jQuery('#loader').hide();
                        jQuery('#submitfile').show();
                    },
                    error: function(jqXHR, textStatus, errorThrown)
                    {
                        // Handle errors here
                       // console.log('ERRORS: ' + textStatus);
                        // STOP LOADING SPINNER
                    }
                });
    }

    function submitForm(event, data)
	{
		// Create a jQuery object from the form
		$form = jQuery(event.target);
		
		// Serialize the form data
		var formData = $form.serialize();
		
		// You should sterilise the file names
		jQuery.each(data.files, function(key, value)
		{
			formData = formData + '&filenames[]=' + value;
		});

		jQuery.ajax({
			url: 'mynewtheme/emailus/sendmail',
            type: 'POST',
            data: formData,
            cache: false,
            dataType: 'json',
            success: function(data, textStatus, jqXHR)
            {
            	if(typeof data.error === 'undefined')
            	{
            		// Success so call function to process the form
            		console.log('SUCCESS: ' + data.success);
            	}
            	else
            	{
            		// Handle errors here
            		console.log('ERRORS: ' + data.error);
            	}
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
            	// Handle errors here
            	console.log('ERRORS: ' + textStatus);
            },
            complete: function()
            {
            	// STOP LOADING SPINNER
            }
		});
	}

       
    });
