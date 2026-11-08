<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title><?= $id ? 'Modifier le trajet' : 'Créer un trajet' ?></title>
    <link rel="stylesheet" href="/css/main.css">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h1 class="h4 text-center mb-4"><?= $id ? 'Modifier le trajet' : 'Créer un trajet' ?></h1>

                        <?php if ($error !== '') : ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>

                        <form method="post" action="<?= $id ? '/trips/' . $id . '/edit' : '/trips/create' ?>">
                            <div class="mb-3">
                                <label class="form-label" for="departure_agency_id">Agence de départ</label>
                                <select class="form-select" id="departure_agency_id" name="departure_agency_id" required>
                                    <option value="">Choisir…</option>
                                    <?php foreach ($agencies as $agency) : ?>
                                        <option value="<?= $agency['id'] ?>" <?= $agency['id'] == $trip['departure_agency_id'] ? 'selected' : '' ?>><?= $agency['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="arrival_agency_id">Agence d'arrivée</label>
                                <select class="form-select" id="arrival_agency_id" name="arrival_agency_id" required>
                                    <option value="">Choisir…</option>
                                    <?php foreach ($agencies as $agency) : ?>
                                        <option value="<?= $agency['id'] ?>" <?= $agency['id'] == $trip['arrival_agency_id'] ? 'selected' : '' ?>><?= $agency['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="departure_at">Date et heure de départ</label>
                                <input class="form-control" type="datetime-local" id="departure_at" name="departure_at" value="<?= $trip['departure_at'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="arrival_at">Date et heure d'arrivée</label>
                                <input class="form-control" type="datetime-local" id="arrival_at" name="arrival_at" value="<?= $trip['arrival_at'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="total_seats">Places au total</label>
                                <input class="form-control" type="number" id="total_seats" name="total_seats" min="1" max="20" value="<?= $trip['total_seats'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="available_seats">Places disponibles</label>
                                <input class="form-control" type="number" id="available_seats" name="available_seats" min="0" max="20" value="<?= $trip['available_seats'] ?>" required>
                            </div>
                            <button class="btn btn-primary" type="submit">Enregistrer</button>
                            <a class="btn btn-outline-secondary" href="/">Annuler</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>
