<?php
if (isset($_FILES['image'])) {
  $targetDir = "uploads/";
  $targetFile = $targetDir . uniqid() . '.png';
  move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
  echo "Image saved!";
}
?>