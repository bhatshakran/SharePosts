<?php require APPROOT . '/views/inc/header.php';?>
<div class="jumbotron jumbotron-flud p-5 bg-light border rounded-3">
<div class="container">
<div class="display-3">
<?php
echo $data['title'];
?>
</div>
<p class="lead">
<?php
echo $data['description'];
?>
</p>
</div>

</div>

<?php require APPROOT . '/views/inc/footer.php';?>