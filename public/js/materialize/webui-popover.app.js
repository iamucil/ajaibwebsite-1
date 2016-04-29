
        $('.chat-pop-over').webuiPopover({
            placement: 'auto-top',
            padding: false,
            width: '300', //can be set with  number
            //height:'300',//can be set with  number
            height: '400', //can be set with  number
            animation: 'pop',
            trigger: 'click',
            offsetTop: -5, // offset the top of the popover
            multi: true, //allow other popovers in page at same time
            dismissible: true, // if popover can be dismissed by  outside click or escape key
            closeable: true //display close button or not
        });


        setInterval(function() {
            $(".chat-blink").toggleClass("backgroundBlink");
        }, 1500);

 

    $(document).on('click', '.close-box', function() {
        $(this).parent().fadeTo(300, 0, function() {
            $(this).remove();
        });
    });
