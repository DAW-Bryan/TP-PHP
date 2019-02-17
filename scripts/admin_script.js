$(document).ready(function() {    

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

    // modal Edita Descrição do Item
    var modalItemDescription = document.querySelector('#modalItemDescription');
    var triggerItemEdit = document.querySelector('#modal-trigger-edit'); 
    if (triggerItemEdit != null){
        triggerItemEdit.addEventListener('click', function(event){
            modalItemDescription.classList.toggle('is-active');
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
        modalItemDescription.classList.remove("is-active");
    });
});