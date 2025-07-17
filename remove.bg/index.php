<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Background Removal with OpenCV.js</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      display: flex;
      flex-direction: column;
      align-items: center;
      background-color: #f0f0f0;
      margin: 20px;
    }
    .container {
      display: flex;
      flex-direction: column;
      gap: 20px;
      align-items: center;
    }
    #outputCanvas {
      max-width: 500px;
      border: 2px dashed #ccc;
    }
    button {
      padding: 10px 20px;
      background: #007bff;
      color: white;
      border: none;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="container">
    <input type="file" id="fileInput" accept="image/*" />
    <button id="processBtn" disabled>Remove Background</button>
    <canvas id="outputCanvas"></canvas>
  </div>

  <!-- Include OpenCV.js -->
  <script async src="https://docs.opencv.org/4.5.0/opencv.js" onload="onOpenCvReady()"></script>

  <script>
    // Called when OpenCV.js is loaded
    function onOpenCvReady() {
      console.log("OpenCV.js is ready!");
      document.getElementById('processBtn').disabled = false;
    }

    // Process button click handler
    document.getElementById('processBtn').addEventListener('click', () => {
      const file = document.getElementById('fileInput').files[0];
      if (!file) {
        alert("Please upload an image first!");
        return;
      }

      const reader = new FileReader();
      reader.onload = (e) => {
        const img = new Image();
        img.onload = () => {
          // Create an offscreen canvas to draw the image
          const tempCanvas = document.createElement('canvas');
          tempCanvas.width = img.width;
          tempCanvas.height = img.height;
          const ctx = tempCanvas.getContext('2d');
          ctx.drawImage(img, 0, 0);

          // Convert the image drawn on canvas to an OpenCV Mat
          let src = cv.imread(tempCanvas);
          if (src.empty()) {
            alert("Failed to load the image!");
            src.delete();
            return;
          }

          // Initialize mask and background/foreground models for GrabCut
          let mask = new cv.Mat();
          let bgdModel = new cv.Mat();
          let fgdModel = new cv.Mat();

          // Define a rectangle around the center (using a 10% margin)
          let rect = new cv.Rect(
            Math.round(src.cols * 0.1),
            Math.round(src.rows * 0.1),
            Math.round(src.cols * 0.8),
            Math.round(src.rows * 0.8)
          );

          try {
            // Run GrabCut algorithm with 5 iterations
            cv.grabCut(src, mask, rect, bgdModel, fgdModel, 5, cv.GC_INIT_WITH_RECT);

            // Create foreground mask by combining definite (GC_FGD) and probable (GC_PR_FGD) foreground
            let fgMask1 = new cv.Mat();
            let fgMask2 = new cv.Mat();
            cv.compare(mask, new cv.Mat(mask.rows, mask.cols, mask.type(), new cv.Scalar(cv.GC_FGD)), fgMask1, cv.CMP_EQ);
            cv.compare(mask, new cv.Mat(mask.rows, mask.cols, mask.type(), new cv.Scalar(cv.GC_PR_FGD)), fgMask2, cv.CMP_EQ);
            let foregroundMask = new cv.Mat();
            cv.add(fgMask1, fgMask2, foregroundMask);
            foregroundMask.convertTo(foregroundMask, cv.CV_8UC1, 255);
            fgMask1.delete();
            fgMask2.delete();

            // Convert source image to RGBA so that we can set the alpha channel
            let rgba = new cv.Mat();
            cv.cvtColor(src, rgba, cv.COLOR_BGR2RGBA);

            // Split channels and replace the alpha channel with the foreground mask
            let channels = new cv.MatVector();
            cv.split(rgba, channels);
            channels.set(3, foregroundMask);
            cv.merge(channels, rgba);

            // Display the result on the output canvas
            cv.imshow('outputCanvas', rgba);

            // Cleanup
            src.delete();
            mask.delete();
            bgdModel.delete();
            fgdModel.delete();
            foregroundMask.delete();
            rgba.delete();
            channels.delete();
          } catch (error) {
            console.error("Error during GrabCut:", error);
            alert("An error occurred while processing the image.");
          }
        };
        img.src = e.target.result;
      };
      reader.readAsDataURL(file);
    });
  </script>
</body>
</html>
