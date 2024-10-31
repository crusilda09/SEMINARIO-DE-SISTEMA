@extends('template')

@section('title', 'Crear Producto')

@push('css')
<style>
    #descripcion {
        resize: none;
    }

    #crear-categoria {
        background-color: #4caf50;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.3s;
        margin-left: 10px;
    }

    #crear-categoria:hover {
        background-color: #45a049;
        transform: scale(1.05);
    }

    .alerta-fecha {
        display: none;
        padding: 10px;
        background-color: #ff6f61;
        color: white;
        font-weight: bold;
        text-align: center;
        border-radius: 5px;
        margin-top: 10px;
        transition: opacity 0.5s ease-in-out, transform 0.5s;
        opacity: 0;
        transform: translateY(-10px);
    }

    .alerta-fecha.mostrar {
        display: block;
        opacity: 1;
        transform: translateY(0);
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Crear Producto</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('productos.index') }}">Productos</a></li>
        <li class="breadcrumb-item active">Crear producto</li>
    </ol>
    <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
        <form action="{{ route('productos.store') }}" method="post" enctype="multipart/form-data" id="form-producto">
            @csrf
            <div class="row g-3 mb-2">
                <!-- Categorías - Movido al principio para generar el código -->
                <div class="col-md-6">
                    <label for="categorias" class="form-label d-flex align-items-center">
                        Categorías
                        <button type="button" id="crear-categoria" onclick="window.location.href='{{ route('categorias.create') }}'">Crear Categoría</button>
                    </label>
                    <select data-size="4" title="Seleccione las categorías" data-live-search="true" name="categorias[]" id="categorias" class="form-control selectpicker show-tick" multiple>
                        @foreach ($categorias as $item)
                            <option value="{{ $item->id }}" data-nombre="{{ $item->nombre }}" {{ in_array($item->id, old('categorias', [])) ? 'selected' : '' }}>{{ $item->nombre }}</option>
                        @endforeach
                    </select>
                    @error('categorias')
                        <small class="text-danger">{{ '*' . $message }}</small>
                    @enderror
                </div>

                <!-- Código -->
                <div class="col-md-6">
                    <label for="codigo" class="form-label">Código</label>
                    <div class="input-group">
                        <input type="text" name="codigo" id="codigo" class="form-control" value="{{ old('codigo') }}" readonly>
                        <button type="button" class="btn btn-outline-secondary" id="regenerar-codigo">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                    @error('codigo')
                        <small class="text-danger">{{ '*' . $message }}</small>
                    @enderror
                </div>

                <!-- Marca -->
                <div class="col-md-6">
                    <label for="marca_id" class="form-label">Marca</label>
                    <select data-size="4" title="Seleccione una marca" data-live-search="true" name="marca_id" id="marca_id" class="form-control selectpicker show-tick">
                        @foreach ($marcas as $item)
                            <option value="{{ $item->id }}" {{ old('marca_id') == $item->id ? 'selected' : '' }}>{{ $item->nombre }}</option>
                        @endforeach
                    </select>
                    @error('marca_id')
                        <small class="text-danger">{{ '*' . $message }}</small>
                    @enderror
                </div>

                <!-- Presentaciones -->
                <div class="col-md-6">
                    <label for="presentacione_id" class="form-label">Presentación</label>
                    <select data-size="4" title="Seleccione una presentación" data-live-search="true" name="presentacione_id" id="presentacione_id" class="form-control selectpicker show-tick">
                        @foreach ($presentaciones as $item)
                            <option value="{{ $item->id }}" {{ old('presentacione_id') == $item->id ? 'selected' : '' }}>{{ $item->nombre }}</option>
                        @endforeach
                    </select>
                    @error('presentacione_id')
                        <small class="text-danger">{{ '*' . $message }}</small>
                    @enderror
                </div>

                <!-- Nombre -->
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}">
                    @error('nombre')
                        <small class="text-danger">{{ '*' . $message }}</small>
                    @enderror
                </div>

                <!-- Descripción -->
                <div class="col-md-12">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="3" class="form-control">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <small class="text-danger">{{ '*' . $message }}</small>
                    @enderror
                </div>

                <!-- Fecha de Vencimiento -->
                <div class="col-md-6">
                    <label for="fecha_vencimiento" class="form-label">Fecha de vencimiento</label>
                    <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control" value="{{ old('fecha_vencimiento') }}">
                    <div class="alerta-fecha" id="alerta-fecha">
                        No se pueden registrar productos vencidos.
                    </div>
                    @error('fecha_vencimiento')
                        <small class="text-danger">{{ '*' . $message }}</small>
                    @enderror
                </div>

                <!-- Imagen -->
                <div class="col-md-6">
                    <label for="img_path" class="form-label">Imagen</label>
                    <input type="file" name="img_path" id="img_path" class="form-control" accept="image/*">
                    @error('img_path')
                        <small class="text-danger">{{ '*' . $message }}</small>
                    @enderror
                </div>

                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-primary mt-3">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script>
$(document).ready(function() {
    // Función para generar un número aleatorio de 4 dígitos
    function generateRandomNumber() {
        return Math.floor(1000 + Math.random() * 9000);
    }

    // Función para generar el código del producto
    function generateProductCode() {
        const selectedOptions = $('#categorias option:selected');
        if (selectedOptions.length > 0) {
            // Tomar el nombre de la primera categoría seleccionada
            const categoryName = $(selectedOptions[0]).data('nombre');
            // Tomar las primeras 3 letras y convertir a mayúsculas
            const prefix = categoryName.substring(0, 3).toUpperCase();
            // Generar número aleatorio
            const randomNum = generateRandomNumber();
            // Combinar para crear el código
            return `${prefix}-${randomNum}`;
        }
        return '';
    }

    // Generar código cuando se selecciona una categoría
    $('#categorias').on('changed.bs.select', function() {
        const code = generateProductCode();
        $('#codigo').val(code);
    });

    // Regenerar código cuando se hace clic en el botón de regenerar
    $('#regenerar-codigo').on('click', function() {
        const code = generateProductCode();
        $('#codigo').val(code);
    });

    // Verificar fecha de vencimiento
    $('#fecha_vencimiento').on('change', function() {
        const fechaIngresada = new Date(this.value);
        const fechaActual = new Date();
        const alerta = document.getElementById('alerta-fecha');

        if (fechaIngresada < fechaActual) {
            alerta.classList.add('mostrar');
        } else {
            alerta.classList.remove('mostrar');
        }
    });
});
</script>
@endpush