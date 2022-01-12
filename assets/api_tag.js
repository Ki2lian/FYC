$(document).ready(function(){
    $('#formAdd').on('submit', function(e){
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
            type: "POST",
            url: urlAPI,
            data,
            dataType: "json",
            success: function(data){
                console.log(data)
            }
        })
    });
});