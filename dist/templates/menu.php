    {%for data in menu%}
        <li><a href="{{data.alias}}"><i class = "{{data.class}}"></i> <span>{{data.title}}</span></a></li>
    {%endfor%}