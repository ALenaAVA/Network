<ul class="list-notifications">
    <span>


        <?php

        use vendor\core\DB;
        use vendor\core\User;

        if (!empty($_POST)) {
            $arr = json_decode($_POST['e'], true);

            include "../../vendor/core/DB.php";
            include "../../vendor/core/User.php";
            $config = include "../../vendor/core/config.php";
            $db = new DB($config['DB']['name'], $config['DB']['user'], $config['DB']['pass'], $config['DB']['host']);
            $arr = json_decode($_POST['e'], true);
            for ($i = 0; $i < count($arr); $i++) {
                $user = new User();
                $user->id = $arr[$i]['id_from'];
        ?>
                <li>
                    <div class="avatar-block">
                        <img src="<?= $user->avatar() ?>" alt="no-img">
                    </div>
                    <div class="right">
                        <div class="text"><?= $arr[$i]['text'] ?></div>
                        <div class="date"><?= $arr[$i]['date'] ?></div>
                    </div>
                </li>
        <?php }
        } ?>
    </span>
</ul>