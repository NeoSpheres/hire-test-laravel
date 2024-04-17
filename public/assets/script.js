/*$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
*/
$(document).ready(function (){
    $("#create-todo-btn").click(function (){
        $("#todo-modal #brand_id").val("");
        $("#todo-modal #model_id").html(`<option value="" selected>${""}</option>`);
        $("#todo-modal #user_id").val("");
        $("#todo-modal #color").val("");
        $("#todo-form input, #todo-form textarea, #todo-form select").removeAttr("disabled");
        $("#todo-form button[type=submit]").removeClass("d-none");
        $("#modal-title").text("create car");
        $("#todo-form").attr("action", `${baseUrl}/datatable-cars`);
        $("#hidden-todo-id").remove();
        $("#todo-modal").modal("toggle");
        $.ajax({
            url: `${baseUrl}/generate-matricule`, // L'URL de votre API pour générer un matricule
            type: "GET",
            success: function(response) {
                // Supposer que la réponse contient un champ 'matricule' avec la nouvelle valeur
                $("#todo-modal #matricule").val(response.matricule);
            },
            error: function(error) {
                console.error('Error fetching new matricule:', error);
                // Gérer l'erreur comme il faut, peut-être mettre une valeur par défaut ou afficher un message
            }
        });
    });


    $("#todo-form").validate({
        rules: {
            model_id: {
                required: true,
                minlength: 1,
                maxlength: 50
            },
            user_id: {
                required: false,
                minlength: 1,
                maxlength: 50
            },
            color: {
                required: true,
                minlength: 3,
                maxlength: 50
            },
            matricule: {
                required: true,
                minlength: 3,
                maxlength: 50
            },
        },
        submitHandler: function(form){
            $("#response").empty();
            const formData = $(form).serializeArray();
            const card=$("#hidden-todo-id").val();
            const  methodeType=(card && "PUT") || "POST";
            const  formAction=$(form).attr("action");
            $.ajax({
                url:formAction,
                type:methodeType,
                data:formData,
                beforeSend:function (){
                    console.log('loading ...');
                },
                success: function (response){

                    $("#todo-form")[0].reset();
                    $("#todo-modal").modal("toggle")

                    if(response.status==="success"){
                        $("#response").html(
                            `<div class='alert alert-success alert-dismissible'>
                            ${response.message}
                            <button type='button' class='btn-close' data-dismiss='alert'></button></div>`
                        );
                        // update
                        if(card){
                            $(`#car_${card} td:nth-child(2)`).html( response.car.model_id );
                            $(`#car_${card} td:nth-child(3)`).html( response.car.user_id );
                            $(`#car_${card} td:nth-child(4)`).html( response.car.color );
                            $(`#car_${card} td:nth-child(5)`).html( response.car.matricule );

                        }
                        //create
                        else{
                            $('#todo-table').append(
                                `<tr id="car_${response.car.id}">
                                  <td>${response.car.id}</td>
                                  <td>${response.car.model_id}</td>
                                  <td>${response.car.user_id}</td>
                                  <td>${response.car.color}</td>
                                  <td>${response.car.matricule}</td>
                        <td>
                            <a class="btn btn-info btn-sm btn-view" href="javascript:void(0)" data-id="${response.car.id}">View</a>
                            <a class="btn btn-success btn-sm btn-edit" href="javascript:void(0)" data-id="${response.car.id}">Edit</a>
                            <a class="btn btn-danger btn-sm btn-delete" href="javascript:void(0)" data-id="${response.car.id}">Delete</a>
                        </td>
                         </tr>`
                            );
                        }
                    }
                    else if(response.status==="failed"){
                        $("#response").html(
                            `<div class='alert alert-danger alert-dismissible'>
                            ${response.message}
                            <button type='button' class='btn-close' data-dismiss='alert'></button></div>`
                        );
                    }
                },
                error: function (error){
                    $("#response").html(
                        `<div class='alert alert-danger alert-dismissible'>
            Error during request: ${error.responseText}
            <button type='button' class='btn-close' data-dismiss='alert'></button>
        </div>`
                    );
                }
            });
        }
    });
    $("#todo-table").dataTable();

    // view cars
    $("#todo-table").on("click", ".btn-view", function () {
        const carId= $(this).data('id');
        const mode = "view";
        console.log(carId);
        carId && fetchCar(carId,mode);
    })
    console.log(baseUrl);
    function fetchCar(carId, mode = null) {
        if (carId) {
            $.ajax({
                url: `datatable-cars/${carId}`,
                type: "GET",
                success: function (response) {
                    if (response.status === 'success' && response.car) {
                        const car = response.car;
                        const brand = response.brand;
                        const model = response.model;
                        // Remplir les champs avec les valeurs
                        $("#todo-modal #brand_id").val(brand.id);
                        $("#todo-modal #model_id").html(`<option value="${model.id}" selected>${model.nomModel}</option>`);
                        $("#todo-modal #user_id").val(car.user_id);
                        $("#todo-modal #color").val(car.color);
                        $("#todo-modal #matricule").val(car.matricule);

                        // S'assurer que la liste des modèles est mise à jour
                        loadModels(brand.id, model.id);

                        // Mise à jour du titre et de l'action du formulaire en fonction du mode
                        if (mode === "view") {
                            $("#todo-form input, #todo-form textarea,#todo-form select").attr("disabled", true);
                            $("#todo-form button[type=submit]").addClass("d-none");
                            $("#modal-title").text("car Detail");
                            $("#todo-form").removeAttr("action");
                            ///$("#hidden-todo-id").remove();
                            // ... autres ajustements pour le mode édition
                        } else if (mode === "edit") {
                            $("#todo-form input, #todo-form textarea,#todo-form select").removeAttr("disabled");
                            $("#todo-form button[type=submit]").removeClass("d-none");
                            $("#modal-title").text("update car");
                            $("#todo-form").attr("action", `${baseUrl}/datatable-cars/${car.id}`);
                            $("#todo-form").append(`<input type="hidden" id="hidden-todo-id" name="hidden_todo_id" value="${car.id}"/>`)
                        }

                        // Afficher la modal
                        $("#todo-modal").modal("toggle");
                    }
                },
                error: function (error) {
                    console.error('Error fetching car details:', error);
                }
            });
        }
    }


    // Edit Car
    $("#todo-table").on("click", ".btn-edit", function () {
        const carId= $(this).data('id');
        const mode = "edit";
        carId && fetchCar(carId,mode);
    })
});


