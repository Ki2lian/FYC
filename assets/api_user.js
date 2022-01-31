$(document).ready(function(){
    var options = {};
    options.type = "POST";
    options.url = addUserURL;
    options.addUser = true;
    $('.add-user').on('click', function(){
        options.type = "POST";
        options.url = addUserURL;
        options.addUser = true;
        $('#user h1, #user .btn-success').html('Ajouter')
        $('#formAdd input:not(#user__token)').val('')
    });

    $('.table').on('click', '.edit-user', function(){
        options.type = "PUT";
        options.url = editUserURL;
        options.addUser = false;
        $('#user h1, #user .btn-success').html('Modifier')
        index = $(this).parents('tr').index()
        $('#user_email').val(usersArray[index].email)
    });

    $('#formAdd').on('submit', function(e){
        e.preventDefault();
        var data = $(this).serialize();
        if(!options.addUser) data = [$(this).serialize(),$.param({"id": usersArray[index].id})].join('&')

        $.ajax({
            type: options.type,
            url: options.url,
            data,
            dataType: "json",
            success: function(data){
                if(options.addUser){
                    $('.table tbody').append(`
                    <tr>
                        <td>${data.info.email}</td>
                        <td>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-primary me-2 edit-user">Edit</button>
                            <button class="btn btn-danger delete-user">Delete</button>
                        </div>
                        </td>
                    </tr>
                    `)
                    usersArray.push({id: data.info.id, email: data.info.email})
                }else{
                    $('.table tbody tr').eq(index).find('td:first').html(data.info.email)
                    usersArray[index].email = data.info.email
                }
                console.log(data)
            }
        })
    });

    $('.table').on('click', '.delete-user', function(){
        index = $(this).parents('tr').index()
        $.ajax({
            type: "DELETE",
            url: deleteUserURL,
            data: `id=${usersArray[index].id}`,
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