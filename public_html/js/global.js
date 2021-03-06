$(document).ready(function()
{
    // If we're coming from another page, disable the immediate scroll to anchor and then smooth scroll to anchor.'
    setTimeout(function() 
    {
        if (location.hash) 
        {
            window.scrollTo(0, 0);

            // Are we coming from a different peage?
            $(document.body).animate(
            {
                'scrollTop':   $(location.hash).offset().top - $('.navbar-fixed-top').height() - 10
            }, 
            'slow');        
        }
    }, 
    1);
    
    var options = 
    { 
        beforeSubmit:  showRequest,  // pre-submit callback 
        success:       showResponse,  // post-submit callback 
        dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
    }; 

    // bind to the form's submit event 
    $('.form-submit').submit(function() 
    { 
        // inside event callbacks 'this' is the DOM element so we first 
        // wrap it in a jQuery object and then invoke ajaxSubmit 

        $(this).ajaxSubmit(options); 

        // !!! Important !!! 
        // always return false to prevent standard browser submit and page navigation 
        return false; 
    }); 
});

// pre-submit callback 
function showRequest(formData, jqForm, options) 
{ 
    $('#error-banner').hide();
    var $pass = true;

    // jqForm is a jQuery object encapsulating the form element.  To access the 
    // DOM element for the form do this: 
     var formElement = jqForm[0]; 
     
    if (jqForm.data('validate_options') != null)
    {
        jqForm.validate(jqForm.data('validate_options'));
        $pass = jqForm.valid();
    }        

    if ($pass)
        jqForm.find('button[type=submit]').attr('disabled','disabled');
    
    return $pass; 
} 

// post-submit callback 
function showResponse(responseText, statusText, xhr, $form)  
{
    // Houston we got a problem
    if (responseText.Error != null)
    {
        jQuery('html,body').animate({scrollTop:0},0);
        $('#error-banner').fadeIn("slow");
        $('span#error-message').text(responseText.Error.Message);
        $form.find('button[type=submit]').removeAttr('disabled');
    }
    
    else
        customResponseHandler(responseText);
}

function getURLParameter(name) 
{
    name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");  
    var regexS = "[\\?&]"+name+"=([^&#]*)";  
    var regex = new RegExp( regexS );  
    var results = regex.exec( window.location.href ); 
    if( results == null )    return "";  
    else    return results[1];
}

function customResponseHandler(responseText)  
{ 
    window.location = responseText.URL;
} 

