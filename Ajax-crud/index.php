<?php
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Data</title>
    <!-- Imports -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Css -->
    <link rel="stylesheet" href="style.css">
    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <p id="success"></p>
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-6">
                    <h2>Manage <b>Users</b></h2>
                </div>
                <div class="col-sm-6">
                    <a href="#addEmployeeModal" class="btn btn-success pull-right" data-toggle="modal"><i class="fas fa-plus"></i> <span>Add New User</span></a>
                </div>
            </div>
        </div>
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>NUM</th>
                <th>NAME</th>
                <th>EMAIL</th>
                <th>PHONE</th>
                <th>CITY</th>
                <th>ACTION</th>
            </tr>
            </thead>
            <tbody>

            <?php
            $result = mysqli_query($con,"SELECT * FROM crud");
            // Loop alle data van de database naar pagina
            while($row = mysqli_fetch_array($result)) {
                ?>
                <tr id="<?php echo $row["id"]; ?>">

                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row["name"]; ?></td>
                    <td><?php echo $row["email"]; ?></td>
                    <td><?php echo $row["phone"]; ?></td>
                    <td><?php echo $row["city"]; ?></td>
                    <td>
                        <a href="#editEmployeeModal" class="edit" data-toggle="modal">
                            <!-- Stuur data attributes mee om makkelijk te updaten -->
                            <i class="fas fa-pencil-alt update" data-toggle="tooltip"
                               data-id="<?php echo $row["id"]; ?>"
                               data-name="<?php echo $row["name"]; ?>"
                               data-email="<?php echo $row["email"]; ?>"
                               data-phone="<?php echo $row["phone"]; ?>"
                               data-city="<?php echo $row["city"]; ?>"
                               title="Edit"></i>
                        </a>
                        <!-- Stuur data attributes mee om makkelijk te verwijderen -->
                        <a href="#deleteEmployeeModal" class="delete" data-id="<?php echo $row["id"]; ?>" data-toggle="modal"><i class="fas fa-trash" data-toggle="tooltip"
                                                                                                                                 title="Delete"></i></a>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>

    </div>
</div>
<!-- Create Modal HTML -->
<div id="addEmployeeModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="user_form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Add User</h4>
                    <div class="message_error" id="message_create_error"><i class="fas fa-times" style="margin-right: 5px"></i><span id="message_create_desc_error_text"></span></div>
                    <div class="message_succes" id="message_create_succes"><i class="fas fa-check" style="margin-right: 5px"></i><span id="message_create_desc_succes_text"></span></div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>NAME</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>EMAIL</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>PHONE</label>
                        <input type="phone" id="phone" name="phone" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>CITY</label>
                        <input type="city" id="city" name="city" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" value="1" name="type">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <button type="button" class="btn btn-success" id="btn-add">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Edit Modal HTML -->
<div id="editEmployeeModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="update_form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Edit User</h4>
                    <div class="message_error" id="message_update_error"><i class="fas fa-times" style="margin-right: 5px"></i><span id="message_update_desc_error_text"></span></div>
                    <div class="message_succes" id="message_update_succes"><i class="fas fa-check" style="margin-right: 5px"></i><span id="message_update_desc_succes_text"></span></div>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id_u" name="id" class="form-control" required>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" id="name_u" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" id="email_u" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>PHONE</label>
                        <input type="phone" id="phone_u" name="phone" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>City</label>
                        <input type="city" id="city_u" name="city" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" value="2" name="type">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <button type="button" class="btn btn-info" id="update">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Delete Modal HTML -->
<div id="deleteEmployeeModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h4 class="modal-title">Delete User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id_d" name="id" class="form-control">
                    <p>Are you sure you want to delete these Records?</p>
                    <p class="text-warning"><small>This action cannot be undone.</small></p>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <button type="button" class="btn btn-danger" id="delete">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
<script>
    $(document).on('click','#btn-add',function(e) {
        var data = $("#user_form").serialize();
        $.ajax({
            data: data,
            type: "post",
            url: "save.php",
            success: function(dataResult){
                var dataResult = JSON.parse(dataResult);
                if(dataResult.statusCode==200){
                    // Laat een bericht zien als het is gelukt
                    $('#message_create_succes').attr('style', 'display:block');
                    $('#message_create_desc_succes_text').text('Gebruiker toegevoegd!');

                    setTimeout(
                        function()
                        {
                            // reload pagina
                            $('#addEmployeeModal').modal('hide');
                            location.reload();
                        }, 2000);
                }
                else if(dataResult.statusCode==201){
                    // Laat een bericht zien als het fout is gegaan
                    $('#message_create_error').attr('style', 'display:block');
                    $('#message_create_desc_error_text').text('Er is een fout opgetreden!');
                }
            }
        });
    });
    $(document).on('click','.update',function(e) {
        // Haal data op van attributes
        var id=$(this).attr("data-id");
        var name=$(this).attr("data-name");
        var email=$(this).attr("data-email");
        var phone=$(this).attr("data-phone");
        var city=$(this).attr("data-city");

        $('#id_u').val(id);
        $('#name_u').val(name);
        $('#email_u').val(email);
        $('#phone_u').val(phone);
        $('#city_u').val(city);

    });

    $(document).on('click','#update',function(e) {
        // Refresh het form om alle data op orde te hebben
        var data = $("#update_form").serialize();
        $.ajax({
            data: data,
            type: "post",
            url: "save.php",
            success: function(dataResult){
                var dataResult = JSON.parse(dataResult);
                if(dataResult.statusCode==200){
                    // Laat een bericht zien als het is gelukt
                    $('#message_update_succes').attr('style', 'display:block');
                    $('#message_update_desc_succes_text').text('Gebruiker aangepast!');

                    setTimeout(
                        function()
                        {
                            // reload pagina
                            $('#editEmployeeModal').modal('hide');
                            location.reload();
                        }, 2000);

                }
                else if(dataResult.statusCode==201){
                    // Laat een bericht zien als het fout is gegaan
                    $('#message_update_error').attr('style', 'display:block');
                    $('#message_update_desc_error_text').text('Er is een fout opgetreden!');
                }
            }
        });
    });
    $(document).on("click", ".delete", function() {
        var id=$(this).attr("data-id");
        $('#id_d').val(id);

    });
    $(document).on("click", "#delete", function() {
        $.ajax({
            url: "save.php",
            type: "POST",
            cache: false,
            data:{
                type:3,
                id: $("#id_d").val()
            },
            success: function(dataResult){
                $('#deleteEmployeeModal').modal('hide');
                $("#"+dataResult).remove();

            }
        });
    });
</script>
</html>