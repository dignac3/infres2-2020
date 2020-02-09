<!doctype html>
{% block head %}
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <title>{% block title %}PasswordManager{% endblock %}</title>
</head>
<body>
{%  block navbar %}
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="/index">Gestionnaire de Mots de Passes de l'IMT</a>
        </div>
        <ul class="nav navbar-nav">
            {% block menu_list %}
                <li><a href="/index">Accueil</a></li>
            {% if session.session_id is not null %}
                    <li><a href="/passwords">Mots de passe</a></li>
                    <li><a href="/passwords/new">Ajouter un mot de passe</a></li>
                {% endif %}
            {% endblock %}
        </ul>
        <ul class="nav navbar-nav navbar-right">
            {% if session.session_id is null %}
                <li><a href="/register"><span class="glyphicon glyphicon-user"></span> S'enregistrer</a></li>
                <li><a href="/login"><span class="glyphicon glyphicon-log-in"></span> Se connecter</a></li>
            {% else %}
                <li><a href="/logout"><span class="glyphicon glyphicon-log-out"></span> Se déconnecter</a></li>
            {% endif %}
        </ul>
    </div>
</nav>
    {% endblock %}
{% endblock %}
<div id="container">{% block content %}{% endblock %}</div>

{% block foot %}
{% block footer %}{% endblock %}
</body>
</html>

<script src="../js/security.js"></script>
{% endblock %}