<?php if ($sousmenus): ?>
<table class="table table-sm table-hover table-stripped table-condensed">
    <thead>
        <th>Libelle</th>
        <th>Lien</th>
        <th>Description</th>
        <th>Visible</th>
        <th>sataut</th>
    </thead>
        
    <?php foreach ($sousmenus as $key => $sousmenu): ?>

        <tr>
            <td><?= $sousmenu->libelle  ?></td>
            <td><?= $sousmenu->lien  ?></td>
            <td><?= $sousmenu->description  ?></td>
            <td>
                <div class="mrg-top">
                    <span>
                        <div class="toggle-checkbox toggle-primary checkbox-inline toggle-sm mrg-top-10 mrg-left-0">
                            <input id="status_<?= $sousmenu->id ?>" type="checkbox" name="toggle5"  <?= $sousmenu->visible == 1?'checked':'' ?> value="<?= $sousmenu->visible ?>" disabled>
                            <label for="status_<?= $sousmenu->id ?>"></label>
                        </div>
                    </span>
                </div>
            </td>
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
        
    <?php endforeach ?>

</table>
<?php else: ?>
<div id="w1-success" class="alert-danger alert fade in">
<!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> -->
    Aucun sous menu pour ce menu.
</div>
<?php endif ?>