$(document).ready(function() {    
    // Navbar mobile
    $(".navbar-burger").click(function() {
      $(".navbar-burger").toggleClass("is-active");
      $(".navbar-menu").toggleClass("is-active");
    });

    // Dropdown Login
    var button = document.querySelector('.dropdown-trigger');
    var dropdown = document.querySelector('.dropdown');
    if (button != null){
        button.addEventListener('click', function(event) {
        event.stopPropagation();
        dropdown.classList.toggle('is-active');
        });
    }
    // Validação de Senha //
    var senha1 = document.getElementById("senha1");
    var senha2 = document.getElementById("senha2");

    if (senha2 != null){
        senha2.onkeyup = function(){
            if (senha1.value != senha2.value){
                $("#btn_finalizar").attr("disabled");
                $("#senha2").removeClass("is-success");
                $("#senha2").addClass("is-danger");
            }else{
                $("#btn_finalizar").removeAttr("disabled");
                $("#senha2").removeClass("is-danger");
                $("#senha2").addClass("is-success");
            }
        }
    }

    if (senha1 != null){
        senha1.onkeyup = function(){
            if (senha1.value != senha2.value){
                $("#btn_finalizar").attr("disabled", "");
                $("#senha2").removeClass("is-success");
                $("#senha2").addClass("is-danger");
            }else{
                $("#btn_finalizar").removeAttr("disabled");
                $("#senha2").removeClass("is-danger");
                $("#senha2").addClass("is-success");
            }
        }
    }
    
    // Modal Muda Senha //
    var modalChangePsw = document.querySelector('#modalChangePsw');
    var triggerPsw = document.querySelector('#modal-trigger-psw');
    if (triggerPsw != null){
        triggerPsw.addEventListener('click', function(event){
            modalChangePsw.classList.toggle('is-active');
        });
    }

    $(".deletarModalChangePsw").click(function() {
        modalChangePsw.classList.remove("is-active");
    });
});
