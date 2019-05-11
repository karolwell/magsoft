<table class="table table-sm table-hover table-stripped table-condensed">

    <tr>
        <th>Nom utilisateur</th><td><?= $user->username  ?></td>
    </tr>
    <tr>
        <th>Téléphone</th><td><?= $user->telephone  ?></td>
    </tr>
    <tr>
        <th>Email</th><td><?= $user->email  ?></td>
    </tr>
    <tr>
        <th>Profile</th><td><?= (isset($user->profile->designation))?$user->profile->designation:'';  ?></td>
    </tr>
    <tr>
        <th class="mrg-top-5">Statut</th>
        <td>
            <div class="mrg-top">
                <span>
                    <div class="toggle-checkbox toggle-warning checkbox-inline toggle-sm mrg-top-10 mrg-left-0">
                        <input id="status_<?= $user->id ?>" type="checkbox" name="toggle5"  <?= $user->status == 10?'checked':'' ?> value="<?= $user->status ?>" disabled>
                        <label for="status_<?= $user->id ?>"></label>
                    </div>
                </span>
            </div>
        </td>
    </tr>
</table>