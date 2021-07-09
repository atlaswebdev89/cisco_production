<!DOCTYPE html>
<html lang="ru">
<head>
    {% block header %}
        {% include 'header.php' %}
    {% endblock %}
</head>

<body class="light-page">

    <nav id="nav-fluid-logo-menu-btn" class="navbar navbar-fixed-top dark">
            <div class="container-fluid">
        
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="navbar-brand">
                        <a href="/" style="background-color: inherit !important;"><img src="/images/wifi-icon2.png"  alt="Your logo" class="dark" ></a>
                        <span><a href = "/profileUser" >{{session.name}} {{session.secondname}}</a></span>
                    </div>
                </div>

                <div id="navbar" role='navigation' class="navbar-collapse collapse" aria-expanded="false" style="height: 0px;">

                    <button class="btn-info btn btn-sm navbar-btn navbar-right"  id="logout_button"><i class="icon-user icon-position-left"></i>
                        <span style="">Выход</span>
                    </button>

                    <a href = "/reports/">
                        <button class="btn-info btn btn-sm navbar-btn navbar-right" >
                            <span style="">Скачать файл</span>
                        </button>
                    </a>

                    <ul class="nav navbar-nav navbar-right" style="">
                        <li><a href="/"><i class="icon-home7 icon-position-right"></i> <span>Home</span></a></li>

                        {% block menu %}
                        {% endblock %}
                    </ul>

                </div>

            </div>
        <div class="nav-bg light"></div>
    </nav>
        <div id="wrap">
                {% block content %} 		
                {% endblock %}

                {% block footer %}
                    {% include 'footer.php' %}
                {% endblock %}
        </div>
            {% block scripts %}
                    {% include 'footer-scripts.php' %}
            {% endblock %}
	</body>
</html>

