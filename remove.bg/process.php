<?php
header('Content-Type: application/json');

// Create directories if they don't exist
$uploadDir = 'uploads/';
$resultDir = 'results/';
foreach ([$uploadDir, $resultDir] as $dir) {
    if (!file_exists($dir)) {
        mkdir($dir, 0755, true);
    }
}

if (isset($_FILES['image'])) {
    $file = $_FILES['image'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    // Validate file type and size (5MB limit)
    if (!in_array($ext, ['jpg', 'jpeg', 'png'])) {
        echo json_encode(['success' => false, 'error' => 'Invalid file type']);
        exit;
    }
    if ($file['size'] > 5242880) {
        echo json_encode(['success' => false, 'error' => 'File too large (max 5MB)']);
        exit;
    }
    
    // Move uploaded file
    $filename = uniqid() . '.' . $ext;
    $uploadPath = $uploadDir . $filename;
    if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
        echo json_encode(['success' => false, 'error' => 'Failed to upload file']);
        exit;
    }
    
    // Process image using Imagick
    $resultPath = $resultDir . 'result_' . $filename;
    if (removeBackgroundWithImagick($uploadPath, $resultPath, $ext)) {
        echo json_encode([
            'success' => true,
            'result' => $resultPath
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Failed to process image'
        ]);
    }
    
    // Clean up original upload
    @unlink($uploadPath);
} else {
    echo json_encode(['success' => false, 'error' => 'No file uploaded']);
}

function removeBackgroundWithImagick($sourcePath, $destPath, $ext) {
    try {
        // Create new Imagick instance
        $image = new Imagick($sourcePath);
        
        // Get the background color (simplified: top-left pixel)
        $bgColor = $image->getImagePixelColor(0, 0);
        $rgb = $bgColor->getColor();
        
        // Remove background (make transparent for PNG, white for JPEG)
        if ($ext === 'png') {
            // Flood fill with transparency
            $image->floodFillPaintImage(
                new ImagickPixel('transparent'), // Transparent color
                0, // Fuzz factor (0 for exact match, adjust as needed)
                $bgColor, // Target color (background)
                0, 0, // Starting point (top-left)
                false // Invert (false to match background)
            );
            $image->setImageFormat('png'); // Ensure PNG format for transparency
        } elseif (in_array($ext, ['jpg', 'jpeg'])) {
            // Replace background with white
            $image->floodFillPaintImage(
                new ImagickPixel('white'), // White color
                0, // Fuzz factor (adjust for tolerance)
                $bgColor, // Target color (background)
                0, 0, // Starting point (top-left)
                false // Invert (false to match background)
            );
            $image->setImageFormat('jpeg'); // Ensure JPEG format
        }
        
        // Strip metadata and save
        $image->stripImage();
        $result = $image->writeImage($destPath);
        $image->destroy();
        
        return $result;
    } catch (ImagickException $e) {
        error_log("Imagick error: " . $e->getMessage());
        return false;
    }
}