$('#search').on('input', function() {
    let search = this.value;
    if(search.length > 2){
        $.post('ajax.php', {search: search}, function(data){
            $('.ajax_response').html(data);
        })
    } else {
        $('.ajax_response').html('');
    }
})

