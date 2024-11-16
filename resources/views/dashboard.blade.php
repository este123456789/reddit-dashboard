<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Argon</title>

    <!-- Argon Dashboard CSS -->
    <link href="{{ asset('css/argon-dashboard.css') }}" rel="stylesheet" />
    
    <!-- FontAwesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Bootstrap CSS (si no lo tienes ya) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- PerfectScrollbar CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/perfect-scrollbar/1.5.0/css/perfect-scrollbar.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Listado de Temas</h2>
        <div id="themes-list" class="row">
            <!-- Los temas se cargarán aquí -->
        </div>
    </div>

    <div class="modal fade" id="themeModal" tabindex="-1" aria-labelledby="themeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="themeModalLabel">Detalles del Tema</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4 id="theme-title"></h4>
                    <p id="theme-description"></p>
                    <p><strong>Suscriptores:</strong> <span id="theme-subscribers"></span></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Cargar los temas desde el API
            $.get('api/themes', function(data) {
                data.forEach(function(theme) {
                    $('#themes-list').append(`
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">${theme.title}</h5>
                                    <p class="card-text">${theme.display_name}</p>
                                    <button class="btn btn-info btn-detail" data-id="${theme.id}">Ver detalles</button>
                                </div>
                            </div>
                        </div>
                    `);
                });
            });

            // Mostrar detalles del tema
            $(document).on('click', '.btn-detail', function() {
                const id = $(this).data('id');

                $.get(`api/themes/${id}`, function(theme) {
                    $('#theme-title').text(theme.title);
                    $('#theme-description').html(theme.description_html);
                    $('#theme-subscribers').text(theme.subscribers);
                    $('#themeModal').modal('show');
                });
            });
        });
    </script>
</body>
</html>
