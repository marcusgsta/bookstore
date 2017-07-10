<?php
$content = $data;

$contentId = getPost("contentId") ?: getGet("id");
if (!is_numeric($contentId)) {
    die("Not valid for content id.");
}

if (hasKeyPost("doDelete")) {
    header("Location: delete?id=$contentId");
    exit;
}

if (hasKeyPost("doSave")) {
    //$params gets all values from getPost()
    $params = getPost([
    "contentTitle",
    "contentPath",
    "contentSlug",
    "contentData",
    "contentType",
    "contentFilter",
    "contentPublish",
    "contentId"
    ]);
    if (!$params['contentSlug']) {
        $params['contentSlug'] = slugify($params['contentTitle']);
    }
    $slug = $params['contentSlug'];

    if (!$params['contentPath']) {
        $params['contentPath'] = $params['contentSlug'];
    }
    $contentId = $params['contentId'];
    // check so that no slug exists with the same name
    $sql = "SELECT * FROM content WHERE id NOT IN ( $contentId );";
    $res = $app->db->executeFetchAll($sql);

    foreach ($res as $row) {
        if ($slug == $row->slug) {
            echo "<div class='container'><p>Det finns redan en slug med samma namn!</p><p>Sidan laddas om om 5 sekunder...<p>Tryck <a href='edit?id=$contentId'>här</a> om omladdning inte sker.</div>";
            header("refresh:5;url=edit?id=$contentId");
            exit;
        }
    }




    // if (!$app->db->executeFetchAll($sql)) {
    //     echo "hej";
    // };
    // if ($app->db->executefetchAll($sql)) {
    //     echo "fel";
    // };
    if (!$params['contentPath']) {
        $params['contentPath'] = null;
    }

    $sql = "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";

    $app->db->execute($sql, array_values($params));


    // $app->db->execute($sql);
    header("Location: edit?id=$content->id");
    exit;
}
    ?>

<div class="container edit-content">
<h1>Redigera innehåll</h1>



<form method="post">
    <fieldset>
    <legend>Edit</legend>
    <input type="hidden" name="contentId" value="<?= esc($content->id) ?>"/>

    <p>
        <label>Title:<br>
        <input type="text" name="contentTitle" value="<?= isset($content->title) ? esc($content->title) : '' ?>"/>
        </label>
    </p>

    <p>
        <label>Path:<br>
        <input type="text" name="contentPath" value="<?= isset($content->path) ? esc($content->path) : null ?>"/>
    </p>

    <p>
        <label>Slug:<br>
        <input type="text" name="contentSlug" value="<?= isset($content->slug) ? esc($content->slug) : '' ?>"/>
    </p>

    <p>
        <label>Text:<br>
        <textarea name="contentData"><?= isset($content->data) ? esc($content->data) : '' ?></textarea>
     </p>

     <p>
         <label>Type:<br>
         <input type="text" name="contentType" value="<?= isset($content->type) ? esc($content->type) : '' ?>"/>
     </p>

     <p>
         <label>Filter:<br>
         <input type="text" name="contentFilter" value="<?= isset($content->filter) ? esc($content->filter) : '' ?>"/>
     </p>

     <p>
         <label>Published:<br>
         <input type="datetime" name="contentPublish" value="<?= isset($content->published) ? esc($content->published) : '' ?>"/>
     </p>

    <p>
        <button type="submit" name="doSave"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
        <button type="reset"><i class="fa fa-undo" aria-hidden="true"></i> Reset</button>
        <button type="submit" name="doDelete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
    </p>
    </fieldset>
</form>
