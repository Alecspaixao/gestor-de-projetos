  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>General Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">General Form</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Casdastro de Projeto</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
                <form role="form">
                  <div class="card-body">

                  <!-- Nome do Projeto -->
                    <div class="form-group">
                      <label for="projectName">Nome do Projeto</label>
                      <input type="text" class="form-control" id="projectName" placeholder="Digite o nome do projeto" required>
                    </div>

                  <!-- Descrição do Projeto -->
                  <div class="form-group">
                      <label for="projectDescription">Descrição</label>
                      <textarea class="form-control" id="projectDescription" rows="3" placeholder="Digite a descrição do projeto" required></textarea>
                  </div>

                  <!-- Categoria -->
                  <div class="form-group">
                      <label for="projectCategory">Categoria</label>
                      <select class="form-control" id="projectCategory" required>
                          <option value="" disabled selected>Escolha a categoria</option>
                          <option value="tech">Trabalho</option>
                          <option value="education">Faculdade</option>
                          <option value="health">Projeto Pessoal</option>
                          <!-- Adicione mais opções conforme necessário -->
                      </select>
                  </div>

                  <!-- Arquivo -->
                  <div class="form-group">
                      <label for="projectFile">Arquivo (opcional)</label>
                      <div class="input-group">
                          <div class="custom-file">
                              <input type="file" class="custom-file-input" id="projectFile">
                              <label class="custom-file-label" for="projectFile">Escolher arquivo</label>
                          </div>
                          <div class="input-group-append">
                              <span class="input-group-text">Enviar</span>
                          </div>
                      </div>
                  </div>

                  <!-- Botão de Enviar -->
                  <button type="submit" class="btn btn-primary">Cadastrar Projeto</button>
                  </div>

                  <!-- Checkbox para Confirmar -->
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="terms" required>
                    <label class="form-check-label" for="terms">Eu li e aceito os termos e condições</label>
                  </div>

              </form>
            </div>
            <!-- /.card -->

          

          

          <!--/.col (left) -->
          <!-- right column -->
          
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>