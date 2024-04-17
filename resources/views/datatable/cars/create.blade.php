<div class="modal fade" id="todo-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('datatable-cars.store') }}" method="POST" id="todo-form">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Add New Car</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group py-2">
                        <label for="brand_id">Brand:</label>
                        <select id="brand_id" name="brand_id" class="form-control" onchange="loadModels(this.value)">
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group py-2">
                        <label for="model_id">Model:</label>
                        <select id="model_id" name="model_id" class="form-control">
                            <option value="">Select a Model</option>
                        </select>
                    </div>
                    <div class="form-group py-2">
                        <label for="user_id">Owner:</label>
                        <select id="user_id" name="user_id" class="form-control">
                            <option value="">Select an Owner</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group py-2">
                        <label for="color">Color:</label>
                        <input type="text" name="color" id="color" placeholder="Color" class="form-control" />
                    </div>
                    <div class="form-group py-2">
                        <label for="matricule">Matricule:</label>
                        <input type="text" name="matricule_display"  value="{{ $matricule }}" class="form-control" disabled>
                        <input type="hidden" name="matricule" id="matricule" value="{{ $matricule }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function loadModels(brandId, selectedModelId = null) {
        if (!brandId) {
            document.getElementById('model_id').innerHTML = '<option value="">Select a Model</option>';
            return;  // Important pour stopper l'exécution si aucun brandId n'est fourni
        }

        fetch(`/api/models/${brandId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error, status = ${response.status}`);
                }
                return response.json();
            })
            .then(models => {
                console.log(models); // Pour voir ce qui est retourné par le serveur

                let modelSelect = document.getElementById('model_id');
                modelSelect.innerHTML = '<option value="">Select a Model</option>';
                models.forEach(model => {
                    let option = document.createElement('option');
                    option.value = model.id;
                    option.textContent = model.nomModel;
                    if (selectedModelId && model.id === selectedModelId) {
                        option.selected = true;
                    }
                    modelSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error loading the models:', error);
                alert('Failed to load models: ' + error.message);
            });
    }


    let modalMode = '';

    function openModalForCreate() {
        modalMode = 'create';
        $('#todo-modal').modal('show');
    }

    function openModalForView(carId) {
        modalMode = 'view';
        fetchCar(carId, 'view');
    }

    function openModalForEdit(carId) {
        modalMode = 'edit';
        fetchCar(carId, 'edit');
    }

    document.addEventListener('DOMContentLoaded', function() {
        $('#todo-modal').on('show.bs.modal', function() {
            var $mode=$(this).data('mode');
            if($mode==='create') {
                fetch('/generate-matricule')
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('matricule').value = data.matricule;
                    })
                    .catch(error => console.error('Failed to fetch matricule:', error));
            }
        });
    });

</script>
