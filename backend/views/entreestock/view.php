<table id="dt-opt" class="table table-sm table-hover table-stripped table-condensed">
    <thead>
        <tr>
<!--             <th>
                <div class="checkbox mrg-left-20">
                    <input id="task" name="task" type="checkbox">
                    <label for="task"></label>
                </div>
            </th> -->
            <th><div class="mrg-btm-15">Produit</div></th>
            <th><div class="mrg-btm-15">Quantité</div></th>
            <th><div class="mrg-btm-15">Fournisseur</div></th>
            <th><div class="mrg-btm-15">Date</div></th>
            <th><div class="mrg-btm-15">Utilisateur</div></th>
            <!-- <th><div class="mrg-btm-15">Status</div></th> 
            <th><div class="mrg-btm-15">Actions</div></th>-->
        </tr>
    </thead>
    <tbody>
        <?php if ($entreeStocks): ?>

            <?php foreach ($entreeStocks as $key=>$entreeStock): ?>
                <tr id="entreeStock_<?= $entreeStock->id ?>">
<!--                     <td>
                        <div class="checkbox mrg-left-20">
                            <input id="task_<?= $entreeStock->id ?>" name="task[]" type="checkbox">
                            <label for="task_<?= $entreeStock->id ?>"></label>
                        </div>
                    </td> -->
                    <td>
                        <div class="mrg-top-15">
                            <span><?= $entreeStock->produit->designation ?></span>
                        </div>
                    </td>
                    <td>
                        <div class="mrg-top-15">
                            <span><?= $entreeStock->quantite ?></span>
                        </div>
                    </td>
                    <td>
                        <div class="mrg-top-15">
                            <span><?= $entreeStock->fournisseur->nom ?></span>
                        </div>
                    </td>
                    <td>
                        <div class="mrg-top-15">
                            <span><?= explode(' ',$entreeStock->date_create)[0] ?></span>
                        </div>
                    </td> 
                    <td>
                        <div class="mrg-top-15">
                            <span><?= $entreeStock->createBy->username ?></span>
                        </div>
                    </td>

<!--                     <td>
                        <div class="mrg-top-15" data-toggle="modal" data-target="#default-modal" title="" onclick="doIt('act','<?= $entreeStock->id ?>','<?= $entreeStock->statut ?>')">
                            <span>
                                <div class="toggle-checkbox toggle-warning checkbox-inline toggle-sm mrg-top-10 mrg-left-0">
                                    <input id="statut_<?= $entreeStock->id ?>" type="checkbox" name="toggle5"  <?= $entreeStock->statut == 1?'checked':'' ?> value="<?= $entreeStock->statut ?>" disabled>
                                    <label for="statut_<?= $entreeStock->id ?>"></label>
                                </div>
                            </span>
                        </div>
                    </td> -->
                   <!-- <td>
                        <div class="mrg-top-20  font-size-18">
                            <a href="#" title="Modifier" onclick="modifentreestockShow('<?= $entreeStock->id."*".$entreeStock->quantite."*".str_replace("'", "\'", $entreeStock->produit->id)."*".str_replace("'", "\'", $entreeStock->fournisseur->id) ?>')" ><span class="icon-holder"><i class="ti-pencil"></i></span></a>
                            <a href="#" data-toggle="modal" data-target="#default-modal" title="Supprimer" onclick="doIt('supp','<?= $entreeStock->id ?>','<?= $entreeStock->statut ?>')"><span class="icon-holder"><i class="ti-trash"></i></span></a>
                            <a href="#" data-toggle="modal" data-target="#modal-lg" title="Détails" onclick="details('<?= $entreeStock->id ?>')"><span class="icon-holder"><i class="ti-view-list"></i></span></a>
                             <button class="btn btn-icon btn-flat btn-rounded dropdown-toggle">
                                <i class="ti-more-alt"></i>
                            </button>
                        </div> -->
                    </td>
                </tr>  

            <?php endforeach ?>

        <?php endif ?>

    </tbody>
</table>