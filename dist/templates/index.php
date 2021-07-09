{% extends "main_layout.php" %}

{% block header %}
    {{parent()}}
        {%for data in page_style%}
            <link href="{{data}}" rel="stylesheet" />
        {%endfor%}
{% endblock %}

{% block menu %}
    {% include 'menu.php' %}
{% endblock %}

{% block content %} 
     {{ mainbar | raw }}
{% endblock %}

{% block scripts %}
    {{parent()}}
        {%for data in page_script%}
            <script src="{{data}}" type="text/javascript"></script>
        {%endfor%}
{% endblock %}

{% block footer %}
    {{parent()}}
{% endblock %}


            