var jQuery = $;
var $ = jQuery;

$(document).ready(function(){
    
    $('.check').click(function(event) {
        
        itemId = String(this.id).split('-')[1]
        
        // console.log(itemId)
        $.ajax({
            url: '/api/item/'+itemId,
            method: 'DELETE',
            success: function(data) {
                itemData = JSON.parse(data)
                document.getElementById('checkItem-'+itemData.id).remove();

            }
        })
    })

    $('#addTodoListButton').click(function(event) {
        $.post(
            "/api/item",
            {
                'message': $('#message').val(),
                'token': document.cookie
            },
            function(data) {
                itemData = JSON.parse(data)
                const item = '<li class="checkbox" id="checkItem-'+itemData.id+'"> \
                    <div> \
                        <label> \
                            <input id="checkItemButton-' + itemData.id + '" class="check" type="checkbox" value="0" />' + itemData.message + '</label> \
                    </div> \
                </li>';

                $('#sortable').append(item);
            }
        );
    })
});

