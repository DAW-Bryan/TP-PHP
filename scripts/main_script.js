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

    // modal Adiciona Categoria
    var modalCat = document.querySelector('#modalCat');
    var triggerCat = document.querySelector('#modal-trigger-cat');
    if (triggerCat != null){
        triggerCat.addEventListener('click', function(event){
            modalCat.classList.toggle('is-active');
        });
    }

    // modal Deleta Categoria
    var modalCatDel = document.querySelector('#modalDelCat');
    var triggerCatDel = document.querySelector('#modal-trigger-delcat');
    if (triggerCatDel != null){
        triggerCatDel.addEventListener('click', function(event){
            modalCatDel.classList.toggle('is-active');
        });
    }

    // modal Adiciona Item
    var modalItem = document.querySelector('#modalItem');
    var triggerItem = document.querySelector('#modal-trigger-e');
    if (triggerItem != null){
        triggerItem.addEventListener('click', function(event){
            modalItem.classList.toggle('is-active');
        });
    }

    // modal Deleta Item
    var modalItemDel = document.querySelector('#modalDelItem');
    var triggerItemDel = document.querySelector('#modal-trigger-del');
    if (triggerItemDel != null){
        triggerItemDel.addEventListener('click', function(event){
            modalItemDel.classList.toggle('is-active');
        });
    }

    // modal Deleta Reserva
    var modalDelReserva = document.querySelector('#modalDelReserva');
    var triggerDelReserva = document.querySelector('#modal-trigger-del-reserva');
    if (triggerDelReserva != null){
        triggerDelReserva.addEventListener('click', function(event){
            modalDelReserva.classList.toggle('is-active');
        });
    };

    // modal Adiciona Adm
    var modalGiveAdm = document.querySelector('#modalGiveAdm');
    var triggerAdm = document.querySelector('#modal-trigger-adm');
    if (triggerAdm != null){
        triggerAdm.addEventListener('click', function(event){
            modalGiveAdm.classList.toggle('is-active');
        });
    }

    // modal Cadastra User
    var modalCadUser = document.querySelector('#modalCadUser');
    var triggerCadUser = document.querySelector('#modal-trigger-caduser');
    if (triggerCadUser != null){
        triggerCadUser.addEventListener('click', function(event){
            modalCadUser.classList.toggle('is-active');
        });
    }

   // Close Modals
    var del = $(".delete");
    del.click(function() {
        modalCat.classList.remove("is-active");
        modalCatDel.classList.remove("is-active");
        modalItem.classList.remove("is-active");
        modalItemDel.classList.remove("is-active");
        modalDelReserva.classList.remove("is-active");
        modalGiveAdm.classList.remove("is-active");
        modalCadUser.classList.remove("is-active");
    });
});
