
<form action="" method="get" autocomplete="off">

    <?php foreach ($this->unique_values as $model => $keys): ?>
        <?= ucfirst($model) ?> :
        <select name="<?= $model ?>">
            <option value="all" selected>All models</option>
            <?php foreach ($keys as $value): ?>
                <option value="<?= ucfirst($value) ?>"><?= ucfirst($value) ?></option>
            <?php endforeach; ?>
        </select> |
    <?php endforeach; ?>

    Pret max: <input type="text" name="price" value=""/> |

    <input type="submit" value="Filtreaza"/> <a href="/">Reset</a>

</form>

<hr/>

