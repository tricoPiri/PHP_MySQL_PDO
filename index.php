<html>
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
<head>
<body>
<div class="container">
    <div class="row">
        <div class="col-4">
        </div>
        <div class="col-4">
            <form style="margin-top:60px;">
                <div class="form-group">
                    <label>Nombre (s):</label>
                    <input type="text" class="form-control" id="nombre" placeholder="Nombre (s)">
                </div>
                <div class="form-group">
                    <label>Apellido paterno:</label>
                    <input type="text" class="form-control" id="paterno" placeholder="Apellido paterno">
                </div>
                <div class="form-group">
                    <label>Apellido materno:</label>
                    <input type="text" class="form-control" id="materno" placeholder="Apellido materno">
                </div>
                <button class="btn btn-primary" id="btnEnviar">Enviar</button>
            </form>    
        </div>
        <div class="col-4">
        </div>
    </div>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido paterno</th>
                <th>Apellido materno</th>
                <th>Eliminar</th>
                <th>Editar</th>
            </tr>
        </thead>
        <tbody id="tbodyAlumnos">
        </tbody>
    </table>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
<script>
    var editar = 0
    var idAlumno = 0

    function limpiar(){
        editar = 0
        idAlumno = 0
        $("#nombre").val('')
        $("#paterno").val('')
        $("#materno").val('')
    }

    function obtenerAlumno(id){
        editar = 1
        idAlumno = id
        $.ajax({
            url: "funciones.php?action=obtenerAlumno",
            data: {'idAlumno' : idAlumno},
            type: "POST",
            success: function (response){
                let objetoAlumno = JSON.parse(response)
                $("#nombre").val(objetoAlumno[0].nombre)
                $("#paterno").val(objetoAlumno[0].paterno)
                $("#materno").val(objetoAlumno[0].materno)
            },
            error: function(response){
                console.log(response)
            }
        })
    }
    
    function eliminar(idAlumno){
        $.ajax({
            url: "funciones.php?action=eliminar",
            data: {'idAlumno' : idAlumno},
            type: "POST",
            success: function (response){
                console.log(response)
                consultar()
            },
            error: function(response){
                console.log(response)
            }
        })
    }

    function consultar(){
        $.ajax({
            url: "funciones.php?action=consultar",
            success: function(response){
                if(response == '0 results'){
                    $("#tbodyAlumnos").html('')    
                }else{
                    let objectoAlumno = JSON.parse(response)
                    let html = ""
                    $.each(objectoAlumno, function(index, value){
                        html += '<tr>'
                        html += '<td>' + value.nombre + '</td>'
                        html += '<td>' + value.paterno + '</td>'
                        html += '<td>' + value.materno + '</td>'
                        html += '<td><button onClick="eliminar('+value.idalumno+')">Eliminar</button></td>'
                        html += '<td><button onClick="obtenerAlumno('+value.idalumno+')">Editar</button></td>'
                        html += '</tr>' 
                    })
                    $("#tbodyAlumnos").html(html)
                }
            },
            error:function(response){
                console.log(response)
            }
        })
    }

    $(document).ready(function(){
        consultar()
        $("#btnEnviar").click(function(e){
            e.preventDefault()
            
            let datos = {
                'idAlumno': idAlumno,
                'nombre'  : $("#nombre").val(),
                'paterno' : $("#paterno").val(),
                'materno' : $("#materno").val(),
                'editar'  : editar
            }
            $.ajax({
                url:  "funciones.php?action=guardar",
                data: {'datos' : datos},
                type: "POST",
                success :function(response){
                    console.log(response)
                    consultar()
                    limpiar()
                },
                error: function(response){
                    console.log(response)
                }
            })
        })
    })
</script>
</body>
</html>