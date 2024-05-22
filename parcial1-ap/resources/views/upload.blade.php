<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir PDF</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Subir PDF para comprimir</h1>
        <form id="upload-form" method="POST" action="/upload" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="file">Selecciona un archivo PDF</label>
                <input type="file" name="file" class="form-control-file" accept="application/pdf" required>
            </div>
            <button type="submit" class="btn btn-primary">Subir</button>
        </form>
        <div id="status" class="mt-3"></div>
    </div>

    <script>
        $(document).ready(function() {
            $('#upload-form').on('submit', function(event) {
                event.preventDefault();

                var formData = new FormData(this);
                $.ajax({
                    url: '/upload',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        checkStatus(data.task_id);
                    }
                });
            });

            function checkStatus(taskId) {
                $('#status').text('Processing...');
                $.ajax({
                    url: '/status/' + taskId,
                    type: 'GET',
                    success: function(data) {
                        if (data.status === 'completed') {
                            window.location.href = '/download-page/' + taskId;
                        } else {
                            setTimeout(function() {
                                checkStatus(taskId);
                            }, 3000);
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>
