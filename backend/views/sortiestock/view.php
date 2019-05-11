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
            <th><div class="mrg-btm-15">Client</div></th>
            <th><div class="mrg-btm-15">Date</div></th>
            <th><div class="mrg-btm-15">Utilisateur</div></th>
            <!-- <th><div class="mrg-btm-15">Status</div></th> 
            <th><div class="mrg-btm-15">Actions</div></th>-->
        </tr>
    </thead>
    <tbody>
        <?php if ($sortieStocks): ?>

            <?php foreach ($sortieStocks as $key=>$sortieStock): ?>
                <tr id="entreeStock_<?= $sortieStock->id ?>">
<!--                     <td>
                        <div class="checkbox mrg-left-20">
                            <input id="task_<?= $sortieStock->id ?>" name="task[]" type="checkbox">
                            <label for="task_<?= $sortieStock->id ?>"></label>
                        </div>
                    </td> -->
                    <td>
                        <div class="mrg-top-15">
                            <span><?= $sortieStock->produit->designation ?></span>
                        </div>
                    </td>
                    <td>
                        <div class="mrg-top-15">
                            <span><?= $sortieStock->quantite ?></span>
                        </div>
                    </td>
                    <td>
                        <div class="mrg-top-15">
                            <span><?= $sortieStock->client->nom ?></span>
                        </div>
                    </td>
                    <td>
                        <div class="mrg-top-15">
                            <span><?= explode(' ',$sortieStock->date_create)[0] ?></span>
                        </div>
                    </td> 
                    <td>
                        <div class="mrg-top-15">
                            <span><?= $sortieStock->createBy->username ?></span>
                        </div>
                    </td>

<!--                     <td>
                        <div class="mrg-top-15" data-toggle="modal" data-target="#default-modal" title="" onclick="doIt('act','<?= $sortieStock->id ?>','<?= $sortieStock->statut ?>')">
                            <span>
                                <div class="toggle-checkbox toggle-warning checkbox-inline toggle-sm mrg-top-10 mrg-left-0">
                                    <input id="statut_<?= $sortieStock->id ?>" type="checkbox" name="toggle5"  <?= $sortieStock->statut == 1?'checked':'' ?> value="<?= $sortieStock->statut ?>" disabled>
                                    <label for="statut_<?= $sortieStock->id ?>"></label>
                                </div>
                            </span>
                        </div>
                    </td> -->
                   <!-- <td>
                        <div class="mrg-top-20  font-size-18">
                            <a href="#" title="Modifier" onclick="modifentreestockShow('<?= $sortieStock->id."*".$sortieStock->quantite."*".str_replace("'", "\'", $sortieStock->produit->id)."*".str_replace("'", "\'", $sortieStock->client->id) ?>')" ><span class="icon-holder"><i class="ti-pencil"></i></span></a>
                            <a href="#" data-toggle="modal" data-target="#default-modal" title="Supprimer" onclick="doIt('supp','<?= $sortieStock->id ?>','<?= $sortieStock->statut ?>')"><span class="icon-holder"><i class="ti-trash"></i></span></a>
                            <a href="#" data-toggle="modal" data-target="#modal-lg" title="Détails" onclick="details('<?= $sortieStock->id ?>')"><span class="icon-holder"><i class="ti-view-list"></i></span></a>
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