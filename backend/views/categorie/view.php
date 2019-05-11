<?php if ($produits): ?>
<table class="table table-sm table-hover table-stripped table-condensed">
    <thead>
        <th>Désignation</th>
        <th>Prix (CFA)</th>
        <th>Description</th>
        <th>Status</th>
    </thead>
        
    <?php foreach ($produits as $key => $produit): ?>

        <tr>
            <td><?= $produit->designation  ?></td>
            <td><?= $produit->prix  ?></td>
            <td><?= $produit->description  ?></td>
            <td>
                <div class="mrg-top">
                    <span>
                        <div class="toggle-checkbox toggle-warning checkbox-inline toggle-sm mrg-top-10 mrg-left-0">
                            <input id="statut_<?= $produit->id ?>" type="checkbox" name="toggle5"  <?= $produit->statut == 1?'checked':'' ?> value="<?= $produit->statut ?>" disabled>
                            <label for="statut_<?= $produit->id ?>"></label>
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
    Aucun produit disponible pour cette catégorie.
</div>
<?php endif ?>
