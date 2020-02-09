{% extends "base.php" %}

{% block title %}Mots de passe{% endblock %}

{% block content %}

<script src="{{ '../js/security.js' }}"></script>

{% if session.session_id is null %}
<div class="row">
    <div class="col-sm-6 col-sm-offset-3">
        <p class="alert alert-warning"> vous n'êtes pas connecté </p>
    </div>
</div>
{% else %}
<div class="row">
    <h2 class="col-sm-2 col-sm-offset-5">Mots de passe</h2>
</div>
<div class="row">
    <div class="col-sm-6 col-sm-offset-3">
        {% if passwords is defined %}
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Nom d'utilisateur</th>
                <th>Mot de passe</th>
            </tr>
            </thead>
            <tbody>
            {% for p in passwords %}
            <tr>
                <td>{{ p.label }}</td>
                <td>{{ p.login }}</td>
                <td class=" text-center">
                    <button class="glyphicon glyphicon-open btn btn-success"
                            onclick="decodePassword('{{p.password}}')"></button>
                </td>
            </tr>
            {% endfor %}
            </tbody>
        </table>
        {% endif %}
    </div>
</div>
{% endif %}
{% endblock %}