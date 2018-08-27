<script>

    $(document).ready(function() {

          // Navbar mobile
          $(".navbar-burger").click(function() {
              $(".navbar-burger").toggleClass("is-active");
              $(".navbar-menu").toggleClass("is-active");
          });

          // dropdown
          var button = document.querySelector('.dropdown-trigger');
          var dropdown = document.querySelector('.dropdown');
          button.addEventListener('click', function(event) {
            event.stopPropagation();
            dropdown.classList.toggle('is-active');
          });

          // modal
          var modal = document.querySelector('.modal');
          var trigger = document.querySelector('#modal-trigger');
          trigger.addEventListener('click', function(event){
            modal.classList.toggle('is-active');
          });

          // Delete Modal
          var del = $(".deletar");
          del.click(function() {
            modal.classList.remove("is-active");
          })

      });

</script>
