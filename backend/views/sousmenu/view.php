<table class="table table-sm table-hover table-stripped table-condensed">

    <tr>
        <th>Menu</th><td><?= $sousmenu->menu->libelle  ?></td>
    </tr>
    <tr>
        <th>Libelle</th><td><?= $sousmenu->libelle  ?></td>
    </tr>
    <tr>
        <th>Lien</th><td><?= $sousmenu->lien  ?></td>
    </tr>
    <tr>
        <th>Description</th><td><?= $sousmenu->description  ?></td>
    </tr>
    <tr>
        <th class="mrg-top-5">Visible</th>
        <td>
            <div class="mrg-top">
                <span>
                    <div class="toggle-checkbox toggle-primary checkbox-inline toggle-sm mrg-top-10 mrg-left-0">
                        <input id="status_<?= $sousmenu->id ?>" type="checkbox" name="toggle5"  <?= $sousmenu->statut == 1?'checked':'' ?> value="<?= $sousmenu->statut ?>" disabled>
                        <label for="status_<?= $sousmenu->id ?>"></label>
                    </div>
                </span>
            </div>
        </td>
    </tr>
    <tr>
        <th class="mrg-top-5">Statut</th>
        <td>
            <div class="mrg-top">
                <span>
                    <div class="toggle-checkbox toggle-warning checkbox-inline toggle-sm mrg-top-10 mrg-left-0">
                        <input id="status_<?= $sousmenu->id ?>" type="checkbox" name="toggle5"  <?= $sousmenu->statut == 1?'checked':'' ?> value="<?= $sousmenu->statut ?>" disabled>
                        <label for="status_<?= $sousmenu->id ?>"></label>
                    </div>
                </span>
            </div>
        </td>
    </tr>
</table>