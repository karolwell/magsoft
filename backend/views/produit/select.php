<option id="select" value=""></option>
<?php foreach ($categories as $key => $categorie): ?>
<optgroup label="<?= $categorie->designation ?>">
    <?php foreach ($categorie->produits as $k => $produit): ?>
    <?php if ($produit->statut==1): ?>      
        <option value="<?= $produit->id.'*'.$produit->designation ?>"><?= $produit->designation ?></option>
    <?php endif ?>    
    <?php endforeach ?>
</optgroup>
<?php endforeach ?>
