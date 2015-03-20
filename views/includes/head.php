<html>
    <head>
        <title>Camp-Cun Backend</title>
        <link rel="stylesheet" href="<?=$this->cssRoute?>bootstrap.min.css"/>
        <script type="text/javascript" src="<?=$this->jsRoute?>jquery.js"></script>
        <script type="text/javascript" src="<?=$this->jsRoute?>bootstrap.js"></script>
    </head>
    <body>
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
            <div class="collapse navbar-collapse" id="menuButtons">
<!--                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="glyphicon glyphicon-user"></i> <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </li>
                </ul>-->
            </div><!-- /.navbar-collapse -->
        </nav>
        <? endif;?>
    
