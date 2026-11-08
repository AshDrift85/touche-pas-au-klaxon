<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="/css/main.css">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <h1 class="h4 text-center mb-4">Connexion</h1>

                        <?php if ($error !== '') : ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>

                        <form method="post" action="/login">
                            <div class="mb-3">
                                <label class="form-label" for="email">Adresse email</label>
                                <input class="form-control" type="email" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="password">Mot de passe</label>
                                <input class="form-control" type="password" id="password" name="password" required>
                            </div>
                            <button class="btn btn-primary w-100" type="submit">Se connecter</button>
                        </form>
                    </div>
                </div>
                <p class="text-center mt-3"><a href="/">Retour à l'accueil</a></p>
            </div>
        </div>
    </div>
    <script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>
