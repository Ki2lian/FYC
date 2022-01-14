$(document).ready(function(){
    var options = {};
    options.type = "POST";
    options.url = addTagURL;
    options.addTag = true;
    $('.add-tag').on('click', function(){
        options.type = "POST";
        options.url = addTagURL;
        options.addTag = true;
        $('#tag h1, #tag .btn-success').html('Ajouter')
        $('#formAdd input:not(#tag__token)').val('')
    });

    $('.table').on('click', '.edit-tag', function(){
        options.type = "PUT";
        options.url = editTagURL;
        options.addTag = false;
        $('#tag h1, #tag .btn-success').html('Modifier')
        index = $(this).parents('tr').index()
        $('#tag_name').val(tagsArray[index].name)
    });

    $('#formAdd').on('submit', function(e){
        e.preventDefault();
        var data = $(this).serialize();
        if(!options.addTag) data = [$(this).serialize(),$.param({"id": tagsArray[index].id})].join('&')

        $.ajax({
            type: options.type,
            url: options.url,
            data,
            dataType: "json",
            success: function(data){
                if(options.addTag){
                    $('.table tbody').append(`
                    <tr>
                        <td>${data.info.name}</td>
                        <td>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-primary me-2 edit-tag">Edit</button>
                            <button class="btn btn-danger delete-tag">Delete</button>
                        </div>
                        </td>
                    </tr>
                    `)
                    tagsArray.push({id: data.info.id, name: data.info.name})
                }else{
                    $('.table tbody tr').eq(index).find('td:first').html(data.info.name)
                    tagsArray[index].name = data.info.name
                }
                console.log(data)
            }
        })
    });

    $('.table').on('click', '.delete-tag', function(){
        index = $(this).parents('tr').index()
        $.ajax({
            type: "DELETE",
            url: deleteTagURL,
            data: `id=${tagsArray[index].id}`,
            dataType: "json",
            success: function(data){
                $('.table tbody tr').eq(index).fadeOut(500, function(){
                    $('.table tbody tr').eq(index).remove()
                })
                console.log(data)

            }
        })
    })
});