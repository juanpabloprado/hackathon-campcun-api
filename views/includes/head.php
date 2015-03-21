<html>
    <head>
        <title>Camp-Cun Backend</title>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="<?=$this->cssRoute?>bootstrap.min.css"/>
        <script type="text/javascript" src="<?=$this->jsRoute?>jquery.js"></script>
        <script type="text/javascript" src="<?=$this->jsRoute?>bootstrap.js"></script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBThXd6ah49EH03wttziSsXbj8Fl-j1DT4"></script>
    </head>
    <body style="padding-top: 50px;">
        <? if(Session::getKey("loggedIn")) :?>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" id="mainMenu">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menuButtons">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Camp-Cun Backend</a>
            </div>
            <div class="collapse navbar-collapse" id="menuButtons" style="padding-right:30px;">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="<?=URL?>index.php?url=places/index">Lugares</a>
                    </li>
                    <li>
                        <a href="<?=URL?>index.php?url=users/index">Usuarios</a>
                    </li>
                    <li>
                        <a href="<?=URL?>index.php?url=todos/index">To-dos</a>
                    </li>
                    <li>
                        <a href="">Logout</a>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
        <? endif;?>
    
