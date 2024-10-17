<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://bootswatch.com/5/quartz/bootstrap.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>assets/css/style.css">
    <link rel="icon" type="image/png" href="/assets/favicons/favicon-48x48.png" sizes="48x48" />
    <link rel="icon" type="image/svg+xml" href="<?= SITE_URL ?>assets/favicons/favicon.svg" />
    <link rel="shortcut icon" href="<?= SITE_URL ?>assets/favicons/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?= SITE_URL ?>assets/favicons/apple-touch-icon.png" />
    <link rel="manifest" href="<?= SITE_URL ?>assets/favicons/site.webmanifest" />
    <script src="<?= SITE_URL ?>assets/js/main.js" defer></script>
    <title>Biblio | <?= $titre; ?></title>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Accueil</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= SITE_URL ?>livres">Livres</a>
                    </li>
                    <?php if (isset($_SESSION['utilisateur'])): ?>
                        <!-- si l'utilisateur est administrateur -->
                        <?php if ($_SESSION['utilisateur']['role'] === 'ROLE_ADMIN'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= SITE_URL ?>admin/utilisateurs">Gérer les utilisateurs</a>
                            </li>
                            <!-- Ajoutez d'autres liens d'administration ici si nécessaire -->
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= SITE_URL ?>logout">Déconnexion</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= SITE_URL ?>login">Connexion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= SITE_URL ?>inscription">Inscription</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div id="container" class="m-2">
        <h1 class="rounded border border-dark p-2 text-center text-white bg-info"><?= $titre ?></h1>
        <div class="d-flex flex-column justify-content-center"> <?= $content ?></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
