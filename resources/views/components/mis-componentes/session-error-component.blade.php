@props(['message'])

<div id="session-error-message" class="error-message">
    {{ $message }}
</div>

<style>
.error-message {
    border-radius: 10px;
    background-color: #f8d7da;
    color: #721c24;
    position: absolute;
    left: 0;
    right: 0;
    padding: 10px;
    text-align: center;
    z-index: 1000;
    display: none; /* Inicialmente oculto */
}
</style>

<script>
    window.onload = function() {
        var errorMessage = document.getElementById('session-error-message');
        if (errorMessage) {
            errorMessage.style.display = 'block'; // Muestra el mensaje de error
            setTimeout(function() {
                errorMessage.style.display = 'none'; // Oculta el mensaje de error después de 5 segundos
            }, 10000);
        }
    };
</script>