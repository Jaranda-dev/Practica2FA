<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Código</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Verificación de Código</h3>
                    </div>
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-error">
                                {{ session('error') }}
                            </div>
                        @endif
                        <p>Se ha enviado un código de verificación a <strong>{{ $email }}</strong>. Por favor, ingrésalo a continuación.</p>
                        <form action="{{ route('verify.code') }}" method="POST" id="verify-form">
                            @csrf
                            <input type="hidden" name="email" value="{{ $email }}">
                            <div class="mb-3">
                                <label for="code" class="form-label">Código de Verificación</label>
                                <input type="text" name="code" class="form-control" required>
                            </div>

                            <!-- Botón con reCAPTCHA v2 Invisible -->
                            <button id="verify-btn" class="g-recaptcha btn btn-primary w-100"
                                data-sitekey="{{ env('NOCAPTCHA_SITEKEY') }}"
                                data-callback="onSubmit"
                                data-action="submit">
                                Verificar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script de reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        function onSubmit(token) {
            document.getElementById("verify-form").submit();
        }
    </script>
</body>
</html>
