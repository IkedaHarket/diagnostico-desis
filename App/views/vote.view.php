<?php
    extract($data);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desis</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <main>
        <section class="logo">
            <img src="https://s3.amazonaws.com/gobcl-prod/images/gob-home.svg" alt="logo">
            <p class="logo_line">Prueba diagnóstico Desis</p>
        </section>
        <section class="section-form">
        <form  class="form" id="voteForm">
            <table class="form__table">
                <tbody>
                    <tr>
                        <td class="form__table-td">
                            <label for="name">Nombre y Apellido</label>
                        </td>
                        <td>
                            <input type="text" id="name" name="name">
                        </td>
                    </tr>
                    <tr>
                        <td class="form__table-td">
                            <label for="alias">Alias</label>
                        </td>
                        <td>
                            <input type="text" id="alias" name="alias">
                        </td>
                    </tr>
                    <tr>
                        <td class="form__table-td">
                            <label for="rut">RUT</label>
                        </td>
                        <td>
                            <input type="text" id="rut" name="rut" >
                        </td>
                    </tr>
                    <tr>
                        <td class="form__table-td">
                            <label for="email">Email</label>
                        </td>
                        <td>
                            <input type="text" id="email" name="email">
                        </td>
                    </tr>
                    <tr>
                        <td class="form__table-td">
                            <label for="region">Región</label>
                        </td>
                        <td>
                            <select id="region" name="region">
                                <option value="#">Seleccione</option>
                                <?php for ($i = 0; $i < count($regions); $i++) : ?>
                                    <option value="<?= $regions[$i]['id']; ?>"><?= $regions[$i]['nombre']; ?></option>
                                <?php endfor; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="form__table-td">
                            <label for="commune">Comuna</label>
                        </td>
                        <td>
                            <select id="commune" name="commune" disabled>
                                <option value="#"></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="form__table-td">
                            <label for="candidate">Candidato</label>
                        </td>
                        <td>
                            <select id="candidate" name="candidate">
                                <option value="#">Seleccione</option>
                                <?php for ($i = 0; $i < count($candidates); $i++) : ?>
                                    <option value="<?= $candidates[$i]['id']; ?>"><?= $candidates[$i]['candidate']; ?></option>
                                <?php endfor; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="form__table-td">
                            <span>Como se enteró de nosotros</span>
                        </td>
                        <td class="form__table-td-inputcheckbox">
                            <?php for ($i = 0; $i < count($checkboxs); $i++) : ?>
                                <input type="checkbox" name="knowus" id="know-<?= $checkboxs[$i]['label'] ?>" value="<?= $checkboxs[$i]['id'] ?>"><label for="know-<?= $checkboxs[$i]['label'] ?>"> <?= $checkboxs[$i]['label'] ?></label>
                            <?php endfor; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button type="submit">Votar</button>
        </form>
        </section>
    </main>
    <script src="../../js/script.js"></script>
</body>
</html>