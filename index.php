<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Php chat, MySQL and java script</title>
         <link rel="stylesheet" type="text/css" href="statics/css/vendor/bootstrap.min.css">
         <link rel="stylesheet" type="text/css" href="statics/css/style.css">
    </head>
<body>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Php chat</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li role="presentation" class="btn-login"><a href="#" >Login</a></li>
            <li role="presentation" class="hide btn-logout"><a href="#" >Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <main>
      <section class="jumbotron welcome-box">
        <h1>Bienvenido phpChat!</h1>
        <p>Para iniciar, ingrese su nickname</p>
        <p class="text-center"><a class="btn btn-primary btn-lg btn-login" href="#" role="button">Login</a></p>
      </section>

      <section class="col-sm-8 col-md-6 chat-box hide">
        <div class="page-header">
          <h4><small>Mensajes</small></h4>
        </div>
          <div id="chat-box">
              <ul class="list-group"></ul>
          </div>
          <div id="msg-box">
             <form role="form">
              <div class="form-group">
                
                <label for="recipient-name" class="control-label">Mensaje:</label>
                <div class="input-group">
                  <input type="text" class="form-control" id="msg" autofocus requiered placeholder="Escriba aquí mensaje">
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="button" id="btn-snd">Send!</button>
                  </span>
                </div><!-- /input-group -->
              </div>
            </form>
          </div>
      </section>

      <section class="col-sm-4 col-md-2 chat-box hide">
      <div class="page-header">
        <h4><small>Usuarios</small></h4>
      </div>
          <div id="user-box">
              <ul class="list-group"></ul>
          </div>
      </section>

      <footer  class="col-sm-12 col-md-12">
        <h5 class="text-center">PHP Chat</h5>
      </footer>
    </main>

    <script type="text/javascript" src="statics/js/vendor/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="statics/js/vendor/underscore-min.js"></script>
    <script type="text/javascript" src="statics/js/vendor/backbone-min.js"></script>
    <script type="text/javascript" src="statics/js/vendor/bootstrap.min.js"></script>
    <script type="text/javascript" src="statics/js/vendor/backbone.marionette.min.js"></script>
    <script type="text/javascript" src="statics/js/app.js"></script>

 <!-- Login Modal -->
  <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="exampleModalLabel">Login</h4>
        </div>
        <div class="modal-body">
          <form role="form">
            <div class="form-group">
              <label for="recipient-name" class="control-label">Nick Name:</label>
              <input type="text" class="form-control" id="nick" autofocus requiered>
            </div>
            <div class="form-group">
              <label for="message-text" class="control-label">Url imagen:</label>
              <input type="text" class="form-control" id="urlimg">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="btn-login">Login</button>
        </div>
      </div>
    </div>
  </div>

</body>
</html>