<div class="col-md-12">
    <div id="datas" class="card">
        <div class="card-block">
            <div class="form-group">
                <div class="input-icon form-group">
                    <input type="text" class="form-control m-b" placeholder="Recherche ..." oninput="filter(this, 'dt-opt')">
                    <i class="search-icon ti-search pdd-right-10"></i>
                </div>
            </div>
            <div class="table-overflow">

                <?php yii\widgets\Pjax::begin(); ?>
                <table id="dt-opt" class="table table-sm table-hover table-stripped table-condensed">
                    <thead>
                        <tr>
                            <th><div class="mrg-btm-15">Designation</div></th>
                            <th><div class="mrg-btm-15">Description</div></th>
                            <th>
                                <div class="checkbox mrg-left-20" onclick="checkAll()">
                                    <input id="task" name="task" type="checkbox"  <?= (count($menus)<=count($droit_menus))? 'checked':'' ?>>
                                    <label for="task"></label>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($menus): ?>

                            <?php foreach ($menus as $menu): ?>
                                <tr id="profile_<?= $menu->id ?>" class="" style="color:#85642d;">
                                    <td>
                                        <div class="mrg-top-15">
                                            <span><?= $menu->libelle ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="mrg-top-15">
                                            <span><?= $menu->description ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox mrg-left-20">
                                            <input class="_task"  id="task_<?= $menu->id ?>" name="tasks[]" type="checkbox" value="<?= $menu->id ?>" onclick="checkSubtasks('<?= $menu->id ?>')" <?= in_array($menu->id, $droit_menus)? 'checked':'' ?> >
                                            <label for="task_<?= $menu->id ?>"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <?php foreach ($menu->sousMenus as  $sousMenu): ?>
                                            <tr id="sousmenu_<?= $sousMenu->id ?>">
                                                <td>
                                                    <div class="mrg-top-15">
                                                        <span><?= $sousMenu->libelle ?></span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="mrg-top-15">
                                                        <span><?= $sousMenu->description ?></span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="checkbox mrg-left-20">
                                                        <input class="_subtask subtask_<?= $menu->id ?>" id="subtask_<?= $sousMenu->id ?>" name="subtasks[]" type="checkbox" value="<?= $sousMenu->id ?>" onclick="checkTask('<?= $menu->id ?>')" <?= ( isset($droit_sousmenus[$menu->id]) && in_array($sousMenu->id, explode(',',$droit_sousmenus[$menu->id])))? 'checked':'' ?> >
                                                        <label for="subtask_<?= $sousMenu->id ?>"></label>
                                                    </div>
                                                </td>
                                            </tr>  
                                        <?php endforeach ?>
                                    </td>
                                </tr>   
                            <?php  endforeach ?>

                        <?php endif ?>

                    </tbody>
                </table>
                <?php yii\widgets\Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>


