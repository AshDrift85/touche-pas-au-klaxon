<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Administration</title>
    <link rel="stylesheet" href="/css/main.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-secondary mb-4">
        <div class="container">
            <a class="navbar-brand" href="/admin">Administration</a>
            <div>
                <a class="btn btn-outline-light" href="#users">Utilisateurs</a>
                <a class="btn btn-outline-light" href="#agencies">Agences</a>
                <a class="btn btn-outline-light" href="#trips">Trajets</a>
                <a class="btn btn-primary" href="/logout">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="container">

        <?php if (isset($_SESSION['flash'])) : ?>
            <div class="alert alert-success"><?= $_SESSION['flash'] ?></div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <h2 class="h4 mt-4" id="users">Utilisateurs</h2>
        <table class="table table-striped table-bordered bg-white">
            <thead class="table-dark">
                <tr><th>Nom</th><th>Prénom</th><th>Email</th><th>Téléphone</th></tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?= $user['last_name'] ?></td>
                        <td><?= $user['first_name'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td><?= trim(chunk_split($user['phone'], 2, ' ')) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2 class="h4 mt-5" id="agencies">Agences</h2>

        <form class="row g-2 mb-3" method="post" action="/admin/agencies/save">
            <input type="hidden" name="id" value="0">
            <div class="col-4">
                <input class="form-control" type="text" name="name" placeholder="Nom de la nouvelle agence" maxlength="100" required>
            </div>
            <div class="col-auto">
                <button class="btn btn-success" type="submit">Créer l'agence</button>
            </div>
        </form>

        <table class="table table-striped table-bordered bg-white">
            <thead class="table-dark">
                <tr><th>Nom</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php foreach ($agencies as $agency) : ?>
                    <tr>
                        <td>
                            <form class="row g-2" method="post" action="/admin/agencies/save">
                                <input type="hidden" name="id" value="<?= $agency['id'] ?>">
                                <div class="col-6">
                                    <input class="form-control" type="text" name="name" value="<?= $agency['name'] ?>" maxlength="100" required>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-secondary" type="submit">Modifier</button>
                                </div>
                            </form>
                        </td>
                        <td>
                            <form method="post" action="/admin/agencies/delete">
                                <input type="hidden" name="id" value="<?= $agency['id'] ?>">
                                <button class="btn btn-danger" type="submit">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2 class="h4 mt-5" id="trips">Trajets</h2>
        <table class="table table-striped table-bordered bg-white mb-5">
            <thead class="table-dark">
                <tr>
                    <th>Départ</th><th>Date</th><th>Heure</th>
                    <th>Destination</th><th>Date</th><th>Heure</th>
                    <th>Places</th><th>Actions</th>
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
                        <td><?= $trip['available_seats'] ?> / <?= $trip['total_seats'] ?></td>
                        <td>
                            <form method="post" action="/admin/trips/delete">
                                <input type="hidden" name="id" value="<?= $trip['id'] ?>">
                                <button class="btn btn-sm btn-danger" type="submit">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

    <script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>
