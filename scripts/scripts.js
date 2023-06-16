setTimeout(function() {
    var alerta = document.getElementById('alerta');
    if (alerta) {
        alerta.style.animation = 'desaparecer 1s forwards';
        setTimeout(function() {
            alerta.style.display = 'none';
        }, 2000);
    }
}, 2000);