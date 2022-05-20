<?php

    require __DIR__ . "/../lib/database.php";

    $db = connectToDb();

    $countries = $db->query("SELECT * from countries")->fetchAll();
    $provinces = $db->query("SELECT * from regions WHERE country_id = 1")->fetchAll();
    $states = $db->query("SELECT * from regions WHERE country_id = 2")->fetchAll();
    $regions = ["canada" => $provinces, "usa" => $states];
?>


<?php partial("header") ?>

<main class="form-container">
    <img src="https://www.voices.com/themes/site_themes/voices/images/logos/voices-logo-brand-sm-blue.png" alt="Voices" draggable="false" class="form-logo">

    <form action="/submissions/create.php" method="POST" enctype="multipart/form-data" class="form">
        <div class="form-body">
            <div class="col-2">
                <label for="job-title" class="required-label">Job Title</label>
                <input id="job-title" name="job-title" type="text" required class="form-control">
            </div>

            <div class="col-1">
                <label for="job-country" class="required-label">Job Country</label>

                <select id="job-country" name="job-country" required class="form-control">
                    <option value="" disabled selected hidden>Select Your Country</option>

                    <?php foreach($countries as $country): ?>
                        <option value="<?= $country["id"] ?>"><?= $country["name"] ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="col-1">
                <label for="job-region" class="required-label">Job State</label>
                <select id="job-region" name="job-region" required class="form-control">
                    <option value="" disabled selected hidden>Select Your State</option>

                    <?php foreach($regions["usa"] as $region): ?>
                        <option value="<?= $region["id"] ?>" data-country="<?= $region["country_id"] ?>"><?= $region["name"] ?></option>
                    <?php endforeach ?>

                    <?php foreach($regions["canada"] as $region): ?>
                        <option value="<?= $region["id"] ?>" disabled hidden data-country="<?= $region["country_id"] ?>"><?= $region["name"] ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="col-2">
                <label for="job-additional-info">Job Additional Info</label>
                <textarea id="job-additional-info" name="job-additional-info" class="form-control" rows="8"></textarea>
                <p class="form-word-count"><span data-word-count>0</span> Word<span data-word-plural>s</span></p>
            </div>

            <div class="col-2">
                <label for="attachment">
                    <span role="button" data-file-button aria-controls="attachment" tabindex="0" class="button button-tertiary">Select File</span>
                </label>

                <span class="form-file-name" data-file-name></span>
                <button type="button" class="button button-remove" style="display: none;">&times;</button>

                <input id="attachment" name="attachment" type="file">
            </div>

            <input type="hidden" name="csrf_token" id="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?? '' ?>">

            <div class="form-alert alert-success col-2" style="display: none;">
                <p>Awesome! Your job was submitted sucessfully!</p>

                <button type="button" class="button button-remove">&times;</button>
            </div>
        </div>

        <div class="form-footer">
            <button type="reset" class="button button-secondary">Reset</button>
            <button type="submit" class="button">Submit</button>
        </div>
    </form>
</main>

<?php partial("footer") ?>
