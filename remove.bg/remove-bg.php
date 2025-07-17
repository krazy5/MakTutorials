<?php
// Check if image was uploaded
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
  $targetDir = "uploads/";
  $uploadedFile = $targetDir . basename($_FILES['image']['name']);
  move_uploaded_file($_FILES['image']['tmp_name'], $uploadedFile);

  // Load the image
  $image = imagecreatefromstring(file_get_contents($uploadedFile));
  imagealphablending($image, false);
  imagesavealpha($image, true);

  // Define the color to remove (e.g., green: RGB 0, 255, 0)
  $colorToRemove = imagecolorallocate($image, 0, 255, 0);
  imagecolortransparent($image, $colorToRemove);

  // Save the result
  $outputFile = $targetDir . 'processed_' . $_FILES['image']['name'];
  imagepng($image, $outputFile);
  imagedestroy($image);

  // Display the result
  echo "<img src='$outputFile' style='max-width: 100%;'>";
}
?>