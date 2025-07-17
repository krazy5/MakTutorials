<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $fileType = $_FILES['image']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedfileExtensions = array('jpg', 'jpeg', 'png', 'gif');

        if (in_array($fileExtension, $allowedfileExtensions)) {
            list($originalWidth, $originalHeight) = getimagesize($fileTmpPath);

            if ($fileExtension == 'jpg' || $fileExtension == 'jpeg') {
                $image = imagecreatefromjpeg($fileTmpPath);
            } elseif ($fileExtension == 'png') {
                $image = imagecreatefrompng($fileTmpPath);
            } elseif ($fileExtension == 'gif') {
                $image = imagecreatefromgif($fileTmpPath);
            }

            $quality = isset($_POST['quality']) ? (int)$_POST['quality'] : 75;
            $newWidth = isset($_POST['width']) && $_POST['width'] ? (int)$_POST['width'] : $originalWidth;
            $newHeight = isset($_POST['height']) && $_POST['height'] ? (int)$_POST['height'] : $originalHeight;

            $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

            $compressedImageName = 'compressed_' . time() . '_' . $fileName;
            $compressedImagePath = 'uploads/' . $compressedImageName;

            if (!file_exists('uploads')) {
                mkdir('uploads', 0777, true);
            }

            if ($fileExtension == 'jpg' || $fileExtension == 'jpeg') {
                imagejpeg($resizedImage, $compressedImagePath, $quality);
            } elseif ($fileExtension == 'png') {
                imagepng($resizedImage, $compressedImagePath, 9 - round($quality / 10));
            } elseif ($fileExtension == 'gif') {
                imagegif($resizedImage, $compressedImagePath);
            }

            imagedestroy($image);
            imagedestroy($resizedImage);

            $compressedSize = filesize($compressedImagePath);

            echo "<h2>Image Compressed Successfully!</h2>";
            echo "<p>Original Size: " . round($fileSize / 1024, 2) . " KB</p>";
            echo "<p>Compressed Size: " . round($compressedSize / 1024, 2) . " KB</p>";
            echo "<p>Resolution: " . $newWidth . " x " . $newHeight . "</p>";

            echo "<h3>Before & After Comparison:</h3>";
            echo "<div style='display: flex; justify-content: center; gap: 20px;'>";
            echo "<div><p>Original Image:</p><img src='data:image/$fileExtension;base64," . base64_encode(file_get_contents($fileTmpPath)) . "' style='max-width: 300px; border-radius: 10px;'></div>";
            echo "<div><p>Compressed Image:</p><img src='$compressedImagePath' style='max-width: 300px; border-radius: 10px;'></div>";
            echo "</div>";

            echo "<br><p><a href='$compressedImagePath' download>Download Compressed Image</a></p>";
        } else {
            echo "Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.";
        }
    } else {
        echo "Error uploading file.";
    }
}
?>
