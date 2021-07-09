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
        <div class="nav-bg light"></div>
    </div>
</nav>
<div id="wrap">
    <section id="spec-404" class="pt-100 pb-100 text-center full-height dark flex-vmiddle">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <img src="/images/error-404.png" srcset="/images/error-404@2x.png 2x" class="screen mb-30" alt="">
                    <h2 class="mb-50">Что-то пошло не так, как надо</h2>
                    <a href="/" class="btn btn-default btn-lg"><i class="icon-arrow-left icon-position-left"></i><span class="spr-option-textedit-link">Назад к главной странице</span></a>
                </div>
            </div>
        </div>
        <div class="bg"></div>
    </section>

        {% block footer %}
            {% include 'footer.php' %}
        {% endblock %}
    </div>

</body>
</html>


​

