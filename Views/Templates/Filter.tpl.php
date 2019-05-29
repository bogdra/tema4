
<form action="" method="get" autocomplete="off">
<?php //var_dump($this); ?>
    <?php foreach ($this->unique_values as $model => $keys): ?>
        <?= ucfirst($model) ?> :
        <select name="<?= $model ?>">

            <?php foreach ($keys as $key => $value): ?>
                <option value="<?= $key ?>"<?= $value ?>><?= ucfirst($key) ?></option>
            <?php endforeach; ?>
        </select> |
    <?php endforeach; ?>

    Pret max: <input type="text" name="price" value="<?=$this->filtered_input['price'];?>"/> |

    <input type="submit" value="Filtreaza"/> <a href="/">Reset</a>

</form>

<hr/>

