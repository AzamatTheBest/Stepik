const commentURL = '/getComments';
let deleteMessage = $('.message_delete');
$(document)
    .on('click', '#send_message', function (e) {
        e.preventDefault();
        let form = $(this).closest('form');
        let formData = form.serialize();
        let input = form.find('input#message_text');
        $('.replyToMessage').val('');
        input.val('');
        toggleReplyBlock();
        $.ajax({
            url: commentURL,
            method: 'POST',
            data: formData,
            success: function(data) {
                drawMessage(data);
            }
        });
    })
    .on('click', '.reply-to-btn', function(e) {
        const messageId = $(this).closest('.chat-message').data('message-id');
        $('.replyToMessage').val(messageId);
        const messageText = $(this).next().text();
        toggleReplyBlock(messageText);
    });

    function drawMessage(message)
    {
       
    
        let prototypeClass = 'message-to-me-prototype'; 
        if (message.sender != null && message.sender.id == currentUser) {
            prototypeClass = 'message-from-me-prototype';
        }
    
        let prototype = $('.' + prototypeClass).clone();
        prototype.removeClass(prototypeClass);
        prototype.data('message-id', message.id);
        prototype.attr('data-message-id', message.id);
        prototype.find('p.message-text').text(message.text);
    
    }

$(document)
     .on('click', deleteMessage, function (e){
       let message = $(this).closest('.chat-message');
       message.remove();
     })