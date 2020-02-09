{% extends "base.php" %}

{% block title %}Connexion{% endblock %}

{% block content %}

{% if session.session_id is not null %}
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <p class="alert alert-success"> vous êtes déjà connecté </p>
        </div>
    </div>
    {% else %}
        <div class="row">
            <h2 class="col-sm-2 col-sm-offset-5">Connexion</h2>
        </div>

        {% if created == true %}
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <p class="alert alert-success"> account succesfuly created </p>
                </div>
            </div>
        {% endif %}

        {% if connected == false and connected is not null %}
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <p class="alert alert-danger"> bad username or bad password </p>
                </div>
            </div>
        {% endif %}

    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <form action="/login" method="post" id="login_form">
                <div class="form-group">
                    <label for="i_email">Email:</label>
                    <input type="email" class="form-control" name="i_email" id="i_email" required>
                </div>
                <div class="form-group">
                    <label for="i_pwd">Mot de Passe:</label>
                    <input type="password" class="form-control" name="i_pwd" id="i_pwd" required>
                </div>
                <input type="hidden" name="challenge" id="challenge"></input>
                <button type="submit" class="btn btn-default" onclick="connection('{{session.login_challenge}}')">Se
                    Connecter
                </button>
            </form>

        </div>
    </div>

    {% endif %}
{% endblock %}