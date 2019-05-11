<?php if ($sortieStocks): ?>
<table class="table table-sm table-hover table-stripped table-condensed">
    <thead>
        <th>Produit</th>
        <th>quantite</th>
        <th>Date</th>
    </thead>
        
    <?php foreach ($sortieStocks as $key => $sortieStock): ?>

        <tr>
            <td><?= $sortieStock->produit  ?></td>
            <td><?= $sortieStock->quantite  ?></td>
            <td><?= $sortieStock->create_by  ?></td>
        </tr>
        
    <?php endforeach ?>

</table>
<?php else: ?>
<div id="w1-success" class="alert-danger alert fade in">
<!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> -->
    Aucun achat pour ce client.
</div>
<?php endif ?>