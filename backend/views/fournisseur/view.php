<?php if ($entreeStocks): ?>
<table class="table table-sm table-hover table-stripped table-condensed">
    <thead>
        <th>Produit</th>
        <th>quantite</th>
        <th>Date</th>
    </thead>
        
    <?php foreach ($entreeStocks as $key => $entreeStock): ?>

        <tr>
            <td><?= $entreeStock->produit  ?></td>
            <td><?= $entreeStock->quantite  ?></td>
            <td><?= $entreeStock->create_by  ?></td>
        </tr>
        
    <?php endforeach ?>

</table>
<?php else: ?>
<div id="w1-success" class="alert-danger alert fade in">
<!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> -->
    Aucun ravitaillement pour ce fournisseur.
</div>
<?php endif ?>