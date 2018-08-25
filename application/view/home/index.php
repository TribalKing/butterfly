<form action="<?php echo URL; ?>home/create" method="POST">
    <div class="table-responsive-sm">
        <table class="table table-dark">
            <thead>
            <tr>
                <td>Add a new user</td>
                <td></td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Name</td>
                <td><input type="text" name="name" value="" required/></td>
            </tr>
            <tr>
                <td>Age</td>
                <td><input type="text" name="age" value="" required/></td>
            </tr>
            <tr>
                <td>Submit</td>
                <td><input type="submit" class="btn btn-success" name="add_user" value="Submit"/></td>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</form>

<!-- main content output -->
<div class="col-lg-12">
    <?php
    if (isset($_SESSION['flash'])):
        ?>
        <div class="alert alert-success">

            <?php
            echo $_SESSION['flash'];
            unset($_SESSION['flash']); ?>

        </div>

        <?php
    endif;
    ?>
</div>
<table class="table table-dark table-responsive-lg">
    <thead>
    <tr>
        <td>Id</td>
        <td>Name</td>
        <td>Age</td>
        <td>DELETE</td>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user) { ?>
        <tr style=" <?php if ($user->age < 18) echo 'color: deeppink' ?>">
            <td><?php if (isset($user->id)) echo htmlspecialchars($user->id, ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php if (isset($user->name)) echo htmlspecialchars($user->name, ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php if (isset($user->age)) echo htmlspecialchars($user->age, ENT_QUOTES, 'UTF-8'); ?></td>
            <td><a class="btn btn-danger"
                   href="<?php echo URL . 'home/delete/' . htmlspecialchars($user->id, ENT_QUOTES, 'UTF-8'); ?>">delete</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</div>
