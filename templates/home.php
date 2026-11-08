<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Touche pas au klaxon</title>
    <link rel="stylesheet" href="/css/main.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-secondary mb-4">
        <div class="container">
            <a class="navbar-brand" href="/">Touche pas au klaxon</a>
            <div>
                <?php if (isset($_SESSION['user'])) : ?>
                    <span class="text-white me-3">
                        Bonjour <?= $_SESSION['user']['first_name'] ?> <?= $_SESSION['user']['last_name'] ?>
                    </span>
                    <a class="btn btn-primary" href="/trips/create">Créer un trajet</a>
                    <a class="btn btn-outline-light" href="/logout">Déconnexion</a>
                <?php else : ?>
                    <a class="btn btn-primary" href="/login">Connexion</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container">

        <?php if (isset($_SESSION['flash'])) : ?>
            <div class="alert alert-success"><?= $_SESSION['flash'] ?></div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <?php if (!isset($_SESSION['user'])) : ?>
            <h1 class="h4 text-center text-dark mb-4">Pour obtenir plus d'informations sur un trajet, veuillez vous connecter</h1>
        <?php endif; ?>

        <table class="table table-striped table-bordered bg-white">
            <thead class="table-dark">
                <tr>
                    <th>Départ</th><th>Date</th><th>Heure</th>
                    <th>Destination</th><th>Date</th><th>Heure</th>
                    <th>Places</th>
                    <?php if (isset($_SESSION['user'])) : ?><th>Actions</th><?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($trips as $trip) : ?>
                    <tr>
                        <td><?= $trip['departure_name'] ?></td>
                        <td><?= date('d/m/Y', strtotime($trip['departure_at'])) ?></td>
                        <td><?= date('H:i', strtotime($trip['departure_at'])) ?></td>
                        <td><?= $trip['arrival_name'] ?></td>
                        <td><?= date('d/m/Y', strtotime($trip['arrival_at'])) ?></td>
                        <td><?= date('H:i', strtotime($trip['arrival_at'])) ?></td>
                        <td><?= $trip['available_seats'] ?></td>
                        <?php if (isset($_SESSION['user'])) : ?>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#trip<?= $trip['id'] ?>">Détails</button>

                                <?php if ($trip['author_id'] == $_SESSION['user']['id']) : ?>
                                    <a class="btn btn-sm btn-secondary" href="/trips/<?= $trip['id'] ?>/edit">Modifier</a>
                                    <form class="d-inline" method="post" action="/trips/<?= $trip['id'] ?>/delete">
                                        <input type="hidden" name="id" value="<?= $trip['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                    </form>
                                <?php endif; ?>

                                <div class="modal fade" id="trip<?= $trip['id'] ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><?= $trip['departure_name'] ?> → <?= $trip['arrival_name'] ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Auteur : <?= $trip['author_first_name'] ?> <?= $trip['author_last_name'] ?></p>
                                                <p>Téléphone : <?= trim(chunk_split($trip['author_phone'], 2, ' ')) ?></p>
                                                <p>Email : <?= $trip['author_email'] ?></p>
                                                <p class="mb-0">Places au total : <?= $trip['total_seats'] ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

    <script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>
