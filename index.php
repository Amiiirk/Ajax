<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>Ajax Project</title>
</head>

<body>
    <div class="container">

        <!-- Button trigger modal -->
        <button type="button" id="modal-add" class="btn btn-primary mt-5" data-bs-toggle="modal"
            data-bs-target="#exampleModal">
            Add New
        </button>

        <!-- Modal -->

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" id="user-form">
                            <input type="hidden" id="id-user">
                            <label for="">Username :</label>
                            <input type="text" id="username" class="form-control">
                            <span id="username-msg" class="text-danger"></span>
                            <br><br>
                            <label for="">Password :</label>
                            <input type="password" id="password" class="form-control">
                            <span id="password-msg" class="text-danger"></span>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="saveChanges" class="btn btn-primary">Add New User</button>
                        <button type="button" id="updateChanges" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </div>
        <!--Table-->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">username</th>
                    <th scope="col">password</th>
                    <th scope="col">Opration</th>
                </tr>
            </thead>
            <tbody id="list-users">

            </tbody>
        </table>
    </div>
</body>
<script>
$(document).ready(function() {

    //Reset Modal datas
    $('#modal-add').click(function() {

        $('#exampleModalLabel').html('Add New User')

        $('#saveChanges').show()
        $('#updateChanges').hide()

        $('#user-form')[0].reset()
        $('#username').val('')
        $('#password').val('')
        $('#id-user').val('')

        $('#username').css('border', '1px solid #ced4da')
        $('#password').css('border', '1px solid #ced4da')

        $('#username-msg').html('')
        $('#password-msg').html('')
    })

    //Send Ajax Request(fetch data)
    $.ajax({
        url: 'fetchData.php',
        method: 'POST',
        success: function(values) {
            $('#list-users').html(values)
        }
    })

    $('#saveChanges').click(function() {
        var username = $('#username').val()
        var password = $('#password').val()

        //Send Ajax Request(insert)
        if (username != '' && password != '' && password.length > 0 && password.length >= 8) {
            $.ajax({
                url: 'insertData.php',
                method: 'POST',
                data: {
                    username: username,
                    password: password
                },
                success: function(result) {
                    swal("Succcessfully!", "User Added Successfully", "success");
                    //fetch data
                    $.ajax({
                        url: 'fetchData.php',
                        method: 'POST',
                        success: function(values) {
                            $('#list-users').html(values)
                        }
                    })
                }
            })
        }

        //Check Empty Fields and Check Password length
        if (username == '') {
            $('#username').css('border', '1px solid red')
            $('#username-msg').html('This Field Is Required')
        }
        if (password == '') {
            $('#password').css('border', '1px solid red')
            $('#password-msg').html('This Field Is Required')
        }

        if (username != '') {
            $('#username').css('border', '1px solid green')
        }
        if (password != '') {
            if (password.length > 0 && password.length < 8) {
                $('#password').css('border', '1px solid red')
                $('#password-msg').html('At least 8 characters')
            } else {
                $('#password').css('border', '1px solid green')
            }
        }
    })

    //Send Ajax Request(delete)
    $(document).on('click', '#delete-user', function() {
        var id = $(this).val()
        $.ajax({
            url: 'deleteData.php',
            method: 'POST',
            data: {
                id: id
            },
            success: function() {
                swal("Succcessfully!", "User Deleted Successfully", "success");
            }
        })
        //fetch data
        $.ajax({
            url: 'fetchData.php',
            method: 'POST',
            success: function(values) {
                $('#list-users').html(values)
            }
        })
    })

    //Send Ajax Request(edit)
    $(document).on('click', '#edit-user', function() {
        var id = $(this).val()

        //reset form datas
        $('#user-form')[0].reset()
        $('#username').css('border', '1px solid #ced4da')
        $('#password').css('border', '1px solid #ced4da')

        $('#username-msg').html('')
        $('#password-msg').html('')
        $.ajax({
            url: 'fetchColumn.php',
            method: 'POST',
            data: {
                id: id
            },
            success: function(values) {
                var convertJsonToJqueryArray = jQuery.parseJSON(values)
                $('#id-user').val(convertJsonToJqueryArray.id)
                $('#username').val(convertJsonToJqueryArray.username)
                $('#password').val(convertJsonToJqueryArray.password)
                $('#exampleModalLabel').html('Update User : ' + ' ' +
                    convertJsonToJqueryArray
                    .username)
                $('#saveChanges').hide()
                $('#updateChanges').show()
            }
        })
    })

    //Send Ajax Request(update)
    $('#updateChanges').click(function() {
        var id = $('#id-user').val()
        var username = $('#username').val()
        var password = $('#password').val()

        $.ajax({
            url: 'updateData.php',
            method: 'POST',
            data: {
                id: id,
                username: username,
                password: password
            },
            success: function() {
                swal("Succcessfully!", "User Updated Successfully", "success");
                //fetch data
                $.ajax({
                    url: 'fetchData.php',
                    method: 'POST',
                    success: function(values) {
                        $('#list-users').html(values)
                    }
                })
            }
        })
    })
})
</script>

</html>