
      <nav class="navbar is-dark" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a class="navbar-item" href="index.php">
                <img src="Images/logo.png">
            </a>

            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbar">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="navbar" class="navbar-menu">
          <div class="navbar-start">
              <a class="navbar-item" href="index.php" id="trigger">
                Home
              </a>
              <a class="navbar-item is-hoverable" href="reservar.php">
                Fazer reserva
              </a>
              <a class="navbar-item is-hoverable" href="espacos.php">
                Espaços
              </a>

            <?php if (isset($_SESSION["root"])){ ?>
              <a class="navbar-item is-hoverable" href="admin.php">
                Administrador
              </a>
            <?php } ?>

          </div>

          <div class="navbar-end">
            <div class="navbar-item">

                <?php if (!isset($_SESSION['login'])) { ?>

                <div class="field is-grouped">
                  <p class="control">
                      <div class="dropdown is-right">

                          <div class="dropdown-trigger">
                              <button class="button is-light" aria-haspopup="true" aria-controls="dropdown-menu">
                                <span class="icon">
                                  <i class="fas fa-user"></i>
                                </span>
                                <span>
                                  Login
                                </span>
                                <span class="icon">
                                  <i class="fas fa-angle-down"></i>
                                </span>
                              </button>
                          </div>

                          <form action="login.php" method="post">
                            <div class="dropdown-menu" id="dropdown-menu" role="menu">
                                <div class="dropdown-content">
                                  <div class="dropdown-item">
                                      <div class="control">
                                          <input class="input" type="number" name="matricula" placeholder="Matrícula">
                                      </div>
                                  </div>
                                  <div class="dropdown-item">
                                      <div class="control">
                                          <input class="input" type="password" name="senha" placeholder="Senha">
                                      </div>
                                  </div>
                                  <div class="dropdown-item">
                                    <input type="submit" class="button is-success" value="Fazer login"></input>
                                  </div>
                                </div>
                            </div>
                        </form>

                      </div>
                  </p>

                  <p class="control" style="margin-left: 5px">
                      <button class="button is-link" id="modal-trigger" data-target="modal">
                          <span class="icon">
                            <i class="fas fa-user"></i>
                          </span>
                          <span>
                            Cadastro
                          </span>
                      </button>
                  </p>

                </div>

              <?php } else { ?>

              <?php echo '<p> Logado como ' . $_SESSION['login'] . ', </p>'; ?>
              <a id='logout' href="index.php?logout=1">  Sair </a>

              <?php } ?>
              </div>
            </div>
          </div>
      </nav>

        <section class="section has-background-dark" style="padding-bottom: 70px !important">
            <div class="container">
                <h1 class="title has-text-centered has-text-white"> Reservas COLTEC</h1>
                <h2 class="subtitle has-text-centered has-text-light"> Para reservar a sala ou espaço que você precisa no Colégio!</h2>
            </div>
        </section>

        <!-- Modal para cadastro -->
        <form method="post" action="autentica_cadastro.php">
          <div class="modal" id="modal">
            <div class="modal-background"></div>
          <div class="modal-card">
            <header class="modal-card-head">
              <p class="modal-card-title">Cadastro de usuários</p>
              <a class="delete deletar" aria-label="close"></a>
            </header>
            <section class="modal-card-body">
              <div class="field">
                  <label class="label">Nome Completo</label>
                  <div class="control has-icons-left">
                      <input class="input" type="text" name="EntradaNome" placeholder="Seu nome completo">
                      <span class="icon is-small is-left">
                          <i class="fas fa-user"></i>
                      </span>
                  </div>
              </div>

              <div class="field">
                  <label class="label">Email</label>
                  <div class="control has-icons-left">
                      <input class="input" type="email"  name="EntradaEmail"placeholder="Seu email">
                      <span class="icon is-small is-left">
                          <i class="fas fa-envelope"></i>
                      </span>
                  </div>
              </div>

              <div class="field">
                  <label class="label">Número de Matrícula</label>
                  <div class="control has-icons-left">
                      <input class="input" type="number" name="EntradaMatricula" placeholder="Sua Matrícula">
                      <span class="icon is-small is-left">
                          <i class="fas fa-id-card"></i>
                      </span>
                  </div>
              </div>

              <div class="field">
                  <label class="label">Senha</label>
                  <div class="control has-icons-left">
                      <input class="input" type="password" id="senha1" placeholder="Digite a senha" name="EntradaSenha" onchange="validaSenha()">
                      <span class="icon is-small is-left">
                          <i class="fas fa-key"></i>
                      </span>
                  </div>
              </div>

            </section>
            <footer class="modal-card-foot">
              <button class="button is-success" type="submit">Finalizar cadastro</button>
              <a class="button deletar">Cancelar</a>
            </footer>
          </div>
        </div>
      </form>
